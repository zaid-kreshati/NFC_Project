<?php

namespace Database\Seeders;

use App\Models\NfcTag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NfcTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 8. Create an NFC Tag linked to the invoice
        NfcTag::create([
            'invoice_id' => 1,
            'is_active' => true,
        ]);

        // 9. Create more NFC Tags for additional invoices
        NfcTag::create([
            'invoice_id' => 2,
            'is_active' => true,
        ]);

        NfcTag::create([
            'invoice_id' => 3,
            'is_active' => false,
        ]);

        // 10. Create a batch of 5 active NFC Tags
        foreach (range(4, 8) as $invoiceId) {
            NfcTag::create([
                'invoice_id' => $invoiceId,
                'is_active' => true,
            ]);
        }
    }
}
