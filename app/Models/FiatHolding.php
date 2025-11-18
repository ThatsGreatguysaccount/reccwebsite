<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FiatHolding extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'symbol',
        'balance',
        'value_usd',
        'allocation_percentage',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'value_usd' => 'decimal:2',
        'allocation_percentage' => 'decimal:2',
    ];

    /**
     * Get the user that owns the holding
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

