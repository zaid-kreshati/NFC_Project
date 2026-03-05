<?php

namespace Database\Seeders;

use App\Models\branch;
use Illuminate\Database\Seeder;
use App\Models\Store;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create multiple stores
        $stores = [
            Store::create(['name' => 'Main Electronics Store']),
            Store::create(['name' => 'Gadget Galaxy']),
            Store::create(['name' => 'Tech Haven']),
            Store::create(['name' => 'Digital Dreams']),
            Store::create(['name' => 'Circuit Central']),
        ];

        // Create branches for each store
        foreach ($stores as $index => $store) {
            Branch::create([
                'store_id' => $store->id,
                'name' => 'Downtown Branch ' . ($index + 1)
            ]);
        }
    }
}
