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
        // Create main admin user
        User::create([
            'name' => 'Admin User',
            'name' => 'Admin User',
            'email' => 'admin@clinic.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'specialization' => null,
            'phone' => '+1234567890',
            'email_verified_at' => now(),
        ]);

        // Create doctor users
        User::create([
            'name' => 'Dr. John Smith',
            'email' => 'doctor@clinic.com',
            'password' => Hash::make('password123'),
            'role' => 'doctor',
            'specialization' => 'General Medicine',
            'phone' => '+1234567891',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Dr. Sarah Johnson',
            'email' => 'dr.johnson@clinic.com',
            'password' => Hash::make('password123'),
            'role' => 'doctor',
            'specialization' => 'Cardiology',
            'phone' => '+1234567892',
            'email_verified_at' => now(),
        ]);

        // Create staff user
        User::create([
            'name' => 'Reception Staff',
            'email' => 'staff@clinic.com',
            'password' => Hash::make('password123'),
            'role' => 'staff',
            'specialization' => null,
            'phone' => '+1234567893',
            'email_verified_at' => now(),
        ]);
    }
}
