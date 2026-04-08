@extends('layouts.app')

@section('title', 'الحجزات')

@section('content')
    <section class="py-12 md:py-24 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <!-- Header -->
                <div class="mb-8 md:mb-12">
                    <a href="{{ route('customer.dashboard') }}"
                        class="text-primary font-bold mb-4 flex items-center gap-2 w-fit hover:translate-x-1 transition-transform text-sm">
                        <i class="ti-arrow-right"></i> العودة للوحة التحكم
                    </a>
                    <h1 class="text-3xl md:text-4xl font-black text-secondary mb-2">حجوزاتي</h1>
                    <p class="text-gray-500 text-base">تتبع حالة طلبات الحجز الخاصة بك</p>
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
                                        <div class="w-14 h-14 bg-gray-50 rounded-2xl flex items-center justify-center text-primary text-2xl group-hover:bg-primary/10 transition-colors shrink-0">
                                            <i class="ti-car"></i>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase mb-1 tracking-widest">تفاصيل السيارة</p>
                                            <h3 class="text-lg md:text-xl font-black text-secondary">{{ $booking->brand_name }} {{ $booking->car_name_manual }}</h3>
                                            <p class="text-gray-500 text-xs mt-1">رقم الطلب: #{{ $booking->id }}</p>
                                        </div>
                                    </div>

                                    <!-- Date & Details -->
                                    <div class="flex flex-row md:flex-col justify-between md:text-center px-4 py-3 md:py-0 bg-gray-50 md:bg-transparent rounded-2xl border border-gray-100 md:border-0">
                                        <div>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase mb-0 md:mb-1">تاريخ الطلب</p>
                                            <p class="text-sm font-bold text-secondary">{{ $booking->request_date->format('d M, Y') }}</p>
                                        </div>
                                        <div class="md:mt-2">
                                            <p class="text-[10px] text-gray-400 font-bold uppercase mb-0 md:mb-1">التوقيت</p>
                                            <p class="text-xs font-medium text-gray-600">{{ $booking->request_date->format('H:i A') }}</p>
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="md:w-32">
                                        <span class="w-full text-center px-4 py-2 rounded-xl text-[10px] font-black uppercase inline-block shadow-sm
                                            {{ $booking->status === 'New' ? 'bg-blue-50 text-blue-700' : '' }}
                                            {{ $booking->status === 'Contacted' ? 'bg-orange-50 text-orange-700' : '' }}
                                            {{ $booking->status === 'Interested' ? 'bg-green-50 text-green-700' : '' }}
                                            {{ $booking->status === 'Completed' ? 'bg-purple-50 text-purple-700' : '' }}
                                            {{ $booking->status === 'Not Interested' ? 'bg-red-50 text-red-700' : '' }}
                                        ">
                                            {{ $booking->status }}
                                        </span>
                                    </div>

                                    <!-- Action -->
                                    <div class="md:text-left">
                                        <a href="{{ route('customer.booking-detail', ['id' => $booking->id, 'type' => $booking->booking_type]) }}"
                                            class="w-full md:w-auto inline-flex items-center justify-center gap-2 bg-secondary text-white font-bold px-6 py-3 rounded-2xl hover:bg-gray-800 transition-all shadow-lg shadow-secondary/10 group-hover:shadow-secondary/20 active:scale-[0.98]">
                                            <span>التفاصيل</span>
                                            <i class="ti-arrow-left text-sm"></i>
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
                    <div class="bg-white rounded-[2rem] p-12 shadow-sm border border-gray-100 text-center">
                        <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                             <i class="ti-package text-5xl"></i>
                        </div>
                        <h2 class="text-xl font-bold text-secondary mb-2">لا توجد حجوزات</h2>
                        <p class="text-gray-500 text-sm mb-8">لم تقم بإجراء أي طلب لغاية الآن.</p>
                        <a href="{{ route('cars.index') }}"
                            class="inline-flex items-center gap-3 bg-primary text-white font-black px-8 py-4 rounded-2xl hover:scale-105 transition-all shadow-lg shadow-primary/20">
                            🚗 اذهب لاختيار سيارتك
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
