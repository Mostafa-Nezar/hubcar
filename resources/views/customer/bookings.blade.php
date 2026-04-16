@extends('layouts.app')

@section('title', __('حجوزاتي'))

@section('content')
    <section class="py-12 md:py-24 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <!-- Header -->
                <div class="mb-8 md:mb-12">
                    <a href="{{ route('customer.dashboard') }}"
                        class="text-primary font-black uppercase tracking-widest mb-6 flex items-center gap-3 w-fit hover:-translate-x-2 transition-transform text-[10px]">
                        <i class="ti-arrow-right"></i> {{ __('العودة للوحة التحكم') }}
                    </a>
                    <h1 class="text-3xl md:text-5xl font-black text-secondary mb-3">{{ __('حجوزاتي') }}</h1>
                    <p class="text-gray-400 text-base md:text-lg italic">{{ __('تتبع حالة طلبات الحجز الخاصة بك') }}</p>
                </div>

                <!-- Bookings List -->
                @if ($bookings->count() > 0)
                    <div class="grid gap-4 md:gap-6">
                        @foreach ($bookings as $booking)
                            <div class="bg-white rounded-[2rem] p-5 md:p-8 shadow-sm border border-gray-100 hover:shadow-md transition-shadow group relative overflow-hidden">
                                <div class="absolute top-0 right-0 w-2 h-full 
                                    {{ $booking->status === 'New' ? 'bg-blue-500' : '' }}
                                    {{ $booking->status === 'Contacted' ? 'bg-orange-500' : '' }}
                                    {{ $booking->status === 'Interested' ? 'bg-green-500' : '' }}
                                    {{ $booking->status === 'Completed' ? 'bg-purple-500' : '' }}
                                    {{ $booking->status === 'Not Interested' ? 'bg-red-500' : '' }}
                                "></div>
                                
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                                    <!-- Car Info -->
                                    <div class="flex items-start gap-4 flex-1">
                                        <div class="w-16 h-16 bg-gray-50 rounded-[1.25rem] flex items-center justify-center text-primary text-2xl group-hover:bg-primary/10 transition-colors shrink-0 shadow-inner">
                                            <i class="ti-car"></i>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-gray-400 font-black uppercase mb-1 tracking-widest">{{ __('تفاصيل السيارة') }}</p>
                                            <h3 class="text-lg md:text-2xl font-black text-secondary group-hover:text-primary transition-colors leading-tight">{{ $booking->brand_name }} {{ $booking->car_name_manual }}</h3>
                                            <p class="text-gray-400 text-xs mt-1 font-bold">{{ __('رقم الطلب') }}: #{{ $booking->id }}</p>
                                        </div>
                                    </div>

                                    <!-- Date & Details -->
                                    <div class="flex flex-row md:flex-col justify-between md:text-center px-6 py-4 md:py-0 bg-gray-50 md:bg-transparent rounded-2xl border border-gray-100 md:border-0">
                                        <div>
                                            <p class="text-[10px] text-gray-400 font-black uppercase mb-1 tracking-widest">{{ __('تاريخ الطلب') }}</p>
                                            <p class="text-sm md:text-base font-black text-secondary">{{ $booking->request_date->format('d M, Y') }}</p>
                                        </div>
                                        <div class="md:mt-3">
                                            <p class="text-[10px] text-gray-400 font-black uppercase mb-1 tracking-widest">{{ __('التوقيت') }}</p>
                                            <p class="text-xs font-bold text-gray-500">{{ $booking->request_date->format('H:i A') }}</p>
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="md:w-32">
                                        <span class="w-full text-center px-5 py-2.5 rounded-xl text-[10px] font-black uppercase inline-block shadow-sm tracking-widest
                                            {{ $booking->status === 'New' ? 'bg-blue-50 text-blue-700' : '' }}
                                            {{ $booking->status === 'Contacted' ? 'bg-orange-50 text-orange-700' : '' }}
                                            {{ $booking->status === 'Interested' ? 'bg-green-50 text-green-700' : '' }}
                                            {{ $booking->status === 'Completed' ? 'bg-purple-50 text-purple-700' : '' }}
                                            {{ $booking->status === 'Not Interested' ? 'bg-red-50 text-red-700' : '' }}
                                        ">
                                            {{ __($booking->status) }}
                                        </span>
                                    </div>

                                    <!-- Action -->
                                    <div class="md:text-left">
                                        <a href="{{ route('customer.booking-detail', ['id' => $booking->id, 'type' => $booking->booking_type]) }}"
                                            class="w-full md:w-auto inline-flex items-center justify-center gap-3 bg-secondary text-white font-black px-8 py-4 rounded-2xl hover:bg-black transition-all shadow-xl shadow-secondary/10 group-hover:shadow-secondary/30 active:scale-[0.98] uppercase tracking-widest text-[10px]">
                                            <span>{{ __('التفاصيل') }}</span>
                                            <i class="ti-arrow-left text-xs"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if ($bookings->hasPages())
                        <div class="mt-12 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
                            {{ $bookings->links() }}
                        </div>
                    @endif
                @else
                    <div class="bg-white rounded-[3rem] p-20 shadow-sm border border-gray-100 text-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-b from-gray-50/50 to-transparent pointer-events-none"></div>
                        <div class="relative z-10">
                            <div class="w-24 h-24 bg-white shadow-inner rounded-full flex items-center justify-center mx-auto mb-8 text-gray-200">
                                 <i class="ti-package text-5xl"></i>
                            </div>
                            <h2 class="text-2xl md:text-3xl font-black text-secondary mb-3">{{ __('لا توجد حجوزات') }}</h2>
                            <p class="text-gray-400 font-bold text-sm mb-10">{{ __('لم تقم بإجراء أي طلب لغاية الآن.') }}</p>
                            <a href="{{ route('cars.index') }}"
                                class="inline-flex items-center gap-4 bg-primary text-white font-black px-10 py-5 rounded-2xl hover:scale-105 transition-all shadow-2xl shadow-primary/25">
                                <i class="ti-car text-xl"></i> {{ __('اذهب لاختيار سيارتك') }}
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
