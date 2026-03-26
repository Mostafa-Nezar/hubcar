@extends('layouts.app')

@section('title', 'اتصل بنا')

@section('content')
    <section class="bg-secondary py-20 text-center relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <img src="{{ asset('img/about.jpg') }}" alt="" loading="lazy" decoding="async" class="w-full h-full object-cover">
        </div>
        <h1 class="text-4xl lg:text-5xl font-bold text-white mb-4 relative z-10">تواصل معنا</h1>
        <p class="text-gray-400 relative z-10 italic">فريقنا جاهز للرد على جميع استفساراتكم</p>
    </section>

    <section class="py-24 bg-gray-50 italic">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-16">
                <!-- Info -->
                <div class="lg:w-1/3 space-y-12">
                    <div>
                        <h3 class="text-2xl font-black text-secondary mb-8">معلومات التواصل</h3>
                        <div class="space-y-8">
                            <div class="flex items-start">
                                <div
                                    class="w-12 h-12 bg-primary bg-opacity-10 text-primary rounded-2xl flex items-center justify-center ml-4 shrink-0">
                                    <i class="ti-location-pin text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-secondary mb-1">الموقع</h4>
                                    <p class="text-gray-500">{{ $settings?->address ?? 'الرياض، المملكة العربية السعودية' }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div
                                    class="w-12 h-12 bg-primary bg-opacity-10 text-primary rounded-2xl flex items-center justify-center ml-4 shrink-0">
                                    <i class="ti-mobile text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-secondary mb-1">الهاتف</h4>
                                    <p class="text-gray-500">{{ $settings?->phone ?? '+966 50 000 0000' }}</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div
                                    class="w-12 h-12 bg-primary bg-opacity-10 text-primary rounded-2xl flex items-center justify-center ml-4 shrink-0">
                                    <i class="ti-email text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-secondary mb-1">البريد</h4>
                                    <p class="text-gray-500">{{ $settings?->email ?? 'info@renax.com' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-8 bg-secondary rounded-3xl text-white">
                        <h4 class="font-bold mb-4">ساعات العمل</h4>
                        <div class="flex justify-between text-sm text-gray-400 mb-2">
                            <span>السبت - الخميس:</span>
                            <span>{{ $settings?->work_hours_weekdays ?? '9:00 ص - 10:00 م' }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-400">
                            <span>الجمعة:</span>
                            <span>{{ $settings?->work_hours_friday ?? '4:00 م - 10:00 م' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <div class="lg:w-2/3 bg-white p-12 rounded-3xl shadow-xl border border-gray-100">
                    <h3 class="text-2xl font-black text-secondary mb-8">أرسل لنا رسالة</h3>
                    <form action="{{ route('contact.store') }}" method="POST"
                        class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @csrf
                        <div class="space-y-2">
                            <label class="font-bold text-gray-700">الاسم</label>
                            <input type="text" name="name" placeholder="الاسم الكامل"
                                class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-primary text-gray-600 transition"
                                required>
                        </div>
                        <div class="space-y-2">
                            <label class="font-bold text-gray-700">البريد</label>
                            <input type="email" name="email" placeholder="example@mail.com"
                                class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-primary text-gray-600 transition"
                                required>
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="font-bold text-gray-700">الموضوع</label>
                            <input type="text" name="subject" placeholder="عن ماذا تود الاستفسار؟"
                                class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-primary text-gray-600 transition"
                                required>
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="font-bold text-gray-700">الرسالة</label>
                            <textarea name="message" rows="5" placeholder="اكتب رسالتك هنا..."
                                class="w-full bg-gray-50 border-none rounded-3xl px-6 py-4 focus:ring-2 focus:ring-primary text-gray-600 transition"
                                required></textarea>
                        </div>
                        @php
                            $siteKey = env('RECAPTCHA_SITE_KEY', $settings?->recaptcha_site_key);
                        @endphp
                        @if ($siteKey)
                            <div class="md:col-span-2 flex justify-center">
                                <div class="recaptcha-wrapper">
                                    <div class="g-recaptcha" data-sitekey="{{ $siteKey }}"></div>
                                </div>
                            </div>
                        @endif

                        <div class="md:col-span-2">
                            @error('g-recaptcha-response')
                                <div class="text-red-500 text-sm mb-4 font-bold text-center italic">يجب تأكيد أنك لست برنامج
                                    روبوت.</div>
                            @enderror
                            <button type="submit"
                                class="w-full bg-primary text-white font-black py-4 rounded-2xl hover:bg-opacity-90 transition shadow-lg uppercase tracking-widest italic">إرسال
                                الرسالة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    @if ($settings?->google_maps_iframe)
        <div class="h-96 w-full grayscale hover:grayscale-0 transition-all duration-700 bg-gray-200">
            {!! $settings->google_maps_iframe !!}
        </div>
    @else
        <div class="h-96 w-full grayscale bg-gray-200 flex items-center justify-center text-gray-400 font-bold italic">
            (الخريطة غير مفعلة حالياً)
        </div>
    @endif
@endsection
