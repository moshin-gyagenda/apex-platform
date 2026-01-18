<?php

namespace Database\Seeders;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get suppliers
        $supplier1 = Supplier::where('name', 'John Smith')->first();
        $supplier2 = Supplier::where('name', 'Sarah Nakato')->first();
        $supplier3 = Supplier::where('name', 'David Kato')->first();
        $supplier4 = Supplier::where('name', 'Mary Tumusiime')->first();

        // Get products
        $products = Product::all();

        // Get a user for created_by
        $user = User::first();

        if (!$user || $products->isEmpty()) {
            return; // Can't create purchases without user or products
        }

        // Purchase 1: iPhone 13 from John Smith
        if ($supplier1 && $products->count() >= 1) {
            $product1 = $products->first();
            $quantity1 = 10;
            $costPrice1 = 699.00;
            $subtotal1 = $quantity1 * $costPrice1;

            $purchase1 = Purchase::create([
                'supplier_id' => $supplier1->id,
                'invoice_number' => 'INV-2026-001',
                'total_amount' => $subtotal1,
                'purchase_date' => Carbon::now()->subDays(30),
                'created_by' => $user->id,
            ]);

            PurchaseItem::create([
                'purchase_id' => $purchase1->id,
                'product_id' => $product1->id,
                'quantity' => $quantity1,
                'cost_price' => $costPrice1,
                'subtotal' => $subtotal1,
            ]);
        }

        // Purchase 2: Multiple products from Sarah Nakato
        if ($supplier2 && $products->count() >= 2) {
            $product1 = $products->first();
            $product2 = $products->skip(1)->first();

            $quantity1 = 5;
            $costPrice1 = 749.00;
            $subtotal1 = $quantity1 * $costPrice1;

            $quantity2 = 3;
            $costPrice2 = 899.00;
            $subtotal2 = $quantity2 * $costPrice2;

            $totalAmount = $subtotal1 + $subtotal2;

            $purchase2 = Purchase::create([
                'supplier_id' => $supplier2->id,
                'invoice_number' => 'INV-2026-002',
                'total_amount' => $totalAmount,
                'purchase_date' => Carbon::now()->subDays(25),
                'created_by' => $user->id,
            ]);

            PurchaseItem::create([
                'purchase_id' => $purchase2->id,
                'product_id' => $product1->id,
                'quantity' => $quantity1,
                'cost_price' => $costPrice1,
                'subtotal' => $subtotal1,
            ]);

            PurchaseItem::create([
                'purchase_id' => $purchase2->id,
                'product_id' => $product2->id,
                'quantity' => $quantity2,
                'cost_price' => $costPrice2,
                'subtotal' => $subtotal2,
            ]);
        }

        // Purchase 3: Laptop from David Kato
        if ($supplier3 && $products->count() >= 3) {
            $product3 = $products->skip(2)->first();
            $quantity3 = 8;
            $costPrice3 = 999.00;
            $subtotal3 = $quantity3 * $costPrice3;

            $purchase3 = Purchase::create([
                'supplier_id' => $supplier3->id,
                'invoice_number' => 'INV-2026-003',
                'total_amount' => $subtotal3,
                'purchase_date' => Carbon::now()->subDays(20),
                'created_by' => $user->id,
            ]);

            PurchaseItem::create([
                'purchase_id' => $purchase3->id,
                'product_id' => $product3->id,
                'quantity' => $quantity3,
                'cost_price' => $costPrice3,
                'subtotal' => $subtotal3,
            ]);
        }

        // Purchase 4: Mixed items from Mary Tumusiime
        if ($supplier4 && $products->count() >= 4) {
            $product1 = $products->first();
            $product2 = $products->skip(1)->first();
            $product3 = $products->skip(2)->first();
            $product4 = $products->skip(3)->first();

            $items = [
                ['product' => $product1, 'qty' => 15, 'price' => 699.00],
                ['product' => $product2, 'qty' => 8, 'price' => 749.00],
                ['product' => $product3, 'qty' => 6, 'price' => 899.00],
                ['product' => $product4, 'qty' => 4, 'price' => 999.00],
            ];

            $totalAmount = 0;
            foreach ($items as $item) {
                $totalAmount += $item['qty'] * $item['price'];
            }

            $purchase4 = Purchase::create([
                'supplier_id' => $supplier4->id,
                'invoice_number' => 'INV-2026-004',
                'total_amount' => $totalAmount,
                'purchase_date' => Carbon::now()->subDays(15),
                'created_by' => $user->id,
            ]);

            foreach ($items as $item) {
                PurchaseItem::create([
                    'purchase_id' => $purchase4->id,
                    'product_id' => $item['product']->id,
                    'quantity' => $item['qty'],
                    'cost_price' => $item['price'],
                    'subtotal' => $item['qty'] * $item['price'],
                ]);
            }
        }

        // Purchase 5: Recent purchase from John Smith
        if ($supplier1 && $products->count() >= 2) {
            $product1 = $products->first();
            $product2 = $products->skip(1)->first();

            $quantity1 = 20;
            $costPrice1 = 699.00;
            $subtotal1 = $quantity1 * $costPrice1;

            $quantity2 = 12;
            $costPrice2 = 749.00;
            $subtotal2 = $quantity2 * $costPrice2;

            $totalAmount = $subtotal1 + $subtotal2;

            $purchase5 = Purchase::create([
                'supplier_id' => $supplier1->id,
                'invoice_number' => 'INV-2026-005',
                'total_amount' => $totalAmount,
                'purchase_date' => Carbon::now()->subDays(7),
                'created_by' => $user->id,
            ]);

            PurchaseItem::create([
                'purchase_id' => $purchase5->id,
                'product_id' => $product1->id,
                'quantity' => $quantity1,
                'cost_price' => $costPrice1,
                'subtotal' => $subtotal1,
            ]);

            PurchaseItem::create([
                'purchase_id' => $purchase5->id,
                'product_id' => $product2->id,
                'quantity' => $quantity2,
                'cost_price' => $costPrice2,
                'subtotal' => $subtotal2,
            ]);
        }

        // Purchase 6: Today's purchase from Sarah Nakato
        if ($supplier2 && $products->count() >= 1) {
            $product1 = $products->first();
            $quantity1 = 30;
            $costPrice1 = 699.00;
            $subtotal1 = $quantity1 * $costPrice1;

            $purchase6 = Purchase::create([
                'supplier_id' => $supplier2->id,
                'invoice_number' => 'INV-2026-006',
                'total_amount' => $subtotal1,
                'purchase_date' => Carbon::now(),
                'created_by' => $user->id,
            ]);

            PurchaseItem::create([
                'purchase_id' => $purchase6->id,
                'product_id' => $product1->id,
                'quantity' => $quantity1,
                'cost_price' => $costPrice1,
                'subtotal' => $subtotal1,
            ]);
        }
    }
}
