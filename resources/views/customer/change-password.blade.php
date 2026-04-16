@extends('layouts.app')

@section('title', __('تغيير كلمة المرور'))

@section('content')
    <section class="py-12 md:py-24 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="max-w-2xl mx-auto">
                <!-- Header -->
                <div class="mb-8 md:mb-12 text-center md:text-right">
                    <a href="{{ route('customer.profile') }}"
                        class="text-primary font-black uppercase tracking-widest mb-6 flex items-center gap-3 w-fit hover:-translate-x-2 transition-transform text-[10px] mx-auto md:mx-0">
                        <i class="ti-arrow-right"></i> {{ __('العودة للملف الشخصي') }}
                    </a>
                    <h1 class="text-3xl md:text-5xl font-black text-secondary mb-3">{{ __('تأمين الحساب') }}</h1>
                    <p class="text-gray-400 text-base md:text-lg italic">
                        {{ __('قم بتحديث كلمة المرور بانتظام لحماية حسابك') }}</p>
                </div>

                <!-- Password Form Card -->
                <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-sm border border-gray-100">
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
                        <div class="mb-8 bg-green-50 border-r-4 border-green-500 rounded-xl p-4 md:p-6 shadow-sm">
                            <p class="text-green-700 font-bold text-sm flex items-center gap-2">
                                <i class="ti-check"></i> {{ session('success') }}
                            </p>
                        </div>
                    @endif

                    <form action="{{ route('customer.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Current Password -->
                        <div class="mb-8 md:mb-10 space-y-4">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                {{ __('كلمة المرور الحالية') }} <span class="text-primary">*</span>
                            </label>
                            <div class="relative group">
                                <i
                                    class="ti-lock absolute right-6 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-primary transition-colors"></i>
                                <input type="password" name="current_password" required
                                    class="w-full bg-gray-50 border-2 border-transparent focus:border-primary/20 focus:bg-white rounded-[1.25rem] pr-14 pl-8 py-5 text-secondary font-bold transition-all outline-none @error('current_password') border-red-500 @enderror"
                                    placeholder="{{ __('أدخل كلمة المرور القديمة') }}">
                            </div>
                            @error('current_password')
                                <p class="text-red-500 text-[10px] mt-2 pr-2 font-black uppercase tracking-widest italic">
                                    {{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 mb-10">
                            <!-- New Password -->
                            <div class="space-y-4">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                    {{ __('الكلمة الجديدة') }} <span class="text-primary">*</span>
                                </label>
                                <div class="relative group">
                                    <i
                                        class="ti-key absolute right-6 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-primary transition-colors"></i>
                                    <input type="password" name="password" required
                                        class="w-full bg-gray-50 border-2 border-transparent focus:border-primary/20 focus:bg-white rounded-[1.25rem] pr-14 pl-8 py-5 text-secondary font-bold transition-all outline-none @error('password') border-red-500 @enderror"
                                        placeholder="{{ __('الكلمة السرية الجديدة') }}">
                                </div>
                                <p class="text-[10px] text-gray-400 mt-2 pr-2 font-bold italic tracking-widest uppercase">
                                    {{ __('8 رموز على الأقل') }}</p>
                                @error('password')
                                    <p class="text-red-500 text-[10px] mt-2 pr-2 font-black uppercase tracking-widest italic">
                                        {{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="space-y-4">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                    {{ __('تأكيد الكلمة') }} <span class="text-primary">*</span>
                                </label>
                                <div class="relative group">
                                    <i
                                        class="ti-shield absolute right-6 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-primary transition-colors"></i>
                                    <input type="password" name="password_confirmation" required
                                        class="w-full bg-gray-50 border-2 border-transparent focus:border-primary/20 focus:bg-white rounded-[1.25rem] pr-14 pl-8 py-5 text-secondary font-bold transition-all outline-none"
                                        placeholder="{{ __('تأكيد الكلمة الجديدة') }}">
                                </div>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full bg-secondary text-white font-black py-4 md:py-6 rounded-[1.25rem] hover:bg-black transition-all shadow-2xl shadow-secondary/20 flex items-center justify-center gap-4 group active:scale-[0.98]">
                            <i class="ti-lock text-xl group-hover:scale-110 transition-transform"></i>
                            {{ __('تحديث كلمة المرور') }}
                        </button>
                    </form>
                </div>

                <!-- Simple Tips -->
                <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div
                        class="flex items-start gap-5 p-6 bg-amber-50 rounded-[1.5rem] border border-amber-100 relative overflow-hidden">
                        <div class="absolute right-0 top-0 w-1 bg-amber-400 h-full"></div>
                        <div
                            class="w-10 h-10 bg-white shadow-sm rounded-xl flex items-center justify-center text-amber-500 text-lg shrink-0">
                            <i class="ti-light-bulb"></i>
                        </div>
                        <p class="text-xs text-amber-900 font-bold leading-relaxed">
                            {{ __('استخدم خليطاً من الرموز والأرقام لضمان قوة كلمة المرور وحماية حسابك.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection