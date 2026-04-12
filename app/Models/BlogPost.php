<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_published',
        'published_at',
        'user_id',
        'content_font_size',
        'content_font_family',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
