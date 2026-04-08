<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', [PageController::class, 'home'])->name('home');

// Static Pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/banks', [PageController::class, 'banks'])->name('banks');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'storeContact'])->name('contact.store');

// Cars Gallery & Details
Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
Route::get('/cars/{car}', [CarController::class, 'show'])->name('cars.show');
Route::get('/booking/{car}', [CarController::class, 'booking'])->name('cars.booking');
Route::post('/booking/{car}', [CarController::class, 'storeBooking'])->name('cars.booking.store');
Route::get('/quick-booking', [CarController::class, 'quickBooking'])->name('cars.quick-booking');
Route::post('/quick-booking-store', [CarController::class, 'storeQuickBooking'])->name('cars.quick-booking.store');

// Authentication Routes (User)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest:customer');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest:customer');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register')->middleware('guest:customer');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest:customer');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:customer');

// Customer Dashboard Routes
Route::middleware('auth:customer')->prefix('dashboard')->name('customer.')->group(function () {
    Route::get('/', [CustomerController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
    Route::put('/profile', [CustomerController::class, 'updateProfile'])->name('profile.update');
    Route::get('/change-password', [CustomerController::class, 'changePassword'])->name('change-password');
    Route::put('/password', [CustomerController::class, 'updatePassword'])->name('password.update');
    Route::get('/bookings', [CustomerController::class, 'bookings'])->name('bookings');
    Route::get('/bookings/{id}', [CustomerController::class, 'bookingDetail'])->name('booking-detail');
});

// Redirect for convenience
Route::redirect('/profile', '/dashboard/profile');
Route::redirect('/dashboard-profile', '/dashboard/profile');


Route::get('/migrate', function () {
    if (! app()->environment('local')) {
        abort(403);
    }

   
   
    
    Artisan::call('migrate', [
        '--force' => true,
    ]);
    // Artisan::call('db:seed', [
    //     '--force' => true,
    // ]);


    return 'Database reset & seeded successfully!';
});

Route::get('/fix-storage', function () {
    try {
        // حذفه في حال كان موجود كملف وهمي أو مجلد فارغ لمنع تعارض الإنشاء
        if (file_exists(public_path('storage'))) {
            if (is_link(public_path('storage'))) {
                unlink(public_path('storage'));
            } else {
                \Illuminate\Support\Facades\File::deleteDirectory(public_path('storage'));
            }
        }
        
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        return 'تم إصلاح مشكلة الصور (Storage Linked Successfully) ✅';
    } catch (\Exception $e) {
        return 'حدث خطأ: ' . $e->getMessage();
    }
});

Route::get('/clear-cache', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        
        return 'تم تنظيف الكاشات والإعدادات بنجاح من السيرفر ✅';
    } catch (\Exception $e) {
        return 'حدث خطأ: ' . $e->getMessage();
    }
});
