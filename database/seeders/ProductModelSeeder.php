<?php

namespace Database\Seeders;

use App\Models\ProductModel;
use App\Models\Brand;
use Illuminate\Database\Seeder;

class ProductModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apple = Brand::where('name', 'Apple')->first();
        $samsung = Brand::where('name', 'Samsung')->first();
        $hp = Brand::where('name', 'HP')->first();
        $dell = Brand::where('name', 'Dell')->first();

        if ($apple) {
            ProductModel::create([
                'brand_id' => $apple->id,
                'name' => 'iPhone 13',
                'model_number' => 'A2482',
                'specifications' => [
                    'screen_size' => '6.1 inches',
                    'storage' => '128GB',
                    'ram' => '4GB',
                    'processor' => 'A15 Bionic',
                    'camera' => '12MP Dual',
                ],
            ]);

            ProductModel::create([
                'brand_id' => $apple->id,
                'name' => 'iPhone 14 Pro',
                'model_number' => 'A2890',
                'specifications' => [
                    'screen_size' => '6.1 inches',
                    'storage' => '256GB',
                    'ram' => '6GB',
                    'processor' => 'A16 Bionic',
                    'camera' => '48MP Triple',
                ],
            ]);
        }

        if ($samsung) {
            ProductModel::create([
                'brand_id' => $samsung->id,
                'name' => 'Galaxy S23',
                'model_number' => 'SM-S911B',
                'specifications' => [
                    'screen_size' => '6.1 inches',
                    'storage' => '256GB',
                    'ram' => '8GB',
                    'processor' => 'Snapdragon 8 Gen 2',
                    'camera' => '50MP Triple',
                ],
            ]);
        }

        if ($hp) {
            ProductModel::create([
                'brand_id' => $hp->id,
                'name' => 'HP EliteBook 840 G5',
                'model_number' => '840 G5',
                'specifications' => [
                    'screen_size' => '14 inches',
                    'storage' => '512GB SSD',
                    'ram' => '16GB',
                    'processor' => 'Intel Core i7-8550U',
                    'graphics' => 'Intel UHD Graphics 620',
                ],
            ]);

            ProductModel::create([
                'brand_id' => $hp->id,
                'name' => 'HP ProBook 450 G8',
                'model_number' => '450 G8',
                'specifications' => [
                    'screen_size' => '15.6 inches',
                    'storage' => '256GB SSD',
                    'ram' => '8GB',
                    'processor' => 'Intel Core i5-1135G7',
                    'graphics' => 'Intel Iris Xe',
                ],
            ]);
        }

        if ($dell) {
            ProductModel::create([
                'brand_id' => $dell->id,
                'name' => 'Dell XPS 13',
                'model_number' => 'XPS 13-9320',
                'specifications' => [
                    'screen_size' => '13.4 inches',
                    'storage' => '512GB SSD',
                    'ram' => '16GB',
                    'processor' => 'Intel Core i7-1280P',
                    'graphics' => 'Intel Iris Xe',
                ],
            ]);
        }
    }
}
