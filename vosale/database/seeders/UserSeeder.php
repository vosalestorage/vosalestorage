<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'      => 'Super Admin',
            'email'     => 'admin@vosale.com',
            'password'  => Hash::make('password'),
            'role'      => 'super_admin',
            'is_active' => true,
        ]);

        User::create([
            'name'      => 'Admin Bar',
            'email'     => 'bar@vosale.com',
            'password'  => Hash::make('password'),
            'role'      => 'bar',
            'is_active' => true,
        ]);

        User::create([
            'name'      => 'Admin Kitchen',
            'email'     => 'kitchen@vosale.com',
            'password'  => Hash::make('password'),
            'role'      => 'kitchen',
            'is_active' => true,
        ]);
    }
}