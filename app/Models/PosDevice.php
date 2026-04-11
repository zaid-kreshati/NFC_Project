<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PosDevice extends Model
{
    protected $table = 'pos_devices';
    protected $fillable = [
        'name',
        'branch_id',
        'api_token',
        'status',
        'created_by'

    ];

    protected $casts = [
        'created_by' => 'integer',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
