<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Car;
use App\Models\FinanceEntity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    use \App\Traits\ValidatesRecaptcha;

    public function home()
    {
        $featuredCars = Cache::remember('home_featured_cars', 3600, function() {
            return Car::with(['brand', 'offer'])->where('is_featured', '=', true)->get();
        });

        $latestCars = Cache::remember('home_latest_cars', 3600, function() {
            return Car::with(['brand', 'offer'])->latest()->take(8)->get();
        });

        $brands = Cache::remember('all_brands', 86400, function() {
            return Brand::all();
        });

        $banks = Cache::remember('all_banks', 86400, function() {
            return FinanceEntity::all();
        });

        $about = Cache::remember('about_page_first', 86400, function() {
            return \App\Models\AboutPage::first();
        });
        
        return view('home', compact('featuredCars', 'latestCars', 'brands', 'banks', 'about'));
    }

    public function about()
    {
        $about = \App\Models\AboutPage::first();
        return view('about', compact('about'));
    }

    public function banks()
    {
        $banks = FinanceEntity::all();
        return view('banks', compact('banks'));
    }

    public function faq()
    {
        $faqs = Cache::remember('all_faqs', 86400, function() {
            return \App\Models\Faq::where('is_active', true)
                ->orderBy('sort_order', 'asc')
                ->get();
        });
            
        return view('faq', compact('faqs'));
    }

    public function terms()
    {
        $terms = Cache::remember('all_terms', 86400, function() {
            return \App\Models\Term::where('is_active', true)
                ->orderBy('sort_order', 'asc')
                ->get();
        });
            
        return view('terms', compact('terms'));
    }

    public function privacy()
    {
        $privacies = Cache::remember('all_privacies', 86400, function() {
            return \App\Models\Privacy::where('is_active', true)
                ->orderBy('sort_order', 'asc')
                ->get();
        });
            
        return view('privacy', compact('privacies'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function storeContact(Request $request)
    {
        $settings = \App\Models\Setting::first();
        $siteKey = config('services.recaptcha.site_key', $settings?->recaptcha_site_key);
        $secretKey = config('services.recaptcha.secret_key', $settings?->recaptcha_secret_key);
        $shouldValidate = (bool) ($siteKey && $secretKey) && ((bool) $settings?->recaptcha_enabled_contact || (bool) config('services.recaptcha.site_key'));

        if ($shouldValidate) {
            if (! $siteKey || ! $secretKey) {
                return back()->withErrors([
                    'g-recaptcha-response' => 'الكابتشا مفعلة لكن مفاتيحها غير مُعدة. يرجى إضافة Site Key و Secret Key من الإعدادات.',
                ])->withInput();
            }

            if (!$this->validateRecaptcha($request->input('g-recaptcha-response'), true)) {
                return back()->withErrors(['g-recaptcha-response' => 'فشل التحقق من الكابتشا.'])->withInput();
            }
        }

        // Sanitize inputs
        $sanitized = array_map(function($value) {
            return is_string($value) ? trim(strip_tags($value)) : $value;
        }, $request->all());
        $request->merge($sanitized);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        \App\Models\ContactMessage::create($validated);

        return back()->with('success', 'شكراً لتواصلك! تم حفظ رسالتك في نظامنا وسنرد عليك قريباً جداً.');
    }
    public function blogs()
    {
        $posts = \App\Models\BlogPost::where('is_published', true)
            ->where(function ($query) {
                $query->where('published_at', '<=', now())
                    ->orWhereNull('published_at');
            })
            ->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(2);

        return view('blogs', compact('posts'));
    }

    public function blogDetail($slug)
    {
        $post = \App\Models\BlogPost::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Get related posts
        $relatedPosts = \App\Models\BlogPost::where('is_published', true)
            ->where('id', '!=', $post->id)
            ->limit(3)
            ->get();

        return view('blog-detail', compact('post', 'relatedPosts'));
    }
}
