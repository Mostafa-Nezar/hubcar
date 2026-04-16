@extends('layouts.app')

@section('title', __('الشروط والأحكام'))

@section('content')
    <section class="bg-secondary py-20 text-center">
        <h1 class="text-4xl lg:text-5xl font-bold text-white mb-4">{{ __('الشروط والأحكام') }}</h1>
    </section>

    <section class="py-24 bg-white italic">
        <div class="container mx-auto px-4 lg:px-8 max-w-4xl font-medium leading-loose text-gray-500">
            @foreach ($terms as $term)
                <h3 class="text-xl font-bold text-secondary mb-4 italic">{{ $loop->iteration }}. {{ $term->title }}</h3>
                <div class="mb-12 whitespace-pre-line">
                    {{ $term->content }}
                </div>
            @endforeach
        </div>
    </section>
@endsection
