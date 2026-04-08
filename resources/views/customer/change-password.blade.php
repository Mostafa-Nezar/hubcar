@extends('layouts.app')

@section('title', 'تغيير كلمة المرور')

@section('content')
    <section class="py-12 md:py-24 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="max-w-2xl mx-auto">
                <!-- Header -->
                <div class="mb-8 md:mb-12 text-center md:text-right">
                    <a href="{{ route('customer.profile') }}"
                        class="text-primary font-bold mb-4 flex items-center gap-2 w-fit hover:translate-x-1 transition-transform text-sm mx-auto md:mx-0">
                        <i class="ti-arrow-right"></i> العودة للملف الشخصي
                    </a>
                    <h1 class="text-3xl md:text-4xl font-black text-secondary mb-2">تأمين الحساب</h1>
                    <p class="text-gray-500 text-base">قم بتحديث كلمة المرور بانتظام لحماية حسابك</p>
                </div>

                <!-- Password Form Card -->
                <div class="bg-white rounded-[2rem] p-6 md:p-10 shadow-sm border border-gray-100">
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
                        <div class="mb-6 md:mb-8 space-y-3">
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest">
                                كلمة المرور الحالية <span class="text-primary">*</span>
                            </label>
                            <div class="relative">
                                <i class="ti-lock absolute right-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                                <input type="password" name="current_password" required
                                    class="w-full bg-gray-50 border-2 border-transparent focus:border-primary/20 focus:bg-white rounded-2xl pr-12 pl-6 py-4 text-secondary font-bold transition-all outline-none @error('current_password') border-red-500 @enderror"
                                    placeholder="أدخل كلمة المرور القديمة">
                            </div>
                            @error('current_password')
                                <p class="text-red-500 text-[10px] mt-1 pr-2 font-bold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 mb-10">
                            <!-- New Password -->
                            <div class="space-y-3">
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest">
                                    الكلمة الجديدة <span class="text-primary">*</span>
                                </label>
                                <div class="relative">
                                    <i class="ti-key absolute right-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                                    <input type="password" name="password" required
                                        class="w-full bg-gray-50 border-2 border-transparent focus:border-primary/20 focus:bg-white rounded-2xl pr-12 pl-6 py-4 text-secondary font-bold transition-all outline-none @error('password') border-red-500 @enderror"
                                        placeholder="الكلمة السرية الجديدة">
                                </div>
                                <p class="text-[10px] text-gray-400 mt-1 pr-2 italic">8 رموز على الأقل</p>
                                @error('password')
                                    <p class="text-red-500 text-[10px] mt-1 pr-2 font-bold">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="space-y-3">
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest">
                                    تأكيد الكلمة <span class="text-primary">*</span>
                                </label>
                                <div class="relative">
                                    <i class="ti-shield absolute right-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                                    <input type="password" name="password_confirmation" required
                                        class="w-full bg-gray-50 border-2 border-transparent focus:border-primary/20 focus:bg-white rounded-2xl pr-12 pl-6 py-4 text-secondary font-bold transition-all outline-none"
                                        placeholder="تأكيد الكلمة الجديدة">
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full bg-secondary text-white font-black py-4 md:py-5 rounded-2xl hover:bg-gray-800 transition-all shadow-xl shadow-secondary/20 flex items-center justify-center gap-3 group active:scale-[0.98]">
                            <i class="ti-lock text-lg"></i>
                            تحديث كلمة المرور
                        </button>
                    </form>
                </div>

                <!-- Simple Tips -->
                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-start gap-4 p-4 bg-white rounded-2xl border border-gray-100 italic">
                         <div class="w-8 h-8 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center shrink-0">
                             <i class="ti-light-bulb"></i>
                         </div>
                         <p class="text-xs text-gray-500 leading-relaxed">استخدم خليطاً من الرموز والأرقام لضمان قوة كلمة المرور وحماية حسابك.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
