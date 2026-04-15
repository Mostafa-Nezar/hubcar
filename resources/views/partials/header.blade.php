<header class="bg-white shadow-sm sticky top-0 z-50" x-data="{ mobileMenu: false, openSearch: false }">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <div class="flex-1 flex items-center justify-start">
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
            <nav class="hidden lg:flex items-center gap-8">
                <a href="{{ route('home') }}"
                    class="{{ request()->routeIs('home') ? 'text-primary' : 'text-gray-600' }} hover:text-primary font-bold transition-colors">الرئيسية</a>
                <a href="{{ route('cars.index') }}"
                    class="{{ request()->routeIs('cars.index') ? 'text-primary' : 'text-gray-600' }} hover:text-primary font-bold transition-colors">السيارات</a>
                <a href="{{ route('offers.index') }}"
                    class="{{ request()->routeIs('offers.index') ? 'text-primary' : 'text-gray-600' }} hover:text-primary font-bold transition-colors">العروض</a>
                <a href="{{ route('blog.index') }}"
                    class="{{ request()->routeIs('blog.index') ? 'text-primary' : 'text-gray-600' }} hover:text-primary font-bold transition-colors">المدونة</a>
                
                <!-- More Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @mouseenter="open = true" @mouseleave="open = false" @click="open = !open"
                        class="flex items-center gap-2 text-gray-600 hover:text-primary font-bold transition-colors">
                        المزيد
                        <i class="ti-angle-down text-[10px] transition-transform" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <!-- Dropdown Content -->
                    <div x-show="open" @mouseenter="open = true" @mouseleave="open = false" x-cloak
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        class="absolute top-full right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-gray-100 py-4 z-50">
                        <a href="{{ route('banks') }}" class="block px-6 py-2 text-sm text-gray-600 hover:text-primary hover:bg-gray-50 transition">جهات التمويل</a>
                        <a href="{{ route('faq') }}" class="block px-6 py-2 text-sm text-gray-600 hover:text-primary hover:bg-gray-50 transition">الأسئلة الشائعة</a>
                        <a href="{{ route('about') }}" class="block px-6 py-2 text-sm text-gray-600 hover:text-primary hover:bg-gray-50 transition">من نحن</a>
                        <a href="{{ route('contact') }}" class="block px-6 py-2 text-sm text-gray-600 hover:text-primary hover:bg-gray-50 transition">اتصل بنا</a>
                    </div>
                </div>
            </nav>

            <!-- Quick Order & Search -->
            <div class="flex-1 flex items-center justify-end space-x-reverse space-x-4">
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

                <!-- Auth Buttons -->
                @auth('customer')
                    <div class="hidden lg:flex items-center gap-4">
                        <!-- Dashboard Button -->
                        <a href="{{ route('customer.dashboard') }}"
                            class="flex items-center justify-center w-10 h-10 rounded-full bg-primary/10 text-primary hover:bg-primary hover:text-white transition-all"
                            title="لوحة التحكم">
                            <i class="ti-dashboard text-xl"></i>
                        </a>
                        <!-- Dropdown Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center gap-2 px-4 py-2 rounded-2xl bg-gray-100 hover:bg-gray-200 transition text-secondary font-medium">
                                <i class="ti-user"></i>
                                <span class="text-sm">{{ Auth::guard('customer')->user()->name }}</span>
                                <i class="ti-arrow-down text-xs" :class="{ 'rotate-180': open }"></i>
                            </button>
                            <!-- Dropdown Items -->
                            <div @show="open" @click.away="open = false"
                                class="absolute top-full right-0 mt-2 w-48 bg-white rounded-2xl shadow-lg border border-gray-100 z-50"
                                x-show="open"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95">
                                <a href="{{ route('customer.dashboard') }}"
                                    class="block px-6 py-3 text-secondary hover:bg-gray-50 font-medium border-b border-gray-100 flex items-center gap-2">
                                    <i class="ti-dashboard"></i> لوحة التحكم
                                </a>
                                <a href="{{ route('customer.profile') }}"
                                    class="block px-6 py-3 text-secondary hover:bg-gray-50 font-medium border-b border-gray-100 flex items-center gap-2">
                                    <i class="ti-user"></i> الملف الشخصي
                                </a>
                                <a href="{{ route('customer.bookings') }}"
                                    class="block px-6 py-3 text-secondary hover:bg-gray-50 font-medium border-b border-gray-100 flex items-center gap-2">
                                    <i class="ti-clipboard"></i> الحجزات
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-6 py-3 text-red-600 hover:bg-red-50 font-medium flex items-center gap-2">
                                        <i class="ti-logout"></i> تسجيل الخروج
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="hidden lg:flex items-center bg-secondary text-white px-6 py-2 rounded-lg hover:bg-gray-800 transition">
                        <i class="ti-user ml-2"></i>
                        <span>تسجيل الدخول</span>
                    </a>
                @endauth('customer')

                <a href="{{ route('cars.quick-booking') }}"
                    class="hidden lg:flex items-center bg-primary text-white px-6 py-2 rounded-lg hover:bg-opacity-90 transition">
                    <i class="ti-bolt ml-2"></i>
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

            <nav class="flex-grow p-6 space-y-2 overflow-y-auto">
                <a href="{{ route('home') }}"
                    class="flex items-center gap-4 p-4 rounded-2xl transition-all {{ request()->routeIs('home') ? 'bg-primary text-white shadow-lg shadow-primary/20 font-bold' : 'text-gray-600 hover:bg-gray-50 font-medium' }}">
                    <i class="ti-home text-lg"></i>
                    <span>الرئيسية</span>
                </a>
                <a href="{{ route('cars.index') }}"
                    class="flex items-center gap-4 p-4 rounded-2xl transition-all {{ request()->routeIs('cars.index') ? 'bg-primary text-white shadow-lg shadow-primary/20 font-bold' : 'text-gray-600 hover:bg-gray-50 font-medium' }}">
                    <i class="ti-car text-lg"></i>
                    <span>السيارات</span>
                </a>
                <a href="{{ route('offers.index') }}"
                    class="flex items-center gap-4 p-4 rounded-2xl transition-all {{ request()->routeIs('offers.index') ? 'bg-primary text-white shadow-lg shadow-primary/20 font-bold' : 'text-gray-600 hover:bg-gray-50 font-medium' }}">
                    <i class="ti-gift text-lg"></i>
                    <span>العروض</span>
                </a>
                <a href="{{ route('blog.index') }}"
                    class="flex items-center gap-4 p-4 rounded-2xl transition-all {{ request()->routeIs('blog.index') ? 'bg-primary text-white shadow-lg shadow-primary/20 font-bold' : 'text-gray-600 hover:bg-gray-50 font-medium' }}">
                    <i class="ti-layout-grid2 text-lg"></i>
                    <span>المدونة</span>
                </a>
                <a href="{{ route('banks') }}"
                    class="flex items-center gap-4 p-4 rounded-2xl transition-all {{ request()->routeIs('banks') ? 'bg-primary text-white shadow-lg shadow-primary/20 font-bold' : 'text-gray-600 hover:bg-gray-50 font-medium' }}">
                    <i class="ti-wallet text-lg"></i>
                    <span>جهات التمويل</span>
                </a>
                <a href="{{ route('faq') }}"
                    class="flex items-center gap-4 p-4 rounded-2xl transition-all {{ request()->routeIs('faq') ? 'bg-primary text-white shadow-lg shadow-primary/20 font-bold' : 'text-gray-600 hover:bg-gray-50 font-medium' }}">
                    <i class="ti-help-alt text-lg"></i>
                    <span>الأسئلة الشائعة</span>
                </a>
                <a href="{{ route('about') }}"
                    class="flex items-center gap-4 p-4 rounded-2xl transition-all {{ request()->routeIs('about') ? 'bg-primary text-white shadow-lg shadow-primary/20 font-bold' : 'text-gray-600 hover:bg-gray-50 font-medium' }}">
                    <i class="ti-info-alt text-lg"></i>
                    <span>من نحن</span>
                </a>
                <a href="{{ route('contact') }}"
                    class="flex items-center gap-4 p-4 rounded-2xl transition-all {{ request()->routeIs('contact') ? 'bg-primary text-white shadow-lg shadow-primary/20 font-bold' : 'text-gray-600 hover:bg-gray-50 font-medium' }}">
                    <i class="ti-headphone-alt text-lg"></i>
                    <span>اتصل بنا</span>
                </a>
            </nav>

            <div class="p-6 border-t border-gray-100 space-y-4 bg-gray-50/50">
                @auth('customer')
                    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                        <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-50">
                            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                                <i class="ti-user text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-secondary text-sm">{{ Auth::guard('customer')->user()->name }}</h4>
                                <p class="text-xs text-gray-500">مرحباً بك مجدداً</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-2">
                            <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-2 text-sm text-gray-600 hover:text-primary py-1">
                                <i class="ti-dashboard text-primary"></i> لوحة التحكم
                            </a>
                            <a href="{{ route('customer.profile') }}" class="flex items-center gap-2 text-sm text-gray-600 hover:text-primary py-1">
                                <i class="ti-id-badge text-primary"></i> الملف الشخصي
                            </a>
                            <a href="{{ route('customer.bookings') }}" class="flex items-center gap-2 text-sm text-gray-600 hover:text-primary py-1">
                                <i class="ti-package text-primary"></i> طلباتي الحالية
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="mt-2 pt-2 border-t border-gray-50">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 text-sm text-red-500 hover:text-red-600 font-medium">
                                    <i class="ti-power-off"></i> تسجيل الخروج
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="flex items-center justify-center gap-3 w-full bg-secondary text-white py-4 rounded-2xl font-bold shadow-lg shadow-secondary/20 hover:bg-gray-800 transition-all">
                        <i class="ti-user text-lg"></i>
                        <span>تسجيل الدخول</span>
                    </a>
                @endauth('customer')

                <a href="{{ route('cars.quick-booking') }}"
                    class="flex items-center justify-center gap-3 w-full bg-primary text-white py-4 rounded-2xl font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] transition-all">
                    <i class="ti-bolt-alt text-lg"></i>
                    <span>طلب حجز سريع</span>
                </a>
            </div>
        </div>
    </div>
</header>
