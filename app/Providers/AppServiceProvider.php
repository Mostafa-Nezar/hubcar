<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Setting;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $settings = Setting::first();
            if (!$settings) {
                $settings = new Setting(['site_name' => 'RENAX (DB EMPTY)']);
            }
            $view->with('settings', $settings);
        });
    }
}
