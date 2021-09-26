<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User
        User::create([
            'name' => 'Administrator',
            'email' => 'administrator@3s.com',
            'password' => Hash::make('admin'),
            'role' => 'ADMIN',
        ]);
        User::create([
            'name' => 'Supervisor',
            'email' => 'supervisor@3s.com',
            'password' => Hash::make('admin'),
            'role' => 'SUPERVISOR',
        ]);
        User::create([
            'name' => 'Toolman',
            'email' => 'toolman@3s.com',
            'password' => Hash::make('admin'),
            'role' => 'TOOLMAN',
        ]);
    }
}
