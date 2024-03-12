<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\ProfileClinic;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@clinic.com',
            'password' => Hash::make('1234567890'),
            'phone_number' => '1234567890',
            'role' => 'admin',
        ]);

        ProfileClinic::factory(10)->create();

        Doctor::factory(10)->create();


    }
}
