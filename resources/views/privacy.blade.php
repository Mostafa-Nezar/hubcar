@extends('layouts.app')

@section('title', __('سياسة الخصوصية'))

@section('content')
    <section class="bg-secondary py-20 text-center">
        <h1 class="text-4xl lg:text-5xl font-bold text-white mb-4">{{ __('سياسة الخصوصية') }}</h1>
    </section>

    <section class="py-24 bg-white italic font-medium leading-loose text-gray-500">
        <div class="container mx-auto px-4 lg:px-8 max-w-4xl">
            @foreach ($privacies as $privacy)
                <h3 class="text-xl font-bold text-secondary mb-4 italic">{{ $privacy->title }}</h3>
                <div class="mb-12 whitespace-pre-line">
                    {{ $privacy->content }}
                </div>
            @endforeach
        </div>
    </section>
@endsection
