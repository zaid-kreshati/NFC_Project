<?php

namespace App\Repositories;

use App\Models\Invoice;

class InvoiceRepository
{
    public function create(array $data)
    {
        return Invoice::create($data);
    }

    public function findByUuid(string $uuid)
    {
        return Invoice::with('items')->where('uuid', $uuid)->firstOrFail();
    }

    public function findById(int $id)
    {
        return Invoice::with('items')->findOrFail($id);
    }

    public function getByUserId(int $userId)
    {
        return Invoice::with('items')->where('user_id', $userId)->get();
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
