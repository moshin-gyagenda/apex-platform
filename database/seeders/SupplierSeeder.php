<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::create([
            'name' => 'John Smith',
            'company' => 'Tech Solutions Ltd',
            'phone' => '+256 701 234 567',
            'email' => 'john.smith@techsolutions.ug',
            'address' => 'Plot 45, Nakawa Industrial Area, Kampala, Uganda',
        ]);

        Supplier::create([
            'name' => 'Sarah Nakato',
            'company' => 'Electronics Wholesale UG',
            'phone' => '+256 772 345 678',
            'email' => 'sarah@ewholesale.ug',
            'address' => 'Block 12, Ntinda Shopping Center, Kampala, Uganda',
        ]);

        Supplier::create([
            'name' => 'David Kato',
            'company' => 'Global Gadgets Importers',
            'phone' => '+256 703 456 789',
            'email' => 'david.kato@globalgadgets.ug',
            'address' => 'Shop 34, Bugolobi Market, Kampala, Uganda',
        ]);

        Supplier::create([
            'name' => 'Mary Tumusiime',
            'company' => 'Premium Electronics Co.',
            'phone' => '+256 750 567 890',
            'email' => 'mary@premiumelectronics.ug',
            'address' => 'Plot 89, Lugogo Mall, Kampala, Uganda',
        ]);
    }
}
