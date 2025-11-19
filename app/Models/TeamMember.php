<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'designation',
        'email',
        'photo',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the photo URL
     */
    public function getPhotoUrlAttribute(): ?string
    {
        if (!$this->photo) {
            return null;
        }

        // If it's already a full URL, return it
        if (filter_var($this->photo, FILTER_VALIDATE_URL)) {
            return $this->photo;
        }

        // Otherwise, return the storage URL
        return asset('storage/' . $this->photo);
    }
}
