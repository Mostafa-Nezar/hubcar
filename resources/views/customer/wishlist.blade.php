@extends('layouts.app')

@section('title', 'المفضلة - ' . Auth::guard('customer')->user()->name)

@section('content')
    <section class="py-12 md:py-24 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <!-- Header -->
                <div class="mb-8 md:mb-12">
                    <h1 class="text-3xl md:text-4xl font-black text-secondary mb-2">السيارات المفضلة ❤️</h1>
                    <p class="text-gray-500 text-base md:text-lg italic">السيارات التي قمت بحفظها للرجوع إليها لاحقاً</p>
                </div>

                <!-- Navigation Tabs -->
                <div class="mb-8 -mx-4 px-4 md:mx-0 md:px-0 overflow-x-auto no-scrollbar">
                    <div class="flex gap-4 md:gap-8 min-w-max border-b border-gray-200">
                        <a href="{{ route('customer.dashboard') }}"
                            class="pb-4 px-2 border-b-4 {{ request()->routeIs('customer.dashboard') ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-primary' }} font-bold transition-all flex items-center gap-2">
                            <i class="ti-dashboard"></i> لوحة التحكم
                        </a>
                        <a href="{{ route('customer.profile') }}"
                            class="pb-4 px-2 border-b-4 {{ request()->routeIs('customer.profile') ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-primary' }} font-bold transition-all flex items-center gap-2">
                            <i class="ti-user"></i> الملف الشخصي
                        </a>
                        <a href="{{ route('customer.bookings') }}"
                            class="pb-4 px-2 border-b-4 {{ request()->routeIs('customer.bookings') ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-primary' }} font-bold transition-all flex items-center gap-2">
                            <i class="ti-clipboard"></i> حجوزاتي
                        </a>
                        <a href="{{ route('customer.wishlist') }}"
                            class="pb-4 px-2 border-b-4 {{ request()->routeIs('customer.wishlist') ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-primary' }} font-bold transition-all flex items-center gap-2">
                            <i class="ti-heart"></i> المفضلة
                        </a>
                    </div>
                </div>

                @if ($wishlist->total() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($wishlist as $car)
                            <x-car-card :car="$car" />
                        @endforeach
                    </div>

                    <div class="mt-12">
                        {{ $wishlist->links('vendor.pagination.tailwind') }}
                    </div>
                @else
                    <div class="bg-white rounded-[3rem] p-12 md:p-20 text-center shadow-sm border border-gray-100">
                        <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-8 text-gray-300">
                            <i class="ti-heart text-5xl"></i>
                        </div>
                        <h2 class="text-2xl font-black text-secondary mb-4">قائمة المفضلة فارغة</h2>
                        <p class="text-gray-500 max-w-sm mx-auto mb-10 leading-relaxed">لم تقم بإضافة أي سيارات للمفضلة حتى الآن. تصفح مجموعتنا الواسعة واحفظ ما ينال إعجابك!</p>
                        <a href="{{ route('cars.index') }}"
                            class="inline-flex items-center gap-3 bg-primary text-white font-black px-8 py-4 rounded-2xl hover:bg-opacity-90 transition shadow-xl shadow-primary/20">
                            <i class="ti-search text-lg"></i> ابحث عن سيارتك الآن
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
