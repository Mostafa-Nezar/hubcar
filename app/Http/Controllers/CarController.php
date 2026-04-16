<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\BookingRequest;
use App\Models\QuickBookingRequest;
use App\Models\FinanceEntity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    use \App\Traits\ValidatesRecaptcha;

    public function index(Request $request)
    {
        $query = Car::with(['brand', 'offer']);

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
        $financeEntities = FinanceEntity::all();
            
        return view('cars.show', compact('car', 'similarCars', 'financeEntities'));
    }

    public function booking(Request $request, Car $car)
    {
        $selectedCar = $car;
        $type = $request->query('type', 'cash'); // cash or finance
        $financeEntities = FinanceEntity::all();
        
        // If user is logged in, pass their data
        $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();
        
        $financeData = [
            'installment' => $request->query('installment'),
            'down_payment' => $request->query('down_payment'),
            'period' => $request->query('period'),
            'bank' => $request->query('bank'),
        ];
        
        return view('cars.booking', compact('selectedCar', 'type', 'financeEntities', 'user', 'financeData'));
    }

    public function quickBooking()
    {
        $cars = Car::latest()->get();
        
        // If user is logged in, pass their data
        $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();
        
        return view('cars.quick-booking', compact('cars', 'user'));
    }

    public function storeBooking(Request $request, Car $car)
    {
        // $settings = \App\Models\Setting::first();
        // if (config('services.recaptcha.site_key') || $settings?->recaptcha_enabled_booking) {
        //     if (!$this->validateRecaptcha($request->input('g-recaptcha-response'))) {
        //         return back()->withErrors(['g-recaptcha-response' => 'فشل التحقق من أنك لست روبوت، يرجى المحاولة مرة أخرى.'])->withInput();
        //     }
        // }

        $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();
        
        // Sanitize inputs
        $sanitized = array_map(function($value) {
            return is_string($value) ? trim(strip_tags($value)) : $value;
        }, $request->all());
        $request->merge($sanitized);

        // Always require name and phone, regardless of login status
        $validated = $request->validate([
            'client_name' => ['required', 'string', 'max:255', 'regex:/^[\p{Arabic}a-zA-Z]+(?:\s+[\p{Arabic}a-zA-Z]+){2,5}$/u'],
            'phone' => ['required', 'string', 'max:20', 'regex:/^(?:\+?966|00966|0)?5[0-9]{8}$/'],
            'email' => 'nullable|email|max:255',
            'city' => 'required|string|max:100',
            'payment_type' => 'required|in:cash,finance',
            'bank_name' => 'required_if:payment_type,finance|nullable|string|max:100',
            'work_sector' => 'required_if:payment_type,finance|nullable|in:govt,private,military,retired',
            'monthly_salary' => 'required_if:payment_type,finance|nullable|numeric|min:0',
            'monthly_installment' => 'nullable|numeric|min:0',
            'down_payment' => 'nullable|numeric|min:0',
            'finance_period' => 'nullable|integer|min:1',
            'client_notes' => 'nullable|string',
        ], [
            'client_name.regex' => __('الرجاء إدخال الاسم كما هو مكتوب في بطاقة الهوية.'),
            'phone.regex' => __('الرجاء إدخال رقم جوال صحيح بالصيغة السعودية.'),
        ]);

        $booking = BookingRequest::create([
            'client_name' => $validated['client_name'],
            'phone' => $validated['phone'],
            'email' => $user ? $user->email : ($validated['email'] ?? null),
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
            'monthly_installment' => $validated['monthly_installment'] ?? null,
            'down_payment' => $validated['down_payment'] ?? null,
            'finance_period' => $validated['finance_period'] ?? null,
            'client_notes' => $validated['client_notes'] ?? null,
            'request_date' => now(),
            'status' => 'New',
        ]);

        return redirect()->route('home')->with('success', __('تم استلام طلبك بنجاح! سنقوم بالتواصل معك قريباً.'));
    }

    public function storeQuickBooking(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::guard('customer')->user();
        
        // Sanitize inputs
        $sanitized = array_map(function($value) {
            return is_string($value) ? trim(strip_tags($value)) : $value;
        }, $request->all());
        $request->merge($sanitized);

        // Always require name and phone, regardless of login status
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'client_name' => ['required', 'string', 'max:255', 'regex:/^[\p{Arabic}a-zA-Z]+(?:\s+[\p{Arabic}a-zA-Z]+){2,5}$/u'],
            'phone' => ['required', 'string', 'max:20', 'regex:/^(?:\+?966|00966|0)?5[0-9]{8}$/'],
            'email' => 'nullable|email|max:255',
            'city' => 'required|string|max:100',
        ], [
            'client_name.regex' => __('الرجاء إدخال الاسم كما هو مكتوب في بطاقة الهوية.'),
            'phone.regex' => __('الرجاء إدخال رقم جوال صحيح بالصيغة السعودية.'),
        ]);

        $car = Car::findOrFail($validated['car_id']);

        $booking = QuickBookingRequest::create([
            'client_name' => $validated['client_name'],
            'phone' => $validated['phone'],
            'email' => $user ? $user->email : ($validated['email'] ?? null),
            'city' => $validated['city'],
            'car_id' => $car->id,
            'car_name_manual' => $car->name,
            'brand_name' => $car->brand->name ?? null,
            'car_type' => $car->type,
            'car_category' => $car->category,
            'car_price' => $car->price,
            'model_year' => $car->model_year,
            'payment_type' => 'cash',
            'request_date' => now(),
            'status' => 'New',
        ]);

        // إذا كان الطلب AJAX، أعد JSON response
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('تم إرسال طلبك بنجاح! سنقوم بالتواصل معك في أقرب وقت.'),
                'booking_id' => $booking->id
            ]);
        }

        return redirect()->route('home')->with('success', __('تم إرسال طلبك بنجاح! سنقوم بالتواصل معك في أقرب وقت.'));
    }

    public function compare()
    {
        $allCars = Car::select('id', 'name')->orderBy('name')->get();
        return view('cars.compare', compact('allCars'));
    }

    public function apiCompare(Request $request)
    {
        $ids = $request->query('ids', []);
        
        // If IDs are sent as a comma-separated string instead of an array
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }

        if (empty($ids)) {
            return response()->json([]);
        }

        $ids = array_filter(array_slice($ids, 0, 3)); // Limit and clean

        $cars = Car::whereIn('id', $ids)
            ->with('brand')
            ->get();

        // Sort by the order of IDs provided
        $cars = $cars->sortBy(function($car) use ($ids) {
            return array_search($car->id, $ids);
        })->values();

        return response()->json($cars->map(function($car) {
            return [
                'id' => $car->id,
                'name' => $car->name,
                'brand' => $car->brand->name ?? '',
                'price' => number_format($car->price),
                'discount_price' => $car->discount_price ? number_format($car->discount_price) : null,
                'model_year' => $car->model_year,
                'fuel_type' => $car->fuel_type ?? 'بنزين',
                'transmission' => $car->transmission == 'automatic' ? 'أتوماتيك' : 'يدوي',
                'seats' => $car->seats,
                'doors' => $car->doors,
                'luggage' => $car->luggage,
                'condition' => $car->condition == 'new' ? 'جديدة' : 'مستعملة',
                'type' => $car->type,
                'category' => $car->category,
                'image' => str_starts_with($car->main_image, 'http')
                    ? $car->main_image
                    : (str_starts_with($car->main_image, 'img/')
                        ? asset($car->main_image)
                        : Storage::url($car->main_image)),
                'url' => route('cars.show', $car->slug),
                'booking_url' => route('cars.booking', $car->slug),
                'specs' => $car->specs,
                'starting_installment' => number_format($car->starting_installment),
            ];
        }));
    }
}
