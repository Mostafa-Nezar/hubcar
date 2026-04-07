@extends('layouts.app')

@section('title', 'الملف الشخصي')

@section('content')
    <section class="py-24 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <!-- Header -->
                <div class="mb-12">
                    <a href="{{ route('customer.dashboard') }}"
                        class="text-primary font-bold mb-6 flex items-center gap-2 w-fit hover:underline">
                        <i class="ti-arrow-left"></i> العودة
                    </a>
                    <h1 class="text-4xl font-black text-secondary mb-2">الملف الشخصي</h1>
                    <p class="text-gray-600 text-lg">إدارة بيانات حسابك</p>
                </div>

                <!-- Navigation Tabs -->
                <div class="mb-8 border-b border-gray-200">
                    <div class="flex gap-8">
                        <a href="{{ route('customer.profile') }}"
                            class="pb-4 px-2 border-b-4 border-primary text-primary font-bold">
                            👤 البيانات الشخصية
                        </a>
                        <a href="{{ route('customer.change-password') }}"
                            class="pb-4 px-2 border-b-4 border-transparent text-gray-600 hover:text-primary font-bold transition-colors">
                            🔐 تغيير كلمة المرور
                        </a>
                    </div>
                </div>

                <!-- Profile Form -->
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    <h2 class="text-2xl font-bold text-secondary mb-8">تحديث البيانات الشخصية</h2>

                    @if ($errors->any())
                        <div class="mb-8 bg-red-50 border border-red-200 rounded-2xl p-6">
                            <h3 class="font-bold text-red-700 mb-2">أخطاء في النموذج:</h3>
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="text-red-600">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="mb-8 bg-green-50 border border-green-200 rounded-2xl p-6">
                            <p class="text-green-700 font-bold">✓ {{ session('success') }}</p>
                        </div>
                    @endif

                    <form action="{{ route('customer.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <!-- Full Name -->
                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-gray-600 uppercase tracking-wide">
                                    الاسم الكامل <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" value="{{ old('name', $customer->name) }}" required
                                    class="w-full bg-gray-50 border-2 border-transparent focus:border-primary/30 focus:bg-white rounded-2xl px-6 py-4 text-secondary font-bold transition-all outline-none @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-gray-600 uppercase tracking-wide">
                                    البريد الإلكتروني <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email', $customer->email) }}" required
                                    class="w-full bg-gray-50 border-2 border-transparent focus:border-primary/30 focus:bg-white rounded-2xl px-6 py-4 text-secondary font-bold transition-all outline-none @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full bg-primary text-white font-black py-4 rounded-2xl hover:bg-opacity-90 transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-3">
                            <i class="ti-save text-lg"></i>
                            حفظ التغييرات
                        </button>
                    </form>
                </div>

                <!-- Account Info Card -->
                <div class="bg-blue-50 rounded-3xl p-8 border border-blue-200 mt-12">
                    <h3 class="text-lg font-bold text-blue-900 mb-4"><i class="ti-info-alt ml-2"></i> معلومات الحساب</h3>
                    <div class="space-y-2 text-blue-800">
                        <p><strong>تاريخ الإنشاء:</strong> {{ $customer->created_at->format('d/m/Y') }}</p>
                        <p><strong>آخر تحديث:</strong> {{ $customer->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
