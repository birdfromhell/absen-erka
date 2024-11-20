<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => Str::uuid(),
            'username' => 'kaisarrayfaal',
            'name' => 'Kaisar Rayfa Al Baihaqqi',
            'email' => 'kaisarrayfa99@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345'),
            'remember_token' => Str::random(10),
            'created_at' => now()->addHours(7),
            'updated_at' => now()->addHours(7),
        ]);
    }
}
