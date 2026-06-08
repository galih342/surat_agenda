<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Super Admin
        $superAdmin = User::create([
            'name' => 'super-admin',
            'username' => 'user-super',
            'password' => Hash::make('12345678'),
        ]);

        // Langsung tempelkan role dari Spatie
        $superAdmin->assignRole('super-admin');


        // 2. Akun Admin Biasa
        $admin = User::create([
            'name' => 'admin',
            'username' => 'user',
            'password' => Hash::make('12345678'),
        ]);

        // Langsung tempelkan role dari Spatie
        $admin->assignRole('admin');
    }
}