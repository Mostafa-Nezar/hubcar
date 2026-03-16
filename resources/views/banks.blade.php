@extends('layouts.app')

@section('title', 'جهات التمويل')

@section('content')
    <section class="bg-secondary py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <img src="{{ asset('img/slider/3.jpg') }}" alt="" class="w-full h-full object-cover">
        </div>
        <div class="container mx-auto px-4 lg:px-8 relative z-10 text-center">
            <h1 class="text-4xl lg:text-5xl font-bold text-white mb-4">شركاء النجاح</h1>
            <p class="text-gray-400">جهات تمويل معتمدة لتسهيل امتلاك سيارتك</p>
        </div>
    </section>

    <section class="py-24 bg-gray-50">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach ($banks as $bank)
                    <div
                        class="bg-white p-10 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl transition duration-500 group text-center italic">
                        <div
                            class="h-24 flex items-center justify-center mb-8 grayscale group-hover:grayscale-0 transition duration-500">
                            @php
                                $logoUrl = str_starts_with($bank->logo, 'http')
                                    ? $bank->logo
                                    : (str_starts_with($bank->logo, 'img/')
                                        ? asset($bank->logo)
                                        : Storage::url($bank->logo));
                            @endphp
                            <img src="{{ $logoUrl }}" alt="{{ $bank->name }}" class="max-h-full">
                        </div>
                        <h3 class="text-2xl font-black text-secondary mb-4">{{ $bank['name'] }}</h3>
                        <p class="text-gray-500 mb-8 leading-relaxed">{{ $bank['description'] }}</p>
                        <a href="{{ route('contact') }}"
                            class="text-primary font-bold hover:underline decoration-2 underline-offset-8">ابدأ الطلب
                            الآن</a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection