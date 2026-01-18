<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Electronics',
        ]);

        Category::create([
            'name' => 'Computers',
        ]);

        Category::create([
            'name' => 'Laptops',
        ]);

        Category::create([
            'name' => 'Mobile Phones',
        ]);

        Category::create([
            'name' => 'Phone Accessories',
        ]);

        Category::create([
            'name' => 'Audio',
        ]);

        Category::create([
            'name' => 'Headphones',
        ]);

        Category::create([
            'name' => 'Gaming',
        ]);

        Category::create([
            'name' => 'Consoles',
        ]);

        Category::create([
            'name' => 'Networking',
        ]);

        Category::create([
            'name' => 'Cables',
        ]);

        Category::create([
            'name' => 'Chargers',
        ]);

        Category::create([
            'name' => 'Storage',
        ]);

        Category::create([
            'name' => 'Memory',
        ]);
    }
}
