<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password123'),
                'role' => User::ROLE_ADMIN,
            ]
        );

        User::firstOrCreate(
            ['email' => 'client@example.com'],
            [
                'name' => 'Client User',
                'password' => bcrypt('password123'),
                'role' => User::ROLE_USER,
            ]
        );

        Category::firstOrCreate(['name' => 'Electronics'], ['description' => 'Electronic devices and accessories']);
        Category::firstOrCreate(['name' => 'Clothing'], ['description' => 'Apparel and fashion items']);
        Category::firstOrCreate(['name' => 'Books'], ['description' => 'Books and publications']);

        Supplier::firstOrCreate(['name' => 'TechCorp'], ['email' => 'contact@techcorp.com', 'phone' => '123-456-7890']);
        Supplier::firstOrCreate(['name' => 'FashionHub'], ['email' => 'info@fashionhub.com', 'phone' => '987-654-3210']);
        Supplier::firstOrCreate(['name' => 'BookWorld'], ['email' => 'sales@bookworld.com', 'phone' => '555-123-4567']);
    }
}
