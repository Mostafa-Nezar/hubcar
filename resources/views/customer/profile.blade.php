@extends('layouts.app')

@section('title', __('البيانات الشخصية'))

@section('content')
    <section class="py-12 md:py-24 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <!-- Header -->
                <div class="mb-8 md:mb-12">
                    <a href="{{ route('customer.dashboard') }}"
                        class="text-primary font-black uppercase tracking-widest mb-6 flex items-center gap-3 w-fit hover:-translate-x-2 transition-transform text-[10px]">
                        <i class="ti-arrow-right"></i> {{ __('العودة للوحة التحكم') }}
                    </a>
                    <h1 class="text-3xl md:text-5xl font-black text-secondary mb-3">{{ __('البيانات الشخصية') }}</h1>
                    <p class="text-gray-400 text-base md:text-lg italic">{{ __('تحكم في بياناتك الشخصية وإعدادات الحساب') }}
                    </p>
                </div>

                <!-- Navigation Tabs (Scrollable) -->
                <div class="mb-8 -mx-4 px-4 md:mx-0 md:px-0 overflow-x-auto no-scrollbar border-b border-gray-100">
                    <div class="flex gap-8 min-w-max">
                        <a href="{{ route('customer.profile') }}"
                            class="pb-4 px-2 border-b-4 {{ request()->routeIs('customer.profile') ? 'border-primary text-primary' : 'border-transparent text-gray-400' }} font-black uppercase tracking-widest text-[10px] transition-all">
                            {{ __('البيانات الشخصية') }}
                        </a>
                        <a href="{{ route('customer.change-password') }}"
                            class="pb-4 px-2 border-b-4 {{ request()->routeIs('customer.change-password') ? 'border-primary text-primary' : 'border-transparent text-gray-400' }} hover:text-primary font-black uppercase tracking-widest text-[10px] transition-all">
                            {{ __('تغيير كلمة المرور') }}
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-sm border border-gray-100">
                    <div class="flex items-center gap-5 mb-12 pb-8 border-b border-gray-50 text-secondary">
                        <div
                            class="w-16 h-16 bg-primary/10 rounded-[1.25rem] flex items-center justify-center text-primary text-2xl shadow-inner">
                            <i class="ti-id-badge"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl md:text-3xl font-black">{{ __('تحديث البيانات') }}</h2>
                            <p class="text-sm text-gray-400">{{ __('تأكد من صحة بيانات التواصل الخاصة بك') }}</p>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="mb-10 bg-red-50 border-r-4 border-red-500 rounded-2xl p-6 shadow-sm">
                            <h3 class="font-black text-red-700 mb-3 flex items-center gap-2 text-sm uppercase tracking-widest">
                                <i class="ti-alert"></i> {{ __('نعتذر، هناك بعض الأخطاء:') }}
                            </h3>
                            <ul class="list-disc pr-6 space-y-2">
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

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-10 mb-12">
                            <!-- Full Name -->
                            <div class="space-y-4">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                    {{ __('الاسم الكامل') }} <span class="text-primary">*</span>
                                </label>
                                <div class="relative group">
                                    <i
                                        class="ti-user absolute right-6 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-primary transition-colors"></i>
                                    <input type="text" name="name" value="{{ old('name', $customer->name) }}" required
                                        class="w-full bg-gray-50 border-2 border-transparent focus:border-primary/20 focus:bg-white rounded-[1.25rem] pr-14 pl-8 py-5 text-secondary font-bold transition-all outline-none @error('name') border-red-500 @enderror"
                                        placeholder="{{ __('أدخل اسمك الكامل') }}">
                                </div>
                                @error('name')
                                    <p class="text-red-500 text-[10px] mt-2 pr-2 font-black uppercase tracking-widest italic">
                                        {{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="space-y-4">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                    {{ __('البريد الإلكتروني') }} <span class="text-primary">*</span>
                                </label>
                                <div class="relative group">
                                    <i
                                        class="ti-email absolute right-6 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-primary transition-colors"></i>
                                    <input type="email" name="email" value="{{ old('email', $customer->email) }}" required
                                        class="w-full bg-gray-50 border-2 border-transparent focus:border-primary/20 focus:bg-white rounded-[1.25rem] pr-14 pl-8 py-5 text-secondary font-bold transition-all outline-none @error('email') border-red-500 @enderror"
                                        placeholder="yourname@example.com">
                                </div>
                                @error('email')
                                    <p class="text-red-500 text-[10px] mt-2 pr-2 font-black uppercase tracking-widest italic">
                                        {{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full bg-secondary text-white font-black py-4 md:py-6 rounded-[1.25rem] hover:bg-black transition-all shadow-2xl shadow-secondary/20 flex items-center justify-center gap-4 group active:scale-[0.98]">
                            <i class="ti-save text-xl group-hover:rotate-12 transition-transform"></i>
                            {{ __('تحديث الملف الشخصي') }}
                        </button>
                    </form>
                </div>

                <!-- Info Card -->
                <div
                    class="bg-gradient-to-l from-white to-gray-50/50 rounded-[1.5rem] p-8 border border-gray-100 mt-12 flex flex-col md:flex-row md:items-center justify-between gap-6 relative overflow-hidden">
                    <div class="absolute right-0 top-0 w-1 bg-primary h-full"></div>
                    <div class="flex items-center gap-5 relative z-10">
                        <div
                            class="w-12 h-12 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center text-primary text-xl">
                            <i class="ti-info-alt"></i>
                        </div>
                        <div>
                            <p class="text-secondary font-black text-sm uppercase tracking-widest">
                                {{ __('معلومات الحساب') }}</p>
                            <p class="text-gray-400 text-xs mt-1">{{ __('انضممت إلينا في') }}
                                {{ $customer->created_at->format('d M, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection