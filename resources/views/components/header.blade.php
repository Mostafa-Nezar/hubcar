<header class="bg-white shadow-sm sticky top-0 z-50" x-data="{ mobileMenu: false, openSearch: false }">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center">
                    @if ($settings?->logo)
                        <img src="{{ asset('storage/' . $settings->logo) }}" alt="{{ $settings->site_name }}"
                            class="h-12 w-auto">
                    @else
                        <span class="text-2xl font-bold text-primary">{{ $settings?->site_name ?? 'RENAX' }}</span>
                    @endif
                </a>
            </div>

            <!-- Main Menu (Desktop) -->
            <nav class="hidden md:flex space-x-reverse space-x-8">
                <a href="{{ route('home') }}"
                    class="{{ request()->routeIs('home') ? 'text-primary' : 'text-gray-600' }} hover:text-primary font-medium transition-colors">الرئيسية</a>
                <a href="{{ route('cars.index') }}"
                    class="{{ request()->routeIs('cars.index') ? 'text-primary' : 'text-gray-600' }} hover:text-primary font-medium transition-colors">السيارات</a>
                <a href="{{ route('banks') }}"
                    class="{{ request()->routeIs('banks') ? 'text-primary' : 'text-gray-600' }} hover:text-primary font-medium transition-colors">جهات
                    التمويل</a>
                <a href="{{ route('faq') }}"
                    class="{{ request()->routeIs('faq') ? 'text-primary' : 'text-gray-600' }} hover:text-primary font-medium transition-colors">الأسئلة
                    الشائعة</a>
                <a href="{{ route('about') }}"
                    class="{{ request()->routeIs('about') ? 'text-primary' : 'text-gray-600' }} hover:text-primary font-medium transition-colors">من
                    نحن</a>
                <a href="{{ route('contact') }}"
                    class="{{ request()->routeIs('contact') ? 'text-primary' : 'text-gray-600' }} hover:text-primary font-medium transition-colors">اتصل
                    بنا</a>
            </nav>

            <!-- Quick Order & Search -->
            <div class="flex items-center space-x-reverse space-x-4">
                <!-- Search Component -->
                <div class="relative flex items-center">
                    <button @click="openSearch = !openSearch; if(openSearch) $nextTick(() => $refs.searchInput.focus())"
                        class="p-2 text-gray-500 hover:text-primary transition-colors focus:outline-none">
                        <i class="ti-search text-xl" x-show="!openSearch"></i>
                        <i class="ti-close text-xl" x-show="openSearch" style="display: none;"></i>
                    </button>

                    <!-- Search Input Overlay -->
                    <div x-show="openSearch" @click.away="openSearch = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-cloak
                        class="absolute top-full left-0 mt-4 z-[60] min-w-[280px] lg:min-w-[350px]">
                        <form action="{{ route('cars.index') }}" method="GET"
                            class="flex items-center bg-white rounded-2xl overflow-hidden shadow-2xl border border-gray-100 p-1">
                            <input type="text" name="search" x-ref="searchInput"
                                placeholder="ابحث عن سيارة (مثلاً: كامري)..."
                                class="bg-transparent border-none px-4 py-3 w-full focus:ring-0 text-sm italic"
                                value="{{ request('search') }}">
                            <button type="submit"
                                class="bg-primary text-white p-3 rounded-xl hover:bg-opacity-90 transition shadow-md">
                                <i class="ti-search"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <a href="tel:{{ $settings?->phone ?? '+966500000000' }}"
                    class="hidden lg:flex items-center bg-primary text-white px-6 py-2 rounded-lg hover:bg-opacity-90 transition">
                    <i class="ti-mobile ml-2"></i>
                    <span>طلب سريع</span>
                </a>

                <!-- Mobile Menu Button -->
                <button @click="mobileMenu = true"
                    class="md:hidden p-2 text-gray-600 hover:text-primary transition-colors">
                    <i class="fa-solid fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Drawer -->
    <div x-show="mobileMenu" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[100] md:hidden" x-cloak>

        <!-- Backdrop -->
        <div class="absolute inset-0 bg-secondary/60 backdrop-blur-sm" @click="mobileMenu = false"></div>

        <!-- content -->
        <div x-show="mobileMenu" x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="absolute inset-y-0 right-0 w-[80%] max-w-sm bg-white shadow-2xl flex flex-col">

            <div class="p-6 flex items-center justify-between border-b border-gray-50">
                <a href="{{ route('home') }}" class="flex items-center">
                    @if ($settings?->logo)
                        <img src="{{ asset('storage/' . $settings->logo) }}" alt="{{ $settings->site_name }}"
                            class="h-10 w-auto">
                    @else
                        <span class="text-xl font-bold text-primary">{{ $settings?->site_name ?? 'RENAX' }}</span>
                    @endif
                </a>
                <button @click="mobileMenu = false" class="p-2 text-gray-400 hover:text-secondary transition-colors">
                    <i class="ti-close text-xl"></i>
                </button>
            </div>

            <nav class="flex-grow p-6 space-y-4 overflow-y-auto">
                <a href="{{ route('home') }}"
                    class="flex items-center gap-4 p-4 rounded-xl {{ request()->routeIs('home') ? 'bg-primary/10 text-primary font-bold' : 'text-gray-600 font-medium' }}">
                    <i class="ti-home"></i> الرئيسية
                </a>
                <a href="{{ route('cars.index') }}"
                    class="flex items-center gap-4 p-4 rounded-xl {{ request()->routeIs('cars.index') ? 'bg-primary/10 text-primary font-bold' : 'text-gray-600 font-medium' }}">
                    <i class="ti-car"></i> السيارات
                </a>
                <a href="{{ route('banks') }}"
                    class="flex items-center gap-4 p-4 rounded-xl {{ request()->routeIs('banks') ? 'bg-primary/10 text-primary font-bold' : 'text-gray-600 font-medium' }}">
                    <i class="ti-wallet"></i> جهات التمويل
                </a>
                <a href="{{ route('faq') }}"
                    class="flex items-center gap-4 p-4 rounded-xl {{ request()->routeIs('faq') ? 'bg-primary/10 text-primary font-bold' : 'text-gray-600 font-medium' }}">
                    <i class="ti-help-alt"></i> الأسئلة الشائعة
                </a>
                <a href="{{ route('about') }}"
                    class="flex items-center gap-4 p-4 rounded-xl {{ request()->routeIs('about') ? 'bg-primary/10 text-primary font-bold' : 'text-gray-600 font-medium' }}">
                    <i class="ti-info-alt"></i> من نحن
                </a>
                <a href="{{ route('contact') }}"
                    class="flex items-center gap-4 p-4 rounded-xl {{ request()->routeIs('contact') ? 'bg-primary/10 text-primary font-bold' : 'text-gray-600 font-medium' }}">
                    <i class="ti-headphone-alt"></i> اتصل بنا
                </a>
            </nav>

            <div class="p-6 border-t border-gray-50">
                <a href="tel:{{ $settings?->phone ?? '+966500000000' }}"
                    class="flex items-center justify-center gap-3 w-full bg-primary text-white py-4 rounded-2xl font-bold shadow-lg shadow-primary/20">
                    <i class="ti-mobile"></i> طلب سريع
                </a>
            </div>
        </div>
    </div>
</header>
