<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Privacy extends Model
{
    protected $table = 'privacies';
    
    protected $fillable = ['title', 'content', 'sort_order', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
