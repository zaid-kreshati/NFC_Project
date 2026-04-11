<?php

namespace App\Services;

use App\Models\Invoice;
use App\Repositories\InvoiceRepository;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Exceptions\InvoiceAlreadyClaimedException;
use App\Exceptions\InvoiceExpiredException;
use App\Models\PosDevice;
use Illuminate\Support\Facades\Log;
use App\Models\UuidLog;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class InvoiceService
{
    public function __construct(
        private InvoiceRepository $repo,
    ) {}
    public function createFromPOS(array $data, PosDevice $pos)
    {
        DB::beginTransaction();
        try {

            $existing = Invoice::where('external_invoice_id', $data['invoice_id'])->first();
            if ($existing) {
                throw new \Exception('الفاتورة موجودة بالفعل، يرجي المحاولة مرة أخرى.بعد تغيير معرف الفاتورة');
            };

            Log::info('createFromPOS', $data);

            $invoice = $this->repo->create([
                'uuid' => Str::uuid()->toString(),
                'external_invoice_id' => $data['invoice_id'],
                'store_id' => $pos->branch->store_id,
                'branch_id' => $pos->branch_id,
                'pos_device_id' => $pos->id,
                'subtotal' => $data['subtotal'],
                'tax' => $data['tax'],
                'total' => $data['total'],
                'expires_at' => now()->addMinutes(5),
                'payment_method' => $data['payment_method'] ?? null,
                'currency' => $data['currency'],
                'status' => 'created',
            ]);
            foreach ($data['invoice_items'] as $item) {
                $invoice->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total' => $item['quantity'] * $item['unit_price'],
                ]);
            }
            DB::commit();
            return $invoice->load(['items.product', 'branch', 'store']);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function claimInvoice(string $uuid, int $userId)
    {
        DB::beginTransaction();
        try {
            $invoice = $this->repo->findByUuid($uuid);

            //case1: the same user try to claim the invoice again
            if ($invoice->claimed && $invoice->user_id == $userId) {
                DB::rollBack();
                return $invoice;
            }

            //case2: the invoice is claimed by another user
            if ($invoice->claimed && $invoice->user_id != $userId) {
                throw new InvoiceAlreadyClaimedException();
            }

            //case3: the invoice is expired
            if ($invoice->expires_at && $invoice->expires_at->isPast()) {
                throw new InvoiceExpiredException();
            }

            //case4: the invoice is not claimed yet(happy scenario)
            $updated = $this->repo->update($invoice, [
                'user_id' => $userId,
                'status' => 'claimed',
                'claimed' => true,
                'claimed_at' => now(),
            ]);

            DB::commit();
            return $updated;
        } catch (NotFoundHttpException | ModelNotFoundException | InvoiceAlreadyClaimedException | InvoiceExpiredException $e) {
            //case5: the invoice does not exist
            DB::rollBack();
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Unexpected error in claimInvoice: {$e->getMessage()}");


            UuidLog::create([
                'uuid' => $uuid,
                'status' => 'cancelled',
                'device_id' => isset($invoice) ? $invoice->pos_device_id : null,
                'message' => $e->getMessage(),
                'created_at' => now(),
            ]);

            throw $e;
        }
    }
}
