@extends('layouts.app')

@section('title', 'طلب حجز - ' . $selectedCar->name)

@section('content')
    <!-- Page Header -->
    <section class="bg-secondary py-20 relative overflow-hidden">
        <div class="absolute inset-0 z-0">
            @php
                $headerImg = str_starts_with($selectedCar->main_image, 'http')
                    ? $selectedCar->main_image
                    : (str_starts_with($selectedCar->main_image, 'img/')
                        ? asset($selectedCar->main_image)
                        : Storage::url($selectedCar->main_image));
            @endphp
            <img src="{{ $headerImg }}" alt=""
                class="w-full h-full object-cover opacity-20 blur-sm transform scale-105">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-secondary"></div>
        </div>
        <div class="container mx-auto px-4 lg:px-8 relative z-10 text-center">
            <span
                class="inline-block px-4 py-1 bg-primary/20 backdrop-blur-md rounded-full text-primary font-bold text-xs tracking-widest uppercase mb-4">خطوة
                واحدة لامتلاك سيارتك</span>
            <h1 class="text-4xl lg:text-6xl font-black text-white mb-4">
                {{ $type == 'finance' ? 'طلب تمويل سيارة' : 'حجز سيارة نقدياً (كاش)' }}
            </h1>
            <nav class="flex justify-center text-gray-400 text-sm">
                <a href="{{ route('cars.show', $selectedCar->slug) }}"
                    class="hover:text-primary transition font-bold">{{ $selectedCar->name }}</a>
                <span class="mx-2">/</span>
                <span class="text-primary">نموذج الطلب</span>
            </nav>
        </div>
    </section>

    <section class="py-24 bg-gray-50">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="max-w-5xl mx-auto">
                <div
                    class="bg-white rounded-[3rem] shadow-[0_40px_100px_rgba(0,0,0,0.08)] overflow-hidden border border-gray-100 flex flex-col lg:flex-row">

                    <!-- Form Sidebar Info -->
                    <div
                        class="lg:w-1/3 bg-secondary p-12 text-white flex flex-col justify-between relative overflow-hidden">
                        <div class="relative z-10">
                            <h3 class="text-2xl font-black mb-6">تفاصيل السيارة</h3>
                            <div class="space-y-6">
                                <div class="p-4 bg-white/5 rounded-2xl border border-white/10">
                                    <span
                                        class="text-[10px] text-gray-400 font-bold uppercase tracking-widest block mb-1">الماركة
                                        والنوع</span>
                                    <span class="text-lg font-bold block">{{ $selectedCar->brand->name }} -
                                        {{ $selectedCar->type }}</span>
                                </div>
                                <div class="p-4 bg-white/5 rounded-2xl border border-white/10">
                                    <span
                                        class="text-[10px] text-gray-400 font-bold uppercase tracking-widest block mb-1">الفئة
                                        والموديل</span>
                                    <span class="text-lg font-bold block">{{ $selectedCar->category ?? 'Luxury' }}
                                        ({{ $selectedCar->model_year }})</span>
                                </div>
                                <div class="p-4 bg-primary/20 rounded-2xl border border-primary/30">
                                    <span
                                        class="text-[10px] text-primary font-bold uppercase tracking-widest block mb-1">السعر
                                        نقدأً</span>
                                    <span class="text-3xl font-black block">{{ number_format($selectedCar->price) }} <span
                                            class="icon-saudi_riyal text-2xl"></span></span>
                                </div>
                            </div>
                        </div>

                        <div
                            class="relative z-10 mt-12 bg-white/5 p-6 rounded-3xl border border-white/10 text-sm text-gray-400 leading-relaxed italic">
                            <i class="ti-info-alt text-primary mb-2 block text-xl"></i>
                            تأكد من إدخال بيانات صحيحة ليتمكن مستشار المبيعات من خدمتك بشكل أسرع وأدق.
                        </div>

                        <!-- Decoration -->
                        <div class="absolute -bottom-12 -left-12 w-48 h-48 bg-primary rounded-full blur-3xl opacity-20">
                        </div>
                    </div>

                    <!-- Main Form -->
                    <div class="lg:w-2/3 p-8 lg:p-16">
                        <form action="{{ route('cars.booking.store', $selectedCar->slug) }}" method="POST" id="booking-form" onsubmit="return handleFormSubmit(event)">
                            @csrf
                            <input type="hidden" name="payment_type" value="{{ $type }}">
                            <input type="hidden" name="brand_name" value="{{ $selectedCar->brand->name ?? '' }}">
                            <input type="hidden" name="car_type" value="{{ $selectedCar->type }}">
                            <input type="hidden" name="car_category" value="{{ $selectedCar->category }}">
                            <input type="hidden" name="model_year" value="{{ $selectedCar->model_year }}">
                            <input type="hidden" name="car_price" value="{{ $selectedCar->price }}">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Pre-filled Disabled Fields (Visual only) -->
                                <div class="space-y-2 opacity-60">
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest">اسم
                                        السيارة (تلقائي)</label>
                                    <input type="text" value="{{ $selectedCar->name }}" disabled
                                        class="w-full bg-gray-100 border-none rounded-2xl px-6 py-4 text-gray-500 font-bold cursor-not-allowed">
                                </div>

                                <div class="space-y-2 opacity-60">
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest">الموديل
                                        (تلقائي)</label>
                                    <input type="text" value="{{ $selectedCar->model_year }}" disabled
                                        class="w-full bg-gray-100 border-none rounded-2xl px-6 py-4 text-gray-500 font-bold cursor-not-allowed">
                                </div>

                                <!-- Full Name -->
                                <div class="space-y-2">
                                    <label class="block text-xs font-black text-gray-500 uppercase tracking-widest">الاسم
                                        الكامل <span class="text-primary">*</span></label>
                                    <input type="text" name="client_name" value="{{ old('client_name') }}"
                                        placeholder="الاسم كما هو في الهوية"
                                        class="w-full bg-gray-50 border-2 border-transparent focus:border-primary/30 focus:bg-white rounded-2xl px-6 py-4 text-secondary font-bold transition-all outline-none"
                                        required>
                                    @error('client_name')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div class="space-y-2">
                                    <label class="block text-xs font-black text-gray-500 uppercase tracking-widest">رقم
                                        الجوال <span class="text-primary">*</span></label>
                                    <input type="tel" name="phone" value="{{ old('phone') }}"
                                        placeholder="05xxxxxxxx"
                                        class="w-full bg-gray-50 border-2 border-transparent focus:border-primary/30 focus:bg-white rounded-2xl px-6 py-4 text-secondary font-bold text-left transition-all outline-none"
                                        required>
                                    @error('phone')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- City -->
                                <div class="space-y-2">
                                    <label class="block text-xs font-black text-gray-500 uppercase tracking-widest">المدينة
                                        <span class="text-primary">*</span></label>
                                    <select name="city" id="city-select"
                                        class="w-full bg-gray-50 border-2 border-transparent focus:border-primary/30 focus:bg-white rounded-2xl px-6 py-4 text-secondary font-bold transition-all outline-none appearance-none"
                                        required>
                                        <option value="">اختر مدينة الإقامة</option>
                                        @php
                                            $saudiCities = config('saudi-cities', []);
                                            sort($saudiCities);
                                        @endphp
                                        @foreach ($saudiCities as $city)
                                            <option value="{{ $city }}"
                                                {{ old('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                                        @endforeach
                                    </select>
                                    @error('city')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                @if ($type == 'finance')
                                    <!-- Bank Name -->
                                    <div class="space-y-2">
                                        <label class="block text-xs font-black text-gray-500 uppercase tracking-widest">اختر
                                            الجهة التمويلية (البنك) <span class="text-primary">*</span></label>
                                        <select name="bank_name"
                                            class="w-full bg-gray-50 border-2 border-transparent focus:border-primary/30 focus:bg-white rounded-2xl px-6 py-4 text-secondary font-bold transition-all outline-none appearance-none"
                                            required>
                                            <option value="">اختر البنك أو شركة التمويل</option>
                                            @foreach ($financeEntities as $entity)
                                                <option value="{{ $entity->name }}" {{ old('bank_name') == $entity->name ? 'selected' : '' }}>{{ $entity->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('bank_name')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Work Sector -->
                                    <div class="space-y-2">
                                        <label
                                            class="block text-xs font-black text-gray-500 uppercase tracking-widest">قطاع
                                            العمل <span class="text-primary">*</span></label>
                                        <select name="work_sector"
                                            class="w-full bg-gray-50 border-2 border-transparent focus:border-primary/30 focus:bg-white rounded-2xl px-6 py-4 text-secondary font-bold transition-all outline-none appearance-none"
                                            required>
                                            <option value="">اختر القطاع</option>
                                            <option value="govt" {{ old('work_sector') == 'govt' ? 'selected' : '' }}>حكومي</option>
                                            <option value="private" {{ old('work_sector') == 'private' ? 'selected' : '' }}>خاص</option>
                                            <option value="military" {{ old('work_sector') == 'military' ? 'selected' : '' }}>عسكري</option>
                                            <option value="retired" {{ old('work_sector') == 'retired' ? 'selected' : '' }}>متقاعد</option>
                                        </select>
                                        @error('work_sector')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="space-y-2">
                                        <label
                                            class="block text-xs font-black text-gray-500 uppercase tracking-widest">الراتب
                                            الشهري <span class="text-primary">*</span></label>
                                        <input type="number" name="monthly_salary" value="{{ old('monthly_salary') }}" placeholder="مثال: 12000"
                                            class="w-full bg-gray-50 border-2 border-transparent focus:border-primary/30 focus:bg-white rounded-2xl px-6 py-4 text-secondary font-bold transition-all outline-none"
                                            required min="0" step="0.01">
                                        @error('monthly_salary')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif

                                @php
                                    $siteKey = env('RECAPTCHA_SITE_KEY', $settings?->recaptcha_site_key);
                                @endphp
                                @if ($siteKey)
                                    <div class="md:col-span-2 flex justify-center mt-4">
                                        <div class="recaptcha-wrapper">
                                            <div class="g-recaptcha" data-sitekey="{{ $siteKey }}">
                                            </div>
                                        </div>
                                    </div>
                                    @if ($errors->has('g-recaptcha-response'))
                                        <div class="md:col-span-2 text-red-500 text-sm font-bold text-center italic mt-2">
                                            يجب تأكيد أنك لست برنامج روبوت.</div>
                                    @endif
                                @endif

                                <div class="md:col-span-2 space-y-2">
                                    <label class="block text-xs font-black text-gray-500 uppercase tracking-widest">ملاحظات
                                        إضافية</label>
                                    <textarea name="client_notes" rows="4" placeholder="هل لديك استفسارات أو تفاصيل إضافية تود إضافتها؟"
                                        class="w-full bg-gray-50 border-2 border-transparent focus:border-primary/30 focus:bg-white rounded-3xl px-6 py-4 text-secondary font-bold transition-all outline-none"></textarea>
                                </div>
                            </div>

                            <div class="mt-12">
                                <button type="submit" id="submit-btn"
                                    class="w-full bg-primary text-white text-xl font-black py-5 rounded-2xl hover:bg-opacity-90 transition-all shadow-2xl transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-4 group">
                                    <span id="btn-text">إرسال الطلب الآن</span>
                                    <div id="btn-loader"
                                        class="hidden animate-spin h-6 w-6 border-4 border-white border-t-transparent rounded-full">
                                    </div>
                                    <i id="btn-icon"
                                        class="ti-arrow-left group-hover:-translate-x-2 transition-transform"></i>
                                </button>
                                <p class="text-center mt-6 text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                                    <i class="ti-lock text-primary ml-1"></i> بياناتك محمية ومشفرة وفق أعلى معايير الخصوصية
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function handleFormSubmit(event) {
            const form = document.getElementById('booking-form');
            const btn = document.getElementById('submit-btn');
            const text = document.getElementById('btn-text');
            const loader = document.getElementById('btn-loader');
            const icon = document.getElementById('btn-icon');
            if (form.checkValidity()) {
                text.innerText = 'جاري الإرسال...';
                loader.classList.remove('hidden');
                icon.classList.add('hidden');
                btn.classList.add('opacity-80', 'pointer-events-none');
                btn.disabled = true;
                
                return true;
            } else {
                event.preventDefault();
                return false;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            new TomSelect('#city-select', {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                placeholder: "ابحث عن مدينتك...",
                noResultsText: "لم يتم العثور على نتائج",
                render: {
                    no_results: function(data, escape) {
                        return '<div class="no-results">لم يتم العثور على مدينة بهذا الاسم</div>';
                    }
                }
            });
        });
    </script>
@endsection
