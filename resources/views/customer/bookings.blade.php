@extends('layouts.app')

@section('title', 'الحجزات')

@section('content')
    <section class="py-24 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <!-- Header -->
                <div class="mb-12">
                    <a href="{{ route('customer.dashboard') }}"
                        class="text-primary font-bold mb-6 flex items-center gap-2 w-fit hover:underline">
                        <i class="ti-arrow-left"></i> العودة
                    </a>
                    <h1 class="text-4xl font-black text-secondary mb-2">الحجزات</h1>
                    <p class="text-gray-600 text-lg">جميع حجزاتك وطلباتك</p>
                </div>

                <!-- Bookings List -->
                @if ($bookings->count() > 0)
                    <div class="grid gap-6">
                        @foreach ($bookings as $booking)
                            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-center">
                                    <!-- Car Info -->
                                    <div>
                                        <p class="text-gray-500 text-sm font-bold uppercase mb-2">السيارة</p>
                                        <p class="text-lg font-bold text-secondary">{{ $booking->brand_name }}</p>
                                        <p class="text-gray-600">{{ $booking->car_name_manual }}</p>
                                    </div>

                                    <!-- Date -->
                                    <div>
                                        <p class="text-gray-500 text-sm font-bold uppercase mb-2">تاريخ الطلب</p>
                                        <p class="text-lg font-bold text-secondary">{{ $booking->request_date->format('d/m/Y') }}</p>
                                        <p class="text-gray-600 text-sm">{{ $booking->request_date->format('H:i') }}</p>
                                    </div>

                                    <!-- Status -->
                                    <div>
                                        <p class="text-gray-500 text-sm font-bold uppercase mb-2">الحالة</p>
                                        <span class="px-4 py-2 rounded-full text-sm font-bold inline-block
                                            {{ $booking->status === 'New' ? 'bg-blue-100 text-blue-700' : '' }}
                                            {{ $booking->status === 'Contacted' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                            {{ $booking->status === 'Interested' ? 'bg-green-100 text-green-700' : '' }}
                                            {{ $booking->status === 'Completed' ? 'bg-purple-100 text-purple-700' : '' }}
                                            {{ $booking->status === 'Not Interested' ? 'bg-red-100 text-red-700' : '' }}
                                        ">
                                            {{ $booking->status }}
                                        </span>
                                    </div>

                                    <!-- Action -->
                                    <div class="text-right">
                                        <a href="{{ route('customer.booking-detail', ['id' => $booking->id, 'type' => $booking->booking_type]) }}"
                                            class="inline-block bg-primary text-white font-bold px-6 py-3 rounded-2xl hover:bg-opacity-90 transition">
                                            عرض التفاصيل
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if ($bookings->hasPages())
                        <div class="mt-12">
                            {{ $bookings->links() }}
                        </div>
                    @endif
                @else
                    <div class="bg-white rounded-3xl p-12 shadow-sm border border-gray-100 text-center">
                        <p class="text-gray-500 text-lg mb-6">لم تقم بأي حجوزات حتى الآن</p>
                        <a href="{{ route('cars.index') }}"
                            class="inline-block bg-primary text-white font-bold px-8 py-4 rounded-2xl hover:bg-opacity-90 transition">
                            🚗 استكشف السيارات الآن
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
