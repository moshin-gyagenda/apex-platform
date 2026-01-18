<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create a Super Admin user for Mubs Script Marking & Tracing System
        $superadmin = User::firstOrCreate(
            ['email' => 'moshingyagenda7@gmail.com'],
            [
                'name' => 'Gyagenda Moshin',
                'email' => 'moshingyagenda7@gmail.com',
                'password' => Hash::make('moshin@2020'),
                'email_verified_at' => now(),
            ]
        );
        if (!$superadmin->hasRole('super-admin')) {
            $superadmin->assignRole('super-admin');
        }
    }
}

