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
        Schema::table('lembur', function (Blueprint $table) {
            if (!Schema::hasColumn('lembur', 'jam_mulai')) {
                $table->time('jam_mulai')->nullable()->after('tanggal_lembur');
            }

            if (!Schema::hasColumn('lembur', 'jam_selesai')) {
                $table->time('jam_selesai')->nullable()->after('jam_mulai');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lembur', function (Blueprint $table) {
            if (Schema::hasColumn('lembur', 'jam_mulai')) {
                $table->dropColumn('jam_mulai');
            }

            if (Schema::hasColumn('lembur', 'jam_selesai')) {
                $table->dropColumn('jam_selesai');
            }
        });
    }
};
