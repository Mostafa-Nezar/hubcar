<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class OfferController extends Controller
{
    public function index()
    {
        $cars = Car::whereHas('offer', function($query) {
            $query->where('is_active', true);
        })->with(['offer', 'brand'])->latest()->paginate(9);

        return view('offers.index', compact('cars'));
    }
}
