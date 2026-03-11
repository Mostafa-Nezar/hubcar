<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutPage extends Model
{
    protected $fillable = [
        'title', 'subtitle', 'description_1', 'description_2',
        'exp_label', 'exp_value', 'clients_label', 'clients_value', 'image',
        'feature_1', 'feature_2', 'feature_3'
    ];
}
