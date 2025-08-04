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
        Schema::create('golongan', function (Blueprint $table) {
            $table->id('id_golongan'); // Primary Key

            $table->string('nama_golongan', 50)->unique(); // Nama golongan, harus unik
            $table->decimal('gaji_pokok', 15, 2)->default(0); // Gaji pokok per golongan
            $table->decimal('tunjangan_keluarga', 15, 2)->default(0); // Tunjangan keluarga
            $table->decimal('uang_makan_bulanan', 15, 2)->default(0); // Uang makan bulanan
            $table->decimal('uang_transport_bulanan', 15, 2)->default(0); // Uang transport bulanan
            $table->decimal('thr_nominal', 15, 2)->nullable(); // THR (nullable, bisa diisi gaji pokok jika kosong)
            $table->decimal('bpjs_per_tanggungan', 15, 2)->default(0); // BPJS per tanggungan
            $table->decimal('bonus_tahunan', 15, 2)->nullable(); // Bonus tahunan
            // Dalam migrasi golongan, di fungsi up()
            $table->decimal('uang_lembur_per_jam', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('golongan');
    }
};