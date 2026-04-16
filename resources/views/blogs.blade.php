@extends('layouts.app')

@section('title', __('مدونة هب كار'))
@section('meta_description', __('تابع آخر أخبار سوق السيارات، نصائح الصيانة، وأحدث الموديلات في مدونة هب كار.'))

@section('content')
    <!-- Page Header -->
    <section class="bg-secondary py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <img src="{{ asset('img/slider/1.jpg') }}" alt="" loading="lazy" decoding="async" class="w-full h-full object-cover">
        </div>
        <div class="container mx-auto px-4 lg:px-8 relative z-10 text-center">
            <h1 class="text-4xl lg:text-5xl font-bold text-white mb-4">{{ __('المدونة') }}</h1>
            <nav class="flex justify-center text-gray-400 text-sm">
                <a href="{{ route('home') }}" class="hover:text-primary transition">{{ __('الرئيسية') }}</a>
                <span class="mx-2">/</span>
                <span class="text-primary">{{ __('أخبار ونصائح السيارات') }}</span>
            </nav>
        </div>
    </section>

    <!-- Blog Posts Grid -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($posts as $post)
                    <article class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 group border border-gray-100 h-full flex flex-col">
                        <!-- Image -->
                        <div class="relative aspect-[16/10] overflow-hidden">
                            <img src="{{ $post->image ? asset('storage/' . $post->image) : asset('img/blog-default.jpg') }}" 
                                 alt="{{ $post->title }}" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute top-4 right-4">
                                <span class="bg-primary text-white text-xs font-bold px-4 py-2 rounded-full shadow-lg">
                                    {{ $post->published_at?->format('Y/m/d') ?? $post->created_at->format('Y/m/d') }}
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-8 flex-1 flex flex-col">
                            <h2 class="text-xl font-bold text-gray-900 mb-4 line-clamp-2 group-hover:text-primary transition-colors duration-300">
                                <a href="{{ route('blog.show', $post->slug) }}">
                                    {{ $post->title }}
                                </a>
                            </h2>
                            <div class="text-gray-500 text-sm mb-6 line-clamp-3 leading-relaxed">
                                {{ Str::limit(strip_tags($post->content), 150) }}
                            </div>
                            
                            <div class="mt-auto pt-6 border-t border-gray-50 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-400">
                                        <i class="ti-user text-xs"></i>
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $post->user?->name ?? __('هب كار') }}</span>
                                </div>
                                <a href="{{ route('blog.show', $post->slug) }}" class="text-primary font-bold text-sm flex items-center gap-2 group/link">
                                    {{ __('اقرأ المزيد') }}
                                    <i class="ti-arrow-left transition-transform group-hover/link:-translate-x-1"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                            <i class="ti-pencil-alt text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-400">{{ __('لا توجد مقالات حالياً') }}</h3>
                        <p class="text-gray-400 mt-2">{{ __('انتظرونا قريباً في مدونة هب كار') }}</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-16">
                {{ $posts->links() }}
            </div>
        </div>
    </section>
@endsection
