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


        /// Seeder Category

        DB::table('categories')->insert([
            [
                'category_id' => 1,
                'user_id' => 1,
                'category_name' => 'food',
                'category_description' => 'Turn your food waste into something valuable. We buy food scraps, expired products, and more. Help reduce waste, support sustainability, and get paid. Schedule a pickup and start earning today!',
                'image_url' => 'rasclny-images/foodpixelss.jpg',
                'deleted_at' => null,
                'created_at' => '2024-11-22 02:21:32',
                'updated_at' => '2024-11-22 02:21:32',
            ],
            [
                'category_id' => 2,
                'user_id' => 1,
                'category_name' => 'plastic',
                'category_description' => 'Turn your plastic waste into value! We buy all types of plastic for recycling. Help reduce pollution and earn cash by recycling with us. Schedule a pickup today and make a difference.',
                'image_url' => 'rasclny-images/plasticpixels.jpg',
                'deleted_at' => null,
                'created_at' => '2024-11-22 02:22:16',
                'updated_at' => '2024-11-22 02:22:16',
            ],
            [
                'category_id' => 4,
                'user_id' => 1,
                'category_name' => 'GLass',
                'category_description' => 'Got glass waste? We buy it! Turn your old glass items into cash and contribute to a greener, cleaner planet. Schedule a pickup today and join us in recycling for a more sustainable future!',
                'image_url' => 'rasclny-images/glasspexels.jpg',
                'deleted_at' => null,
                'created_at' => '2024-11-22 02:24:29',
                'updated_at' => '2024-11-22 02:24:29',
            ],
            [
                'category_id' => 5,
                'user_id' => 1,
                'category_name' => 'Metal',
                'category_description' => 'Got glass waste? We buy it! Turn your old glass items into cash and contribute to a greener, cleaner planet. Schedule a pickup today and join us in recycling for a more sustainable future!',
                'image_url' => 'rasclny-images/Metall.jpg',
                'deleted_at' => null,
                'created_at' => '2024-11-22 02:26:25',
                'updated_at' => '2024-11-22 02:26:25',
            ],
            [
                'category_id' => 6,
                'user_id' => 1,
                'category_name' => 'Paper',
                'category_description' => 'Have excess paper? We buy it! Turn your paper waste into cash while helping to save trees and reduce landfill waste. Schedule a pickup today and contribute to a greener future!',
                'image_url' => 'rasclny-images/paperpexels.jpg',
                'deleted_at' => null,
                'created_at' => '2024-11-22 02:27:32',
                'updated_at' => '2024-11-22 02:27:32',
            ],
        ]);

        
        DB::table('productspoints')->insert([
            [
                'id' => 1,
                'name' => 'oil',
                'point' => 100,
                'image_url' => 'rasclny-images/zeeet.jpeg',
                'deleted_at' => null,
                'created_at' => '2024-11-22 06:02:14',
                'updated_at' => '2024-11-22 06:02:14',
            ],
            [
                'id' => 2,
                'name' => 'sugar',
                'point' => 300,
                'image_url' => 'rasclny-images/sugar.png',
                'deleted_at' => null,
                'created_at' => '2024-11-22 06:03:04',
                'updated_at' => '2024-11-22 06:03:04',
            ],
            [
                'id' => 3,
                'name' => 'flour',
                'point' => 500,
                'image_url' => 'rasclny-images/de2e2.jpeg',
                'deleted_at' => null,
                'created_at' => '2024-11-22 06:03:45',
                'updated_at' => '2024-11-22 06:03:45',
            ],
            [
                'id' => 4,
                'name' => 'rice',
                'point' => 50,
                'image_url' => 'rasclny-images/ricce.jpeg',
                'deleted_at' => null,
                'created_at' => '2024-11-22 06:04:34',
                'updated_at' => '2024-11-22 06:04:34',
            ],
            [
                'id' => 5,
                'name' => 'Maleka lentils/beans (400gm)',
                'point' => 90,
                'image_url' => 'rasclny-images/bkolyat.jpg',
                'deleted_at' => null,
                'created_at' => '2024-11-22 06:05:07',
                'updated_at' => '2024-11-22 06:05:07',
            ],
            [
                'id' => 6,
                'name' => 'reuseable bags',
                'point' => 100,
                'image_url' => 'rasclny-images/shantaa.jpeg',
                'deleted_at' => null,
                'created_at' => '2024-11-22 06:05:36',
                'updated_at' => '2024-11-22 06:05:36',
            ],
            [
                'id' => 7,
                'name' => 'reuseable water bottles',
                'point' => 200,
                'image_url' => 'rasclny-images/plasticcbootlee.jpeg',
                'deleted_at' => null,
                'created_at' => '2024-11-22 06:05:59',
                'updated_at' => '2024-11-22 06:05:59',
            ],
            [
                'id' => 8,
                'name' => 'poot',
                'point' => 150,
                'image_url' => 'rasclny-images/pott.jpeg',
                'deleted_at' => null,
                'created_at' => '2024-11-22 06:06:31',
                'updated_at' => '2024-11-22 06:06:31',
            ],
            [
                'id' => 9,
                'name' => 'organic soap',
                'point' => 150,
                'image_url' => 'rasclny-images/soup.jpeg',
                'deleted_at' => null,
                'created_at' => '2024-11-22 06:07:12',
                'updated_at' => '2024-11-22 06:07:12',
            ],
        ]);


    }
}
