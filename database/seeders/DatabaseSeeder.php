<?php

namespace Database\Seeders;

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
        User::create([
            'name' => 'Admin 1',
            'email' => 'admin1@gmail.com',
            'password' => Hash::make('admin1'), // Password: admin1
            'question' => 'Siapa aku?',
            'answer' => 'Admin 1',
            'status' => 'Y',
            'deleted' => 'N',
        ]);

        User::create([
            'name' => 'Admin 2',
            'email' => 'admin2@gmail.com',
            'password' => Hash::make('admin2'), // Password: admin2
            'question' => 'Siapa aku?',
            'answer' => 'Admin 2',
            'status' => 'Y',
            'deleted' => 'N',
        ]);

        User::create([
            'name' => 'Admin 3',
            'email' => 'admin3@gmail.com',
            'password' => Hash::make('admin3'), // Password: admin3
            'question' => 'Siapa aku?',
            'answer' => 'Admin 3',
            'status' => 'Y',
            'deleted' => 'N',
        ]);
    }
}
