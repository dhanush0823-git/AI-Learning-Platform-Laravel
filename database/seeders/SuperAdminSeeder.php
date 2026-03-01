<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@ailearning.local'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Admin@12345'),
                'is_super_admin' => true,
            ]
        );
    }
}
