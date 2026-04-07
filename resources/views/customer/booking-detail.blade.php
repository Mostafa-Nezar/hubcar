@extends('layouts.app')

@section('title', 'تفاصيل الحجز')

@section('content')
    <section class="py-24 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <!-- Header -->
                <div class="mb-12">
                    <a href="{{ route('customer.bookings') }}"
                        class="text-primary font-bold mb-6 flex items-center gap-2 w-fit hover:underline">
                        <i class="ti-arrow-left"></i> العودة إلى الحجزات
                    </a>
                    <h1 class="text-4xl font-black text-secondary mb-2">تفاصيل الحجز</h1>
                </div>

                <!-- Status Card -->
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 mb-8">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-2xl font-bold text-secondary">حالة الحجز</h2>
                        <span class="px-6 py-3 rounded-full text-lg font-bold
                            {{ $booking->status === 'New' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $booking->status === 'Contacted' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $booking->status === 'Interested' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $booking->status === 'Completed' ? 'bg-purple-100 text-purple-700' : '' }}
                            {{ $booking->status === 'Not Interested' ? 'bg-red-100 text-red-700' : '' }}
                        ">
                            {{ $booking->status }}
                        </span>
                    </div>

                    <!-- Timeline -->
                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="w-4 h-4 bg-primary rounded-full mt-2 flex-shrink-0"></div>
                            <div>
                                <p class="font-bold text-secondary">تم استقبال الطلب</p>
                                <p class="text-gray-600">{{ $booking->request_date->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        @if ($booking->last_status_update)
                            <div class="flex items-start gap-4">
                                <div class="w-4 h-4 bg-primary rounded-full mt-2 flex-shrink-0"></div>
                                <div>
                                    <p class="font-bold text-secondary">آخر تحديث</p>
                                    <p class="text-gray-600">{{ $booking->last_status_update->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Car Details -->
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 mb-8">
                    <h2 class="text-2xl font-bold text-secondary mb-6">معلومات السيارة</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-gray-500 text-sm font-bold uppercase mb-2">الماركة</p>
                            <p class="text-lg font-bold text-secondary">{{ $booking->brand_name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-bold uppercase mb-2">النموذج</p>
                            <p class="text-lg font-bold text-secondary">{{ $booking->car_name_manual }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-bold uppercase mb-2">النوع</p>
                            <p class="text-lg font-bold text-secondary">{{ $booking->car_type }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-bold uppercase mb-2">سنة الموديل</p>
                            <p class="text-lg font-bold text-secondary">{{ $booking->model_year }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-bold uppercase mb-2">الفئة</p>
                            <p class="text-lg font-bold text-secondary">{{ $booking->car_category }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-bold uppercase mb-2">السعر</p>
                            <p class="text-xl font-black text-primary">{{ number_format($booking->car_price) }} <span class="icon-saudi_riyal text-lg"></span></p>
                        </div>
                    </div>
                </div>

                <!-- Booking Details -->
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 mb-8">
                    <h2 class="text-2xl font-bold text-secondary mb-6">بيانات الحجز</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-gray-500 text-sm font-bold uppercase mb-2">الاسم</p>
                            <p class="text-lg font-bold text-secondary">{{ $booking->client_name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-bold uppercase mb-2">الهاتف</p>
                            <p class="text-lg font-bold text-secondary">{{ $booking->phone }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-bold uppercase mb-2">المدينة</p>
                            <p class="text-lg font-bold text-secondary">{{ $booking->city }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-bold uppercase mb-2">نوع الحجز</p>
                            <p class="text-lg font-bold text-secondary">
                                {{ $booking->payment_type === 'cash' ? 'حجز نقدي' : 'طلب تمويل' }}
                            </p>
                        </div>
                        @if ($booking->bank_name)
                            <div>
                                <p class="text-gray-500 text-sm font-bold uppercase mb-2">جهة التمويل</p>
                                <p class="text-lg font-bold text-secondary">{{ $booking->bank_name }}</p>
                            </div>
                        @endif
                        @if ($booking->work_sector)
                            <div>
                                <p class="text-gray-500 text-sm font-bold uppercase mb-2">قطاع العمل</p>
                                <p class="text-lg font-bold text-secondary">
                                    {{ $booking->work_sector === 'govt' ? 'حكومي' : '' }}
                                    {{ $booking->work_sector === 'private' ? 'خاص' : '' }}
                                    {{ $booking->work_sector === 'military' ? 'عسكري' : '' }}
                                    {{ $booking->work_sector === 'retired' ? 'متقاعد' : '' }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Notes -->
                @if ($booking->client_notes)
                    <div class="bg-blue-50 rounded-3xl p-8 border border-blue-200 mb-8">
                        <h2 class="text-lg font-bold text-blue-900 mb-4">📝 ملاحظاتك</h2>
                        <p class="text-blue-800">{{ $booking->client_notes }}</p>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex gap-4 flex-wrap">
                    <a href="tel:{{ $booking->phone }}"
                        class="bg-green-500 text-white font-bold px-8 py-4 rounded-2xl hover:bg-opacity-90 transition flex items-center gap-2">
                        <i class="ti-mobile"></i> اتصل بنا
                    </a>
                    <a href="{{ route('cars.index') }}"
                        class="bg-primary text-white font-bold px-8 py-4 rounded-2xl hover:bg-opacity-90 transition flex items-center gap-2">
                        <i class="ti-car"></i> استكشف المزيد من السيارات
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
