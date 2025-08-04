<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id('id_karyawan');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('nip', 50)->nullable();
            $table->string('nama', 255);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'])->nullable();
            $table->enum('status_pernikahan', ['Belum Menikah', 'Menikah', 'Cerai Hidup', 'Cerai Mati'])->nullable();
            // Dalam migrasi karyawan, di fungsi up()
            $table->unsignedSmallInteger('jumlah_anak')->default(0);    
            $table->text('alamat');
            $table->string('no_telepon', 20);
            $table->string('email')->unique(); 
            $table->date('tanggal_masuk');
            $table->unsignedBigInteger('golongan_id');
            $table->foreign('golongan_id')->references('id_golongan')->on('golongan')->onDelete('cascade');
            $table->unsignedBigInteger('jabatan_id');
            $table->foreign('jabatan_id')->references('id_jabatan')->on('jabatan')->onDelete('cascade');
            $table->string('foto_profil')->nullable(); 
            $table->text('bio')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Balikkan migrasi.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};
