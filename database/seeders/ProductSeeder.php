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

        // Get additional categories
        $phoneAccessories = Category::where('name', 'Phone Accessories')->first();
        $audio = Category::where('name', 'Audio')->first();
        $headphones = Category::where('name', 'Headphones')->first();
        $gaming = Category::where('name', 'Gaming')->first();
        $consoles = Category::where('name', 'Consoles')->first();
        $networking = Category::where('name', 'Networking')->first();
        $cables = Category::where('name', 'Cables')->first();
        $chargers = Category::where('name', 'Chargers')->first();
        $storage = Category::where('name', 'Storage')->first();
        $computers = Category::where('name', 'Computers')->first();

        // Get additional brands
        $sony = Brand::where('name', 'Sony')->first();
        $lenovo = Brand::where('name', 'Lenovo')->first();
        $asus = Brand::where('name', 'Asus')->first();
        $xiaomi = Brand::where('name', 'Xiaomi')->first();
        $lg = Brand::where('name', 'LG')->first();
        $microsoft = Brand::where('name', 'Microsoft')->first();

        // Get additional models
        $iphone14Pro = ProductModel::where('name', 'iPhone 14 Pro')->first();
        $hpProBook450 = ProductModel::where('name', 'HP ProBook 450 G8')->first();

        // Existing Products with Images
        if ($mobilePhones && $apple && $iphone13) {
            Product::create([
                'category_id' => $mobilePhones->id,
                'brand_id' => $apple->id,
                'model_id' => $iphone13->id,
                'name' => 'Apple iPhone 13 128GB',
                'sku' => 'IPH13-128GB-BLK',
                'barcode' => '1234567890123',
                'description' => 'Latest iPhone 13 with 128GB storage, featuring A15 Bionic chip and dual camera system.',
                'image' => 'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=800&h=800&fit=crop',
                'cost_price' => 2800000.00,
                'selling_price' => 3500000.00,
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
                'image' => 'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?w=800&h=800&fit=crop',
                'cost_price' => 3200000.00,
                'selling_price' => 4000000.00,
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
                'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800&h=800&fit=crop',
                'cost_price' => 3500000.00,
                'selling_price' => 4800000.00,
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
                'image' => 'https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?w=800&h=800&fit=crop',
                'cost_price' => 4200000.00,
                'selling_price' => 5800000.00,
                'quantity' => 8,
                'reorder_level' => 2,
                'serial_number' => 'SN-DELLXPS-001',
                'warranty_months' => 24,
                'status' => 'active',
            ]);
        }

        // 12 Additional Products
        if ($mobilePhones && $apple && $iphone14Pro) {
            Product::create([
                'category_id' => $mobilePhones->id,
                'brand_id' => $apple->id,
                'model_id' => $iphone14Pro->id,
                'name' => 'Apple iPhone 14 Pro 256GB',
                'sku' => 'IPH14PRO-256GB',
                'barcode' => '1234567890127',
                'description' => 'iPhone 14 Pro with 256GB storage, A16 Bionic chip, and 48MP camera system.',
                'image' => 'https://images.unsplash.com/photo-1663499482523-1c0c1bae4ce1?w=800&h=800&fit=crop',
                'cost_price' => 4500000.00,
                'selling_price' => 5800000.00,
                'quantity' => 20,
                'reorder_level' => 5,
                'serial_number' => 'SN-IPH14PRO-001',
                'warranty_months' => 12,
                'status' => 'active',
            ]);
        }

        if ($laptops && $hp && $hpProBook450) {
            Product::create([
                'category_id' => $laptops->id,
                'brand_id' => $hp->id,
                'model_id' => $hpProBook450->id,
                'name' => 'HP ProBook 450 G8 Laptop',
                'sku' => 'HP-450G8-I5-8GB',
                'barcode' => '1234567890128',
                'description' => 'HP ProBook 450 G8 with Intel Core i5, 8GB RAM, 256GB SSD, 15.6-inch display.',
                'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800&h=800&fit=crop',
                'cost_price' => 2800000.00,
                'selling_price' => 4200000.00,
                'quantity' => 12,
                'reorder_level' => 3,
                'serial_number' => 'SN-HP450G8-001',
                'warranty_months' => 24,
                'status' => 'active',
            ]);
        }

        if ($headphones && $sony) {
            Product::create([
                'category_id' => $headphones->id,
                'brand_id' => $sony->id,
                'model_id' => null,
                'name' => 'Sony WH-1000XM5 Wireless Headphones',
                'sku' => 'SONY-WH1000XM5',
                'barcode' => '1234567890129',
                'description' => 'Premium noise-cancelling wireless headphones with 30-hour battery life.',
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&h=800&fit=crop',
                'cost_price' => 1200000.00,
                'selling_price' => 1800000.00,
                'quantity' => 18,
                'reorder_level' => 5,
                'serial_number' => 'SN-SONY-WH1000XM5-001',
                'warranty_months' => 12,
                'status' => 'active',
            ]);
        }

        if ($phoneAccessories && $apple) {
            Product::create([
                'category_id' => $phoneAccessories->id,
                'brand_id' => $apple->id,
                'model_id' => null,
                'name' => 'Apple MagSafe Charger',
                'sku' => 'APPLE-MAGSAFE',
                'barcode' => '1234567890130',
                'description' => 'Official Apple MagSafe wireless charger for iPhone 12 and later models.',
                'image' => 'https://images.unsplash.com/photo-1587825140708-dfaf72ae4b04?w=800&h=800&fit=crop',
                'cost_price' => 120000.00,
                'selling_price' => 180000.00,
                'quantity' => 50,
                'reorder_level' => 10,
                'serial_number' => 'SN-APPLE-MAGSAFE-001',
                'warranty_months' => 12,
                'status' => 'active',
            ]);
        }

        if ($gaming && $asus) {
            Product::create([
                'category_id' => $gaming->id,
                'brand_id' => $asus->id,
                'model_id' => null,
                'name' => 'ASUS ROG Strix Gaming Keyboard',
                'sku' => 'ASUS-ROG-KEYBOARD',
                'barcode' => '1234567890131',
                'description' => 'Mechanical gaming keyboard with RGB lighting and customizable keys.',
                'image' => 'https://images.unsplash.com/photo-1587825140708-dfaf72ae4b04?w=800&h=800&fit=crop',
                'cost_price' => 350000.00,
                'selling_price' => 550000.00,
                'quantity' => 30,
                'reorder_level' => 8,
                'serial_number' => 'SN-ASUS-ROG-KB-001',
                'warranty_months' => 24,
                'status' => 'active',
            ]);
        }

        if ($consoles && $microsoft) {
            Product::create([
                'category_id' => $consoles->id,
                'brand_id' => $microsoft->id,
                'model_id' => null,
                'name' => 'Xbox Series X Gaming Console',
                'sku' => 'XBOX-SERIES-X',
                'barcode' => '1234567890132',
                'description' => 'Next-generation gaming console with 1TB SSD and 4K gaming support.',
                'image' => 'https://images.unsplash.com/photo-1606144042614-b2417e99c4e3?w=800&h=800&fit=crop',
                'cost_price' => 2200000.00,
                'selling_price' => 2800000.00,
                'quantity' => 15,
                'reorder_level' => 3,
                'serial_number' => 'SN-XBOX-SX-001',
                'warranty_months' => 12,
                'status' => 'active',
            ]);
        }

        if ($storage && $samsung) {
            Product::create([
                'category_id' => $storage->id,
                'brand_id' => $samsung->id,
                'model_id' => null,
                'name' => 'Samsung 1TB Portable SSD T7',
                'sku' => 'SAMSUNG-T7-1TB',
                'barcode' => '1234567890133',
                'description' => 'Ultra-fast portable SSD with USB 3.2 Gen 2, up to 1050MB/s read speeds.',
                'image' => 'https://images.unsplash.com/photo-1614108718611-8495c5e00209?w=800&h=800&fit=crop',
                'cost_price' => 450000.00,
                'selling_price' => 650000.00,
                'quantity' => 25,
                'reorder_level' => 5,
                'serial_number' => 'SN-SAMSUNG-T7-001',
                'warranty_months' => 36,
                'status' => 'active',
            ]);
        }

        if ($audio && $sony) {
            Product::create([
                'category_id' => $audio->id,
                'brand_id' => $sony->id,
                'model_id' => null,
                'name' => 'Sony SRS-XB43 Bluetooth Speaker',
                'sku' => 'SONY-SRS-XB43',
                'barcode' => '1234567890134',
                'description' => 'Extra bass portable Bluetooth speaker with 24-hour battery life.',
                'image' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=800&h=800&fit=crop',
                'cost_price' => 800000.00,
                'selling_price' => 1200000.00,
                'quantity' => 20,
                'reorder_level' => 5,
                'serial_number' => 'SN-SONY-SRS-XB43-001',
                'warranty_months' => 12,
                'status' => 'active',
            ]);
        }

        if ($cables && $apple) {
            Product::create([
                'category_id' => $cables->id,
                'brand_id' => $apple->id,
                'model_id' => null,
                'name' => 'Apple USB-C to Lightning Cable (2m)',
                'sku' => 'APPLE-USB-C-LIGHTNING-2M',
                'barcode' => '1234567890135',
                'description' => 'Official Apple USB-C to Lightning cable, 2 meters length.',
                'image' => 'https://images.unsplash.com/photo-1587037542794-6ca5f4772330?w=800&h=800&fit=crop',
                'cost_price' => 80000.00,
                'selling_price' => 120000.00,
                'quantity' => 60,
                'reorder_level' => 15,
                'serial_number' => 'SN-APPLE-CABLE-001',
                'warranty_months' => 12,
                'status' => 'active',
            ]);
        }

        if ($networking && $asus) {
            Product::create([
                'category_id' => $networking->id,
                'brand_id' => $asus->id,
                'model_id' => null,
                'name' => 'ASUS RT-AX3000 WiFi 6 Router',
                'sku' => 'ASUS-RT-AX3000',
                'barcode' => '1234567890136',
                'description' => 'Dual-band WiFi 6 router with 3000Mbps speed and AiMesh support.',
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&h=800&fit=crop',
                'cost_price' => 600000.00,
                'selling_price' => 850000.00,
                'quantity' => 12,
                'reorder_level' => 3,
                'serial_number' => 'SN-ASUS-RT-AX3000-001',
                'warranty_months' => 24,
                'status' => 'active',
            ]);
        }

        if ($mobilePhones && $xiaomi) {
            Product::create([
                'category_id' => $mobilePhones->id,
                'brand_id' => $xiaomi->id,
                'model_id' => null,
                'name' => 'Xiaomi Redmi Note 12 Pro 128GB',
                'sku' => 'XIAOMI-REDMI-NOTE12',
                'barcode' => '1234567890137',
                'description' => 'Xiaomi Redmi Note 12 Pro with 128GB storage, 108MP camera, and 5000mAh battery.',
                'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=800&h=800&fit=crop',
                'cost_price' => 1200000.00,
                'selling_price' => 1600000.00,
                'quantity' => 22,
                'reorder_level' => 5,
                'serial_number' => 'SN-XIAOMI-RN12-001',
                'warranty_months' => 12,
                'status' => 'active',
            ]);
        }

        if ($laptops && $lenovo) {
            Product::create([
                'category_id' => $laptops->id,
                'brand_id' => $lenovo->id,
                'model_id' => null,
                'name' => 'Lenovo ThinkPad X1 Carbon Gen 10',
                'sku' => 'LENOVO-THINKPAD-X1',
                'barcode' => '1234567890138',
                'description' => 'Ultra-light business laptop with Intel Core i7, 16GB RAM, 512GB SSD.',
                'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800&h=800&fit=crop',
                'cost_price' => 5500000.00,
                'selling_price' => 7200000.00,
                'quantity' => 8,
                'reorder_level' => 2,
                'serial_number' => 'SN-LENOVO-X1-001',
                'warranty_months' => 36,
                'status' => 'active',
            ]);
        }

        if ($chargers && $samsung) {
            Product::create([
                'category_id' => $chargers->id,
                'brand_id' => $samsung->id,
                'model_id' => null,
                'name' => 'Samsung 25W Super Fast Charger',
                'sku' => 'SAMSUNG-25W-CHARGER',
                'barcode' => '1234567890139',
                'description' => 'Official Samsung 25W Super Fast Charging adapter with USB-C cable.',
                'image' => 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=800&h=800&fit=crop',
                'cost_price' => 100000.00,
                'selling_price' => 150000.00,
                'quantity' => 45,
                'reorder_level' => 10,
                'serial_number' => 'SN-SAMSUNG-25W-001',
                'warranty_months' => 12,
                'status' => 'active',
            ]);
        }

        // Affordable Products - Budget-Friendly Options
        if ($mobilePhones && $xiaomi) {
            Product::create([
                'category_id' => $mobilePhones->id,
                'brand_id' => $xiaomi->id,
                'model_id' => null,
                'name' => 'Xiaomi Redmi 10C 64GB',
                'sku' => 'XIAOMI-REDMI-10C',
                'barcode' => '1234567890140',
                'description' => 'Budget-friendly smartphone with 64GB storage, 6.71-inch display, and 5000mAh battery.',
                'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=800&h=800&fit=crop',
                'cost_price' => 450000.00,
                'selling_price' => 650000.00,
                'quantity' => 35,
                'reorder_level' => 8,
                'serial_number' => 'SN-XIAOMI-10C-001',
                'warranty_months' => 12,
                'status' => 'active',
            ]);
        }

        if ($mobilePhones && $samsung) {
            Product::create([
                'category_id' => $mobilePhones->id,
                'brand_id' => $samsung->id,
                'model_id' => null,
                'name' => 'Samsung Galaxy A14 64GB',
                'sku' => 'SAMSUNG-A14-64GB',
                'barcode' => '1234567890141',
                'description' => 'Affordable Samsung smartphone with 64GB storage, triple camera, and 5000mAh battery.',
                'image' => 'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?w=800&h=800&fit=crop',
                'cost_price' => 550000.00,
                'selling_price' => 750000.00,
                'quantity' => 30,
                'reorder_level' => 8,
                'serial_number' => 'SN-SAMSUNG-A14-001',
                'warranty_months' => 12,
                'status' => 'active',
            ]);
        }

        if ($headphones && $sony) {
            Product::create([
                'category_id' => $headphones->id,
                'brand_id' => $sony->id,
                'model_id' => null,
                'name' => 'Sony WH-CH520 Wireless Headphones',
                'sku' => 'SONY-WH-CH520',
                'barcode' => '1234567890142',
                'description' => 'Affordable wireless headphones with 50-hour battery life and comfortable design.',
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&h=800&fit=crop',
                'cost_price' => 280000.00,
                'selling_price' => 420000.00,
                'quantity' => 40,
                'reorder_level' => 10,
                'serial_number' => 'SN-SONY-CH520-001',
                'warranty_months' => 12,
                'status' => 'active',
            ]);
        }

        if ($phoneAccessories && $samsung) {
            Product::create([
                'category_id' => $phoneAccessories->id,
                'brand_id' => $samsung->id,
                'model_id' => null,
                'name' => 'Samsung Clear View Cover',
                'sku' => 'SAMSUNG-CLEAR-COVER',
                'barcode' => '1234567890143',
                'description' => 'Transparent protective case for Samsung smartphones with card slots.',
                'image' => 'https://images.unsplash.com/photo-1708430633913-033362b8b91a?w=800&h=800&fit=crop',
                'cost_price' => 25000.00,
                'selling_price' => 45000.00,
                'quantity' => 80,
                'reorder_level' => 20,
                'serial_number' => 'SN-SAMSUNG-COVER-001',
                'warranty_months' => 6,
                'status' => 'active',
            ]);
        }

        if ($chargers && $apple) {
            Product::create([
                'category_id' => $chargers->id,
                'brand_id' => $apple->id,
                'model_id' => null,
                'name' => 'Apple 20W USB-C Power Adapter',
                'sku' => 'APPLE-20W-ADAPTER',
                'barcode' => '1234567890144',
                'description' => 'Compact 20W USB-C power adapter for fast charging iPhone and iPad.',
                'image' => 'https://images.unsplash.com/photo-1603539550859-3a559eb00687?w=800&h=800&fit=crop',
                'cost_price' => 60000.00,
                'selling_price' => 95000.00,
                'quantity' => 60,
                'reorder_level' => 15,
                'serial_number' => 'SN-APPLE-20W-001',
                'warranty_months' => 12,
                'status' => 'active',
            ]);
        }

        if ($cables && $samsung) {
            Product::create([
                'category_id' => $cables->id,
                'brand_id' => $samsung->id,
                'model_id' => null,
                'name' => 'Samsung USB-C Cable (1m)',
                'sku' => 'SAMSUNG-USB-C-1M',
                'barcode' => '1234567890145',
                'description' => 'Fast charging USB-C cable, 1 meter length, compatible with Samsung devices.',
                'image' => 'https://images.unsplash.com/photo-1760708825913-65a50b3dc39b?w=800&h=800&fit=crop',
                'cost_price' => 30000.00,
                'selling_price' => 55000.00,
                'quantity' => 100,
                'reorder_level' => 25,
                'serial_number' => 'SN-SAMSUNG-CABLE-001',
                'warranty_months' => 12,
                'status' => 'active',
            ]);
        }

        if ($storage && $samsung) {
            Product::create([
                'category_id' => $storage->id,
                'brand_id' => $samsung->id,
                'model_id' => null,
                'name' => 'Samsung 128GB MicroSD Card',
                'sku' => 'SAMSUNG-MICROSD-128GB',
                'barcode' => '1234567890146',
                'description' => 'High-speed 128GB MicroSD card with Class 10 rating, perfect for phones and cameras.',
                'image' => 'https://images.unsplash.com/photo-1642229407991-e28d009cb968?w=800&h=800&fit=crop',
                'cost_price' => 85000.00,
                'selling_price' => 130000.00,
                'quantity' => 50,
                'reorder_level' => 15,
                'serial_number' => 'SN-SAMSUNG-SD128-001',
                'warranty_months' => 12,
                'status' => 'active',
            ]);
        }

        if ($audio && $sony) {
            Product::create([
                'category_id' => $audio->id,
                'brand_id' => $sony->id,
                'model_id' => null,
                'name' => 'Sony SRS-XB12 Bluetooth Speaker',
                'sku' => 'SONY-SRS-XB12',
                'barcode' => '1234567890147',
                'description' => 'Compact portable Bluetooth speaker with extra bass and 16-hour battery.',
                'image' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=800&h=800&fit=crop',
                'cost_price' => 180000.00,
                'selling_price' => 280000.00,
                'quantity' => 35,
                'reorder_level' => 10,
                'serial_number' => 'SN-SONY-XB12-001',
                'warranty_months' => 12,
                'status' => 'active',
            ]);
        }

        if ($phoneAccessories && $apple) {
            Product::create([
                'category_id' => $phoneAccessories->id,
                'brand_id' => $apple->id,
                'model_id' => null,
                'name' => 'Apple Silicone Case for iPhone',
                'sku' => 'APPLE-SILICONE-CASE',
                'barcode' => '1234567890148',
                'description' => 'Official Apple silicone case with soft-touch finish, available in multiple colors.',
                'image' => 'https://images.unsplash.com/photo-1556656793-08538906a9f8?w=800&h=800&fit=crop',
                'cost_price' => 45000.00,
                'selling_price' => 75000.00,
                'quantity' => 70,
                'reorder_level' => 20,
                'serial_number' => 'SN-APPLE-CASE-001',
                'warranty_months' => 12,
                'status' => 'active',
            ]);
        }

        if ($gaming && $asus) {
            Product::create([
                'category_id' => $gaming->id,
                'brand_id' => $asus->id,
                'model_id' => null,
                'name' => 'ASUS TUF Gaming Mouse',
                'sku' => 'ASUS-TUF-MOUSE',
                'barcode' => '1234567890149',
                'description' => 'Precision gaming mouse with RGB lighting and 7200 DPI sensor.',
                'image' => 'https://images.unsplash.com/photo-1527814050087-3793815479db?w=800&h=800&fit=crop',
                'cost_price' => 120000.00,
                'selling_price' => 200000.00,
                'quantity' => 45,
                'reorder_level' => 12,
                'serial_number' => 'SN-ASUS-MOUSE-001',
                'warranty_months' => 24,
                'status' => 'active',
            ]);
        }

        if ($laptops && $hp) {
            Product::create([
                'category_id' => $laptops->id,
                'brand_id' => $hp->id,
                'model_id' => null,
                'name' => 'HP 15s Laptop (Intel Core i3)',
                'sku' => 'HP-15S-I3-4GB',
                'barcode' => '1234567890150',
                'description' => 'Budget-friendly laptop with Intel Core i3, 4GB RAM, 256GB SSD, 15.6-inch display.',
                'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800&h=800&fit=crop',
                'cost_price' => 1800000.00,
                'selling_price' => 2500000.00,
                'quantity' => 20,
                'reorder_level' => 5,
                'serial_number' => 'SN-HP-15S-001',
                'warranty_months' => 12,
                'status' => 'active',
            ]);
        }

        if ($networking && $asus) {
            Product::create([
                'category_id' => $networking->id,
                'brand_id' => $asus->id,
                'model_id' => null,
                'name' => 'ASUS RT-AC1200 WiFi Router',
                'sku' => 'ASUS-RT-AC1200',
                'barcode' => '1234567890151',
                'description' => 'Dual-band WiFi router with 1200Mbps speed, perfect for home use.',
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&h=800&fit=crop',
                'cost_price' => 250000.00,
                'selling_price' => 380000.00,
                'quantity' => 25,
                'reorder_level' => 8,
                'serial_number' => 'SN-ASUS-AC1200-001',
                'warranty_months' => 24,
                'status' => 'active',
            ]);
        }

        if ($storage && $samsung) {
            Product::create([
                'category_id' => $storage->id,
                'brand_id' => $samsung->id,
                'model_id' => null,
                'name' => 'Samsung 256GB USB Flash Drive',
                'sku' => 'SAMSUNG-USB-256GB',
                'barcode' => '1234567890152',
                'description' => 'High-speed USB 3.0 flash drive with 256GB storage capacity.',
                'image' => 'https://images.unsplash.com/photo-1597872200969-2b65d56bd16b?w=800&h=800&fit=crop',
                'cost_price' => 120000.00,
                'selling_price' => 180000.00,
                'quantity' => 40,
                'reorder_level' => 12,
                'serial_number' => 'SN-SAMSUNG-USB256-001',
                'warranty_months' => 12,
                'status' => 'active',
            ]);
        }
    }
}
