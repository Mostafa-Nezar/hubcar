@extends('layouts.app')

@section('title', 'الصفحة غير موجودة - 404')

@section('content')
    <div class="min-h-[70vh] flex items-center justify-center bg-gray-50 py-20">
        <div class="container mx-auto px-4 text-center">
            <div class="max-w-2xl mx-auto">
                {{-- Icon or Illustration --}}
                <div
                    class="w-32 h-32 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-8 animate-bounce">
                    <span class="text-6xl font-black text-primary">404</span>
                </div>

                {{-- Text Content --}}
                <h1 class="text-4xl md:text-5xl font-black text-secondary mb-6">
                    عذراً، الصفحة غير موجودة
                </h1>

                <p class="text-xl text-gray-500 mb-10 leading-relaxed">
                    يبدو أنك ضللت الطريق. الصفحة التي تبحث عنها قد تكون حذفت، تغير اسمها، أو غير متاحة مؤقتاً.
                </p>

                {{-- Action Buttons --}}
                <div class="flex flex-col md:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('home') }}"
                        class="px-8 py-4 bg-primary text-white text-lg font-bold rounded-xl hover:bg-opacity-90 transition shadow-lg hover:shadow-primary/30 flex items-center gap-2">
                        <i class="ti-home"></i>
                        العودة للرئيسية
                    </a>

                    <a href="{{ route('cars.index') }}"
                        class="px-8 py-4 bg-white text-secondary border border-gray-200 text-lg font-bold rounded-xl hover:bg-gray-50 transition shadow-sm flex items-center gap-2">
                        <i class="ti-car"></i>
                        تصفح السيارات
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
