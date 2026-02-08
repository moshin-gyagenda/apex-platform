<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Map product names to image filenames
        // Priority: exact matches first, then keyword-based fallbacks
        $productImageMap = [
            // Exact matches
            'Universal' => 'universal charger.jpg',
            'Wireless Mouse' => 'Wireless Mouse.jpg',
            'Wired Mouse' => 'Wired Mouse.jpg',
            'Dr Lee' => 'Dr Lee.jpg',
            'Oraimo Headset Ora' => 'Oraimo Headset Ora.jpg',
            'AKG Short' => 'AKG Short.webp',
            'AKG Long' => 'AKG Long.webp',
            'EU 02 Headsets' => 'EU 02 Headsets.jpg',
            'BT 6899 Neaked' => 'BT 6899 Neaked.webp',
            'Banana Pins' => 'Banana Pins.jpg',
            'Junction Box Cables' => 'junction cables.webp',
        ];

        // Keyword-based mappings (checked if exact match fails)
        $keywordMappings = [
            // Adapters & Chargers
            ['keywords' => ['adapter', 'charger', 'usb', 'iphone'], 'image' => 'adapter.jpg'],
            
            // Bulbs
            ['keywords' => ['bulb', 'highlight'], 'image' => 'bulbs.jpg'],
            
            // Antena
            ['keywords' => ['antena', 'antenna'], 'image' => 'Antena.jpg'],
            
            // Beats/Headphones
            ['keywords' => ['beats', 'headset', 'headphone', 'pods'], 'image' => 'Beats.jpg'],
            
            // Clips
            ['keywords' => ['clip'], 'image' => 'wall clips.webp'],
            
            // Fans
            ['keywords' => ['fan'], 'image' => 'Air Fans.jpg'],
            
            // Computers/Consoles
            ['keywords' => ['computer', 'console', 'laptop'], 'image' => 'computers.webp'],
            
            // Cables/Wires
            ['keywords' => ['cable', 'wire', 'junction'], 'image' => 'junction cables.webp'],
        ];

        // Use public/assets/images/products
        $productsPath = public_path('assets/images/products');
        if (!File::exists($productsPath)) {
            File::makeDirectory($productsPath, 0755, true);
        }

        $sourcePath = public_path('assets/images');
        $updated = 0;
        $skipped = 0;

        // Get all products
        $products = Product::all();

        foreach ($products as $product) {
            $imageFilename = null;

            // Try exact match first
            if (isset($productImageMap[$product->name])) {
                $imageFilename = $productImageMap[$product->name];
            } else {
                // Try keyword-based matching
                $productNameLower = strtolower($product->name);
                foreach ($keywordMappings as $mapping) {
                    foreach ($mapping['keywords'] as $keyword) {
                        if (stripos($productNameLower, $keyword) !== false) {
                            $imageFilename = $mapping['image'];
                            break 2; // Break out of both loops
                        }
                    }
                }
            }

            if ($imageFilename) {
                $sourceFile = $sourcePath . '/' . $imageFilename;
                $destinationFile = $productsPath . '/' . $imageFilename;

                if (File::exists($sourceFile)) {
                    if (!File::exists($destinationFile)) {
                        File::copy($sourceFile, $destinationFile);
                    }
                    $product->image = 'products/' . $imageFilename;
                    $product->save();
                    $updated++;
                    
                    $this->command->info("✓ Updated: {$product->name} → {$imageFilename}");
                } else {
                    $this->command->warn("⚠ Source file not found: {$imageFilename} for product: {$product->name}");
                    $skipped++;
                }
            } else {
                $skipped++;
                // Uncomment to see which products don't have images
                // $this->command->line("⊘ No image mapping for: {$product->name}");
            }
        }

        $this->command->info("\n✅ Seeding completed!");
        $this->command->info("   Updated: {$updated} products");
        $this->command->info("   Skipped: {$skipped} products");
    }
}
