<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'name'     => 'Super Admin',
            'email'    => 'owner@yoga.com',
            'password' => 'password123',
            'role'     => 'super_admin',
        ]);

        Admin::create([
            'name'     => 'Admin',
            'email'    => 'admin@yoga.com',
            'password' => 'password123',
            'role'     => 'admin',
        ]);
    }
}