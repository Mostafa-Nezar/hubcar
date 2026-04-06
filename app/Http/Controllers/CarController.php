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

        $cars = $query->paginate(12)->withQueryString();
        
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
        if (config('services.recaptcha.site_key') || $settings?->recaptcha_enabled_booking) {
            if (!$this->validateRecaptcha($request->input('g-recaptcha-response'))) {
                return back()->withErrors(['g-recaptcha-response' => 'فشل التحقق من أنك لست روبوت، يرجى المحاولة مرة أخرى.'])->withInput();
            }
        }

        $validated = $request->validate([
            // 3 to 6 Arabic name parts separated by spaces (Saudi ID style)
            'client_name' => ['required', 'string', 'max:255', 'regex:/^\p{Arabic}+(?:\s+\p{Arabic}+){2,5}$/u'],
            // Saudi mobile formats: 05xxxxxxxx | +9665xxxxxxxx | 009665xxxxxxxx (allow spaces/dashes)
            'phone' => ['required', 'string', 'max:20', 'regex:/^(?:\+?966|00966|0)?5[0-9]{8}$/'],
            'city' => 'required|string|max:100',
            'payment_type' => 'required|in:cash,finance',
            'bank_name' => 'required_if:payment_type,finance|nullable|string|max:100',
            'work_sector' => 'required_if:payment_type,finance|nullable|in:govt,private,military,retired',
            'monthly_salary' => 'required_if:payment_type,finance|nullable|numeric|min:0',
            'client_notes' => 'nullable|string',
        ]
        ,
        [
            'client_name.regex' => 'الرجاء إدخال الاسم كما هو مكتوب في بطاقة الهوية.',
            'phone.regex' => 'الرجاء إدخال رقم جوال صحيح بالصيغة السعودية.',
        ]
    );

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
