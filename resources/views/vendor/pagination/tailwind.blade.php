@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-center">
        <div class="flex gap-3 items-center sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center px-5 py-2.5 text-sm font-bold text-gray-400 bg-white border border-gray-100 cursor-not-allowed rounded-2xl shadow-sm">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-5 py-2.5 text-sm font-bold text-gray-700 bg-white border border-gray-100 rounded-2xl hover:bg-primary hover:text-white hover:border-primary hover:scale-105 transition-all duration-300 shadow-sm active:scale-95">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-5 py-2.5 text-sm font-bold text-gray-700 bg-white border border-gray-100 rounded-2xl hover:bg-primary hover:text-white hover:border-primary hover:scale-105 transition-all duration-300 shadow-sm active:scale-95">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="inline-flex items-center px-5 py-2.5 text-sm font-bold text-gray-400 bg-white border border-gray-100 cursor-not-allowed rounded-2xl shadow-sm">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        <div class="hidden sm:flex sm:items-center sm:gap-6">
            <div class="flex items-center gap-3">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                        <span class="inline-flex items-center justify-center w-12 h-12 text-gray-300 bg-white border border-gray-100 cursor-not-allowed rounded-2xl shadow-sm" aria-hidden="true">
                            <i class="ti-arrow-right text-lg"></i>
                        </span>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center justify-center w-12 h-12 text-gray-700 bg-white border border-gray-100 rounded-2xl hover:bg-primary hover:text-white hover:border-primary hover:scale-110 transition-all duration-300 shadow-sm hover:shadow-primary/20 active:scale-95" aria-label="{{ __('pagination.previous') }}">
                        <i class="ti-arrow-right text-lg"></i>
                    </a>
                @endif

                {{-- Pagination Elements --}}
                <div class="flex items-center gap-3 px-2">
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="inline-flex items-center justify-center w-12 h-12 text-gray-400 font-bold tracking-widest">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="inline-flex items-center justify-center w-12 h-12 text-white font-black bg-primary border border-primary rounded-2xl shadow-xl shadow-primary/30 scale-110 relative z-10">
                                            {{ $page }}
                                        </span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="inline-flex items-center justify-center w-12 h-12 text-gray-600 font-bold bg-white border border-gray-100 rounded-2xl hover:bg-primary/5 hover:text-primary hover:border-primary/20 hover:scale-110 transition-all duration-300 shadow-sm active:scale-95" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </div>

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center justify-center w-12 h-12 text-gray-700 bg-white border border-gray-100 rounded-2xl hover:bg-primary hover:text-white hover:border-primary hover:scale-110 transition-all duration-300 shadow-sm hover:shadow-primary/20 active:scale-95" aria-label="{{ __('pagination.next') }}">
                        <i class="ti-arrow-left text-lg"></i>
                    </a>
                @else
                    <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                        <span class="inline-flex items-center justify-center w-12 h-12 text-gray-300 bg-white border border-gray-100 cursor-not-allowed rounded-2xl shadow-sm" aria-hidden="true">
                            <i class="ti-arrow-left text-lg"></i>
                        </span>
                    </span>
                @endif
            </div>
        </div>
    </nav>
@endif
