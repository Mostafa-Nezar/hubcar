@extends('layouts.app')

@section('title', 'قائمة السيارات')

@section('content')
    <!-- Page Header -->
    <section class="bg-secondary py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <img src="{{ asset('img/slider/2.jpg') }}" alt="" loading="lazy" decoding="async" class="w-full h-full object-cover">
        </div>
        <div class="container mx-auto px-4 lg:px-8 relative z-10 text-center">
            <h1 class="text-4xl lg:text-5xl font-bold text-white mb-4">جميع السيارات</h1>
            <nav class="flex justify-center text-gray-400 text-sm">
                <a href="{{ route('home') }}" class="hover:text-primary transition">الرئيسية</a>
                <span class="mx-2">/</span>
                <span class="text-primary">قائمة السيارات</span>
            </nav>
        </div>
    </section>

    <!-- Dynamic Content Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4 lg:px-8">
            @livewire('car-list')
        </div>
    </section>
@endsection
