<div class="{{ $style === 'large' ? '' : 'absolute top-4 z-30' }}" style="{{ $style === 'large' ? '' : 'left: 1rem !important; right: auto !important;' }}">
    @if($style === 'large')
        <button wire:click="toggleFavorite"
            class="flex items-center justify-center gap-2 px-6 py-3 rounded-xl border-2 {{ $isFavorite ? 'bg-red-50 border-red-200 text-red-500' : 'bg-white border-gray-100 text-gray-400 hover:border-red-200 hover:text-red-500' }} transition-all duration-300 font-bold group">
            <i
                class="{{ $isFavorite ? 'ti-heart' : 'ti-heart' }} {{ $isFavorite ? 'text-red-500 fill-current' : 'group-hover:scale-110' }} transition-transform"></i>
            <span>{{ $isFavorite ? 'في المفضلة' : 'إضافة للمفضلة' }}</span>
        </button>
    @else
        <button wire:click="toggleFavorite"
            class="w-10 h-10 flex items-center justify-center rounded-xl backdrop-blur-md transition-all duration-500 group {{ $isFavorite ? 'bg-red-500 text-white shadow-lg shadow-red-500/30' : 'bg-white/90 text-gray-400 hover:bg-white hover:text-red-500' }}">
            <i
                class="ti-heart {{ $isFavorite ? 'scale-110' : 'group-hover:scale-125' }} transition-transform duration-300"></i>
        </button>
    @endif
</div>