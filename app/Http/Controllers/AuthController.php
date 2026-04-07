<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeUserMail;

class AuthController extends Controller
{
    use \App\Traits\ValidatesRecaptcha;

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $settings = Setting::first();
        // $siteKey = config('services.recaptcha.site_key', $settings?->recaptcha_site_key);
        // $secretKey = config('services.recaptcha.secret_key', $settings?->recaptcha_secret_key);
        // $recaptchaEnabled = (bool) ($siteKey && $secretKey);

        // if ($recaptchaEnabled) {
        //     if (! $this->validateRecaptcha($request->input('g-recaptcha-response'), true)) {
        //         return back()
        //             ->withErrors(['g-recaptcha-response' => 'فشل التحقق من أنك لست روبوت، يرجى المحاولة مرة أخرى.'])
        //             ->withInput();
        //     }
        // }

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('customer')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'))->with('success', 'مرحباً بك! تم تسجيل الدخول بنجاح.');
        }

        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $settings = Setting::first();
        $siteKey = config('services.recaptcha.site_key', $settings?->recaptcha_site_key);
        $secretKey = config('services.recaptcha.secret_key', $settings?->recaptcha_secret_key);
        $recaptchaEnabled = (bool) ($siteKey && $secretKey);

        if ($recaptchaEnabled) {
            if (! $this->validateRecaptcha($request->input('g-recaptcha-response'), true)) {
                return back()
                    ->withErrors(['g-recaptcha-response' => 'فشل التحقق من أنك لست روبوت، يرجى المحاولة مرة أخرى.'])
                    ->withInput();
            }
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $customer = Customer::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        try {
            Mail::to($customer->email)->send(new WelcomeUserMail($customer));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Welcome Email Sending failed: ' . $e->getMessage());
        }

        Auth::guard('customer')->login($customer);

        return redirect()->route('home')->with('success', 'تم إنشاء حسابك بنجاح! مرحباً بك.');
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'تم تسجيل الخروج بنجاح.');
    }
}
