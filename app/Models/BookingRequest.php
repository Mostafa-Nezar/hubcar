<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class BookingRequest extends Model
{
    use Notifiable;
    protected $fillable = [
        'payment_type', 'client_name', 'phone', 'email', 'car_id', 'car_name_manual',
        'brand_name', 'car_type', 'car_category', 'car_price',
        'model_year', 'city', 'request_date', 'status', 'state_category',
        'bank_name', 'work_sector', 'monthly_salary', 'client_notes',
        'internal_notes', 'updated_by', 'last_status_update',
        'monthly_installment', 'down_payment', 'finance_period',
    ];

    protected $casts = [
        'request_date' => 'datetime',
        'last_status_update' => 'datetime',
        'monthly_salary' => 'decimal:2',
        'monthly_installment' => 'decimal:2',
        'down_payment' => 'decimal:2',
        'finance_period' => 'integer',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    protected static function booted()
    {
        static::updating(function ($booking) {
            if ($booking->isDirty('status')) {
                $booking->last_status_update = now();
                $booking->updated_by = auth()->id();
            }
        });
    }

    public function scopeNewRequests($query)
    {
        return $query->where('status', 'New');
    }

    public function scopeByPaymentType($query, $type)
    {
        return $query->where('payment_type', $type);
    }
}
