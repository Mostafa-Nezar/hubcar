@props(['brands'])

<section class="py-20 bg-white">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="text-center mb-12">
            <h6 class="text-primary font-bold tracking-widest uppercase text-sm mb-2">أفضل الماركات</h6>
            <h2 class="text-4xl font-bold text-secondary">اختر حسب <span class="text-primary">العلامة التجارية</span></h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8 items-center">
            @foreach ($brands as $brand)
                <a href="{{ route('cars.index', ['brand' => $brand->id]) }}"
                    class="grayscale hover:grayscale-0 transition duration-500 flex justify-center p-6 bg-gray-50 rounded-2xl hover:bg-white hover:shadow-lg block">
                    @php
                        $logoUrl = str_starts_with($brand->logo, 'http') ? $brand->logo : Storage::url($brand->logo);
                    @endphp
                    <img src="{{ $logoUrl }}" alt="{{ $brand->name }}" loading="lazy" decoding="async"
                        class="h-12 object-contain filter">
                </a>
            @endforeach
        </div>
    </div>
</section>
