<?php

namespace App\Services;

use App\Models\Invoice;
use App\Repositories\InvoiceRepository;
use Illuminate\Support\Str;
use App\Services\StoreService;
use Illuminate\Database\Eloquent\Casts\AsBinary;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class InvoiceService
{
    public function __construct(
        private InvoiceRepository $repo,
        protected StoreService $StoreService
    ) {}


    public function createFromPOS(array $data)
    {
        $store = $this->StoreService->findById($data['store_id']);

        $invoice = $this->repo->create([
            'uuid' => Str::uuid()->toString(),
            // 'external_invoice_id' => $data['invoice_id'],
            'store_id' => $store->id,
            'store_name' => $store->name,
            'branch_id' => $data['branch_id'],
            'subtotal' => $data['subtotal'],
            'tax' => $data['tax'],
            'total' => $data['total'],
            'payment_method' => $data['payment_method'] ?? null,
            'currency' => $data['currency'],
            'status' => 'pending',
            'pos_timestamp' => $data['pos_timestamp'] ?? now(),
        ]);

        foreach ($data['invoice_items'] as $item) {
            $invoice->items()->firstOrCreate([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total' => $item['quantity'] * $item['unit_price'],
            ]);
        }

        return $invoice->load(['items.product', 'branch', 'store']);
    }

    public function claimInvoice(string $uuid, int $userId)
    {
        $invoice = $this->repo->findByUuid($uuid);

        if ($invoice->user_id) {
            abort(409, 'Invoice already claimed');
        }

        return $this->repo->update($invoice, [
            'user_id' => $userId,
            'status' => 'registered',
        ]);
    }
}
