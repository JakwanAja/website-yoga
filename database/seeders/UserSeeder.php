<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name'       => 'Super Admin',
                'username'   => 'superadmin',
                'password'   => Hash::make('superadmin123'),
                'role'       => 'superadmin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Admin Asha',
                'username'   => 'admin',
                'password'   => Hash::make('admin123'),
                'role'       => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}