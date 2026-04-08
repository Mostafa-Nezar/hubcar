<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoPage extends Model
{
    protected $fillable = [
        'url_path',
        'page_name',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_image',
        'twitter_image',
    ];

    protected $casts = [
        'meta_keywords' => 'array',
    ];
}
