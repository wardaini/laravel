<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Pastikan ini diimpor
use Carbon\Carbon; // Pastikan ini diimpor jika digunakan

class CutiController extends Controller
{
    /**
     * Menampilkan daftar pengajuan cuti.
     * Admin melihat semua, Pegawai hanya melihat cuti mereka sendiri.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'admin') {
            // Admin melihat semua cuti
            $cuti = Cuti::with('karyawan')->latest()->get();
        } else {
            // Pegawai hanya melihat cuti mereka sendiri
            $karyawanLogin = $user->karyawan; // Dapatkan data karyawan yang login
            if (!$karyawanLogin) {
                // Jika user adalah pegawai tapi belum punya data karyawan, alihkan atau tampilkan pesan
                return redirect()->route('dashboard')->with('error', 'Anda harus melengkapi profil karyawan untuk melihat riwayat cuti.');
            }
            $cuti = Cuti::where('karyawan_id', $karyawanLogin->id_karyawan)
                        ->with('karyawan')
                        ->latest()
                        ->get();
        }
        return view('cuti.index', compact('cuti'));
    }

    /**
     * Menampilkan form untuk mengajukan cuti baru.
     * Pegawai hanya bisa mengajukan untuk diri sendiri.
     */
    public function create()
    {
        $user = Auth::user();
        $karyawanLogin = $user->karyawan;

        if ($user->role == 'admin') {
            // Admin bisa memilih karyawan mana saja
            $karyawan = Karyawan::all();
        } else {
            // Pegawai hanya bisa mengajukan untuk diri sendiri
            if (!$karyawanLogin) {
                return redirect()->route('dashboard')->with('error', 'Anda harus melengkapi profil karyawan untuk mengajukan cuti.');
            }
            // Kirim hanya data karyawan yang sedang login
            $karyawan = collect([$karyawanLogin]);
        }
        return view('cuti.create', compact('karyawan'));
    }

    /**
     * Menyimpan pengajuan cuti baru.
     * Pegawai hanya bisa mengajukan untuk diri sendiri.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $karyawanLogin = $user->karyawan;

        $validatedData = $request->validate([
            'karyawan_id' => [
                'required',
                'exists:karyawan,id_karyawan',
                function ($attribute, $value, $fail) use ($user, $karyawanLogin) {
                    // Jika bukan admin, pastikan karyawan_id yang dipilih adalah karyawan yang sedang login
                    if ($user->role !== 'admin' && $karyawanLogin && $value != $karyawanLogin->id_karyawan) {
                        $fail('Anda hanya dapat mengajukan cuti untuk diri sendiri.');
                    }
                },
            ],
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string',
        ]);

        // Status awal selalu 'pending' saat diajukan
        $validatedData['status'] = 'pending';

        Cuti::create($validatedData);

        return redirect()->route('cuti.index')->with('success', 'Pengajuan cuti berhasil ditambahkan dan menunggu persetujuan!');
    }

    /**
     * Menampilkan form untuk mengedit pengajuan cuti.
     * Admin bisa edit semua, Pegawai hanya edit cuti sendiri (jika status pending).
     */
    public function edit(Cuti $cuti)
    {
        $user = Auth::user();
        $karyawanLogin = $user->karyawan;

        // Otorisasi: Admin bisa edit semua, Pegawai hanya edit cuti sendiri dan statusnya harus pending
        if ($user->role !== 'admin') {
            if (!$karyawanLogin || $cuti->karyawan_id !== $karyawanLogin->id_karyawan) {
                return redirect()->route('cuti.index')->with('error', 'Anda tidak memiliki akses untuk mengedit pengajuan cuti ini.');
            }
            // Pegawai hanya bisa edit jika statusnya masih pending
            if ($cuti->status !== 'pending') {
                return redirect()->route('cuti.index')->with('error', 'Pengajuan cuti yang sudah disetujui/ditolak tidak dapat diedit.');
            }
        }

        // Admin bisa memilih karyawan mana saja, pegawai hanya melihat diri sendiri
        $karyawan = ($user->role == 'admin') ? Karyawan::all() : collect([$karyawanLogin]);

        return view('cuti.edit', compact('cuti', 'karyawan'));
    }

    /**
     * Memperbarui pengajuan cuti.
     * Admin bisa update semua, Pegawai hanya update cuti sendiri (jika status pending).
     */
    public function update(Request $request, Cuti $cuti)
    {
        $user = Auth::user();
        $karyawanLogin = $user->karyawan;

        // Otorisasi: Admin bisa update semua, Pegawai hanya update cuti sendiri dan statusnya harus pending
        if ($user->role !== 'admin') {
            if (!$karyawanLogin || $cuti->karyawan_id !== $karyawanLogin->id_karyawan) {
                return redirect()->route('cuti.index')->with('error', 'Anda tidak memiliki akses untuk memperbarui pengajuan cuti ini.');
            }
            if ($cuti->status !== 'pending') {
                return redirect()->route('cuti.index')->with('error', 'Pengajuan cuti yang sudah disetujui/ditolak tidak dapat diperbarui.');
            }
        }

        $validatedData = $request->validate([
            'karyawan_id' => [
                'required',
                'exists:karyawan,id_karyawan',
                function ($attribute, $value, $fail) use ($user, $karyawanLogin) {
                    if ($user->role !== 'admin' && $karyawanLogin && $value != $karyawanLogin->id_karyawan) {
                        $fail('Anda hanya dapat memperbarui cuti untuk diri sendiri.');
                    }
                },
            ],
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string',
            // Admin bisa mengubah status, pegawai tidak bisa (status tidak ada di form pegawai)
            'status' => ($user->role == 'admin') ? 'required|in:pending,disetujui,ditolak' : 'in:pending',
        ]);

        // Jika bukan admin, pastikan status tidak diubah dari 'pending'
        if ($user->role !== 'admin') {
            $validatedData['status'] = 'pending'; // Paksa status tetap pending jika bukan admin
        }

        $cuti->update($validatedData);

        return redirect()->route('cuti.index')->with('success', 'Data cuti berhasil diperbarui!');
    }

    /**
     * Menghapus pengajuan cuti.
     * Admin bisa hapus semua, Pegawai hanya hapus cuti sendiri (jika status pending).
     */
    public function destroy(Cuti $cuti)
    {
        $user = Auth::user();
        $karyawanLogin = $user->karyawan;

        // Otorisasi: Admin bisa hapus semua, Pegawai hanya hapus cuti sendiri dan statusnya harus pending
        if ($user->role !== 'admin') {
            if (!$karyawanLogin || $cuti->karyawan_id !== $karyawanLogin->id_karyawan) {
                return redirect()->route('cuti.index')->with('error', 'Anda tidak memiliki akses untuk menghapus pengajuan cuti ini.');
            }
            if ($cuti->status !== 'pending') {
                return redirect()->route('cuti.index')->with('error', 'Pengajuan cuti yang sudah disetujui/ditolak tidak dapat dihapus.');
            }
        }

        $cuti->delete();
        return redirect()->route('cuti.index')->with('success', 'Data cuti berhasil dihapus!');
    }
}