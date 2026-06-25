<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@facturo.com'],
            [
                'name'     => 'Oumar',
                'password' => Hash::make('oumar@123'),
            ]
        );
    }
}
