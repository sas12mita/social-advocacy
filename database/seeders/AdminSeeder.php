<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('admins')->insert([
            'full_name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Always hash password
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
