<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf; // Pastikan Anda sudah meng-install package ini

class LaporanController extends Controller
{
    /**
     * Membuat file PDF slip gaji.
     * Fungsi ini dipanggil oleh rute 'gaji.cetak'.
     */
    public function cetakSlipGaji(Gaji $gaji)
    {
        // Otorisasi: Memastikan pengguna yang login hanya bisa mengakses slip gajinya sendiri,
        // kecuali jika pengguna tersebut adalah admin.
        if (Auth::user()->role !== 'admin' && $gaji->karyawan->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke slip gaji ini.');
        }

        // Eager load relasi untuk efisiensi
        $gaji->load('karyawan.golongan', 'karyawan.jabatan');

        // Mengirim data gaji yang lengkap ke view 'laporan.slip-gaji'
        // View ini akan di-render menjadi PDF
        $pdf = Pdf::loadView('laporan.slip-gaji', compact('gaji'));

        // Membuat nama file yang dinamis
        $namaFile = 'slip-gaji-' . str_replace(' ', '-', strtolower($gaji->karyawan->nama)) . '-' .
                    Carbon::createFromDate($gaji->tahun, $gaji->bulan, 1)->format('Y-m') . '.pdf';
        
        // Menampilkan PDF di browser
        return $pdf->stream($namaFile);
    }

    // Anda bisa menambahkan fungsi laporan lainnya di sini di masa depan.
}
