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