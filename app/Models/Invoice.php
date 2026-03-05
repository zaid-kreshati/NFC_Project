<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    //
    protected $fillable = [
        'uuid',
        'external_invoice_id',
        'user_id',
        'store_id',
        'store_name',
        'branch_id',
        'subtotal',
        'tax',
        'total',
        'currency',
        'payment_method',
        'status',
        'pos_timestamp',

    ];

    protected $casts = [
        'pos_timestamp' => 'datetime:Y-m-d H:i:s',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];



    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
