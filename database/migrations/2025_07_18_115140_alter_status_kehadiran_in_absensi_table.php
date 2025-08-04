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
    public function up()
    {
        // Perintah ini akan mencari tabel 'absensi' dan mengubah kolom yang ada
        Schema::table('absensi', function (Blueprint $table) {
            // Mengubah kolom 'status_kehadiran' menjadi tipe string dengan panjang 10 karakter.
            // Metode ->change() berarti kolom ini harus sudah ada sebelumnya.
            $table->string('status_kehadiran', 10)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('absensi', function (Blueprint $table) {
            // Bagian ini untuk membatalkan perubahan jika diperlukan.
            // Anda bisa menyesuaikannya dengan tipe data asli kolom Anda.
            // Jika Anda tidak yakin, biarkan saja seperti ini.
            $table->string('status_kehadiran', 5)->change(); // Contoh mengembalikan ke panjang 5
        });
    }
};
