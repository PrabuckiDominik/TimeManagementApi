<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use TimeManagement\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ["email" => "admin@example.com"],
            [
                "name" => "Admin",
                "email_verified_at" => now(),
                "password" => Hash::make("password"),
                "remember_token" => Str::random(10),
            ],
        );
        $admin->assignRole("administrator");

        $superAdmin = User::firstOrCreate(
            ["email" => "superadmin@example.com"],
            [
                "name" => "Super_Admin",
                "email_verified_at" => now(),
                "password" => Hash::make("password"),
                "remember_token" => Str::random(10),
            ],
        );
        $superAdmin->assignRole("superAdministrator");
    }
}
