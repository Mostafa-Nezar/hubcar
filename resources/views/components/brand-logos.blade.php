@props(['brands'])

<section class="partners-section py-20 bg-white overflow-hidden">
    <!-- Header -->
    <div class="container mx-auto px-4 lg:px-8 text-center mb-12">
        <h6 class="text-primary font-bold tracking-widest uppercase text-sm mb-2">{{ __('أفضل الماركات') }}</h6>
        <h2 class="text-4xl md:text-5xl font-black text-secondary tracking-tighter uppercase italic">
            {{ __('اختر حسب') }} <span class="text-primary">{{ __('العلامة التجارية') }}</span>
        </h2>
        <div class="h-1.5 w-24 bg-primary mx-auto rounded-full mt-4"></div>
    </div>

    <!-- Marquee Slider -->
    <style>
        .partners-slider-container {
            width: 100%;
            overflow: hidden;
            position: relative;
            background: #ffffff;
            direction: ltr;
        }

        /* Fade edges */
        .partners-slider-container::before,
        .partners-slider-container::after {
            content: "";
            position: absolute;
            top: 0;
            width: 100px;
            height: 100%;
            z-index: 2;
            pointer-events: none;
        }

        .partners-slider-container::before {
            left: 0;
            background: linear-gradient(to right, white 0%, transparent 100%);
        }

        .partners-slider-container::after {
            right: 0;
            background: linear-gradient(to left, white 0%, transparent 100%);
        }

        .partners-track {
            display: flex;
            width: max-content;
            animation: slideLeft 40s linear infinite;
        }

        .partners-slider-container:hover .partners-track {
            animation-play-state: paused;
        }

        .partner-logo-card {
            width: 220px;
            height: 120px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            filter: grayscale(100%);
            transition: all 0.4s ease;
            margin: 0 1rem;
            background: #f9fafb;
            border-radius: 1.5rem;
            flex-shrink: 0;
            position: relative;
            z-index: 1;
        }

        .partner-logo-card:hover {
            filter: grayscale(0%);
            background: white;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            transform: translateY(-8px) scale(1.05); /* Slight lift */
            border: 1px solid #f3f4f6;
            z-index: 20;
        }

        .partner-logo-card img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
        }

        @keyframes slideLeft {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        /* Responsive speed */
        @media (max-width: 768px) {
            .partners-track {
                animation: slideLeft 25s linear infinite;
            }

            .partner-logo-card {
                width: 160px;
                height: 90px;
            }
        }
    </style>

    <div class="partners-slider-container py-12">
        <div class="partners-track">
            <!-- First Set -->
            @foreach ($brands as $brand)
                @php
                    $logoUrl = str_starts_with($brand->logo, 'http') ? $brand->logo : Storage::url($brand->logo);
                @endphp
                <a href="{{ route('cars.index', ['brand' => $brand->id]) }}" class="partner-logo-card">
                    <img
                        class="partner-logo-img"
                        src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
                        data-src="{{ $logoUrl }}"
                        alt="{{ $brand->name }}"
                        decoding="async"
                        loading="lazy">
                </a>
            @endforeach

            <!-- Duplicated Set for infinite effect -->
            @foreach ($brands as $brand)
                @php
                    $logoUrl = str_starts_with($brand->logo, 'http') ? $brand->logo : Storage::url($brand->logo);
                @endphp
                <a href="{{ route('cars.index', ['brand' => $brand->id]) }}" class="partner-logo-card">
                    <img
                        class="partner-logo-img"
                        src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
                        data-src="{{ $logoUrl }}"
                        alt="{{ $brand->name }}"
                        decoding="async"
                        loading="lazy">
                </a>
            @endforeach
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Avoid double-initializing if this component renders more than once.
                if (window.__brandLogosLazyInit) return;
                window.__brandLogosLazyInit = true;

                const images = document.querySelectorAll('.partner-logo-img[data-src]:not([data-loaded])');
                if (!('IntersectionObserver' in window) || images.length === 0) {
                    images.forEach(img => {
                        img.src = img.dataset.src;
                        img.dataset.loaded = '1';
                    });
                    return;
                }

                // Shrink the root horizontally so "edge" logos load later.
                const observer = new IntersectionObserver((entries, obs) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src;
                            img.dataset.loaded = '1';
                            obs.unobserve(img);
                        }
                    });
                }, {
                    root: null,
                    rootMargin: '0px -250px 0px -250px',
                    threshold: 0.01
                });

                images.forEach(img => observer.observe(img));
            });
        </script>
    @endpush
</section>