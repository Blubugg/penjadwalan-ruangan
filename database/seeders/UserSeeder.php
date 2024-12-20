<?php

namespace Database\Seeders;

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
       $userData = [
           [
               'name' => 'Admin',
               'email' => 'admin@admin.com',
               'role' => 'Admin',
               'password' => bcrypt('admin123')
           ],
           
           [
               'name' => 'User',
               'email' => 'user@user.com',
               'role' => 'User',
               'password' => bcrypt('user123')
           ],
        ];

        foreach ($userData as $key => $val) {
            User::create($val);
        }
    }
}
