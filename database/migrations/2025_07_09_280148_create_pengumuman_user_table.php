<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengumuman_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengumuman_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('dibaca_pada')->nullable();
            $table->timestamps();

            // FOREIGN KEY
            $table->foreign('pengumuman_id')
                  ->references('id')
                  ->on('pengumuman')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengumuman_user');
    }
};
