@extends('layouts.app')

@section('title', 'غير منفذة - 501')

@section('content')
    <div class="min-h-[70vh] flex items-center justify-center bg-gray-50 py-20">
        <div class="container mx-auto px-4 text-center">
            <div class="max-w-2xl mx-auto">
                {{-- Icon or Illustration --}}
                <div class="w-32 h-32 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-8">
                    <span class="text-5xl font-black text-orange-500">501</span>
                </div>

                {{-- Text Content --}}
                <h1 class="text-4xl md:text-5xl font-black text-secondary mb-6">
                    الخدمة غير متوفرة حالياً
                </h1>

                <p class="text-xl text-gray-500 mb-10 leading-relaxed">
                    عذراً، الخادم لا يدعم الوظيفة المطلوبة للوفاء بالطلب. يرجى المحاولة لاحقاً أو التواصل مع الدعم الفني.
                </p>

                {{-- Action Buttons --}}
                <div class="flex flex-col md:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('home') }}"
                        class="px-8 py-4 bg-primary text-white text-lg font-bold rounded-xl hover:bg-opacity-90 transition shadow-lg hover:shadow-primary/30 flex items-center gap-2">
                        <i class="ti-home"></i>
                        العودة للرئيسية
                    </a>

                    <a href="{{ route('contact') }}"
                        class="px-8 py-4 bg-white text-secondary border border-gray-200 text-lg font-bold rounded-xl hover:bg-gray-50 transition shadow-sm flex items-center gap-2">
                        <i class="ti-headphone-alt"></i>
                        تواصل معنا
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
