<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $image
 */
class InvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'store_id' => 'required|exists:stores,id',
            'branch_id' => 'required|exists:branches,id',
            'subtotal' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'currency' => 'required|string|max:3',
            'status' => 'required|in:pending,send,registered,cancelled',
            'invoice_items' => 'required|array',
            'invoice_items.*.product_id' => 'required|exists:products,id',
            'invoice_items.*.quantity' => 'required|integer|min:1',
            'invoice_items.*.unit_price' => 'required|numeric|min:0',
            'invoice_items.*.total' => 'required|numeric|min:0',
        ];
    }
}
