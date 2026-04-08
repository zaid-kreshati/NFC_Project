<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;



class Branch extends Model
{
    protected $fillable = [
        'store_id',
        'name',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

     public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function pos_devices(): HasMany
    {
        return $this->hasMany(PosDevice::class);
    }
}
