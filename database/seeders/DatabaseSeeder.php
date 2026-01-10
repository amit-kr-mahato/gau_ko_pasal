<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin already in DB
        if (!User::where('role', 'admin')->exists()) {
            User::create([
                'name' => 'amit kumar mahato',
                'email' => 'singhamit984537@gmail.com',
                'password' => Hash::make('Admin@123'),
                'role' => 'admin',
            ]);
        }
    }
}
