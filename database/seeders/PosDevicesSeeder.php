<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\pos_device;
use Illuminate\Database\Seeder;
use App\Models\Store;
use App\Models\Branch;
use App\Models\PosDevice;

class PosDevicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stores = Store::all();
        $branches = Branch::all();

        $pos_devices1 = PosDevice::create([
            'name' => fake()->name(),
            'api_token' => fake()->unique()->sha1(),
            'status' => 'active',
            'store_id' => $stores->random()->id,
            'branch_id' => $branches->random()->id,
        ]);



        $pos_devices2 = PosDevice::create([
            'name' => fake()->name(),
            'api_token' => fake()->unique()->sha1(),
            'status' => 'active',
            'store_id' => $stores->random()->id,
            'branch_id' => $branches->random()->id,
        ]);
    }

}
