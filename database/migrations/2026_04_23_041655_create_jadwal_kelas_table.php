<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_kelas', function (Blueprint $table) {
            $table->increments('id_jadwal');
            $table->enum('hari', ['senin','selasa','rabu','kamis','jumat','sabtu','minggu']);
            $table->time('jam_mulai');
            $table->tinyInteger('status')->default(1)->comment('1=Aktif, 0=Nonaktif');
            $table->unsignedInteger('booking_id_booking')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_kelas');
    }
};