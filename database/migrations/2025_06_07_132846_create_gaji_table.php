<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('gaji', function (Blueprint $table) {
            $table->id('id_gaji'); // Primary Key

            // Foreign Key ke tabel karyawan
            $table->unsignedBigInteger('karyawan_id');
            $table->foreign('karyawan_id')->references('id_karyawan')->on('karyawan')->onDelete('cascade');

            // Periode Gaji
            $table->unsignedSmallInteger('bulan'); // Bulan (1-12)
            $table->unsignedSmallInteger('tahun'); // Tahun (misal: 2024)
            $table->date('periode_gaji'); // Tanggal awal periode (contoh: 2024-07-01)

            // KOMPONEN GAJI POKOK & TUNJANGAN
            $table->decimal('gaji_pokok', 15, 2);
            $table->decimal('tunjangan_keluarga', 15, 2)->default(0); // Dari golongan
            $table->decimal('uang_makan', 15, 2)->default(0);         // Dari golongan, per hari
            $table->decimal('uang_transport', 15, 2)->default(0);     // Dari golongan, per hari
            $table->decimal('thr', 15, 2)->nullable();                // Dari golongan, bisa kosong
            $table->decimal('bonus', 15, 2)->nullable();              // Dari golongan, bisa kosong
            $table->decimal('tunjangan_lembur', 15, 2)->default(0);   // Dari perhitungan lembur

            // KOMPONEN POTONGAN
            $table->decimal('total_potongan_lain', 15, 2)->default(0); // Potongan lain-lain (manual)
            $table->decimal('bpjs_kesehatan', 15, 2)->default(0);      // Dari golongan, per orang
            $table->decimal('potongan_absensi', 15, 2)->default(0);    // Dari AbsensiController
            $table->decimal('potongan_uang_makan_cuti', 15, 2)->default(0); // Potongan baru
            $table->decimal('potongan_transport_cuti', 15, 2)->default(0); // Potongan baru
            $table->decimal('potongan_pajak', 15, 2)->default(0);      // Potongan baru (1%)

            // TOTAL GAJI
            $table->decimal('total_gaji_bruto', 15, 2);
            $table->decimal('total_gaji_netto', 15, 2);

            // STATUS PEMBAYARAN
            $table->enum('status_pembayaran', ['pending', 'dibayar'])->default('pending');

            // Keterangan tambahan (opsional)
            $table->text('keterangan')->nullable();

            $table->timestamps();

            // Constraint unik untuk memastikan hanya satu record gaji per karyawan per bulan/tahun
            $table->unique(['karyawan_id', 'bulan', 'tahun']);
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('gaji');
    }
};