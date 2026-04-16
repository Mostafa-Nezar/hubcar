<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if(isset($seoPage) && $seoPage->meta_title) {{ $seoPage->meta_title }}
        @elseif(View::hasSection('title')) @yield('title')
        @else {{ $settings?->meta_title ?? 'معرض هب كار' }} @endif
        - {{ $settings?->site_name ?? 'هب كار' }}
    </title>

    <!-- SEO Meta Tags -->
    <meta name="description"
        content="@if(View::hasSection('meta_description')) @yield('meta_description') @elseif(isset($seoPage) && $seoPage->meta_description) {{ $seoPage->meta_description }} @else {{ $settings?->meta_description ?? 'أفضل معرض سيارات هب كار' }} @endif">
    <meta name="keywords"
        content="@if(View::hasSection('meta_keywords')) @yield('meta_keywords') @elseif(isset($seoPage) && $seoPage->meta_keywords) {{ is_array($seoPage->meta_keywords) ? implode(', ', $seoPage->meta_keywords) : $seoPage->meta_keywords }} @else {{ $settings?->meta_keywords ?? 'سيارات, هب كار' }} @endif">
    <meta name="author" content="{{ $settings?->site_name ?? 'هب كار' }}">
    <meta name="robots" content="{{ $seoPage?->seo_robots ?? ($settings?->seo_robots ?? 'index, follow') }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="{{ $seoPage?->og_type ?? ($settings?->og_type ?? 'website') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title"
        content="@if(isset($seoPage) && $seoPage->og_title) {{ $seoPage->og_title }} @elseif(isset($seoPage) && $seoPage->meta_title) {{ $seoPage->meta_title }} @elseif(View::hasSection('title')) @yield('title') @else {{ $settings?->og_title ?? ($settings?->meta_title ?? 'معرض هب كار') }} @endif">
    <meta property="og:description"
        content="@if(isset($seoPage) && $seoPage->og_description) {{ $seoPage->og_description }} @elseif(isset($seoPage) && $seoPage->meta_description) {{ $seoPage->meta_description }} @elseif(View::hasSection('meta_description')) @yield('meta_description') @else {{ $settings?->og_description ?? ($settings?->meta_description ?? 'أفضل معرض سيارات هب كار') }} @endif">
    <meta property="og:image"
        content="@if(isset($seoPage) && $seoPage->og_image) {{ asset('storage/' . $seoPage->og_image) }} @else {{ $settings?->og_image ? asset('storage/' . $settings->og_image) : asset('img/og-default.jpg') }} @endif">
    @if($settings?->facebook_app_id)
        <meta property="fb:app_id" content="{{ $settings->facebook_app_id }}">
    @endif

    <!-- Twitter -->
    <meta property="twitter:card"
        content="{{ $seoPage?->twitter_card ?? ($settings?->twitter_card ?? 'summary_large_image') }}">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title"
        content="@if(isset($seoPage) && $seoPage->twitter_title) {{ $seoPage->twitter_title }} @elseif(isset($seoPage) && $seoPage->meta_title) {{ $seoPage->meta_title }} @elseif(View::hasSection('title')) @yield('title') @else {{ $settings?->twitter_title ?? ($settings?->meta_title ?? 'معرض هب كار') }} @endif">
    <meta property="twitter:description"
        content="@if(isset($seoPage) && $seoPage->twitter_description) {{ $seoPage->twitter_description }} @elseif(isset($seoPage) && $seoPage->meta_description) {{ $seoPage->meta_description }} @elseif(View::hasSection('meta_description')) @yield('meta_description') @else {{ $settings?->twitter_description ?? ($settings?->meta_description ?? 'أفضل معرض سيارات هب كار') }} @endif">
    <meta property="twitter:image"
        content="@if(isset($seoPage) && $seoPage->twitter_image) {{ asset('storage/' . $seoPage->twitter_image) }} @elseif(isset($seoPage) && $seoPage->og_image) {{ asset('storage/' . $seoPage->og_image) }} @else {{ $settings?->twitter_image ? asset('storage/' . $settings->twitter_image) : ($settings?->og_image ? asset('storage/' . $settings->og_image) : asset('img/og-default.jpg')) }} @endif">

    <!-- Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">

    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&family=Tajawal:wght@200..900&family=Almarai:wght@300..800&family=IBM+Plex+Sans+Arabic:wght@100..700&display=swap"
        rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">

    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        /* TomSelect Custom Styling */
        .ts-wrapper.single .ts-control {
            border: none !important;
            background-color: #f9fafb !important;
            /* bg-gray-50 */
            padding: 1rem 1.5rem !important;
            border-radius: 1rem !important;
            font-weight: 700 !important;
            color: #1a1a1a !important;
        }

        .ts-wrapper.single.focus .ts-control {
            box-shadow: 0 0 0 2px #c19b76 !important;
            /* ring-primary */
        }

        .ts-wrapper.single.input-active .ts-control {
            background-color: white !important;
            box-shadow: 0 0 0 2px #c19b76 !important;
        }

        .ts-dropdown {
            border-radius: 1rem !important;
            margin-top: 5px !important;
            border: 1px solid #f3f4f6 !important;
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1) !important;
        }

        .ts-dropdown .active {
            background-color: #c19b76 !important;
            color: white !important;
        }

        .ts-dropdown-content,
        .ts-control,
        .ts-dropdown {
            direction: rtl !important;
            text-align: right !important;
        }

        .ts-wrapper.single .ts-control {
            padding-left: 2rem !important;
            padding-right: 1.5rem !important;
        }

        .ts-wrapper.single .ts-control::after {
            left: 15px !important;
            right: auto !important;
        }
    </style>

    @stack('styles')
    @livewireStyles
</head>

<body class="bg-gray-50 text-gray-800">

    <!-- Header -->
    @php
        $isGuest = !auth()->guard('customer')->check();
        if ($isGuest) {
            echo \Illuminate\Support\Facades\Cache::remember('header_guest_html_' . app()->getLocale(), 86400, function () {
                return view('partials.header')->render();
            });
        } else {
    @endphp
    @include('partials.header')
    @php
        }
    @endphp

    <!-- Main Content -->
    <main>
        @if (session('success'))
            <div id="success-notification"
                class="fixed top-24 right-4 md:right-8 z-[100] transform translate-x-full transition-transform duration-500">
                <div
                    class="bg-white rounded-2xl shadow-[0_20px_60px_rgba(0,0,0,0.1)] border-r-4 border-primary p-6 flex items-center gap-6 max-w-md">
                    <div
                        class="w-14 h-14 bg-primary/10 rounded-full flex items-center justify-center text-primary text-2xl animate-bounce">
                        <i class="ti-check"></i>
                    </div>
                    <div>
                        <h4 class="text-secondary font-black text-lg mb-1">تم الإرسال بنجاح!</h4>
                        <p class="text-gray-500 text-sm leading-relaxed">{{ session('success') }}</p>
                    </div>
                    <button onclick="closeNotification()" class="text-gray-300 hover:text-gray-500 transition-colors">
                        <i class="ti-close"></i>
                    </button>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const notification = document.getElementById('success-notification');
                    if (notification) {
                        setTimeout(() => {
                            notification.classList.remove('translate-x-full');
                            notification.classList.add('translate-x-0');
                        }, 500);

                        // Auto hide after 8 seconds
                        setTimeout(() => closeNotification(), 8000);
                    }
                });

                function closeNotification() {
                    const notification = document.getElementById('success-notification');
                    if (notification) {
                        notification.classList.add('translate-x-full');
                        notification.classList.remove('translate-x-0');
                    }
                }
            </script>
        @endif
        @yield('content')
    </main>

    <!-- Footer -->
    @php
        echo \Illuminate\Support\Facades\Cache::remember('footer_html_' . app()->getLocale(), 86400, function () {
            return view('partials.footer')->render();
        });
    @endphp

    <!-- WhatsApp Floating Button -->
    <div class="fixed bottom-8 right-8 z-50 group">
        <a href="https://wa.me/{{ $settings?->whatsapp ? preg_replace('/[^0-9]/', '', $settings->whatsapp) : '966532533580' }}"
            target="_blank"
            class="relative flex items-center justify-center w-16 h-16 bg-green-500 text-white rounded-full shadow-lg shadow-green-500/40 transition-all duration-300 hover:scale-110"
            aria-label="Chat on WhatsApp">
            <span
                class="absolute inline-flex h-full w-full rounded-full bg-green-500 opacity-20 animate-ping duration-[1.5s]"></span>
            <span
                class="absolute inline-flex h-full w-full rounded-full bg-green-500 opacity-10 animate-ping duration-[2s] delay-150"></span>
            <i class="fa-brands fa-whatsapp text-4xl drop-shadow-md z-10"></i>
            <span
                class="absolute right-full mr-4 bg-gray-900/90 backdrop-blur text-white text-sm font-bold px-3 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap shadow-xl pointer-events-none transform translate-x-2 group-hover:translate-x-0">
                تواصل معنا
                <span
                    class="absolute top-1/2 -right-1 -translate-y-1/2 border-4 border-transparent border-l-gray-900/90"></span>
            </span>
        </a>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?hl=ar" async defer></script>

    <script>
        window.countdown = (expiresAt) => {
            return {
                expiresAt: expiresAt,
                time: '',
                init() {
                    this.update();
                    setInterval(() => this.update(), 1000);
                },
                update() {
                    const end = new Date(this.expiresAt).getTime();
                    const now = new Date().getTime();
                    const distance = end - now;

                    if (distance < 0) {
                        this.time = "منتهي";
                        return;
                    }

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    this.time = `${days}ي ${hours}س ${minutes}د ${seconds}ث`;
                }
            };
        };
    </script>
    @stack('scripts')
    @livewireScripts
</body>

</html>