<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CarController;

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

Route::get('/login', function () {
    return redirect()->route('filament.admin.auth.login');
})->name('login');

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
