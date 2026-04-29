<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_kelas', function (Blueprint $table) {
            if (!Schema::hasColumn('jadwal_kelas', 'kelas_id')) {
                $table->unsignedBigInteger('kelas_id')->nullable()->after('id_jadwal');
                $table->foreign('kelas_id')->references('id')->on('kelas')->nullOnDelete();
            }

            if (Schema::hasColumn('jadwal_kelas', 'nama')) {
                $table->dropColumn('nama');
            }
            if (Schema::hasColumn('jadwal_kelas', 'keterangan')) {
                $table->dropColumn('keterangan');
            }
            if (Schema::hasColumn('jadwal_kelas', 'instruktur')) {
                $table->dropColumn('instruktur');
            }
            if (Schema::hasColumn('jadwal_kelas', 'harga')) {
                $table->dropColumn('harga');
            }
            if (Schema::hasColumn('jadwal_kelas', 'gambar')) {
                $table->dropColumn('gambar');
            }
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_kelas', function (Blueprint $table) {
            if (Schema::hasColumn('jadwal_kelas', 'kelas_id')) {
                $table->dropForeign(['kelas_id']);
                $table->dropColumn('kelas_id');
            }

            if (!Schema::hasColumn('jadwal_kelas', 'nama')) {
                $table->string('nama')->nullable()->after('id_jadwal');
            }
            if (!Schema::hasColumn('jadwal_kelas', 'keterangan')) {
                $table->text('keterangan')->nullable()->after('jam_mulai');
            }
            if (!Schema::hasColumn('jadwal_kelas', 'instruktur')) {
                $table->string('instruktur')->nullable()->after('keterangan');
            }
            if (!Schema::hasColumn('jadwal_kelas', 'harga')) {
                $table->unsignedInteger('harga')->default(0)->after('instruktur');
            }
            if (!Schema::hasColumn('jadwal_kelas', 'gambar')) {
                $table->string('gambar')->nullable()->after('harga');
            }
        });
    }
};
