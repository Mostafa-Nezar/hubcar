@extends('layouts.app')

@section('title', $car->seo_title ?? $car->name)

@section('meta_description', $car->seo_description ?? Str::limit(strip_tags($car->description), 160))

@section('meta_keywords')
@if($car->seo_keywords)
{{ is_array($car->seo_keywords) ? implode(', ', $car->seo_keywords) : $car->seo_keywords }}
@else
سيارة {{ $car->name }}, {{ $car->brand->name }}, {{ $car->model_year }}, {{ $car->type }}, سيارات للبيع
@endif
@endsection

@php
    $mainImageUrl = str_starts_with($car->main_image, 'http')
        ? $car->main_image
        : (str_starts_with($car->main_image, 'img/')
            ? asset($car->main_image)
            : Storage::url($car->main_image));

    $ogImageUrl = $car->og_image 
        ? (str_starts_with($car->og_image, 'http') ? $car->og_image : Storage::url($car->og_image))
        : $mainImageUrl;
@endphp

@section('og_image', $ogImageUrl)
@section('twitter_image', $ogImageUrl)

@section('content')
    <!-- Breadcrumb & Header -->
    <div class="bg-gray-50 border-b border-gray-100 py-6">
        <div class="container mx-auto px-4 lg:px-8">
            <nav class="flex text-sm text-gray-400 mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-reverse space-x-2">
                    <li><a href="{{ route('home') }}" class="hover:text-primary transition-colors">الرئيسية</a></li>
                    <li><i class="ti-angle-left text-[10px] mx-2"></i></li>
                    <li><a href="{{ route('cars.index', request()->query()) }}" class="hover:text-primary transition-colors">السيارات</a></li>
                    <li><i class="ti-angle-left text-[10px] mx-2"></i></li>
                    <li class="text-secondary font-bold">{{ $car->name }}</li>
                </ol>
            </nav>
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <span
                        class="inline-block px-3 py-1 bg-primary/10 text-primary rounded-lg text-xs font-bold tracking-widest uppercase mb-3">{{ $car->brand->name }}
                        | {{ $car->type }}</span>
                    <h1 class="text-4xl lg:text-6xl font-black text-secondary leading-tight">{{ $car->name }}</h1>
                </div>
                <div class="flex flex-col md:items-end">
                    <span class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">السعر نقدأً</span>
                    <div class="flex flex-col md:items-end gap-1">
                        @if ($car->discount_price)
                            <div class="flex items-center gap-2 mb-[-10px]">
                                <span
                                    class="text-xl font-bold text-gray-400 line-through">{{ number_format($car->price) }}</span>
                                <span class="text-sm text-red-500 font-bold bg-red-50 px-2 py-0.5 rounded">عرض خاص</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span
                                    class="text-5xl font-black text-primary">{{ number_format($car->discount_price) }}</span>
                                <span class="icon-saudi_riyal text-5xl text-primary font-bold"></span>
                            </div>
                        @else
                            <div class="flex items-center gap-3">
                                <span class="text-5xl font-black text-primary">{{ number_format($car->price) }}</span>
                                <span class="icon-saudi_riyal text-5xl text-primary font-bold"></span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-12">

                <!-- Left Column: Gallery & Details -->
                <div class="lg:w-2/3">
                    <!-- Professional Gallery -->
                    <div class="mb-16">
                        <div
                            class="relative rounded-[2rem] overflow-hidden shadow-2xl mb-6 group bg-gray-100 aspect-[16/9]">
                            <img id="mainGalleryImage" src="{{ $mainImageUrl }}" alt="{{ $car->name }}" loading="lazy"
                                decoding="async"
                                class="w-full h-full object-cover transform transition-all duration-700">

                            <!-- Overlay Info -->
                            <div class="absolute bottom-6 left-6 z-20">
                                <span
                                    class="bg-white/90 backdrop-blur px-4 py-2 rounded-xl text-secondary font-bold text-sm shadow-xl">
                                    {{ $car->model_year }} Model
                                </span>
                            </div>

                            <!-- Availability Badge -->
                            <div class="absolute top-6 left-6 z-20">
                                <span
                                    class="px-6 py-2 rounded-full text-sm font-black shadow-lg {{ $car->availability_status == 'available' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                    {{ $car->availability_status == 'available' ? 'متوفرة الآن' : 'مباعة' }}
                                </span>
                            </div>
                        </div>

                        @if ($car->images->count() > 0)
                            <div class="grid grid-cols-4 md:grid-cols-6 gap-4">
                                <div class="aspect-square rounded-2xl overflow-hidden shadow-sm border-2 border-primary cursor-pointer thumbnail-item active"
                                    onclick="switchImage('{{ $mainImageUrl }}', this)">
                                    <img src="{{ $mainImageUrl }}" class="w-full h-full object-cover" loading="lazy" decoding="async">
                                </div>
                                @foreach ($car->images as $img)
                                    @php
                                        $galleryUrl = str_starts_with($img->path, 'http')
                                            ? $img->path
                                            : Storage::url($img->path);
                                    @endphp
                                    <div class="aspect-square rounded-2xl overflow-hidden shadow-sm border-2 border-transparent hover:border-primary transition-all cursor-pointer thumbnail-item"
                                        onclick="switchImage('{{ $galleryUrl }}', this)">
                                        <img src="{{ $galleryUrl }}" alt="Gallery image" loading="lazy" decoding="async"
                                            class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Features Grid (Desktop only) -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-16">
                        <div
                            class="bg-gray-50 p-6 rounded-3xl border border-gray-100 flex flex-col items-center text-center">
                            <div
                                class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mb-4 text-xl">
                                <i class="ti-user"></i>
                            </div>
                            <span class="text-xs text-gray-400 font-bold mb-1">المقاعد</span>
                            <span class="text-lg font-black text-secondary">{{ $car->seats ?? '5' }}</span>
                        </div>
                        <div
                            class="bg-gray-50 p-6 rounded-3xl border border-gray-100 flex flex-col items-center text-center">
                            <div
                                class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mb-4 text-xl">
                                <i class="ti-settings"></i>
                            </div>
                            <span class="text-xs text-gray-400 font-bold mb-1">ناقل الحركة</span>
                            <span
                                class="text-lg font-black text-secondary">{{ $car->transmission == 'automatic' ? 'أتوماتيك' : 'يدوي' }}</span>
                        </div>
                        <div
                            class="bg-gray-50 p-6 rounded-3xl border border-gray-100 flex flex-col items-center text-center">
                            <div
                                class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mb-4 text-xl">
                                <i class="ti-shine"></i>
                            </div>
                            <span class="text-xs text-gray-400 font-bold mb-1">الوقود</span>
                            <span class="text-lg font-black text-secondary">{{ $car->fuel_type ?? 'بنزين' }}</span>
                        </div>
                        <div
                            class="bg-gray-50 p-6 rounded-3xl border border-gray-100 flex flex-col items-center text-center">
                            <div
                                class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mb-4 text-xl">
                                <i class="ti-calendar"></i>
                            </div>
                            <span class="text-xs text-gray-400 font-bold mb-1">الموديل</span>
                            <span class="text-lg font-black text-secondary">{{ $car->model_year }}</span>
                        </div>
                    </div>

                    <!-- Tabs or Sections -->
                    <div class="space-y-16">
                        <!-- Overview -->
                        <div>
                            <div class="flex items-center gap-4 mb-8">
                                <div class="h-8 w-2 bg-primary rounded-full"></div>
                                <h2 class="text-3xl font-black text-secondary">نظرة عامة</h2>
                            </div>
                            <div
                                class="bg-gray-50/50 p-8 rounded-[2.5rem] border border-gray-100 italic text-xl leading-relaxed text-gray-600">
                                {{ $car->description }}
                            </div>
                        </div>

                        <!-- Technical Information -->
                        <div>
                            <div class="flex items-center gap-4 mb-8">
                                <div class="h-8 w-2 bg-primary rounded-full"></div>
                                <h2 class="text-3xl font-black text-secondary">المواصفات الفنية</h2>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div
                                    class="flex items-center justify-between p-5 rounded-2xl border border-gray-100 hover:bg-gray-50 transition-colors">
                                    <span class="text-gray-400 font-bold">النوع</span>
                                    <span class="text-secondary font-black">{{ $car->type }}</span>
                                </div>
                                <div
                                    class="flex items-center justify-between p-5 rounded-2xl border border-gray-100 hover:bg-gray-50 transition-colors">
                                    <span class="text-gray-400 font-bold">الفئة</span>
                                    <span class="text-secondary font-black">{{ $car->category ?? 'غير محددة' }}</span>
                                </div>
                                <div
                                    class="flex items-center justify-between p-5 rounded-2xl border border-gray-100 hover:bg-gray-50 transition-colors">
                                    <span class="text-gray-400 font-bold">الحالة</span>
                                    <span
                                        class="px-4 py-1 rounded-full text-xs font-black {{ $car->condition == 'new' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                        {{ $car->condition == 'new' ? 'جديدة' : 'مستعملة' }}
                                    </span>
                                </div>
                                @if ($car->specs)
                                    @foreach ($car->specs as $key => $val)
                                        <div
                                            class="flex items-center justify-between p-5 rounded-2xl border border-gray-100 hover:bg-gray-50 transition-colors">
                                            <span class="text-gray-400 font-bold">{{ $key }}</span>
                                            <span class="text-secondary font-black">{{ $val }}</span>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <!-- Additional Content Box -->
                        @if ($car->other_specs)
                            <div>
                                <div class="flex items-center gap-4 mb-8">
                                    <div class="h-8 w-2 bg-primary rounded-full"></div>
                                    <h2 class="text-3xl font-black text-secondary">المعدات والميزات</h2>
                                </div>
                                <div
                                    class="bg-secondary text-white p-10 rounded-[3rem] shadow-2xl relative overflow-hidden group">
                                    <div
                                        class="absolute -top-24 -right-24 w-64 h-64 bg-primary/10 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-1000">
                                    </div>
                                    <div class="relative z-10 whitespace-pre-line leading-loose text-lg text-gray-300">
                                        {{ $car->other_specs }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column: Premium Booking Card -->
                <div class="lg:w-1/3">
                    <div class="sticky top-12">
                        <div
                            class="bg-white rounded-[2.5rem] p-10 shadow-[0_30px_100px_rgba(0,0,0,0.08)] border border-gray-100 relative overflow-hidden">
                            <!-- Highlighting badge -->
                            <div
                                class="absolute top-0 right-0 py-2 px-8 bg-primary rounded-bl-[1.5rem] text-white text-[10px] font-black uppercase tracking-widest">
                                Best Deal
                            </div>

                            <div class="mb-10 mt-4">
                                <h4 class="text-xs text-gray-400 font-bold uppercase tracking-widest mb-4">هل أنت جاهز
                                    للقيادة؟</h4>
                                <div class="space-y-4">
                                    <a href="{{ route('cars.booking', [$car->slug, 'type' => 'cash']) }}"
                                        class="flex items-center justify-between w-full p-6 bg-secondary text-white rounded-2xl font-black hover:bg-black transition-all group">
                                        <span class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center">
                                                <i class="ti-wallet text-xl"></i>
                                            </div>
                                            احجز نقدأً (كاش)
                                        </span>
                                        <i
                                            class="ti-arrow-left opacity-0 group-hover:opacity-100 -translate-x-4 group-hover:translate-x-0 transition-all"></i>
                                    </a>

                                    <a href="{{ route('cars.booking', [$car->slug, 'type' => 'finance']) }}"
                                        class="flex items-center justify-between w-full p-6 bg-primary text-white rounded-2xl font-black hover:bg-opacity-90 transition-all group shadow-[0_10px_30px_rgba(193,155,118,0.3)] hover:shadow-primary/40">
                                        <span class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                                                <i class="ti-medall text-xl"></i>
                                            </div>
                                            اطلب تمويل الآن
                                        </span>
                                        <i
                                            class="ti-arrow-left opacity-0 group-hover:opacity-100 -translate-x-4 group-hover:translate-x-0 transition-all transition-all"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="space-y-4 pt-10 border-t border-gray-100">
                                <p class="text-sm text-gray-500 text-center italic">تواصل معنا عبر القنوات السريعة:</p>
                                <div class="flex gap-4">
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings?->whatsapp ?? '966500000000') }}"
                                        class="flex-1 flex items-center justify-center gap-3 py-4 rounded-xl border-2 border-green-500/20 text-[#25D366] font-bold hover:bg-green-500 hover:text-white transition-all">
                                        <i class="fa-brands fa-whatsapp text-xl"></i>
                                        واتساب
                                    </a>
                                    <a href="tel:{{ $settings?->phone ?? '+966500000000' }}"
                                        class="flex-1 flex items-center justify-center gap-3 py-4 rounded-xl border-2 border-blue-500/20 text-blue-500 font-bold hover:bg-blue-500 hover:text-white transition-all">
                                        <i class="ti-mobile text-xl"></i>
                                        اتصال
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Trust Badge -->
                        <div class="mt-8 flex items-center gap-6 p-6">
                            <div
                                class="w-14 h-14 bg-primary/10 rounded-full flex items-center justify-center text-primary text-2xl flex-shrink-0">
                                <i class="ti-shield"></i>
                            </div>
                            <div>
                                <h6 class="text-secondary font-black text-sm">ضمان الجودة والثقة</h6>
                                <p class="text-xs text-gray-400">جميع سياراتنا تخضع لفحص شامل بأدق المعايير العالمية.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Similar Cars Section -->
    <x-similar-cars :cars="$similarCars" />

    @push('scripts')
        <script>
            function switchImage(src, element) {
                const mainImg = document.getElementById('mainGalleryImage');

                // Fade effect
                mainImg.style.opacity = '0';

                setTimeout(() => {
                    mainImg.src = src;
                    mainImg.style.opacity = '1';

                    // Active class for thumbnails
                    document.querySelectorAll('.thumbnail-item').forEach(thumb => {
                        thumb.classList.remove('border-primary');
                        thumb.classList.add('border-transparent');
                    });
                    element.classList.remove('border-transparent');
                    element.classList.add('border-primary');
                }, 300);
            }
        </script>
    @endpush
@endsection
