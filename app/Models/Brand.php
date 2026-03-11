<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['name', 'logo'];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function models()
    {
        return $this->hasMany(CarModel::class);
    }
}
