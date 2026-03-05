<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\InvoiceService;
use App\Repositories\InvoiceRepository;
use App\Traits\JsonResponseTrait;
use App\Http\Requests\InvoiceRequest;
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
        Log::info('InvoiceRequest', $request->all());
        $invoice = $this->service->createFromPOS($request->all());
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

        return $this->success($invoice, 201);
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
