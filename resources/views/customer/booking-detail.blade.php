@extends('layouts.app')

@section('title', __('تفاصيل الحجز'))

@section('content')
    <section class="py-12 md:py-24 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <!-- Header -->
                <div class="mb-8 md:mb-12">
                    <a href="{{ route('customer.bookings') }}"
                        class="text-primary font-black uppercase tracking-widest mb-6 flex items-center gap-3 w-fit hover:-translate-x-2 transition-transform text-[10px]">
                        <i class="ti-arrow-right"></i> {{ __('العودة لقائمة الحجوزات') }}
                    </a>
                    <h1 class="text-3xl md:text-5xl font-black text-secondary mb-3">{{ __('تفاصيل الطلب') }}</h1>
                    <p class="text-gray-400 text-base md:text-lg italic">{{ __('رقم طلبك') }}: <span
                            class="text-primary font-black ml-2 uppercase">#{{ $booking->id }}</span></p>
                </div>

                <!-- Status & Timeline Card -->
                <div
                    class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-sm border border-gray-100 mb-10 relative overflow-hidden">
                    <div
                        class="flex flex-col md:flex-row md:items-center justify-between gap-8 mb-12 pb-8 border-b border-gray-50">
                        <div class="flex items-center gap-5">
                            <div
                                class="w-14 h-14 bg-gray-50 rounded-[1.25rem] flex items-center justify-center text-secondary text-2xl shadow-inner">
                                <i class="ti-pulse"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-black text-secondary uppercase tracking-widest">
                                    {{ __('حالة الطلب الحالية') }}</h2>
                                <p class="text-sm text-gray-400 italic">{{ __('يتم تحديث الحالة دورياً') }}</p>
                            </div>
                        </div>
                        <span class="w-fit px-10 py-4 rounded-[1.25rem] text-[10px] font-black uppercase shadow-xl shadow-secondary/5 tracking-widest
                                {{ $booking->status === 'New' ? 'bg-blue-50 text-blue-700 border border-blue-100' : '' }}
                                {{ $booking->status === 'Contacted' ? 'bg-orange-50 text-orange-700 border border-orange-100' : '' }}
                                {{ $booking->status === 'Interested' ? 'bg-green-50 text-green-700 border border-green-100' : '' }}
                                {{ $booking->status === 'Completed' ? 'bg-purple-50 text-purple-700 border border-purple-100' : '' }}
                                {{ $booking->status === 'Not Interested' ? 'bg-red-50 text-red-700 border border-red-100' : '' }}
                            ">
                            {{ __($booking->status) }}
                        </span>
                    </div>

                    <!-- Modern Timeline -->
                    <div
                        class="relative pl-10 space-y-10 before:absolute before:right-[7px] before:top-2 before:bottom-2 before:w-[2px] before:bg-gray-100">
                        <div class="relative flex flex-col md:flex-row md:items-center gap-5">
                            <div
                                class="absolute right-[-24px] top-1 w-4 h-4 bg-primary rounded-full border-4 border-white shadow-xl ring-8 ring-primary/5">
                            </div>
                            <div class="bg-gray-50 p-6 rounded-[1.5rem] flex-1 border border-gray-100">
                                <p class="font-black text-secondary text-sm uppercase tracking-widest">
                                    {{ __('تم إنشاء الطلب بنجاح') }}</p>
                                <p class="text-gray-400 text-[10px] mt-2 font-bold">
                                    {{ $booking->request_date->format('d M, Y - H:i A') }}</p>
                            </div>
                        </div>

                        @if ($booking->last_status_update)
                            <div class="relative flex flex-col md:flex-row md:items-center gap-5">
                                <div
                                    class="absolute right-[-24px] top-1 w-4 h-4 bg-green-500 rounded-full border-4 border-white shadow-xl ring-8 ring-green-500/5 transition-all">
                                </div>
                                <div class="bg-green-50 p-6 rounded-[1.5rem] border border-green-100 flex-1">
                                    <p class="font-black text-green-900 text-sm uppercase tracking-widest">
                                        {{ __('آخر تحديث من قبل المعرض') }}</p>
                                    <p class="text-green-600/60 text-[10px] mt-2 font-bold">
                                        {{ $booking->last_status_update->format('d M, Y - H:i A') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <!-- Car Section -->
                    <div
                        class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-gray-100 relative overflow-hidden group">
                        <div
                            class="absolute inset-x-0 top-0 h-1 bg-primary transform origin-right scale-x-0 group-hover:scale-x-100 transition-transform duration-500">
                        </div>
                        <h3 class="text-xl font-black text-secondary mb-8 flex items-center gap-4">
                            <i class="ti-car text-primary"></i> {{ __('تفاصيل المركبة') }}
                        </h3>
                        <div class="space-y-6">
                            <div class="flex justify-between items-center py-4 border-b border-gray-50">
                                <span
                                    class="text-gray-400 text-[10px] font-black uppercase tracking-widest">{{ __('البراند والنوع') }}</span>
                                <span class="font-black text-secondary">{{ $booking->brand_name }}
                                    {{ $booking->car_name_manual }}</span>
                            </div>
                            <div class="flex justify-between items-center py-4 border-b border-gray-50">
                                <span
                                    class="text-gray-400 text-[10px] font-black uppercase tracking-widest">{{ __('سنة الصنع') }}</span>
                                <span class="font-bold text-secondary">{{ $booking->model_year }}</span>
                            </div>
                            <div class="flex justify-between items-center py-4 border-b border-gray-50">
                                <span
                                    class="text-gray-400 text-[10px] font-black uppercase tracking-widest">{{ __('الفئة') }}</span>
                                <span class="font-bold text-secondary">{{ __($booking->car_category) }}</span>
                            </div>
                            <div class="flex justify-between items-center py-4">
                                <span
                                    class="text-gray-400 text-[10px] font-black uppercase tracking-widest">{{ __('القيمة التقديرية') }}</span>
                                <span class="font-black text-primary text-xl">{{ number_format($booking->car_price) }}
                                    {{ __('ر.س') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Client Section -->
                    <div
                        class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-gray-100 relative overflow-hidden group">
                        <div
                            class="absolute inset-x-0 top-0 h-1 bg-primary transform origin-right scale-x-0 group-hover:scale-x-100 transition-transform duration-500">
                        </div>
                        <h3 class="text-xl font-black text-secondary mb-8 flex items-center gap-4">
                            <i class="ti-clipboard text-primary"></i> {{ __('بيانات التواصل') }}
                        </h3>
                        <div class="space-y-6">
                            <div class="flex justify-between items-center py-4 border-b border-gray-50">
                                <span
                                    class="text-gray-400 text-[10px] font-black uppercase tracking-widest">{{ __('الاسم الكامل') }}</span>
                                <span class="font-black text-secondary">{{ $booking->client_name }}</span>
                            </div>
                            <div class="flex justify-between items-center py-4 border-b border-gray-50">
                                <span
                                    class="text-gray-400 text-[10px] font-black uppercase tracking-widest">{{ __('رقم الجوال') }}</span>
                                <span class="font-bold text-secondary" dir="ltr">{{ $booking->phone }}</span>
                            </div>
                            <div class="flex justify-between items-center py-4 border-b border-gray-50">
                                <span
                                    class="text-gray-400 text-[10px] font-black uppercase tracking-widest">{{ __('المدينة') }}</span>
                                <span class="font-bold text-secondary">{{ __($booking->city) }}</span>
                            </div>
                            <div class="flex justify-between items-center py-4">
                                <span
                                    class="text-gray-400 text-[10px] font-black uppercase tracking-widest">{{ __('طريقة الدفع') }}</span>
                                <span
                                    class="font-black text-primary">{{ $booking->payment_type === 'cash' ? __('كاش (نقدي)') : __('تمويل بنكي') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes Section -->
                @if ($booking->client_notes)
                    <div
                        class="bg-amber-50 rounded-[2.5rem] p-8 md:p-10 border border-amber-100 mb-10 relative overflow-hidden">
                        <i class="ti-quote-right absolute left-8 top-8 text-amber-200/50 text-6xl"></i>
                        <h2 class="text-base font-black text-amber-900 mb-4 flex items-center gap-3 uppercase tracking-widest">
                            <i class="ti-comment-alt"></i> {{ __('ملاحظاتك المرفقة:') }}
                        </h2>
                        <p class="text-amber-800 text-base leading-relaxed font-bold italic z-10 relative">
                            {{ $booking->client_notes }}</p>
                    </div>
                @endif

                <!-- Contact Footer -->
                <div class="flex flex-col md:flex-row gap-6">
                    <a href="tel:{{ $booking->phone }}"
                        class="flex-1 bg-secondary text-white font-black py-6 rounded-[1.5rem] flex items-center justify-center gap-4 hover:bg-black transition-all shadow-2xl shadow-secondary/15 active:scale-[0.98] uppercase tracking-widest text-[10px]">
                        <i class="ti-headphone-alt text-xl"></i> {{ __('تواصل مع خدمة العملاء') }}
                    </a>
                    <a href="{{ route('cars.index') }}"
                        class="flex-1 bg-primary text-white font-black py-6 rounded-[1.5rem] flex items-center justify-center gap-4 hover:scale-105 transition-all shadow-2xl shadow-primary/20 active:scale-[0.98] uppercase tracking-widest text-[10px]">
                        <i class="ti-car text-xl"></i> {{ __('استعراض مركبات أخرى') }}
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection