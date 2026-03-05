<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NfcTag extends Model
{
    protected $fillable = [
        'invoice_id',
        'is_active',
        'scan_count',
        'last_scanned_at',
    ];

    protected $casts = [
        'last_scanned_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
