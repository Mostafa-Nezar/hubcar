<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $settings?->meta_title ?? 'معرض هب كار') - Renax</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', $settings?->meta_description ?? 'أفضل معرض سيارات في المملكة العربية السعودية - نوفر أفضل السيارات بأفضل الأسعار مع إمكانية التمويل')">
    <meta name="keywords" content="@yield('meta_keywords', $settings?->meta_keywords ?? 'سيارات, معرض سيارات, الرياض, تمويل سيارات, السعودية')">
    <meta name="author" content="{{ $settings?->site_name ?? 'هب كار' }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', $settings?->meta_title ?? 'معرض هب كار')">
    <meta property="og:description" content="@yield('meta_description', $settings?->meta_description ?? 'أفضل معرض سيارات في المملكة العربية السعودية')">
    <meta property="og:image" content="@yield('og_image', $settings?->og_image ? asset('storage/' . $settings->og_image) : asset('img/og-default.jpg'))">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', $settings?->meta_title ?? 'معرض هب كار')">
    <meta property="twitter:description" content="@yield('meta_description', $settings?->meta_description ?? 'أفضل معرض سيارات في المملكة العربية السعودية')">
    <meta property="twitter:image" content="@yield('twitter_image', $settings?->og_image ? asset('storage/' . $settings->og_image) : asset('img/og-default.jpg'))">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

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
    @include('partials.header')

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
                document.addEventListener('DOMContentLoaded', function() {
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
    @include('partials.footer')

    <!-- WhatsApp Floating Button -->
    <div class="fixed bottom-8 right-8 z-50 group">
        <a href="https://wa.me/{{ $settings?->whatsapp ? preg_replace('/[^0-9]/', '', $settings->whatsapp) : '966532533580' }}" target="_blank" 
           class="relative flex items-center justify-center w-16 h-16 bg-green-500 text-white rounded-full shadow-lg shadow-green-500/40 transition-all duration-300 hover:scale-110" 
           aria-label="Chat on WhatsApp">
            <span class="absolute inline-flex h-full w-full rounded-full bg-green-500 opacity-20 animate-ping duration-[1.5s]"></span>
            <span class="absolute inline-flex h-full w-full rounded-full bg-green-500 opacity-10 animate-ping duration-[2s] delay-150"></span>
            <i class="fa-brands fa-whatsapp text-4xl drop-shadow-md z-10"></i>
            <span class="absolute right-full mr-4 bg-gray-900/90 backdrop-blur text-white text-sm font-bold px-3 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap shadow-xl pointer-events-none transform translate-x-2 group-hover:translate-x-0">
                تواصل معنا
                <span class="absolute top-1/2 -right-1 -translate-y-1/2 border-4 border-transparent border-l-gray-900/90"></span>
            </span>
        </a>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?hl=ar" async defer></script>
    @stack('scripts')
    @livewireScripts
</body>

</html>
