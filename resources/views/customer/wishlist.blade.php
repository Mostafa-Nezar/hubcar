@extends('layouts.app')

@section('title', __('المفضلة') . ' - ' . Auth::guard('customer')->user()->name)

@section('content')
    <section class="py-12 md:py-24 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <!-- Header -->
                <div class="mb-10 md:mb-16 flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div>
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary text-xl shadow-inner">
                                <i class="ti-heart"></i>
                            </div>
                            <span class="text-[10px] font-black text-primary uppercase tracking-[0.3em]">{{ __('قائمة الرغبات') }}</span>
                        </div>
                        <h1 class="text-4xl md:text-6xl font-black text-secondary mb-3 leading-tight">{{ __('السيارات المفضلة') }}</h1>
                        <p class="text-gray-400 text-lg italic">{{ __('السيارات التي قمت بحفظها للرجوع إليها لاحقاً') }}</p>
                    </div>
                </div>

                <div class="mb-12 -mx-4 px-4 md:mx-0 md:px-0 overflow-x-auto no-scrollbar border-b-2 border-gray-100">
                    <div class="flex gap-10 min-w-max">
                        <a href="{{ route('customer.dashboard') }}"
                            class="pb-5 px-1 border-b-4 {{ request()->routeIs('customer.dashboard') ? 'border-primary text-secondary' : 'border-transparent text-gray-400 hover:text-primary transition-all' }} font-black uppercase tracking-widest text-xs flex items-center gap-3 group">
                            <i class="ti-dashboard {{ request()->routeIs('customer.dashboard') ? 'text-primary' : 'text-gray-300 group-hover:text-primary' }} transition-colors"></i> 
                            <span>{{ __('لوحة التحكم') }}</span>
                        </a>
                        <a href="{{ route('customer.profile') }}"
                            class="pb-5 px-1 border-b-4 {{ request()->routeIs('customer.profile') ? 'border-primary text-secondary' : 'border-transparent text-gray-400 hover:text-primary transition-all' }} font-black uppercase tracking-widest text-xs flex items-center gap-3 group">
                            <i class="ti-user {{ request()->routeIs('customer.profile') ? 'text-primary' : 'text-gray-300 group-hover:text-primary' }} transition-colors"></i> 
                            <span>{{ __('البيانات الشخصية') }}</span>
                        </a>
                        <a href="{{ route('customer.bookings') }}"
                            class="pb-5 px-1 border-b-4 {{ request()->routeIs('customer.bookings') ? 'border-primary text-secondary' : 'border-transparent text-gray-400 hover:text-primary transition-all' }} font-black uppercase tracking-widest text-xs flex items-center gap-3 group">
                            <i class="ti-clipboard {{ request()->routeIs('customer.bookings') ? 'text-primary' : 'text-gray-300 group-hover:text-primary' }} transition-colors"></i> 
                            <span>{{ __('حجوزاتي') }}</span>
                        </a>
                        <a href="{{ route('customer.wishlist') }}"
                            class="pb-5 px-1 border-b-4 {{ request()->routeIs('customer.wishlist') ? 'border-primary text-secondary' : 'border-transparent text-gray-400 hover:text-primary transition-all' }} font-black uppercase tracking-widest text-xs flex items-center gap-3 group">
                            <i class="ti-heart {{ request()->routeIs('customer.wishlist') ? 'text-primary' : 'text-gray-300 group-hover:text-primary' }} transition-colors"></i> 
                            <span>{{ __('المفضلة') }}</span>
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
                    <div class="bg-white rounded-[3.5rem] p-16 md:p-24 text-center shadow-sm border border-gray-100 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-b from-gray-50/50 to-transparent"></div>
                        <div class="relative z-10">
                            <div class="w-28 h-28 bg-white shadow-inner rounded-full flex items-center justify-center mx-auto mb-10 text-gray-200 border border-gray-50">
                                <i class="ti-heart text-6xl"></i>
                            </div>
                            <h2 class="text-3xl font-black text-secondary mb-4">{{ __('قائمة المفضلة فارغة') }}</h2>
                            <p class="text-gray-400 font-bold max-w-sm mx-auto mb-12 leading-relaxed italic">{{ __('لم تقم بإضافة أي سيارات للمفضلة حتى الآن. تصفح مجموعتنا الواسعة واحفظ ما ينال إعجابك!') }}</p>
                            <a href="{{ route('cars.index') }}"
                                class="inline-flex items-center gap-4 bg-primary text-white font-black px-12 py-5 rounded-2xl hover:scale-105 transition-all shadow-2xl shadow-primary/25">
                                <i class="ti-search text-xl"></i> {{ __('ابحث عن سيارتك الآن') }}
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
