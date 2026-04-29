<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_kelas', function (Blueprint $table) {
            $table->string('nama')->after('id_jadwal')->nullable();
            $table->text('keterangan')->after('jam_mulai')->nullable();
            $table->string('instruktur')->after('keterangan')->nullable();
            $table->unsignedInteger('harga')->after('instruktur')->default(0);
            $table->string('gambar')->after('harga')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_kelas', function (Blueprint $table) {
            $table->dropColumn(['nama', 'keterangan', 'instruktur', 'harga', 'gambar']);
        });
    }
};
