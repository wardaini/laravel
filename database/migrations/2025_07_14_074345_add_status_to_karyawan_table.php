<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('karyawan', function (Blueprint $table) {
        $table->string('status')->default('aktif'); // bisa juga null, tapi default 'aktif' lebih aman
    });
}

public function down()
{
    Schema::table('karyawan', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}

};
