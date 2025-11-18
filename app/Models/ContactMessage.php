<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactMessage extends Model
{
    use HasFactory;

    protected $table = 'contact_messages';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'subject',
        'message',
        'status',
        'read_at',
        'replied_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'replied_at' => 'datetime',
    ];

    /**
     * Get the user that sent the message
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

