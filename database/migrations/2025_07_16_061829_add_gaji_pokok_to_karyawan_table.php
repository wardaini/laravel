
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('karyawan', function (Blueprint $table) {
            // Tambahkan kolom gaji_pokok dengan tipe decimal (15 digit total, 2 di belakang koma)
            // Default 0.00 jika tidak diisi, dan posisikan setelah kolom 'nama'
            $table->decimal('gaji_pokok', 15, 2)->default(0.00)->after('nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('karyawan', function (Blueprint $table) {
            // Hapus kolom gaji_pokok jika migrasi di-rollback
            $table->dropColumn('gaji_pokok');
        });
    }
};