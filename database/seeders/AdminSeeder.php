<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Buat beberapa user admin dengan data fake

            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'), // Atur password sesuai kebutuhan
                'role' => 'admin',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

    }
}
