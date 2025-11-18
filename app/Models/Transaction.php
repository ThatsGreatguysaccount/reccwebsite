<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'withdrawal_request_id',
        'type',
        'asset',
        'amount',
        'amount_usd',
        'status',
        'wallet_address',
        'transaction_hash',
        'notes',
        'date_time',
    ];

    protected $casts = [
        'amount' => 'decimal:8',
        'amount_usd' => 'decimal:2',
        'date_time' => 'datetime',
    ];

    /**
     * Get the user that owns the transaction
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the withdrawal request associated with this transaction
     */
    public function withdrawalRequest(): BelongsTo
    {
        return $this->belongsTo(WithdrawalRequest::class);
    }
}

