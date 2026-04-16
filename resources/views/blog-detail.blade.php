@extends('layouts.app')

@section('title', $post->meta_title ?? $post->title)
@section('meta_description', $post->meta_description ?? Str::limit(strip_tags($post->content), 160))
@section('meta_keywords', $post->meta_keywords)

@section('content')
    <!-- Post Header -->
    <section class="bg-secondary py-12 lg:py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <img src="{{ $post->image ? asset('storage/' . $post->image) : asset('img/slider/1.jpg') }}" alt="" class="w-full h-full object-cover">
        </div>
        <div class="container mx-auto px-4 lg:px-8 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <nav class="flex flex-wrap justify-center text-gray-400 text-sm mb-6">
                    <a href="{{ route('home') }}" class="hover:text-primary transition">{{ __('الرئيسية') }}</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('blog.index') }}" class="hover:text-primary transition">{{ __('المدونة') }}</a>
                    <span class="mx-2">/</span>
                    <span class="text-primary line-clamp-1 italic">{{ $post->title }}</span>
                </nav>
                <h1 class="text-2xl sm:text-3xl lg:text-5xl font-extrabold text-white mb-6 leading-tight">
                    {{ $post->title }}
                </h1>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-6 text-gray-300">
                    <div class="flex items-center gap-2">
                        <i class="ti-calendar text-primary"></i>
                        <span>{{ $post->published_at?->format('Y/m/d') ?? $post->created_at->format('Y/m/d') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="ti-user text-primary"></i>
                        <span>{{ $post->user?->name ?? __('هب كار') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Post Content -->
    <section class="py-12 lg:py-20 bg-white">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <!-- Featured Image -->
                <div class="rounded-3xl overflow-hidden shadow-2xl -mt-16 sm:-mt-24 lg:-mt-32 mb-12 border-4 sm:border-8 border-white">
                    <img src="{{ $post->image ? asset('storage/' . $post->image) : asset('img/blog-default.jpg') }}" 
                         alt="{{ $post->title }}" 
                         class="w-full h-auto">
                </div>

                <!-- Article Body -->
                <article class="prose prose-sm sm:prose-base md:prose-lg prose-primary max-w-none text-gray-700 leading-relaxed" 
                         style="font-family: '{{ $post->content_font_family ?? 'Cairo' }}', sans-serif; font-size: {{ $post->content_font_size ?? '1.125rem' }};">
                    {!! nl2br($post->content) !!}
                </article>

                <!-- Share Section -->
                <div class="mt-16 pt-8 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-start">
                    <h4 class="font-bold text-gray-900">{{ __('مشاركة المقال:') }}</h4>
                    <div class="flex items-center gap-4">
                        <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $post->title }}" target="_blank" class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center text-gray-500 hover:bg-black hover:text-white transition-all">
                            <i class="ti-twitter-alt text-xl"></i>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center text-gray-500 hover:bg-blue-600 hover:text-white transition-all">
                            <i class="ti-facebook text-xl"></i>
                        </a>
                        <a href="https://wa.me/?text={{ $post->title }}%20{{ url()->current() }}" target="_blank" class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center text-gray-500 hover:bg-green-500 hover:text-white transition-all">
                            <i class="fa-brands fa-whatsapp text-xl"></i>
                        </a>
                    </div>
                </div>

                <!-- Related Posts -->
                @if($relatedPosts->count() > 0)
                    <div class="mt-16 lg:mt-24">
                        <h3 class="text-xl sm:text-2xl font-black text-gray-900 mb-8 sm:mb-10 text-center">
                            {{ __('مقالات قد تهمك') }}
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 sm:gap-8">
                            @foreach($relatedPosts as $related)
                                <a href="{{ route('blog.show', $related->slug) }}" class="group">
                                    <div class="relative aspect-video rounded-2xl overflow-hidden mb-4">
                                        <img src="{{ $related->image ? asset('storage/' . $related->image) : asset('img/blog-default.jpg') }}" 
                                             alt="{{ $related->title }}" 
                                             class="w-full h-full object-cover transition-transform group-hover:scale-110">
                                    </div>
                                    <h5 class="font-bold text-gray-900 group-hover:text-primary transition-colors line-clamp-2 text-sm sm:text-base">
                                        {{ $related->title }}
                                    </h5>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection