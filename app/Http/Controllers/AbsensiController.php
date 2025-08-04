<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    /**
     * Tampilkan daftar absensi.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $karyawans = Karyawan::orderBy('nama')->get();
            $query = Absensi::with('karyawan')->latest('tanggal_absensi');

            if ($request->filled('karyawan_id')) {
                $query->where('karyawan_id', $request->karyawan_id);
            }

            $absensis = $query->paginate(15);
            return view('absensi.index', compact('absensis', 'karyawans'));

        } else {
            $karyawan = $user->karyawan;
            if (!$karyawan) {
                return redirect()->route('dashboard')->with('error', 'Profil karyawan tidak ditemukan.');
            }

            $absensis = $karyawan->absensi()->latest('tanggal_absensi')->paginate(15);

            $bulanIni = $karyawan->absensi()->whereBetween('tanggal_absensi', [
                now()->startOfMonth(), now()->endOfMonth()
            ])->get();

            $statistik = [
                'hadir' => $bulanIni->where('status_kehadiran', 'hadir')->count(),
                'terlambat' => $bulanIni->where('status_kehadiran', 'terlambat')->count(),
                'lainnya' => $bulanIni->whereIn('status_kehadiran', ['izin', 'sakit', 'cuti'])->count(),
            ];

            return view('absensi.index-pegawai', compact('absensis', 'statistik'));
        }
    }

    public function edit(Absensi $absensi)
{
    if (Auth::user()->role !== 'admin') {
        abort(403);
    }
    $karyawans = Karyawan::orderBy('nama')->get();
    return view('absensi.edit', compact('absensi', 'karyawans'));
}




    /**
     * Store absensi otomatis (pegawai) atau manual (admin).
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $validated = $request->validate([
                'karyawan_id' => 'required|exists:karyawan,id_karyawan',
                'tanggal_absensi' => 'required|date',
                'waktu_masuk' => 'nullable|date_format:H:i',
                'waktu_keluar' => 'nullable|date_format:H:i|after_or_equal:waktu_masuk',
                'status_kehadiran' => 'required|in:hadir,izin,sakit,alpa,libur,cuti,terlambat',
                'keterangan' => 'nullable|string|max:255',
            ]);

            Absensi::updateOrCreate(
                [
                    'karyawan_id' => $validated['karyawan_id'],
                    'tanggal_absensi' => $validated['tanggal_absensi'],
                ],
                $validated
            );

            return redirect()->route('absensi.index')->with('success', 'Absensi manual berhasil disimpan.');
        }

        // Pegawai: absen masuk otomatis
        $karyawan = $user->karyawan;

        if (!$karyawan) {
            return redirect()->back()->with('error', 'Data karyawan tidak ditemukan.');
        }

        $today = today();

        if ($karyawan->absensi()->whereDate('tanggal_absensi', $today)->exists()) {
            return redirect()->back()->with('error', 'Anda sudah absen hari ini.');
        }

        $waktuMasuk = now();
        $jamMasuk = today()->setHour(9);
        $status = $waktuMasuk->gt($jamMasuk) ? 'terlambat' : 'hadir';

        $karyawan->absensi()->create([
            'tanggal_absensi' => $today,
            'waktu_masuk' => $waktuMasuk,
            'status_kehadiran' => $status,
        ]);

        return redirect()->back()->with('success', 'Absen berhasil dicatat.');
    }

    /**
     * Update: absensi pulang.
     */
    public function update(Request $request, Absensi $absensi)
    {
        $karyawan = Auth::user()->karyawan;

        if (!$karyawan || $absensi->karyawan_id !== $karyawan->id_karyawan) {
            return redirect()->back()->with('error', 'Aksi tidak diizinkan.');
        }

        if ($absensi->waktu_keluar) {
            return redirect()->back()->with('error', 'Anda sudah absen pulang.');
        }

        $absensi->update(['waktu_keluar' => now()]);

        return redirect()->back()->with('success', 'Absen pulang berhasil.');
    }

    /**
     * Get events untuk FullCalendar.
     */
    public function getEvents(Request $request)
    {
        $request->validate(['start' => 'required|date', 'end' => 'required|date']);

        $query = Absensi::query();
        $karyawanId = $request->input('karyawan_id');

        if ($karyawanId) {
            $query->where('karyawan_id', $karyawanId);
        } else {
            $karyawan = Auth::user()->karyawan;
            if (!$karyawan) return response()->json([]);
            $query->where('karyawan_id', $karyawan->id_karyawan);
        }

        $absensis = $query->whereBetween('tanggal_absensi', [$request->start, $request->end])->get();

        $events = $absensis->map(function ($absen) {
            $color = match ($absen->status_kehadiran) {
                'hadir' => '#10B981',
                'terlambat' => '#F59E0B',
                'izin' => '#3B82F6',
                'sakit' => '#FBBF24',
                'alpa' => '#EF4444',
                'libur' => '#6B7280',
                'cuti' => '#8B5CF6',
                default => '#D1D5DB',
            };
            return [
                'id' => $absen->id,
                'title' => $absen->status_kehadiran,
                'start' => $absen->tanggal_absensi->format('Y-m-d'),
                'backgroundColor' => $color,
                'borderColor' => $color,
                'textColor' => '#FFFFFF',
                'extendedProps' => [
                    'waktu_masuk' => optional($absen->waktu_masuk)->format('H:i'),
                    'waktu_keluar' => optional($absen->waktu_keluar)->format('H:i'),
                    'keterangan' => $absen->keterangan,
                ]
            ];
        });

        return response()->json($events);
    }

    /**
     * Tampilkan detail absensi karyawan.
     */
    public function showKaryawanAbsensi(Karyawan $karyawan)
    {
        if (Auth::user()->role !== 'admin') abort(403);
        $absensis = $karyawan->absensi()->latest('tanggal_absensi')->get();
        return view('absensi.karyawan_detail', compact('karyawan', 'absensis'));
    }

    /**
     * Hapus data absensi.
     */
    public function destroy(Absensi $absensi)
    {
        if (Auth::user()->role !== 'admin') abort(403);
        $absensi->delete();
        return redirect()->route('absensi.index')->with('success', 'Data absensi dihapus.');
    }
}
