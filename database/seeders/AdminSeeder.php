<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $adminRole = Role::where('slug', 'admin')->first();
        $admin->assignRole($adminRole);

        // Create a demo user
        $user = User::create([
            'name' => 'Demo User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $userRole = Role::where('slug', 'user')->first();
        $user->assignRole($userRole);
    }
} 