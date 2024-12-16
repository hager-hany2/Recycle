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
        //
        DB::table('users')->insert([
            'username' => 'admin',
            'email' => 'hager@gmail.com',
            'phone' => '1234567890',
            'password' => Hash::make('12345678'), // Always hash passwords
            'role' => 'admin',
            'category_user' => null, // Not applicable for admin
            'api_token' => bin2hex(random_bytes(40)), // Generate a random API token
            'price' => 0,
            'point' => 0,
            'is_locked' => 0,
            'image_url' => '50.png', // Adjust as needed
            'Gender' => 'male', // Set a default value
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
