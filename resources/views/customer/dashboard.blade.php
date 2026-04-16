@extends('layouts.app')

@section('title', __('لوحة التحكم') . ' - ' . Auth::guard('customer')->user()->name)

@section('content')
    <section class="py-12 md:py-24 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <!-- Header -->
                <div class="mb-8 md:mb-12">
                    <h1 class="text-3xl md:text-5xl font-black text-secondary mb-3">{{ __('مرحباً') }}،
                        {{ Auth::guard('customer')->user()->name }}! </h1>
                    <p class="text-gray-400 text-base md:text-xl">{{ __('إليك نظرة سريعة على نشاطك') }}</p>
                </div>

                <!-- Navigation Tabs (Scrollable on mobile) -->
                <div class="mb-8 -mx-4 px-4 md:mx-0 md:px-0 overflow-x-auto no-scrollbar">
                    <div class="flex gap-4 md:gap-8 min-w-max border-b border-gray-100">
                        <a href="{{ route('customer.dashboard') }}"
                            class="pb-4 px-2 border-b-4 {{ request()->routeIs('customer.dashboard') ? 'border-primary text-primary' : 'border-transparent text-gray-400 hover:text-primary' }} font-bold transition-all flex items-center gap-2">
                            <i class="ti-dashboard"></i> {{ __('لوحة التحكم') }}
                        </a>
                        <a href="{{ route('customer.profile') }}"
                            class="pb-4 px-2 border-b-4 {{ request()->routeIs('customer.profile') ? 'border-primary text-primary' : 'border-transparent text-gray-400 hover:text-primary' }} font-bold transition-all flex items-center gap-2">
                            <i class="ti-user"></i> {{ __('الملف الشخصي') }}
                        </a>
                        <a href="{{ route('customer.bookings') }}"
                            class="pb-4 px-2 border-b-4 {{ request()->routeIs('customer.bookings') ? 'border-primary text-primary' : 'border-transparent text-gray-400 hover:text-primary' }} font-bold transition-all flex items-center gap-2">
                            <i class="ti-clipboard"></i> {{ __('حجوزاتي') }}
                        </a>
                        <a href="{{ route('customer.wishlist') }}"
                            class="pb-4 px-2 border-b-4 {{ request()->routeIs('customer.wishlist') ? 'border-primary text-primary' : 'border-transparent text-gray-400 hover:text-primary' }} font-bold transition-all flex items-center gap-2">
                            <i class="ti-heart"></i> {{ __('المفضلة') }}
                        </a>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-8 md:mb-12">
                    <div
                        class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl hover:shadow-primary/5 transition-all duration-500">
                        <div
                            class="absolute -right-4 -top-4 w-32 h-32 bg-primary/5 rounded-full transition-transform group-hover:scale-150 duration-700">
                        </div>
                        <div class="relative flex items-center justify-between">
                            <div>
                                <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-2">
                                    {{ __('إجمالي الحجزات') }}</p>
                                <p class="text-4xl md:text-5xl font-black text-secondary">{{ $bookingCount }}</p>
                            </div>
                            <div
                                class="w-16 h-16 bg-primary text-white rounded-[1.25rem] flex items-center justify-center text-2xl shadow-xl shadow-primary/20">
                                <i class="ti-package"></i>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl hover:shadow-green-500/5 transition-all duration-500">
                        <div
                            class="absolute -right-4 -top-4 w-32 h-32 bg-green-50 rounded-full transition-transform group-hover:scale-150 duration-700">
                        </div>
                        <div class="relative flex items-center justify-between">
                            <div>
                                <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-2">
                                    {{ __('حالة الحساب') }}</p>
                                <p class="text-3xl font-black text-green-500 uppercase">{{ __('نشط') }}</p>
                            </div>
                            <div
                                class="w-16 h-16 bg-green-500 text-white rounded-[1.25rem] flex items-center justify-center text-2xl shadow-xl shadow-green-500/20">
                                <i class="ti-check"></i>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100 relative overflow-hidden group sm:col-span-2 lg:col-span-1 hover:shadow-xl hover:shadow-blue-500/5 transition-all duration-500">
                        <div
                            class="absolute -right-4 -top-4 w-32 h-32 bg-blue-50 rounded-full transition-transform group-hover:scale-150 duration-700">
                        </div>
                        <div class="relative flex items-center justify-between h-full">
                            <div class="max-w-[70%]">
                                <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-2">
                                    {{ __('البريد المسجل') }}</p>
                                <p class="text-base font-bold text-secondary truncate">
                                    {{ Auth::guard('customer')->user()->email }}</p>
                            </div>
                            <div
                                class="w-16 h-16 bg-blue-500 text-white rounded-[1.25rem] flex items-center justify-center text-2xl shadow-xl shadow-blue-500/20">
                                <i class="ti-email"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Bookings Section -->
                <div
                    class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-sm border border-gray-100 overflow-hidden relative">
                    <div class="flex items-center justify-between mb-10">
                        <div>
                            <h2 class="text-2xl md:text-3xl font-black text-secondary">{{ __('آخر الحجزات') }}</h2>
                            <p class="text-gray-400 text-sm mt-1">{{ __('تابع أحدث طلباتك هنا') }}</p>
                        </div>
                        <a href="{{ route('customer.bookings') }}"
                            class="text-primary font-black text-xs uppercase tracking-widest bg-primary/5 px-6 py-3 rounded-2xl hover:bg-primary hover:text-white transition-all">
                            {{ __('الكل') }} <i class="ti-arrow-left mr-2"></i>
                        </a>
                    </div>

                    @if ($bookings->count() > 0)
                        <!-- Desktop Table -->
                        <div class="hidden md:block overflow-x-auto">
                            <table class="w-full text-right">
                                <thead>
                                    <tr
                                        class="text-gray-400 text-[10px] font-black uppercase tracking-widest border-b border-gray-50">
                                        <th class="pb-6">{{ __('السيارة') }}</th>
                                        <th class="pb-6">{{ __('التاريخ') }}</th>
                                        <th class="pb-6">{{ __('الحالة') }}</th>
                                        <th class="pb-6"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach ($bookings as $booking)
                                        <tr class="group">
                                            <td class="py-4">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="w-10 h-10 bg-gray-50 rounded-lg flex items-center justify-center text-secondary group-hover:bg-primary/10 group-hover:text-primary transition-colors">
                                                        <i class="ti-car"></i>
                                                    </div>
                                                    <div>
                                                        <p class="font-bold text-secondary line-clamp-1">{{ $booking->brand_name }}
                                                            - {{ $booking->car_name_manual }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 text-gray-500 font-medium text-sm">
                                                {{ $booking->request_date->format('d M, Y') }}
                                            </td>
                                            <td class="py-4">
                                                <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase
                                                                {{ $booking->status === 'New' ? 'bg-blue-50 text-blue-600' : '' }}
                                                                {{ $booking->status === 'Contacted' ? 'bg-orange-50 text-orange-600' : '' }}
                                                                {{ $booking->status === 'Interested' ? 'bg-green-50 text-green-600' : '' }}
                                                                {{ $booking->status === 'Completed' ? 'bg-purple-50 text-purple-600' : '' }}
                                                                {{ $booking->status === 'Not Interested' ? 'bg-red-50 text-red-600' : '' }}
                                                            ">
                                                    {{ $booking->status }}
                                                </span>
                                            </td>
                                            <td class="py-4 text-left">
                                                <a href="{{ route('customer.booking-detail', ['id' => $booking->id, 'type' => $booking->booking_type]) }}"
                                                    class="p-2 hover:bg-gray-100 rounded-lg transition-colors inline-block"
                                                    title="عرض التفاصيل">
                                                    <i class="ti-angle-left text-gray-400"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card List -->
                        <div class="md:hidden space-y-4">
                            @foreach ($bookings as $booking)
                                <a href="{{ route('customer.booking-detail', ['id' => $booking->id, 'type' => $booking->booking_type]) }}"
                                    class="block p-4 rounded-2xl bg-gray-50 border border-gray-100 active:scale-[0.98] transition-all">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">
                                                {{ $booking->request_date->format('d M, Y') }}</p>
                                            <h3 class="font-bold text-secondary leading-tight">{{ $booking->brand_name }}<br><span
                                                    class="text-gray-500 font-medium text-sm">{{ $booking->car_name_manual }}</span>
                                            </h3>
                                        </div>
                                        <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase
                                                        {{ $booking->status === 'New' ? 'bg-blue-100 text-blue-700' : '' }}
                                                        {{ $booking->status === 'Contacted' ? 'bg-orange-100 text-orange-700' : '' }}
                                                        {{ $booking->status === 'Interested' ? 'bg-green-100 text-green-700' : '' }}
                                                        {{ $booking->status === 'Completed' ? 'bg-purple-100 text-purple-700' : '' }}
                                                        {{ $booking->status === 'Not Interested' ? 'bg-red-100 text-red-700' : '' }}
                                                    ">
                                            {{ $booking->status }}
                                        </span>
                                    </div>
                                    <div class="flex items-center text-primary text-[10px] font-black uppercase tracking-widest">
                                        {{ __('عرض التفاصيل') }} <i class="ti-arrow-left mr-2"></i>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-20 bg-gray-50/50 rounded-[2.5rem]">
                            <div
                                class="w-24 h-24 bg-white shadow-inner rounded-full flex items-center justify-center mx-auto mb-6 text-gray-200">
                                <i class="ti-package text-5xl"></i>
                            </div>
                            <p class="text-gray-400 font-bold mb-8">{{ __('لم تقم بإجراء أي حجوزات حتى الآن لا تقلق!') }}</p>
                            <a href="{{ route('cars.index') }}"
                                class="inline-flex items-center gap-3 bg-primary text-white font-black px-10 py-5 rounded-2xl hover:scale-105 transition-all shadow-xl shadow-primary/25">
                                <i class="ti-car text-xl"></i> {{ __('استكشف سيارتنا الآن') }}
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Footer Quick Actions -->
                <div class="mt-12 text-center text-gray-400 text-xs">
                    <p>© {{ date('Y') }} {{ config('app.name') }}. جميع الحقوق محفوظة.</p>
                </div>
            </div>
        </div>
    </section>
@endsection