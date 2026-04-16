@extends('layouts.app')

@section('title', __('الأسئلة الشائعة'))

@section('content')
    <section class="bg-secondary py-20 text-center">
        <h1 class="text-4xl lg:text-5xl font-bold text-white mb-4">{{ __('الأسئلة الشائعة') }}</h1>
        <p class="text-gray-400 italic">{{ __('كل ما تحتاجه من معلومات في مكان واحد') }}</p>
    </section>

    <section class="py-24 bg-white">
        <div class="container mx-auto px-4 lg:px-8 max-w-4xl">
            <div class="space-y-4" x-data="{ openFaq: null }">
                @foreach ($faqs as $faq)
                    <div class="border border-gray-100 rounded-3xl shadow-sm overflow-hidden">
                        <button class="w-full text-right p-8 hover:bg-gray-50 hover:shadow-md transition-all duration-200 ease-in-out focus:outline-none focus:bg-gray-50 focus:shadow-md"
                                @click="openFaq = openFaq === {{ $faq->id }} ? null : {{ $faq->id }}">
                            <h3 class="text-xl font-bold text-secondary flex items-center justify-between">
                                <span class="w-8 h-8 bg-primary bg-opacity-10 text-primary rounded-full flex items-center justify-center text-sm">?</span>
                                {{ $faq->question }}
                                <svg class="w-5 h-5 text-primary transform transition-all duration-500 ease-in-out"
                                     :class="{ 'rotate-180 scale-110': openFaq === {{ $faq->id }} }"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </h3>
                        </button>
                        <div x-show="openFaq === {{ $faq->id }}" x-collapse x-transition:enter.duration.600ms x-transition:leave.duration.400ms class="px-8">
                            <p class="text-gray-500 leading-relaxed font-medium">{{ $faq->answer }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
