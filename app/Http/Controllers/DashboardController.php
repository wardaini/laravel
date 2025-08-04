<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Karyawan;
use App\Models\Jabatan;
use App\Models\Golongan;
use App\Models\Lembur;
use App\Models\Absensi;
use App\Models\Cuti;
use App\Models\Pengumuman;
use Carbon\Carbon; // <-- TAMBAHKAN INI

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard yang sesuai dengan peran pengguna.
     */
    public function index()
    {
        // --- 1. AMBIL DATA UMUM YANG DIBUTUHKAN SEMUA USER ---
        $user = Auth::user();
        $pengumuman = Pengumuman::latest()->take(5)->get();
        $karyawanDataLogin = $user->karyawan; // Ambil data karyawan yang terhubung dengan user

        // Tambahkan ini di bagian atas, setelah mengambil $user
            $unreadPengumuman = Pengumuman::whereDoesntHave('dibacaOleh', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->count();

        // Inisialisasi variabel agar tidak error jika user belum punya data karyawan
        $sisaCuti = 0;
        $absensis = collect(); // Koleksi kosong untuk riwayat absensi
        $lemburData = collect(); // Koleksi kosong untuk riwayat lembur
        $absensiHariIni = null; // <-- INI VARIABEL PENTING YANG KITA TAMBAHKAN

        // --- 2. JIKA USER MEMILIKI DATA KARYAWAN, AMBIL DATA SPESIFIK MEREKA ---
        //    (Ini berlaku untuk admin yang juga pegawai, dan untuk semua pegawai)
        if ($karyawanDataLogin) {
            $karyawanDataLogin->load(['jabatan', 'golongan']);

            // Hitung sisa cuti tahunan
            $cutiDisetujui = $karyawanDataLogin->cuti()
                ->where('status', 'disetujui')
                ->whereYear('tanggal_mulai', date('Y'))
                ->count();
            $sisaCuti = 12 - $cutiDisetujui;

            // Ambil 5 riwayat absensi terakhir
            $absensis = $karyawanDataLogin->absensi()
                ->orderBy('tanggal_absensi', 'desc')
                ->take(5)
                ->get();

            // Ambil 5 riwayat lembur terakhir
            $lemburData = $karyawanDataLogin->lembur()
                ->orderBy('tanggal_lembur', 'desc')
                ->take(5)
                ->get();

            // Cek absensi untuk HARI INI (untuk tombol clock-in/clock-out)
            // $absensiHariIni = $karyawanDataLogin->absensi()
            //     ->whereDate('tanggal_absensi', Carbon::today())
            //     ->first();

            $absensiHariIni = null;
            if ($karyawanDataLogin) {
                $absensiHariIni = $karyawanDataLogin->absensi()
                    ->whereDate('tanggal_absensi', Carbon::today())
                    ->first();
}

                        
        }

        // --- 3. TENTUKAN VIEW DAN DATA TAMBAHAN BERDASARKAN ROLE ---
        if ($user->role == 'admin') {
            // Data tambahan khusus untuk dashboard Admin
            $totalKaryawan = Karyawan::count();
            $totalJabatan = Jabatan::count();
            $totalGolongan = Golongan::count();

            return view('dashboard.index', compact(
                'totalKaryawan',
                'totalJabatan',
                'totalGolongan',
                'karyawanDataLogin',
                'sisaCuti',
                'absensis',
                'lemburData',
                'absensiHariIni', // <-- Variabel dikirim ke view admin
                'pengumuman'
            ));
        } else {
            // Untuk role 'pegawai'
            return view('dashboard.index-pegawai', compact(
                'karyawanDataLogin',
                'sisaCuti',
                'absensis',
                'lemburData',
                'absensiHariIni', // <-- Variabel dikirim ke view pegawai
                'pengumuman', 'unreadPengumuman'
            ));
        }
    }
}
