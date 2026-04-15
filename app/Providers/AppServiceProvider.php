<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Setting;
use App\Models\BookingRequest;
use App\Models\QuickBookingRequest;
use App\Observers\BookingRequestObserver;
use App\Observers\QuickBookingRequestObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

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
        BookingRequest::observe(BookingRequestObserver::class);
        QuickBookingRequest::observe(QuickBookingRequestObserver::class);

        Paginator::useTailwind();

        View::composer('*', function ($view) {
            $settings = \Illuminate\Support\Facades\Cache::remember('site_settings', 86400, function() {
                return Setting::first() ?? new Setting(['site_name' => 'RENAX (DB EMPTY)']);
            });

            // Fetch SEO for the current path with safety check
            $seoPage = null;
            try {
                if (\Illuminate\Support\Facades\Schema::hasTable('seo_pages')) {
                    $currentPath = request()->getPathInfo();
                    $cacheKey = 'seo_page_' . md5($currentPath);
                    $seoPage = \Illuminate\Support\Facades\Cache::remember($cacheKey, 3600, function() use ($currentPath) {
                        return \App\Models\SeoPage::where('url_path', $currentPath)->first();
                    });
                }
            } catch (\Exception $e) {
                // Ignore error to keep site running
            }

            $view->with('settings', $settings);
            $view->with('seoPage', $seoPage);
        });
    }
}
