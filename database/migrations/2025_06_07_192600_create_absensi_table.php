<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id('id'); // Primary key

            // Foreign key ke tabel karyawan
            // Ini harus merujuk ke PRIMARY KEY di tabel 'karyawan'
           
            $table->unsignedBigInteger('karyawan_id');
            $table->foreign('karyawan_id')->references('id_karyawan')->on('karyawan')->onDelete('cascade');

            $table->date('tanggal_absensi');
            $table->time('waktu_masuk')->nullable();
            $table->time('waktu_keluar')->nullable();
            $table->enum('status_kehadiran', ['hadir', 'izin', 'sakit', 'alpa', 'libur', 'terlambat'])->default('hadir');
            $table->text('catatan')->nullable();

            $table->timestamps();

            // Indeks unik gabungan (untuk memastikan satu karyawan hanya punya satu absensi per hari)
            $table->unique(['karyawan_id', 'tanggal_absensi']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};