@extends('layouts.app')

@section('title', 'لوحة التحكم - ' . Auth::guard('customer')->user()->name)

@section('content')
    <section class="py-24 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <!-- Header -->
                <div class="mb-12">
                    <h1 class="text-4xl font-black text-secondary mb-2">مرحباً، {{ Auth::guard('customer')->user()->name }}! 👋</h1>
                    <p class="text-gray-600 text-lg">لوحة التحكم الخاصة بك</p>
                </div>

                <!-- Navigation Tabs -->
                <div class="mb-8 border-b border-gray-200">
                    <div class="flex gap-8 overflow-x-auto">
                        <a href="{{ route('customer.dashboard') }}"
                            class="pb-4 px-2 border-b-4 {{ request()->routeIs('customer.dashboard') ? 'border-primary text-primary' : 'border-transparent text-gray-600 hover:text-primary' }} font-bold transition-colors flex items-center gap-2">
                            <i class="ti-dashboard text-base"></i> لوحة التحكم
                        </a>
                        <a href="{{ route('customer.profile') }}"
                            class="pb-4 px-2 border-b-4 {{ request()->routeIs('customer.profile') ? 'border-primary text-primary' : 'border-transparent text-gray-600 hover:text-primary' }} font-bold transition-colors flex items-center gap-2">
                            <i class="ti-user text-base"></i> الملف الشخصي
                        </a>
                        <a href="{{ route('customer.bookings') }}"
                            class="pb-4 px-2 border-b-4 {{ request()->routeIs('customer.bookings') ? 'border-primary text-primary' : 'border-transparent text-gray-600 hover:text-primary' }} font-bold transition-colors flex items-center gap-2">
                            <i class="ti-clipboard text-base"></i> الحجزات
                        </a>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:shadow-lg transition">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-bold uppercase mb-2">إجمالي الحجزات</p>
                                <p class="text-4xl font-black text-primary">{{ $bookingCount }}</p>
                            </div>
                            <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center text-2xl text-primary">
                                <i class="ti-package"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:shadow-lg transition">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-bold uppercase mb-2">حالة السجل</p>
                                <p class="text-4xl font-black text-green-500">✓ نشط</p>
                            </div>
                            <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center text-2xl text-green-700">
                                <i class="ti-check"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:shadow-lg transition">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-bold uppercase mb-2">البريد الإلكتروني</p>
                                <p class="text-lg font-bold text-secondary break-all">{{ substr(Auth::guard('customer')->user()->email, 0, 20) }}...</p>
                            </div>
                            <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center text-2xl text-blue-700">
                                <i class="ti-email"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Bookings -->
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-secondary">آخر الحجزات</h2>
                        <a href="{{ route('customer.bookings') }}"
                            class="text-primary font-bold hover:underline flex items-center gap-2">
                            عرض الكل <i class="ti-arrow-left"></i>
                        </a>
                    </div>

                    @if ($bookings->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-right text-sm font-bold text-gray-600">السيارة</th>
                                        <th class="px-6 py-4 text-right text-sm font-bold text-gray-600">التاريخ</th>
                                        <th class="px-6 py-4 text-right text-sm font-bold text-gray-600">الحالة</th>
                                        <th class="px-6 py-4 text-right text-sm font-bold text-gray-600">الإجراء</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bookings as $booking)
                                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 font-bold text-secondary">
                                                {{ $booking->brand_name }} - {{ $booking->car_name_manual }}
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ $booking->request_date->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="px-4 py-2 rounded-full text-sm font-bold
                                                    {{ $booking->status === 'New' ? 'bg-blue-100 text-blue-700' : '' }}
                                                    {{ $booking->status === 'Contacted' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                                    {{ $booking->status === 'Interested' ? 'bg-green-100 text-green-700' : '' }}
                                                    {{ $booking->status === 'Completed' ? 'bg-purple-100 text-purple-700' : '' }}
                                                    {{ $booking->status === 'Not Interested' ? 'bg-red-100 text-red-700' : '' }}
                                                ">
                                                    {{ $booking->status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <a href="{{ route('customer.booking-detail', ['id' => $booking->id, 'type' => $booking->booking_type]) }}"
                                                    class="text-primary font-bold hover:underline">
                                                    عرض التفاصيل
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500 text-lg mb-4">لم تقم بأي حجوزات حتى الآن</p>
                            <a href="{{ route('cars.index') }}"
                                class="inline-block bg-primary text-white font-bold px-8 py-3 rounded-2xl hover:bg-opacity-90 transition">
                                استكشف السيارات الآن
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Quick Actions -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
                    <a href="{{ route('customer.profile') }}"
                        class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition flex items-center gap-4">
                        <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-2xl text-primary">
                            <i class="ti-user"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-secondary">تحديث الملف الشخصي</h3>
                            <p class="text-gray-500 text-sm">عدّل بيانات حسابك</p>
                        </div>
                    </a>

                    <a href="{{ route('customer.change-password') }}"
                        class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition flex items-center gap-4">
                        <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-2xl text-primary">
                            <i class="ti-lock"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-secondary">تغيير كلمة المرور</h3>
                            <p class="text-gray-500 text-sm">حافظ على أمان حسابك</p>
                        </div>
                    </a>

                    <a href="{{ route('cars.index') }}"
                        class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition flex items-center gap-4">
                        <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-2xl text-primary">
                            <i class="ti-car"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-secondary">استكشاف السيارات</h3>
                            <p class="text-gray-500 text-sm">اعرض قائمتنا الكاملة</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
