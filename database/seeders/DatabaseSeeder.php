<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Main Branch
        $mainBranch = Branch::firstOrCreate(
            ['name' => 'Main Branch'],
            [
                'is_main' => true,
                'address' => 'Main HQ',
                'phone' => '123456789'
            ]
        );

        // 2. Create Admin Role
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'Manager']);
        Role::firstOrCreate(['name' => 'Cashier']);

        // 3. Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@erp.com'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('password123'),
                'branch_id' => $mainBranch->id,
            ]
        );

        $admin->assignRole($adminRole);
    }
}
