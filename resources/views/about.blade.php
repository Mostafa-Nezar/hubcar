@extends('layouts.app')

@section('title', 'من نحن')

@section('content')
    <!-- Page Header -->
    <section class="bg-secondary py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <img src="{{ asset('img/about.jpg') }}" alt="" class="w-full h-full object-cover">
        </div>
        <div class="container mx-auto px-4 lg:px-8 relative z-10 text-center">
            <h1 class="text-4xl lg:text-5xl font-bold text-white mb-4">من نحن</h1>
            <nav class="flex justify-center text-gray-400 text-sm italic">
                <a href="{{ route('home') }}" class="hover:text-primary transition">الرئيسية</a>
                <span class="mx-2">/</span>
                <span class="text-primary">قصتنا</span>
            </nav>
        </div>
    </section>

    <!-- Content -->
    <section class="py-24 bg-white italic font-medium">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="lg:w-1/2">
                    <h2 class="text-4xl font-black text-secondary mb-8 leading-tight">
                        @php
                            $title = $about?->title ?? 'تاريخ حافل بالثقة والتميز';
                            // Optional: highlight last word
                            $words = explode(' ', $title);
                            $lastWord = array_pop($words);
                            $mainTitle = implode(' ', $words);
                        @endphp
                        {{ $mainTitle }} <span class="text-primary">{{ $lastWord }}</span>
                    </h2>
                    <p class="text-gray-500 mb-6 text-lg">{{ $about?->description_1 }}</p>
                    <p class="text-gray-500 mb-10 leading-relaxed italic">{{ $about?->description_2 }}</p>

                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <span
                                class="text-4xl font-black text-primary block mb-1">{{ $about?->exp_value ?? '15+' }}</span>
                            <span
                                class="text-gray-400 text-sm font-bold uppercase tracking-widest">{{ $about?->exp_label ?? 'عاماً من الخبرة' }}</span>
                        </div>
                        <div>
                            <span
                                class="text-4xl font-black text-primary block mb-1">{{ $about?->clients_value ?? '5000+' }}</span>
                            <span
                                class="text-gray-400 text-sm font-bold uppercase tracking-widest">{{ $about?->clients_label ?? 'عميل سعيد' }}</span>
                        </div>
                    </div>
                </div>
                <div class="lg:w-1/2 relative">
                    @php
                        $image = $about?->image
                            ? (Str::startsWith($about->image, 'http')
                                ? $about->image
                                : asset('storage/' . $about->image))
                            : asset('img/slider/1.jpg');
                    @endphp
                    <img src="{{ $image }}" alt="" class="rounded-3xl shadow-2xl relative z-10">
                    <div class="absolute -top-10 -left-10 w-64 h-64 bg-primary bg-opacity-10 rounded-full animate-pulse">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
