<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have products and stores seeded first
        $products = Product::all();
        $stores = Store::all();
        $users = User::all();

        if ($products->isEmpty() || $stores->isEmpty() || $users->isEmpty()) {
            $this->command->warn('Please run ProductSeeder, StoreSeeder, and UserSeeder first.');
            return;
        }

        // Create 100 invoices with realistic data
        for ($i = 0; $i < 20; $i++) {
            $store = $stores->random();
            $user = $users->random();
            $subtotal = rand(50, 2000);
            $tax = $subtotal * 0.1;
            $total = $subtotal + $tax;

            $invoice = Invoice::create([
                'uuid' => Str::uuid(),
                'external_invoice_id' => 'POS-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT),
                'user_id' => $user->id,
                'store_id' => $store->id,
                'store_name' => $store->name,
                'branch_id' => rand(1, 5),
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'currency' => 'EUR',
                'payment_method' => ['Credit Card', 'Cash', 'Debit Card', 'PayPal', 'Bank Transfer'][rand(0, 4)],
                'status' => ['pending', 'send', 'registered', 'cancelled'][rand(0, 3)],
                'pos_timestamp' => now()->subDays(rand(0, 365))->subHours(rand(0, 23))->subMinutes(rand(0, 59)),
            ]);

            // Create 1-8 realistic invoice items per invoice
            $numItems = rand(1, 8);
            $itemSubtotal = 0;

            for ($j = 0; $j < $numItems; $j++) {
                $product = $products->random();
                $quantity = rand(1, 5);
                $unitPrice = rand(10, 1000);
                $itemTotal = $quantity * $unitPrice;

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total' => $itemTotal,
                ]);

                $itemSubtotal += $itemTotal;
            }

            // Recalculate totals based on actual items
            $invoice->update([
                'subtotal' => $itemSubtotal,
                'tax' => $itemSubtotal * 0.1,
                'total' => $itemSubtotal * 1.1,
            ]);
        }
    }
}
