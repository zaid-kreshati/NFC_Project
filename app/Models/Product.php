<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'store_id',
        'name',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

     public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }

}
