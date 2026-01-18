<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::create([
            'name' => 'Apple',
        ]);

        Brand::create([
            'name' => 'Samsung',
        ]);

        Brand::create([
            'name' => 'Dell',
        ]);

        Brand::create([
            'name' => 'HP',
        ]);

        Brand::create([
            'name' => 'Lenovo',
        ]);

        Brand::create([
            'name' => 'Sony',
        ]);

        Brand::create([
            'name' => 'LG',
        ]);

        Brand::create([
            'name' => 'Microsoft',
        ]);

        Brand::create([
            'name' => 'Asus',
        ]);

        Brand::create([
            'name' => 'Acer',
        ]);

        Brand::create([
            'name' => 'Xiaomi',
        ]);

        Brand::create([
            'name' => 'Huawei',
        ]);

        Brand::create([
            'name' => 'Nokia',
        ]);

        Brand::create([
            'name' => 'Canon',
        ]);

        Brand::create([
            'name' => 'Nikon',
        ]);
    }
}
