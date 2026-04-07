<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuickBookingRequest extends Model
{
    protected $fillable = [
        'payment_type', 'client_name', 'phone', 'email', 'car_id', 'car_name_manual',
        'brand_name', 'car_type', 'car_category', 'car_price',
        'model_year', 'city', 'request_date', 'status', 'state_category',
        'bank_name', 'work_sector', 'monthly_salary', 'client_notes',
        'internal_notes', 'updated_by', 'last_status_update',
    ];

    protected $casts = [
        'request_date' => 'datetime',
        'last_status_update' => 'datetime',
        'monthly_salary' => 'decimal:2',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
