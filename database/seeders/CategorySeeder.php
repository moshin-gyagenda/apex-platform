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
            'name' => 'Computers',
            'image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=800&h=600&fit=crop',
        ]);

        Category::create([
            'name' => 'Laptops',
            'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800&h=600&fit=crop',
        ]);

        Category::create([
            'name' => 'Mobile Phones',
            'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=800&h=600&fit=crop',
        ]);

        Category::create([
            'name' => 'Phone Accessories',
            'image' => 'https://images.unsplash.com/photo-1601784551446-20c9e07cdbdb?w=800&h=600&fit=crop',
        ]);

        Category::create([
            'name' => 'Audio',
            'image' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=800&h=600&fit=crop',
        ]);

        Category::create([
            'name' => 'Headphones',
            'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&h=600&fit=crop',
        ]);

        Category::create([
            'name' => 'Gaming',
            'image' => 'https://images.unsplash.com/photo-1542751371-adc38448a05e?w=800&h=600&fit=crop',
        ]);

        Category::create([
            'name' => 'Consoles',
            'image' => 'https://images.unsplash.com/photo-1606144042614-b2417e99c4e3?w=800&h=600&fit=crop',
        ]);

        Category::create([
            'name' => 'Networking',
            'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&h=600&fit=crop',
        ]);

        Category::create([
            'name' => 'Cables',
            'image' => 'https://images.unsplash.com/photo-1587825140708-dfaf72ae4b04?w=800&h=600&fit=crop',
        ]);

        Category::create([
            'name' => 'Chargers',
            'image' => 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=800&h=600&fit=crop',
        ]);

        Category::create([
            'name' => 'Storage',
            'image' => 'https://images.unsplash.com/photo-1597872200969-2b65d56bd16b?w=800&h=600&fit=crop',
        ]);
    }
}
