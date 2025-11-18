<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WithdrawalRequest extends Model
{
    use HasFactory;

    protected $table = 'withdrawal_requests';

    protected $fillable = [
        'user_id',
        'type',
        'asset',
        'amount',
        'amount_usd',
        'wallet_address',
        'bank_account',
        'network_fee',
        'status',
        'rejection_reason',
        'notes',
        'confirmed_at',
        'rejected_at',
        'confirmed_by',
        'rejected_by',
        'transaction_hash',
    ];

    protected $casts = [
        'amount' => 'decimal:8',
        'amount_usd' => 'decimal:2',
        'network_fee' => 'decimal:8',
        'confirmed_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    /**
     * Get the user that owns the withdrawal request
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who confirmed the request
     */
    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    /**
     * Get the admin who rejected the request
     */
    public function rejectedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }
}

