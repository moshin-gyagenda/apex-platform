<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'name' => 'James Ochieng',
            'phone' => '+256 701 111 111',
            'email' => 'james.ochieng@email.com',
            'address' => 'Plot 12, Nakasero, Kampala, Uganda',
        ]);

        Customer::create([
            'name' => 'Grace Nakato',
            'phone' => '+256 772 222 222',
            'email' => 'grace.nakato@email.com',
            'address' => 'Block 8, Ntinda, Kampala, Uganda',
        ]);

        Customer::create([
            'name' => 'Peter Mukasa',
            'phone' => '+256 703 333 333',
            'email' => 'peter.mukasa@email.com',
            'address' => 'Shop 15, Bugolobi, Kampala, Uganda',
        ]);

        Customer::create([
            'name' => 'Sarah Nalubega',
            'phone' => '+256 750 444 444',
            'email' => 'sarah.nalubega@email.com',
            'address' => 'Unit 25, Kololo, Kampala, Uganda',
        ]);

        Customer::create([
            'name' => 'David Kigozi',
            'phone' => '+256 771 555 555',
            'email' => 'david.kigozi@email.com',
            'address' => 'Plot 33, Muyenga, Kampala, Uganda',
        ]);
    }
}
