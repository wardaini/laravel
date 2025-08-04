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
        Schema::create('jabatan', function (Blueprint $table) {
            // Mengatur 'id_jabatan' sebagai Primary Key
            $table->id('id_jabatan');

            // Kolom untuk nama jabatan dengan maksimal 100 karakter
            $table->string('nama_jabatan', 100);

            // Kolom untuk deskripsi jabatan, boleh kosong (nullable)
            $table->text('deskripsi')->nullable();
            
            // Kolom created_at dan updated_at
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
        Schema::dropIfExists('jabatan');
    }
};
