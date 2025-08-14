<?php

namespace Database\Seeders;

use App\Models\Business;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

          Business::create([
            'name' => 'Software Dev',
            'city' => 'Lahore',
            'state' =>'Punjab',
            'country' => 'Pakistan',
            'start_date' => now(),
        ]);

         User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
            'business_id' => 1
        ]);
    }
}
