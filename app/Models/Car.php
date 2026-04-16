<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\HasTranslations;

class Car extends Model
{
    use HasTranslations;

    public $translatable = []; // Ready for translatable columns
    protected $fillable = [
        'name',
        'brand_id',
        'type',
        'category',
        'model_year',
        'price',
        'discount_price',
        'condition',
        'availability_status',
        'main_image',
        'specs',
        'other_specs',
        'description',
        'seats',
        'doors',
        'transmission',
        'luggage',
        'fuel_type',
        'is_featured',
        'slug',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'og_image',
        'offer_id',
    ];

    protected $casts = [
        'specs' => 'array',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'seo_keywords' => 'array',
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

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
        return $this->hasMany(CarImage::class)->orderBy('sort_order');
    }

    public function getStartingInstallmentAttribute()
    {
        $price = $this->discount_price ?? $this->price;
        $interestRate = 3.5; // Default flat rate
        $months = 60; // 5 years
        $downPaymentPercent = 10;
        
        $principle = $price * (1 - ($downPaymentPercent / 100));
        $totalInterest = $principle * ($interestRate / 100) * ($months / 12);
        $totalAmount = $principle + $totalInterest;
        
        return round($totalAmount / $months);
    }
}
