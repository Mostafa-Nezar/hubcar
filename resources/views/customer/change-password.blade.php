@extends('layouts.app')

@section('title', 'تغيير كلمة المرور')

@section('content')
    <section class="py-24 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="max-w-2xl mx-auto">
                <!-- Header -->
                <div class="mb-12">
                    <a href="{{ route('customer.profile') }}"
                        class="text-primary font-bold mb-6 flex items-center gap-2 w-fit hover:underline">
                        <i class="ti-arrow-left"></i> العودة
                    </a>
                    <h1 class="text-4xl font-black text-secondary mb-2">تغيير كلمة المرور</h1>
                    <p class="text-gray-600 text-lg">حافظ على أمان حسابك بكلمة مرور قوية</p>
                </div>

                <!-- Password Form -->
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    @if ($errors->any())
                        <div class="mb-8 bg-red-50 border border-red-200 rounded-2xl p-6">
                            <h3 class="font-bold text-red-700 mb-2">أخطاء:</h3>
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

                    <form action="{{ route('customer.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Current Password -->
                        <div class="mb-8 space-y-2">
                            <label class="block text-sm font-bold text-gray-600 uppercase tracking-wide">
                                كلمة المرور الحالية <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="current_password" required
                                class="w-full bg-gray-50 border-2 border-transparent focus:border-primary/30 focus:bg-white rounded-2xl px-6 py-4 text-secondary font-bold transition-all outline-none @error('current_password') border-red-500 @enderror">
                            @error('current_password')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="mb-8 space-y-2">
                            <label class="block text-sm font-bold text-gray-600 uppercase tracking-wide">
                                كلمة المرور الجديدة <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password" required
                                class="w-full bg-gray-50 border-2 border-transparent focus:border-primary/30 focus:bg-white rounded-2xl px-6 py-4 text-secondary font-bold transition-all outline-none @error('password') border-red-500 @enderror">
                            <p class="text-gray-500 text-xs mt-2">يجب أن تكون الكلمة 8 أحرف على الأقل</p>
                            @error('password')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-8 space-y-2">
                            <label class="block text-sm font-bold text-gray-600 uppercase tracking-wide">
                                تأكيد كلمة المرور <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password_confirmation" required
                                class="w-full bg-gray-50 border-2 border-transparent focus:border-primary/30 focus:bg-white rounded-2xl px-6 py-4 text-secondary font-bold transition-all outline-none">
                            @error('password_confirmation')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full bg-primary text-white font-black py-4 rounded-2xl hover:bg-opacity-90 transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-3">
                            <i class="ti-lock text-lg"></i>
                            تحديث كلمة المرور
                        </button>
                    </form>
                </div>

                <!-- Security Tips -->
                <div class="bg-amber-50 rounded-3xl p-8 border border-amber-200 mt-12">
                    <h3 class="text-lg font-bold text-amber-900 mb-4">💡 نصائح الأمان</h3>
                    <ul class="list-disc pl-5 space-y-2 text-amber-800">
                        <li>استخدم كلمة مرور قوية تحتوي على أحرف وأرقام ورموز</li>
                        <li>لا تشاركها مع أحد أبداً</li>
                        <li>غيّرها بشكل دوري للحفاظ على أمان حسابك</li>
                        <li>تجنب استخدام معلومات شخصية في كلمة المرور</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
