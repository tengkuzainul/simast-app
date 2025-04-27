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
        $users = [
            [
                'name' => 'Owner RK Store',
                'email' => 'owner@gmail.com',
                'username' => 'owner2025',
                'password' => bcrypt('password'),
                'role' => 'Owner',
                'last_login_at' => now(),
            ],
            [
                'name' => 'Operator Gudang',
                'email' => 'operator@gmail.com',
                'password' => bcrypt('password'),
                'username' => 'operator2025',
                'role' => 'Op-Gudang',
                'last_login_at' => now(),
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
