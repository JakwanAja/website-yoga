<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->increments('kode_booking');
            $table->string('nama', 35);
            $table->string('email', 35);
            $table->string('telephone', 13);
            $table->unsignedInteger('id_jadwal');

            $table->foreign('id_jadwal')
                  ->references('id_jadwal')
                  ->on('jadwal_kelas')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};