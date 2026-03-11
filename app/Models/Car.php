<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'name', 'brand_id', 'type', 'category', 'model_year', 'price', 'discount_price',
        'condition', 'availability_status', 'main_image', 'specs', 
        'other_specs', 'description', 'seats', 'doors', 
        'transmission', 'luggage', 'fuel_type', 'is_featured', 'slug',
    ];

    protected $casts = [
        'specs' => 'array',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::creating(function ($car) {
            if (empty($car->slug)) {
                $car->slug = \App\Helpers\ArabicSlugHelper::unique($car->name, self::class);
            }
        });

        static::updating(function ($car) {
            if ($car->isDirty('name') && empty($car->slug)) {
                $car->slug = \App\Helpers\ArabicSlugHelper::unique($car->name, self::class, 'slug', $car->id);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(CarImage::class);
    }
}
