<?php

namespace App\Http\Controllers;

use App\Models\Lembur;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class LemburController extends Controller
{
    public function index(): View
    {
        if (auth()->user()->role === 'admin') {
            $lemburs = Lembur::with('karyawan')->latest()->paginate(10);
        } else {
            $karyawanId = auth()->user()->karyawan->id_karyawan;
            $lemburs = Lembur::with('karyawan')
                ->where('karyawan_id', $karyawanId)
                ->latest()->paginate(10);
        }

        return view('lembur.index', compact('lemburs'));
    }

    public function create(): View
    {
        if (auth()->user()->role === 'admin') {
            $karyawans = Karyawan::all();
            return view('lembur.create-admin', compact('karyawans'));
        } else {
            $karyawan = auth()->user()->karyawan;
            return view('lembur.create', compact('karyawan'));
        }
    }

    public function store(Request $request)
    {
        if (auth()->user()->role === 'admin') {
            $request->validate([
                'karyawan_id' => 'required|exists:karyawan,id_karyawan',
            ]);
            $karyawanId = $request->karyawan_id;
        } else {
            $karyawanId = auth()->user()->karyawan->id_karyawan;
        }

        $request->validate([
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $tanggal = today()->format('Y-m-d');

        $jamMulai = Carbon::createFromFormat('Y-m-d H:i', $tanggal . ' ' . $request->jam_mulai);
        $jamSelesai = Carbon::createFromFormat('Y-m-d H:i', $tanggal . ' ' . $request->jam_selesai);

        // Penanganan untuk lembur yang melewati tengah malam
        if ($jamSelesai->lessThanOrEqualTo($jamMulai)) {
            $jamSelesai->addDay();
        }

        // --- PERBAIKAN LOGIKA PERHITUNGAN DURASI ---
        // Menggunakan selisih timestamp untuk hasil yang paling akurat dan andal.
        // Hasilnya dalam detik, kemudian dikonversi ke jam dan dibulatkan.
        $durasiDetik = $jamSelesai->getTimestamp() - $jamMulai->getTimestamp();
        $durasiJam = round($durasiDetik / 3600, 2);

        Lembur::create([
            'karyawan_id' => $karyawanId,
            'tanggal_lembur' => $tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'durasi_jam' => $durasiJam, // Menyimpan durasi yang sudah benar
            'keterangan' => $request->keterangan,
            'status' => 'pending',
        ]);

        return redirect()->route('lembur.index')->with('success', 'Pengajuan lembur berhasil!');
    }

    public function edit(Lembur $lembur): View
    {
        if (auth()->user()->role !== 'admin') {
            if ($lembur->karyawan_id !== auth()->user()->karyawan->id_karyawan) {
                abort(403);
            }
        }
        $karyawans = Karyawan::all();
        return view('lembur.edit', compact('lembur', 'karyawans'));
    }

    public function update(Request $request, Lembur $lembur)
    {
        if (auth()->user()->role !== 'admin') {
            if ($lembur->karyawan_id !== auth()->user()->karyawan->id_karyawan) {
                abort(403, 'Anda tidak memiliki akses untuk mengupdate lembur ini.');
            }
        }

        $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id_karyawan',
            'tanggal_lembur' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
            'keterangan' => 'nullable|string|max:255',
            'status' => 'required|in:pending,disetujui,ditolak',
        ]);

        $tanggal = Carbon::parse($request->tanggal_lembur)->format('Y-m-d');

        $jamMulai = Carbon::createFromFormat('Y-m-d H:i', $tanggal . ' ' . $request->jam_mulai);
        $jamSelesai = Carbon::createFromFormat('Y-m-d H:i', $tanggal . ' ' . $request->jam_selesai);

        if ($jamSelesai->lessThanOrEqualTo($jamMulai)) {
            $jamSelesai->addDay();
        }

        // --- PERBAIKAN LOGIKA PERHITUNGAN DURASI ---
        $durasiDetik = $jamSelesai->getTimestamp() - $jamMulai->getTimestamp();
        $durasiJam = round($durasiDetik / 3600, 2);

        $lembur->update([
            'karyawan_id' => $request->karyawan_id,
            'tanggal_lembur' => $request->tanggal_lembur,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'durasi_jam' => $durasiJam, // Menyimpan durasi yang sudah benar
            'keterangan' => $request->keterangan,
            'status' => $request->status,
        ]);

        return redirect()->route('lembur.index')->with('success', 'Data lembur diperbarui!');
    }

    public function destroy(Lembur $lembur)
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->karyawan->id_karyawan !== $lembur->karyawan_id) {
            abort(403);
        }

        $lembur->delete();

        return redirect()->route('lembur.index')->with('success', 'Data lembur dihapus!');
    }

    public function approve(Lembur $lembur)
    {
        $lembur->update(['status' => 'disetujui']);
        return back()->with('success', 'Lembur disetujui!');
    }

    public function reject(Lembur $lembur)
    {
        $lembur->update(['status' => 'ditolak']);
        return back()->with('success', 'Lembur ditolak!');
    }
}
