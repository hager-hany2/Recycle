<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {



        // Create account for Hager
        User::create([
            'username' => 'hager',
            'email' => 'hager@gmail.com',
            'phone' => '01002444738',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'price' => 0,
            'point' => 0,
            'is_locked' => 0,
            'image_url' => "50.png", // Optional
            'Gender' => 'male', // Set a default value
            'created_at' => now(),
            'updated_at' => now()
            ]);

        // Create account for Kero
        User::create([
            'username' => 'ker00sama',
            'email' => 'cocoosama6@gmail.com',
            'phone' => '01010110600',
            'password' => Hash::make('kerokero'), // Always hash passwords
            'role' => 'admin',
            'price' => 0,
            'point' => 0,
            'is_locked' => 0,
            'image_url' => "1.png", // Optional
            'Gender' => 'male', // Set a default value
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
