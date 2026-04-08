@extends('layouts.app')

@section('title', 'تفاصيل الحجز')

@section('content')
    <section class="py-12 md:py-24 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <!-- Header -->
                <div class="mb-8 md:mb-12">
                    <a href="{{ route('customer.bookings') }}"
                        class="text-primary font-bold mb-4 flex items-center gap-2 w-fit hover:translate-x-1 transition-transform text-sm">
                        <i class="ti-arrow-right"></i> العودة لقائمة الحجوزات
                    </a>
                    <h1 class="text-3xl md:text-4xl font-black text-secondary mb-2">تفاصيل الطلب</h1>
                    <p class="text-gray-500 text-sm italic">رقم طلبك: <span class="text-primary font-bold">#{{ $booking->id }}</span></p>
                </div>

                <!-- Status & Timeline Card -->
                <div class="bg-white rounded-[2rem] p-6 md:p-10 shadow-sm border border-gray-100 mb-8 relative overflow-hidden">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10 pb-6 border-b border-gray-50">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center text-secondary text-xl">
                                <i class="ti-pulse"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-secondary">حالة الطلب الحالية</h2>
                                <p class="text-xs text-gray-400 italic">يتم تحديث الحالة دورياً</p>
                            </div>
                        </div>
                        <span class="w-fit px-8 py-3 rounded-2xl text-sm font-black uppercase shadow-sm
                            {{ $booking->status === 'New' ? 'bg-blue-50 text-blue-700 border border-blue-100' : '' }}
                            {{ $booking->status === 'Contacted' ? 'bg-orange-50 text-orange-700 border border-orange-100' : '' }}
                            {{ $booking->status === 'Interested' ? 'bg-green-50 text-green-700 border border-green-100' : '' }}
                            {{ $booking->status === 'Completed' ? 'bg-purple-50 text-purple-700 border border-purple-100' : '' }}
                            {{ $booking->status === 'Not Interested' ? 'bg-red-50 text-red-700 border border-red-100' : '' }}
                        ">
                            {{ $booking->status }}
                        </span>
                    </div>

                    <!-- Modern Timeline -->
                    <div class="relative pl-8 space-y-8 before:absolute before:right-[7px] before:top-2 before:bottom-2 before:w-[2px] before:bg-gray-100">
                        <div class="relative flex flex-col md:flex-row md:items-center gap-4">
                            <div class="absolute right-[-24px] top-1 w-4 h-4 bg-primary rounded-full border-4 border-white shadow-sm ring-4 ring-primary/5"></div>
                            <div class="bg-gray-50 p-4 rounded-2xl flex-1">
                                <p class="font-bold text-secondary text-sm">تم إنشاء الطلب بنجاح</p>
                                <p class="text-gray-400 text-[10px] mt-1">{{ $booking->request_date->format('d M, Y - H:i A') }}</p>
                            </div>
                        </div>
                        
                        @if ($booking->last_status_update)
                            <div class="relative flex flex-col md:flex-row md:items-center gap-4">
                                <div class="absolute right-[-24px] top-1 w-4 h-4 bg-green-500 rounded-full border-4 border-white shadow-sm ring-4 ring-green-500/5 transition-all"></div>
                                <div class="bg-green-50 p-4 rounded-2xl border border-green-100 flex-1">
                                    <p class="font-bold text-green-800 text-sm">آخر تحديث من قبل المعرض</p>
                                    <p class="text-green-600/60 text-[10px] mt-1">{{ $booking->last_status_update->format('d M, Y - H:i A') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <!-- Car Section -->
                    <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-secondary mb-6 flex items-center gap-2">
                            <i class="ti-car text-primary"></i> تفاصيل المركبة
                        </h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-3 border-b border-gray-50">
                                <span class="text-gray-400 text-xs font-bold uppercase">البراند والنوع</span>
                                <span class="font-bold text-secondary">{{ $booking->brand_name }} {{ $booking->car_name_manual }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-50">
                                <span class="text-gray-400 text-xs font-bold uppercase">سنة الصنع</span>
                                <span class="font-medium text-secondary">{{ $booking->model_year }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-50">
                                <span class="text-gray-400 text-xs font-bold uppercase">الفئة</span>
                                <span class="font-medium text-secondary">{{ $booking->car_category }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3">
                                <span class="text-gray-400 text-xs font-bold uppercase">القيمة التقديرية</span>
                                <span class="font-black text-primary text-lg">{{ number_format($booking->car_price) }} ر.س</span>
                            </div>
                        </div>
                    </div>

                    <!-- Client Section -->
                    <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-secondary mb-6 flex items-center gap-2">
                            <i class="ti-clipboard text-primary"></i> بيانات التواصل
                        </h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-3 border-b border-gray-50">
                                <span class="text-gray-400 text-xs font-bold uppercase">الاسم الكامل</span>
                                <span class="font-bold text-secondary">{{ $booking->client_name }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-50">
                                <span class="text-gray-400 text-xs font-bold uppercase">رقم الجوال</span>
                                <span class="font-medium text-secondary" dir="ltr">{{ $booking->phone }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-50">
                                <span class="text-gray-400 text-xs font-bold uppercase">المدينة</span>
                                <span class="font-medium text-secondary">{{ $booking->city }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3">
                                <span class="text-gray-400 text-xs font-bold uppercase">طريقة الدفع</span>
                                <span class="font-bold text-primary">{{ $booking->payment_type === 'cash' ? 'كاش (نقدي)' : 'تمويل بنكي' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes Section -->
                @if ($booking->client_notes)
                    <div class="bg-amber-50 rounded-[2rem] p-6 md:p-8 border border-amber-100 mb-8 relative">
                        <i class="ti-quote-right absolute left-8 top-8 text-amber-200 text-4xl"></i>
                        <h2 class="text-base font-bold text-amber-900 mb-3 flex items-center gap-2">
                            <i class="ti-comment-alt"></i> ملاحظاتك المرفقة:
                        </h2>
                        <p class="text-amber-800 text-sm leading-relaxed">{{ $booking->client_notes }}</p>
                    </div>
                @endif

                <!-- Contact Footer -->
                <div class="flex flex-col md:flex-row gap-4">
                    <a href="tel:{{ $booking->phone }}"
                        class="flex-1 bg-secondary text-white font-black py-4 rounded-2xl flex items-center justify-center gap-3 hover:bg-gray-800 transition-all shadow-xl shadow-secondary/10 active:scale-[0.98]">
                        <i class="ti-headphone-alt"></i> تواصل مع خدمة العملاء
                    </a>
                    <a href="{{ route('cars.index') }}"
                        class="flex-1 bg-primary text-white font-black py-4 rounded-2xl flex items-center justify-center gap-3 hover:opacity-90 transition-all shadow-xl shadow-primary/10 active:scale-[0.98]">
                        <i class="ti-car"></i> استعراض مركبات أخرى
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
