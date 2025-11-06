<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Cristian',
            'last_name' => 'Coltan',
            'email' => 'cristicoltan0202@yahoo.com',
            'password' => bcrypt('1234'),
            'email_verified_at' => now(),
            'is_admin' => false,
        ]);
    }
}
