@extends('layouts.app')

@section('title', 'الطلب السريع')

@section('content')
    <section class="bg-secondary py-20 text-center">
        <h1 class="text-4xl lg:text-5xl font-bold text-white mb-4">طلب سريع</h1>
        <p class="text-gray-400 italic">اختر السيارة التي تريدها وتواصل معنا الآن</p>
    </section>

    <section class="py-24 bg-white">
        <div class="container mx-auto px-4 lg:px-8 max-w-2xl">
            <form action="{{ route('cars.quick-booking.store') }}" method="POST"
                class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm">
                @csrf

                <!-- Car Selection -->
                <div class="space-y-2">
                    <label for="car_id" class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-3">
                        اختر السيارة <span class="text-red-500">*</span>
                    </label>
                    <select id="car_id" name="car_id" required
                        class="w-full bg-gray-50 border-2 border-transparent focus:border-primary/30 focus:bg-white rounded-2xl px-6 py-4 text-secondary font-bold transition-all outline-none appearance-none @error('car_id') border-red-500 @enderror">
                        <option value="">-- اختر سيارة --</option>
                        @foreach ($cars as $car)
                            <option value="{{ $car->id }}" {{ old('car_id') == $car->id ? 'selected' : '' }}>
                                {{ $car->brand->name ?? '' }} - {{ $car->name }} ({{ $car->model_year }})
                            </option>
                        @endforeach
                    </select>
                    @error('car_id')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Client Name -->
                <div class="space-y-2">
                    <label for="client_name" class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-3">
                        الاسم الكامل <span class="text-red-500">*</span>
                    </label>
                    @if($user)
                        <input type="text" value="{{ $user->name }}" disabled
                            class="w-full bg-gray-100 border-2 border-gray-200 rounded-2xl px-6 py-4 text-secondary font-bold cursor-not-allowed opacity-75">
                        <p class="text-xs text-gray-500">مسجل من حسابك</p>
                    @else
                        <input type="text" id="client_name" name="client_name" required placeholder="أحمد محمد علي سالم"
                            value="{{ old('client_name') }}"
                            class="w-full bg-gray-50 border-2 border-transparent focus:border-primary/30 focus:bg-white rounded-2xl px-6 py-4 text-secondary font-bold transition-all outline-none @error('client_name') border-red-500 @enderror">
                        @error('client_name')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    @endif
                </div>

                <!-- Phone Number -->
                <div class="space-y-2">
                    <label for="phone" class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-3">
                        رقم الجوال <span class="text-red-500">*</span>
                    </label>
                    @if($user)
                        <input type="text" value="{{ $user->email }}" disabled
                            class="w-full bg-gray-100 border-2 border-gray-200 rounded-2xl px-6 py-4 text-secondary font-bold cursor-not-allowed opacity-75 ltr">
                        <p class="text-xs text-gray-500">من حسابك المسجل</p>
                    @else
                        <input type="tel" id="phone" name="phone" required placeholder="0512345678"
                            value="{{ old('phone') }}"
                            class="w-full bg-gray-50 border-2 border-transparent focus:border-primary/30 focus:bg-white rounded-2xl px-6 py-4 text-secondary font-bold transition-all outline-none text-left @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    @endif
                </div>

                <!-- City -->
                <div class="space-y-2">
                    <label for="city" class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-3">
                        المدينة <span class="text-red-500">*</span>
                    </label>
                    <select id="city" name="city" required
                        class="w-full bg-gray-50 border-2 border-transparent focus:border-primary/30 focus:bg-white rounded-2xl px-6 py-4 text-secondary font-bold transition-all outline-none appearance-none @error('city') border-red-500 @enderror">
                        <option value="">اختر مدينة الإقامة</option>
                        @php
                            $saudiCities = config('saudi-cities', []);
                            sort($saudiCities);
                        @endphp
                        @foreach ($saudiCities as $city)
                            <option value="{{ $city }}" {{ old('city') == $city ? 'selected' : '' }}>
                                {{ $city }}
                            </option>
                        @endforeach
                    </select>
                    @error('city')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-primary text-white text-xl font-black py-5 rounded-2xl hover:bg-opacity-90 transition-all shadow-2xl transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-4 group">
                    <span>إرسال الطلب السريع</span>
                    <i class="ti-bolt group-hover:scale-110 transition-transform"></i>
                </button>

                <p class="text-center text-gray-500 text-sm mt-6">
                    سنقوم بالتواصل معك في أقرب وقت للتأكد من تفاصيل طلبك
                </p>
            </form>
        </div>
    </section>
@endsection
