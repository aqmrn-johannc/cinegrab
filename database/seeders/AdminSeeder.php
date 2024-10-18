<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Import your User model

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin123@gmail.com',
            'password' => bcrypt('123'), // Hash the password
            'is_admin' => true, // Assuming you have a column to differentiate admin users
        ]);
    }
}