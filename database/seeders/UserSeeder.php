<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
           'name' => 'dika',
           'email' => 'dika@example.com',
           'password' => bcrypt('11111111'),
           'email_verified_at' => now(),
           'created_at' => now(),
           'updated_at' => now()
        ]);
    }
}
