@props(['cars'])

<div class="relative group h-[70vh] md:h-[85vh] lg:h-[90vh] w-full overflow-hidden bg-secondary">
    <!-- Swiper -->
    <div class="swiper heroSwiper h-full w-full">
        <div class="swiper-wrapper">
            @forelse($cars as $car)
                <div class="swiper-slide relative flex items-center justify-center overflow-hidden">
                    <!-- Link Wrapper for the entire slide image -->
                    <a href="{{ route('cars.show', $car->slug) }}" class="absolute inset-0 z-0 group/slide">
                        @php
                            $imageUrl = str_starts_with($car->main_image, 'http')
                                ? $car->main_image
                                : (str_starts_with($car->main_image, 'img/')
                                    ? asset($car->main_image)
                                    : Storage::url($car->main_image));
                        @endphp
                        <!-- <img src="{{ $imageUrl }}" alt="{{ $car->name }}" loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                                fetchpriority="{{ $loop->first ? 'high' : 'auto' }}" decoding="async"
                                class="w-full h-full object-contain bg-gray-100 transform scale-110 transition-transform duration-[12000ms] ease-out car-img-zoom group-hover/slide:scale-105"> -->
                        <img src="{{ $imageUrl }}" alt="{{ $car->name }}" loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                        fetchpriority="{{ $loop->first ? 'high' : 'auto' }}" decoding="async"
                            class="w-full h-full object-cover transform scale-110 transition-transform duration-[12000ms] ease-out car-img-zoom group-hover/slide:scale-105">
                        <!-- Elegant Dark Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-b from-secondary/50 via-secondary/20 to-secondary/90">
                        </div>
                        <div class="absolute inset-0 bg-secondary/30"></div>
                    </a>

                    <!-- Minimalist Content -->
                    <div class="container mx-auto px-6 relative z-10 text-center pointer-events-none">
                        <div class="max-w-4xl mx-auto space-y-4 md:space-y-6">

                            <!-- Delicate Label -->
                            <div class="slide-up-content opacity-0 translate-y-4 transition-all duration-1000 delay-300">
                                <span
                                    class="text-primary font-medium tracking-[0.3em] md:tracking-[0.5em] text-xs md:text-sm uppercase inline-block border-b border-primary/30 pb-2">
                                    {{ $car->brand->name ?? 'Luxury Selection' }}
                                </span>
                            </div>

                            <!-- Majestic Title -->
                            <div class="slide-up-content opacity-0 translate-y-4 transition-all duration-1000 delay-500">
                                <h1
                                    class="text-3xl md:text-5xl lg:text-8xl font-black text-white leading-tight drop-shadow-2xl px-2">
                                    {{ $car->name }}
                                </h1>
                            </div>

                            <!-- Minimal Price / Year -->
                            <div class="slide-up-content opacity-0 translate-y-4 transition-all duration-1000 delay-700">
                                <p
                                    class="text-base md:text-xl text-gray-200 font-light flex items-center justify-center gap-3 md:gap-4">
                                    <span>{{ $car->model_year }}</span>
                                    <span class="w-1 h-1 md:w-1.5 md:h-1.5 bg-primary rounded-full"></span>

                                    @if ($car->discount_price)
                                        <span class="flex items-center gap-3">
                                            <span
                                                class="text-gray-400 line-through text-sm md:text-base opacity-70">{{ number_format($car->price) }}</span>
                                            <span class="font-bold text-primary">
                                                {{ number_format($car->discount_price) }}
                                                <span
                                                    class="icon-saudi_riyal text-3xl md:text-4xl inline-block align-middle transform translate-y-[-2px]"></span>
                                            </span>
                                        </span>
                                    @else
                                        <span class="font-bold text-primary">
                                            {{ number_format($car->price) }}
                                            <span
                                                class="icon-saudi_riyal text-3xl md:text-4xl inline-block align-middle transform translate-y-[-2px]"></span>
                                        </span>
                                    @endif
                                </p>
                            </div>

                            <!-- Refined CTA -->
                            <div
                                class="pt-4 md:pt-8 slide-up-content opacity-0 translate-y-4 transition-all duration-1000 delay-900 pointer-events-auto">
                                <a href="{{ route('cars.show', $car->slug) }}"
                                    class="group relative inline-flex items-center justify-center px-8 md:px-12 py-3 md:py-4 bg-white text-secondary rounded-full font-bold overflow-hidden transition-all duration-500 hover:bg-primary hover:text-white hover:scale-105 active:scale-95 shadow-2xl">
                                    <span class="relative z-10 flex items-center gap-2 text-sm md:text-base">
                                        {{ __('اكتشف الفخامة') }}
                                        <i
                                            class="ti-arrow-left mt-1 transform group-hover:-translate-x-1 transition-transform"></i>
                                    </span>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <!-- Clean Minimal Fallback -->
                <div class="swiper-slide bg-secondary flex items-center justify-center">
                    <h2 class="text-white text-3xl font-black italic opacity-20 uppercase">Hup Car</h2>
                </div>
            @endforelse
        </div>

        <!-- Minimal Navigation Indicators -->
        <div class="absolute bottom-6 md:bottom-12 left-0 w-full z-20">
            <div class="container mx-auto px-6 flex justify-between items-center">
                <div class="flex gap-2 md:gap-3 swiper-pagination-custom"></div>
                <div class="flex gap-2 md:gap-4">
                    <button
                        class="nav-prev w-10 h-10 md:w-12 md:h-12 rounded-full border border-white/20 flex items-center justify-center text-white hover:bg-white hover:text-secondary transition-all">
                        <i class="ti-angle-right text-xs md:text-sm"></i>
                    </button>
                    <button
                        class="nav-next w-10 h-10 md:w-12 md:h-12 rounded-full border border-white/20 flex items-center justify-center text-white hover:bg-white hover:text-secondary transition-all">
                        <i class="ti-angle-left text-xs md:text-sm"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Artistic Overlay Elements -->
        <div class="absolute top-0 right-0 p-12 z-20 hidden lg:block select-none pointer-events-none">
            <span class="text-white/10 font-black text-2xl rotate-90 inline-block origin-right">EST. 2024</span>
        </div>
    </div>
</div>

@push('styles')
    <style>
        /* Content Animations */
        .heroSwiper .swiper-slide-active .slide-up-content {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }

        .heroSwiper .swiper-slide-active .car-img-zoom {
            transform: scale(1) !important;
        }

        /* Custom Pagination Bullets */
        .swiper-pagination-custom .swiper-pagination-bullet {
            width: 8px;
            height: 3px;
            background: #fff;
            opacity: 0.2;
            border-radius: 4px;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            margin: 0 !important;
        }

        @media (min-width: 768px) {
            .swiper-pagination-custom .swiper-pagination-bullet {
                width: 12px;
                height: 4px;
            }
        }

        .swiper-pagination-custom .swiper-pagination-bullet-active {
            width: 24px;
            background: #c19b76;
            opacity: 1;
            border-radius: 4px;
        }

        @media (min-width: 768px) {
            .swiper-pagination-custom .swiper-pagination-bullet-active {
                width: 40px;
            }
        }

        [dir="rtl"] .nav-prev i,
        [dir="rtl"] .nav-next i {
            transform: rotate(0deg);
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Swiper !== 'undefined') {
                const swiper = new Swiper('.heroSwiper', {
                    loop: true,
                    grabCursor: true,
                    watchSlidesProgress: true,
                    speed: 1500,
                    autoplay: {
                        delay: 6000,
                        disableOnInteraction: false,
                    },
                    effect: 'fade',
                    fadeEffect: {
                        crossFade: true
                    },
                    pagination: {
                        el: '.swiper-pagination-custom',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.nav-next',
                        prevEl: '.nav-prev',
                    }
                });
            }
        });
    </script>
@endpush
