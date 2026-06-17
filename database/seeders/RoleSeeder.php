<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::updateOrCreate(
            ['name' => 'admin'],
            ['name' => 'admin']
        );

        $userRole = Role::updateOrCreate(
            ['name' => 'user'],
            ['name' => 'user']
        );

        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );

        $admin->role_id = $adminRole->id;
        $admin->save();

        $user = User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Normale Gebruiker',
                'password' => Hash::make('password'),
            ]
        );

        $user->role_id = $userRole->id;
        $user->save();
    }
}
