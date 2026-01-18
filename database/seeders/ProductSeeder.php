<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductModel;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $electronics = Category::where('name', 'Electronics')->first();
        $mobilePhones = Category::where('name', 'Mobile Phones')->first();
        $laptops = Category::where('name', 'Laptops')->first();
        
        $apple = Brand::where('name', 'Apple')->first();
        $samsung = Brand::where('name', 'Samsung')->first();
        $hp = Brand::where('name', 'HP')->first();
        $dell = Brand::where('name', 'Dell')->first();

        $iphone13 = ProductModel::where('name', 'iPhone 13')->first();
        $galaxyS23 = ProductModel::where('name', 'Galaxy S23')->first();
        $hp840G5 = ProductModel::where('name', 'HP EliteBook 840 G5')->first();
        $dellXPS = ProductModel::where('name', 'Dell XPS 13')->first();

        if ($mobilePhones && $apple && $iphone13) {
            Product::create([
                'category_id' => $mobilePhones->id,
                'brand_id' => $apple->id,
                'model_id' => $iphone13->id,
                'name' => 'Apple iPhone 13 128GB',
                'sku' => 'IPH13-128GB-BLK',
                'barcode' => '1234567890123',
                'description' => 'Latest iPhone 13 with 128GB storage, featuring A15 Bionic chip and dual camera system.',
                'cost_price' => 699.00,
                'selling_price' => 899.00,
                'quantity' => 25,
                'reorder_level' => 5,
                'serial_number' => 'SN-IPH13-001',
                'warranty_months' => 12,
                'status' => 'active',
            ]);
        }

        if ($mobilePhones && $samsung && $galaxyS23) {
            Product::create([
                'category_id' => $mobilePhones->id,
                'brand_id' => $samsung->id,
                'model_id' => $galaxyS23->id,
                'name' => 'Samsung Galaxy S23 256GB',
                'sku' => 'SGS23-256GB-PRP',
                'barcode' => '1234567890124',
                'description' => 'Samsung Galaxy S23 with 256GB storage, Snapdragon 8 Gen 2 processor.',
                'cost_price' => 749.00,
                'selling_price' => 949.00,
                'quantity' => 15,
                'reorder_level' => 3,
                'serial_number' => 'SN-SGS23-001',
                'warranty_months' => 12,
                'status' => 'active',
            ]);
        }

        if ($laptops && $hp && $hp840G5) {
            Product::create([
                'category_id' => $laptops->id,
                'brand_id' => $hp->id,
                'model_id' => $hp840G5->id,
                'name' => 'HP EliteBook 840 G5 Business Laptop',
                'sku' => 'HP-840G5-I7-16GB',
                'barcode' => '1234567890125',
                'description' => 'HP EliteBook 840 G5 with Intel Core i7, 16GB RAM, 512GB SSD.',
                'cost_price' => 899.00,
                'selling_price' => 1299.00,
                'quantity' => 10,
                'reorder_level' => 2,
                'serial_number' => 'SN-HP840G5-001',
                'warranty_months' => 24,
                'status' => 'active',
            ]);
        }

        if ($laptops && $dell && $dellXPS) {
            Product::create([
                'category_id' => $laptops->id,
                'brand_id' => $dell->id,
                'model_id' => $dellXPS->id,
                'name' => 'Dell XPS 13 Ultrabook',
                'sku' => 'DELL-XPS13-I7-512GB',
                'barcode' => '1234567890126',
                'description' => 'Dell XPS 13 with Intel Core i7, 16GB RAM, 512GB SSD, 13.4-inch display.',
                'cost_price' => 999.00,
                'selling_price' => 1399.00,
                'quantity' => 8,
                'reorder_level' => 2,
                'serial_number' => 'SN-DELLXPS-001',
                'warranty_months' => 24,
                'status' => 'active',
            ]);
        }
    }
}
