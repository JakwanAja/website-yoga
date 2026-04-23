<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nama_user', 35);
            $table->string('username', 35)->unique();
            $table->string('password', 60);
            $table->enum('role', ['admin', 'superadmin'])->default('admin');
            $table->tinyInteger('status')->default(1); // 1 = aktif, 0 = nonaktif
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};