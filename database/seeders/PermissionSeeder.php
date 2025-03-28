<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Admin Permissions
        $adminPermissions = [
            // User Management
            ['name' => 'View Users', 'slug' => 'view-users', 'description' => 'Can view all users'],
            ['name' => 'Create Users', 'slug' => 'create-users', 'description' => 'Can create new users'],
            ['name' => 'Edit Users', 'slug' => 'edit-users', 'description' => 'Can edit existing users'],
            ['name' => 'Delete Users', 'slug' => 'delete-users', 'description' => 'Can delete users'],
            ['name' => 'Manage User Roles', 'slug' => 'manage-user-roles', 'description' => 'Can assign and remove roles from users'],

            // Template Management
            ['name' => 'View Templates', 'slug' => 'view-templates', 'description' => 'Can view all templates'],
            ['name' => 'Create Templates', 'slug' => 'create-templates', 'description' => 'Can create new templates'],
            ['name' => 'Edit Templates', 'slug' => 'edit-templates', 'description' => 'Can edit existing templates'],
            ['name' => 'Delete Templates', 'slug' => 'delete-templates', 'description' => 'Can delete templates'],
            ['name' => 'Manage Template Pricing', 'slug' => 'manage-template-pricing', 'description' => 'Can set and modify template prices'],

            // Analytics
            ['name' => 'View Analytics', 'slug' => 'view-analytics', 'description' => 'Can view analytics dashboard'],
            ['name' => 'View Purchase Analytics', 'slug' => 'view-purchase-analytics', 'description' => 'Can view purchase statistics'],
            ['name' => 'View Download Analytics', 'slug' => 'view-download-analytics', 'description' => 'Can view download statistics'],
            ['name' => 'Export Analytics', 'slug' => 'export-analytics', 'description' => 'Can export analytics data'],

            // System Management
            ['name' => 'Manage Settings', 'slug' => 'manage-settings', 'description' => 'Can manage system settings'],
            ['name' => 'View Activity Logs', 'slug' => 'view-activity-logs', 'description' => 'Can view system activity logs'],
            ['name' => 'Manage Roles', 'slug' => 'manage-roles', 'description' => 'Can manage roles and permissions'],
        ];

        // User Permissions
        $userPermissions = [
            // Portfolio Management
            ['name' => 'View Own Portfolios', 'slug' => 'view-own-portfolios', 'description' => 'Can view their own portfolios'],
            ['name' => 'Create Portfolios', 'slug' => 'create-portfolios', 'description' => 'Can create new portfolios'],
            ['name' => 'Edit Own Portfolios', 'slug' => 'edit-own-portfolios', 'description' => 'Can edit their own portfolios'],
            ['name' => 'Delete Own Portfolios', 'slug' => 'delete-own-portfolios', 'description' => 'Can delete their own portfolios'],
            ['name' => 'Download Own Portfolios', 'slug' => 'download-own-portfolios', 'description' => 'Can download their own portfolios'],

            // Template Access
            ['name' => 'View Available Templates', 'slug' => 'view-available-templates', 'description' => 'Can view available templates'],
            ['name' => 'Purchase Templates', 'slug' => 'purchase-templates', 'description' => 'Can purchase templates'],
            ['name' => 'Use Purchased Templates', 'slug' => 'use-purchased-templates', 'description' => 'Can use purchased templates'],

            // Profile Management
            ['name' => 'View Own Profile', 'slug' => 'view-own-profile', 'description' => 'Can view their own profile'],
            ['name' => 'Edit Own Profile', 'slug' => 'edit-own-profile', 'description' => 'Can edit their own profile'],
            ['name' => 'Delete Own Account', 'slug' => 'delete-own-account', 'description' => 'Can delete their own account'],
        ];

        // Create all permissions
        foreach (array_merge($adminPermissions, $userPermissions) as $permission) {
            Permission::create($permission);
        }
    }
} 