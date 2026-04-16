@props(['cars'])

<section class="py-20 bg-white">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h6 class="text-primary font-bold tracking-widest uppercase text-sm mb-2">{{ __('قد يعجبك أيضاً') }}</h6>
                <h2 class="text-4xl font-bold text-secondary">{{ __('سيارات') }} <span class="text-primary">{{ __('مشابهة') }}</span></h2>
            </div>
            <a href="{{ route('cars.index') }}"
                class="text-secondary font-bold hover:text-primary transition underline decoration-primary decoration-2 underline-offset-8">{{ __('شاهد الكل') }}</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($cars as $car)
                <x-car-card :car="$car" />
            @endforeach
        </div>
    </div>
</section>
