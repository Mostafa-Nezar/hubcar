@extends('layouts.app')

@section('title', 'الأسئلة الشائعة')

@section('content')
    <section class="bg-secondary py-20 text-center">
        <h1 class="text-4xl lg:text-5xl font-bold text-white mb-4">الأسئلة الشائعة</h1>
        <p class="text-gray-400 italic">كل ما تحتاجه من معلومات في مكان واحد</p>
    </section>

    <section class="py-24 bg-white">
        <div class="container mx-auto px-4 lg:px-8 max-w-4xl">
            <div class="space-y-6">
                @foreach ($faqs as $faq)
                    <div class="border border-gray-100 rounded-3xl p-8 hover:bg-gray-50 transition italic shadow-sm">
                        <h3 class="text-xl font-bold text-secondary mb-4 flex items-center">
                            <span
                                class="w-8 h-8 bg-primary bg-opacity-10 text-primary rounded-full flex items-center justify-center ml-3 text-sm">?</span>
                            {{ $faq->question }}
                        </h3>
                        <p class="text-gray-500 leading-relaxed pr-11 font-medium">{{ $faq->answer }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
