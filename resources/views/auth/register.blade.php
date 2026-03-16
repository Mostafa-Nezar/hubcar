@extends('layouts.app')

@section('title', 'إنشاء حساب جديد')

@section('content')
    <section class="py-24 bg-gray-50">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="max-w-md mx-auto">
                <div class="bg-white rounded-3xl shadow-xl p-8 md:p-10 border border-gray-100">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-secondary mb-2">إنشاء حساب جديد</h2>
                        <p class="text-gray-500">انضم إلينا اليوم</p>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border-r-4 border-red-500 rounded-xl">
                            <ul class="list-none text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li class="flex items-center gap-2 mb-1">
                                        <i class="ti-alert-circle"></i>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">الاسم</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary text-gray-800"
                                placeholder="أدخل اسمك الكامل">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">البريد الإلكتروني</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary text-gray-800"
                                placeholder="example@email.com">
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-2">كلمة المرور</label>
                            <input type="password" id="password" name="password" required
                                class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary text-gray-800"
                                placeholder="••••••••">
                            <p class="mt-1 text-xs text-gray-500">يجب أن تكون 8 أحرف على الأقل</p>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">تأكيد كلمة المرور</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary text-gray-800"
                                placeholder="••••••••">
                        </div>

                        <button type="submit"
                            class="w-full bg-primary text-white font-bold py-4 rounded-xl hover:bg-opacity-90 transition shadow-lg">
                            إنشاء حساب
                        </button>
                    </form>

                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-500">
                            لديك حساب بالفعل؟
                            <a href="{{ route('login') }}" class="text-primary font-bold hover:underline">سجل الدخول</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
