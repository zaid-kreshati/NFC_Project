<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Invoice;
use App\Exceptions\InvoiceNotFoundException;
use Illuminate\Support\Facades\Log;



class InvoiceRepository
{
    public function create(array $data)
    {
        return Invoice::create($data);
    }

    public function findByUuid(string $uuid)
    {
        $invoice = Invoice::with('items')->where('uuid', $uuid)->lockForUpdate()->firstOrFail();


        return $invoice;
    }

    public function findById(int $id)
    {
        return Invoice::with('items')->findOrFail($id);
    }

    public function getByUserId(int $userId)
    {
        return Invoice::with('items')->where('user_id', $userId)->orderBy('claimed_at', 'desc')->orderBy('id', 'desc')->get();
    }

    public function update(Invoice $invoice, array $data)
    {
        $invoice->update($data);
        return $invoice;
    }

    public function delete(Invoice $invoice)
    {
        return $invoice->delete();
    }
}
