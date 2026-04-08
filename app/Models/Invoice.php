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
        'branch_id',
        'pos_device_id',
        'claimed',
        'claimed_at',
        'expires_at',
        'subtotal',
        'tax',
        'total',
        'currency',
        'payment_method',
        'status',

    ];

    protected $casts = [
        'claimed' => 'boolean',
        'claimed_at' => 'datetime:Y-m-d H:i:s',
        'expires_at' => 'datetime:Y-m-d H:i:s',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];



    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function pos(): BelongsTo
    {
        return $this->belongsTo(PosDevice::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
