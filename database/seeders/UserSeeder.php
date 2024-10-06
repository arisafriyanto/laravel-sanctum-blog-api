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
        $users = collect([
            [
                'name' => 'Aris Apriyanto',
                'email' => 'arisapriyanto.new@gmail.com',
                'password' => bcrypt('secret-password'),
                'email_verified_at' => now()
            ],
            [
                'name' => 'Jasmine',
                'email' => 'jasmine@gmail.com',
                'password' => bcrypt('secret-password'),
                'email_verified_at' => now()
            ],
            [
                'name' => 'Runi',
                'email' => 'runi@gmail.com',
                'password' => bcrypt('secret-password'),
                'email_verified_at' => now()
            ]
        ]);

        $users->each(function ($userData) {
            User::create($userData);
        });
    }
}
