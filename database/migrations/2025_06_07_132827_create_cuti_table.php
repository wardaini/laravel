<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('cuti', function (Blueprint $table) {
            // Set 'id_cuti' as the Primary Key
            $table->id('id_cuti');

            // Foreign Key to the karyawan table
            $table->unsignedBigInteger('karyawan_id');
            $table->foreign('karyawan_id')->references('id_karyawan')->on('karyawan')->onDelete('cascade');

            // Columns for the leave date range
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');

            // Column for the reason for the leave request
            $table->text('alasan');

            // Status column with a default value of 'pending'
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            
            // created_at and updated_at columns
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('cuti');
    }
};