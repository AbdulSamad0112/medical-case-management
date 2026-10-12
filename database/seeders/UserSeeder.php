<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Primary Administrator account
        User::updateOrCreate(
            ['email' => 'admin@jajalmedical.com'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('Admin@123456'),
                'role' => UserRole::ADMIN,
                'email_verified_at' => now(),
            ]
        );

        // Read-only Viewer account
        User::updateOrCreate(
            ['email' => 'viewer@jajalmedical.com'],
            [
                'name' => 'Clinical Case Reviewer',
                'password' => Hash::make('Viewer@123456'),
                'role' => UserRole::VIEWER,
                'email_verified_at' => now(),
            ]
        );
    }
}
