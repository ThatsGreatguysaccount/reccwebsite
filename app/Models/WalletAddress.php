<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletAddress extends Model
{
    use HasFactory;

    protected $table = 'wallet_addresses';

    protected $fillable = [
        'user_id',
        'symbol',
        'chain',
        'address',
    ];

    /**
     * Get the user that owns the wallet address
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

