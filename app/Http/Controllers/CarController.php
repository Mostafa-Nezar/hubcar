<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\BookingRequest;
use App\Models\FinanceEntity;
use Illuminate\Http\Request;

class CarController extends Controller
{
    use \App\Traits\ValidatesRecaptcha;

    public function index(Request $request)
    {
        $query = Car::query();

        // Filtering
        if ($request->has('brand')) {
            $query->whereHas('brand', function($q) use ($request) {
                $q->where('id', $request->brand);
            });
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sorting
        if ($request->sort == 'price_low') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort == 'price_high') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        $cars = $query->paginate(12);
        
        return view('cars.index', compact('cars'));
    }

    public function show(Car $car)
    {
        $car->load(['brand', 'images']);
        $similarCars = Car::where('brand_id', $car->brand_id)
            ->where('id', '!=', $car->id)
            ->take(3)
            ->get();
            
        return view('cars.show', compact('car', 'similarCars'));
    }

    public function booking(Request $request, Car $car)
    {
        $selectedCar = $car;
        $type = $request->query('type', 'cash'); // cash or finance
        $financeEntities = FinanceEntity::all();
        
        return view('cars.booking', compact('selectedCar', 'type', 'financeEntities'));
    }

    public function storeBooking(Request $request, Car $car)
    {

        $settings = \App\Models\Setting::first();
        if ($settings?->recaptcha_enabled_booking) {
            if (!$this->validateRecaptcha($request->input('g-recaptcha-response'), true)) {
                return back()->withErrors(['g-recaptcha-response' => 'فشل التحقق من الكابتشا.'])->withInput();
            }
        }

        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'city' => 'nullable|string|max:100',
            'payment_type' => 'required|in:cash,finance',
            'bank_name' => 'nullable|string|max:100',
            'work_sector' => 'nullable|string|max:100',
            'monthly_salary' => 'nullable|numeric',
            'client_notes' => 'nullable|string',
        ]);

        $booking = BookingRequest::create([
            'client_name' => $validated['client_name'],
            'phone' => $validated['phone'],
            'city' => $validated['city'],
            'car_id' => $car->id,
            'car_name_manual' => $car->name,
            'brand_name' => $car->brand->name ?? null,
            'car_type' => $car->type,
            'car_category' => $car->category,
            'car_price' => $car->price,
            'model_year' => $car->model_year,
            'payment_type' => $validated['payment_type'],
            'bank_name' => $validated['bank_name'] ?? null,
            'work_sector' => $validated['work_sector'] ?? null,
            'monthly_salary' => $validated['monthly_salary'] ?? null,
            'client_notes' => $validated['client_notes'] ?? null,
            'request_date' => now(),
            'status' => 'New',
        ]);

        return redirect()->route('home')->with('success', 'تم استلام طلبك بنجاح! سنقوم بالتواصل معك قريباً.');
    }
}
