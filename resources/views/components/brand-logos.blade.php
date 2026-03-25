@props(['brands'])

<section class="partners-section py-20 bg-white overflow-hidden">
    <!-- Header -->
    <div class="container mx-auto px-4 lg:px-8 text-center mb-12">
        <h6 class="text-primary font-bold tracking-widest uppercase text-sm mb-2">أفضل الماركات</h6>
        <h2 class="text-4xl md:text-5xl font-black text-secondary tracking-tighter uppercase italic">
            اختر حسب <span class="text-primary">العلامة التجارية</span>
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
                    <img src="{{ $logoUrl }}" alt="{{ $brand->name }}" loading="lazy" decoding="async">
                </a>
            @endforeach

            <!-- Duplicated Set for infinite effect -->
            @foreach ($brands as $brand)
                @php
                    $logoUrl = str_starts_with($brand->logo, 'http') ? $brand->logo : Storage::url($brand->logo);
                @endphp
                <a href="{{ route('cars.index', ['brand' => $brand->id]) }}" class="partner-logo-card">
                    <img src="{{ $logoUrl }}" alt="{{ $brand->name }}" loading="lazy" decoding="async">
                </a>
            @endforeach
        </div>
    </div>
</section>