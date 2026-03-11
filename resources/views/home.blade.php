@extends('layouts.app')

@section('title', 'الرئيسية')

@section('content')
    <!-- Hero Slider Section -->
    <x-hero-slider :cars="$featuredCars" />


    <!-- Brand Logos Section -->
    <x-brand-logos :brands="$brands" />

    <!-- Dynamic Cars Section with Real-time Filtering -->
    <section class="py-20 bg-gray-50 overflow-hidden">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="text-center mb-16">
                <h6 class="text-primary font-bold tracking-widest uppercase text-sm mb-2">معرضنا المتجدد</h6>
                <h2 class="text-4xl font-bold text-secondary">ابحث عن <span class="text-primary">سيارتك</span> في متجرنا</h2>
            </div>

            @livewire('car-list')
        </div>
    </section>

    <!-- Finance Section -->
    <x-finance-logos :banks="$banks" />

    <!-- About Section Brief -->
    <section class="py-24 bg-white relative overflow-hidden">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="lg:w-1/2 relative">
                    <img src="{{ $about?->image ? asset('storage/' . $about->image) : asset('img/about.jpg') }}"
                        alt="{{ $about?->title ?? 'About our showroom' }}" class="rounded-3xl shadow-2xl z-10 relative">
                    <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-primary rounded-3xl -z-0 hidden lg:block"></div>
                </div>
                <div class="lg:w-1/2">
                    <h6 class="text-primary font-bold tracking-widest uppercase text-sm mb-4">من نحن</h6>
                    <h2 class="text-4xl font-bold text-secondary mb-8 leading-tight">
                        @if ($about?->title)
                            {!! str_replace('سيارتك', '<span class="text-primary">سيارتك</span>', $about->title) !!}
                        @else
                            نحن شريكك الموثوق في <span class="text-primary">رحلة شراء</span> سيارتك
                        @endif
                    </h2>
                    <p class="text-gray-500 mb-8 leading-relaxed italic text-lg line-clamp-3">
                        {{ $about?->description_1 ?? 'نقدم تجربة استثنائية في عالم السيارات، حيث الجودة والمصداقية هي أساس عملنا. نوفر لك كافة التسهيلات لتمتلك سيارة أحلامك بكل يسر وسهولة.' }}
                    </p>

                    <ul class="space-y-4 mb-10">
                        @if ($about?->feature_1)
                            <li class="flex items-center text-secondary font-bold">
                                <i class="ti-check ml-3 text-primary bg-primary bg-opacity-10 p-1 rounded"></i>
                                {{ $about->feature_1 }}
                            </li>
                        @endif
                        @if ($about?->feature_2)
                            <li class="flex items-center text-secondary font-bold">
                                <i class="ti-check ml-3 text-primary bg-primary bg-opacity-10 p-1 rounded"></i>
                                {{ $about->feature_2 }}
                            </li>
                        @endif
                        @if ($about?->feature_3)
                            <li class="flex items-center text-secondary font-bold">
                                <i class="ti-check ml-3 text-primary bg-primary bg-opacity-10 p-1 rounded"></i>
                                {{ $about->feature_3 }}
                            </li>
                        @endif
                    </ul>

                    <a href="{{ route('about') }}"
                        class="bg-secondary text-white px-8 py-3 rounded-xl font-bold hover:bg-gray-800 transition shadow-lg inline-block">اقرأ
                        المزيد</a>
                </div>
            </div>
        </div>
    </section>
@endsection
