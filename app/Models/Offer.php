<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = ['name', 'badge_text', 'color', 'expires_at', 'is_active', 'description'];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
