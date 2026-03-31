@if($banner)
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <div         @if($banner->link)
            <a href="{{ $banner->link }}" class="relative rounded-2xl overflow-hidden block">
        @else
            <div class="relative rounded-2xl overflow-hidden block">
        @endif
            @php
                $imageUrl = str_starts_with($banner->image, 'http')
                    ? $banner->image
                    : Storage::url($banner->image);
            @endphp
            <picture>
                <source media="(max-width: 767px)" srcset="{{ $imageUrl }}">
                <img src="{{ $imageUrl }}" alt="{{ $banner->title ?? '' }}" class="w-full h-auto block" style="display: block; width: 100%; height: auto;">
            </picture>
        @if($banner->link)
            </a>
        @else
             </div>
        @endif

    </div>
</section>
@endif