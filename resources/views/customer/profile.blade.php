@extends('layouts.app')

@section('title', 'الملف الشخصي')

@section('content')
    <section class="py-12 md:py-24 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <!-- Header -->
                <div class="mb-8 md:mb-12">
                    <a href="{{ route('customer.dashboard') }}"
                        class="text-primary font-bold mb-4 flex items-center gap-2 w-fit hover:translate-x-1 transition-transform text-sm">
                        <i class="ti-arrow-right"></i> العودة للوحة التحكم
                    </a>
                    <h1 class="text-3xl md:text-4xl font-black text-secondary mb-2">الملف الشخصي</h1>
                    <p class="text-gray-500 text-base">تحكم في بياناتك الشخصية وإعدادات الحساب</p>
                </div>

                <!-- Navigation Tabs (Scrollable) -->
                <div class="mb-8 -mx-4 px-4 md:mx-0 md:px-0 overflow-x-auto no-scrollbar border-b border-gray-200">
                    <div class="flex gap-6 min-w-max">
                        <a href="{{ route('customer.profile') }}"
                            class="pb-4 px-2 border-b-4 border-primary text-primary font-bold transition-all">
                            👤 البيانات الشخصية
                        </a>
                        <a href="{{ route('customer.change-password') }}"
                            class="pb-4 px-2 border-b-4 border-transparent text-gray-500 hover:text-primary font-bold transition-all">
                            🔐 تغيير كلمة المرور
                        </a>
                    </div>
                </div>

                <!-- Profile Form Card -->
                <div class="bg-white rounded-[2rem] p-6 md:p-10 shadow-sm border border-gray-100">
                    <div class="flex items-center gap-4 mb-10 pb-6 border-b border-gray-50 text-secondary">
                        <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary text-xl shadow-inner">
                            <i class="ti-id-badge"></i>
                        </div>
                        <div>
                            <h2 class="text-xl md:text-2xl font-bold">تحديث البيانات</h2>
                            <p class="text-xs text-gray-400">تأكد من صحة بيانات التواصل الخاصة بك</p>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="mb-8 bg-red-50 border-r-4 border-red-500 rounded-xl p-4 md:p-6 shadow-sm">
                            <h3 class="font-bold text-red-700 mb-2 flex items-center gap-2 text-sm">
                                <i class="ti-alert"></i> نعتذر، هناك بعض الأخطاء:
                            </h3>
                            <ul class="list-disc pr-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="text-red-600 text-xs">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="mb-8 bg-green-50 border-r-4 border-green-500 rounded-xl p-4 md:p-6 shadow-sm animate-pulse">
                            <p class="text-green-700 font-bold text-sm flex items-center gap-2">
                                <i class="ti-check"></i> {{ session('success') }}
                            </p>
                        </div>
                    @endif

                    <form action="{{ route('customer.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 mb-10">
                            <!-- Full Name -->
                            <div class="space-y-3">
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest">
                                    الاسم الكامل <span class="text-primary">*</span>
                                </label>
                                <div class="relative">
                                    <i class="ti-user absolute right-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                                    <input type="text" name="name" value="{{ old('name', $customer->name) }}" required
                                        class="w-full bg-gray-50 border-2 border-transparent focus:border-primary/20 focus:bg-white rounded-2xl pr-12 pl-6 py-4 text-secondary font-bold transition-all outline-none @error('name') border-red-500 @enderror"
                                        placeholder="أدخل اسمك الكامل">
                                </div>
                                @error('name')
                                    <p class="text-red-500 text-[10px] mt-1 pr-2 font-bold">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="space-y-3">
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest">
                                    البريد الإلكتروني <span class="text-primary">*</span>
                                </label>
                                <div class="relative">
                                    <i class="ti-email absolute right-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                                    <input type="email" name="email" value="{{ old('email', $customer->email) }}" required
                                        class="w-full bg-gray-50 border-2 border-transparent focus:border-primary/20 focus:bg-white rounded-2xl pr-12 pl-6 py-4 text-secondary font-bold transition-all outline-none @error('email') border-red-500 @enderror"
                                        placeholder="yourname@example.com">
                                </div>
                                @error('email')
                                    <p class="text-red-500 text-[10px] mt-1 pr-2 font-bold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full bg-secondary text-white font-black py-4 md:py-5 rounded-2xl hover:bg-gray-800 transition-all shadow-xl shadow-secondary/20 flex items-center justify-center gap-3 group active:scale-[0.98]">
                            <i class="ti-save text-lg group-hover:rotate-12 transition-transform"></i>
                            تحديث الملف الشخصي
                        </button>
                    </form>
                </div>

                <!-- Info Card -->
                <div class="bg-gradient-to-l from-blue-50 to-white rounded-2xl p-6 border border-blue-100 mt-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <i class="ti-info-alt text-blue-500 text-xl"></i>
                        <div>
                            <p class="text-blue-900 font-bold text-sm">معلومات الحساب</p>
                            <p class="text-blue-400 text-[10px]">انضممت إلينا في {{ $customer->created_at->format('d M, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
