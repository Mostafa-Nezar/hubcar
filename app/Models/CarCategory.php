<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarCategory extends Model
{
    protected $fillable = ['car_model_id', 'name'];

    public function model()
    {
        return $this->belongsTo(CarModel::class, 'car_model_id');
    }
}
