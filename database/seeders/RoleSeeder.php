<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Buat Role
        Role::create(['name' => 'super-admin']);
        Role::create(['name' => 'admin']);

        // Opsional: Langsung jadikan akun pertamamu sebagai super-admin
        $user = User::first();
        if ($user) {
            $user->assignRole('super-admin');
        }
    }
}
