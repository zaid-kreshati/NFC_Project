<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\InvoiceService;
use App\Repositories\InvoiceRepository;
use App\Traits\JsonResponseTrait;
use App\Http\Requests\InvoiceRequest;
use App\Exceptions\InvoiceAlreadyClaimedException;
use App\Exceptions\InvoiceExpiredException;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    use JsonResponseTrait;

    public function __construct(
        private InvoiceService $service,
        private InvoiceRepository $repo
    ) {}

    // POS create invoice
    public function store(InvoiceRequest $request)
    {
        $pos = $request->attributes->get('pos');

        $invoice = $this->service->createFromPOS($request->all(), $pos);
        // $uuid = escapeshellarg($invoice->uuid);

        // exec("python3 scripts/write_nfc.py {$uuid}");

        $uuid = $invoice->uuid; // No need to escapeshellarg here – Process does it automatically


        $python = '/Users/STADIA_AD/.pyenv/versions/3.13.0/bin/python3';
        $script = base_path('scripts/write_nfc.py');
        exec("$python " . escapeshellarg($script) . " {$uuid}");


        // $result = Process::path(base_path())->run([
        //     'python3',
        //     'scripts/write_nfc.py',
        //     $uuid
        // ]);

        // if ($result->successful()) {
        //     // NFC write succeeded
        //     Log::info('NFC write success', ['uuid' => $uuid, 'output' => $result->output()]);
        // } else {
        //     // NFC write failed – log error but don't block the invoice creation
        //     Log::error('NFC write failed', [
        //         'uuid' => $uuid,
        //         'error' => $result->errorOutput(),
        //         'exit_code' => $result->exitCode()
        //     ]);
        // }
        return $this->success($invoice, 201);
    }

    // Get my invoices (token)
    public function myInvoices(Request $request)
    {
        $invoices = $this->repo->getByUserId($request->user()->id);
        return $this->success($invoices, 201);
    }

    // Get invoices by user id
    public function byUser($id)
    {
        $invoices = $this->repo->getByUserId($id);
        return $this->success($invoices, 201);
    }

    // Get by UUID
    public function show($uuid)
    {
        $invoice = $this->repo->findByUuid($uuid);
        return $this->success($invoice, 201);
    }

    // Claim invoice
    public function claim(Request $request, $uuid)
    {
        $invoice = $this->service->claimInvoice(
            $uuid,
            $request->user()->id
        );

        return $this->success($invoice, 'Invoice claimed successfully', 201);
    }

    // Update invoice
    public function update(Request $request, $id)
    {
        $invoice = $this->repo->findById($id);
        $invoice = $this->repo->update($invoice, $request->all());
        return $this->success($invoice, 201);
    }

    // Delete invoice
    public function destroy($id)
    {
        $invoice = $this->repo->findById($id);
        $this->repo->delete($invoice);

        return $this->success(['message' => 'Deleted'], 201);
    }
}
