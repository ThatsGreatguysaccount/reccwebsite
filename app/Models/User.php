<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'uid',
        'first_name',
        'last_name',
        'account_type',
        'country',
        'address1',
        'address2',
        'zip_code',
        'id_verification_status',
        'bank_verification_status',
        'front_id',
        'back_id',
        'bank_statement',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Generate a unique UID for the user
     */
    public static function generateUID(): string
    {
        do {
            $uid = 'UID' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));
        } while (self::where('uid', $uid)->exists());

        return $uid;
    }

    /**
     * Get the user's crypto holdings
     */
    public function cryptoHoldings(): HasMany
    {
        return $this->hasMany(CryptoHolding::class);
    }

    /**
     * Get the user's fiat holdings
     */
    public function fiatHoldings(): HasMany
    {
        return $this->hasMany(FiatHolding::class);
    }
}

