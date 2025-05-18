<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use Illuminate\Support\Facades\Log;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            User::create([
                'first_name' => 'Admin',
                'last_name' => 'User',
                'adress' => 'Admin Address',
                'city' => 'Admin City',
                'phone_number' => '0555555555',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => UserRole::ADMIN,
                'status' => UserStatus::APPROVED,
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating admin user: ' . $e->getMessage());
        }
    }
}
