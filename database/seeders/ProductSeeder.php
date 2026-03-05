<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // 4. Create Products for the Store
        $product1 = Product::create(['store_id' => 1, 'name' => 'NFC Smart Tag']);
        $product2 = Product::create(['store_id' => 1, 'name' => 'Digital Reader']);
        $product3 = Product::create(['store_id' => 2, 'name' => 'Bluetooth Tracker']);
        $product4 = Product::create(['store_id' => 2, 'name' => 'Wireless Charger']);
        $product5 = Product::create(['store_id' => 3, 'name' => 'Smart Plug']);
        $product6 = Product::create(['store_id' => 3, 'name' => 'USB-C Hub']);
        $product7 = Product::create(['store_id' => 4, 'name' => 'LED Strip Lights']);
        $product8 = Product::create(['store_id' => 4, 'name' => 'Smart Thermostat']);
        $product9 = Product::create(['store_id' => 5, 'name' => 'Wi-Fi Extender']);
        $product10 = Product::create(['store_id' => 5, 'name' => 'Power Bank']);

    }
}
