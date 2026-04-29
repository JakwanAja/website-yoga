<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_kelas', function (Blueprint $table) {
            $table->unsignedSmallInteger('kuota')->default(10)->after('status')->comment('Kuota peserta per jadwal');
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_kelas', function (Blueprint $table) {
            $table->dropColumn('kuota');
        });
    }
};
