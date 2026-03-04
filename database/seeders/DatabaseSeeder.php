<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; 

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password'); 

        // 1. THE ADMIN (Facility Manager)
        User::create([
            'name' => 'Dr. Facility Manager',
            'email' => 'admin@bit.edu.et',
            'password' => $password,
            'role' => 'admin',
            'is_banned' => false,
            'campus_role'=>'admin_staff',
        ]);

        // 2. THE TECHNICIAN
        User::create([
            'name' => 'Engineer Tesfaye',
            'email' => 'tech@bit.edu.et',
            'password' => $password,
            'role' => 'technician',
            'specialty' => 'Electrical',
            'assigned_buildings' => 'Abdisa Aga Dorm, Thomas Edison',
            'is_banned' => false,
        ]);

        // 3. THE STUDENT
        User::create([
            'name' => 'Dawud Muhammed',
            'email' => 'dawud@student.bit.edu.et',
            'password' => $password,
            'role' => 'user',
            'is_banned' => false,
            'campus_role'=>'student',
        ]);

        // 4. THE CATEGORIES
        $categories = [
            ['name' => 'Electrical', 'sla_hours' => 2],
            ['name' => 'Plumbing', 'sla_hours' => 4],
            ['name' => 'Carpentry', 'sla_hours' => 48],
            ['name' => 'Network/IT', 'sla_hours' => 12],
        ];

        foreach ($categories as $cat) {
            // 🚨 Automatically creates 'electrical', 'network-it', etc.
            $cat['slug'] = Str::slug($cat['name']); 
            Category::create($cat);
        }
    }
}