<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create admin role
        $adminRole = Role::create([
            'name' => 'Administrator',
            'slug' => 'admin',
            'description' => 'Administrator with full access to all features',
        ]);

        // Create user role
        $userRole = Role::create([
            'name' => 'User',
            'slug' => 'user',
            'description' => 'Regular user with limited access',
        ]);

        // Assign all permissions to admin role
        $adminRole->permissions()->attach(Permission::all());

        // Assign user permissions to user role
        $userPermissions = [
            'view-own-portfolios',
            'create-portfolios',
            'edit-own-portfolios',
            'delete-own-portfolios',
            'download-own-portfolios',
            'view-available-templates',
            'purchase-templates',
            'use-purchased-templates',
            'view-own-profile',
            'edit-own-profile',
            'delete-own-account',
        ];

        $userRole->permissions()->attach(
            Permission::whereIn('slug', $userPermissions)->get()
        );
    }
} 