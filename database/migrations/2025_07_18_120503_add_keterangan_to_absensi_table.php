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
        // Perintah ini akan mencari tabel 'absensi' dan menambahkan kolom baru
        Schema::table('absensi', function (Blueprint $table) {
            // Menambahkan kolom 'keterangan' dengan tipe string (VARCHAR)
            // ->nullable() berarti kolom ini boleh kosong
            // ->after('status_kehadiran') menempatkan kolom ini setelah kolom status_kehadiran
            $table->string('keterangan')->nullable()->after('status_kehadiran');
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
            // Bagian ini untuk membatalkan perubahan (menghapus kolom) jika diperlukan.
            $table->dropColumn('keterangan');
        });
    }
};
