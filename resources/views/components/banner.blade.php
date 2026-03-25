@if($car)
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <a href="{{ route('cars.show', $car->slug) }}" class="relative rounded-2xl overflow-hidden block">
            
            @php
                $imageUrl = str_starts_with($car->main_image, 'http')
                    ? $car->main_image
                    : (str_starts_with($car->main_image, 'img/')
                        ? asset($car->main_image)
                        : Storage::url($car->main_image));
            @endphp

            <picture>
                <source media="(max-width: 767px)" srcset="{{ $imageUrl }}">
                <img src="{{ $imageUrl }}"
                     alt="{{ $car->name ?? '' }}"
                     class="w-full h-auto block"
                     style="display: block; width: 100%; height: auto; max-height: 400px; object-fit: cover;">
            </picture>

        </a>
    </div>
</section>
@endif