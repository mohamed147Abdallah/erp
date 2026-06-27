<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Ensure Admin role exists
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        // Assign all permissions to Admin
        $permissions = Permission::all();
        $adminRole->syncPermissions($permissions);

        // Create or find an admin user
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@erp.com'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('password'), // Change in production
            ]
        );

        // Assign the role to the user
        $adminUser->assignRole('Admin');
    }
}
