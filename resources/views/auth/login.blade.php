@extends('layouts.app')

@section('title', 'تسجيل الدخول')

@section('content')
    <section class="py-24 bg-gray-50">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="max-w-md mx-auto">
                <div class="bg-white rounded-3xl shadow-xl p-8 md:p-10 border border-gray-100">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-secondary mb-2">تسجيل الدخول</h2>
                        <p class="text-gray-500">مرحباً بك مرة أخرى</p>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border-r-4 border-red-500 rounded-xl">
                            <ul class="list-none text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li class="flex items-center gap-2 mb-1">
                                        <i class="ti-alert-circle"></i>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">البريد الإلكتروني</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary text-gray-800"
                                placeholder="example@email.com">
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-2">كلمة المرور</label>
                            <input type="password" id="password" name="password" required
                                class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary text-gray-800"
                                placeholder="••••••••">
                        </div>

                        @php
                            $siteKey = env('RECAPTCHA_SITE_KEY', $settings?->recaptcha_site_key);
                        @endphp
                        @if ($siteKey)
                            <div class="flex justify-center">
                                <div class="recaptcha-wrapper">
                                    <div class="g-recaptcha" data-sitekey="{{ $siteKey }}"></div>
                                </div>
                            </div>
                            @error('g-recaptcha-response')
                                <div class="text-red-500 text-sm font-bold text-center italic">
                                    يجب تأكيد أنك لست برنامج روبوت.
                                </div>
                            @enderror
                        @endif

                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="remember" class="w-4 h-4 text-primary rounded focus:ring-primary">
                                <span class="text-sm text-gray-600">تذكرني</span>
                            </label>
                        </div>

                        <button type="submit"
                            class="w-full bg-primary text-white font-bold py-4 rounded-xl hover:bg-opacity-90 transition shadow-lg">
                            تسجيل الدخول
                        </button>
                    </form>

                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-500">
                            ليس لديك حساب؟
                            <a href="{{ route('register') }}" class="text-primary font-bold hover:underline">سجل الآن</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
