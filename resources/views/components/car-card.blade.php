@props(['car', 'viewMode' => 'grid'])

@if ($viewMode === 'grid')
    <div
        class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group border border-gray-100 relative">
        <!-- Overlay Link for entire card -->
        <a href="{{ route('cars.show', array_merge(['car' => $car->slug], request()->query())) }}" class="absolute inset-0 z-10" aria-label="عرض التفاصيل"></a>

        <div class="relative overflow-hidden aspect-[16/10]">
            @php
                $cardImageUrl = str_starts_with($car->main_image, 'http')
                    ? $car->main_image
                    : (str_starts_with($car->main_image, 'img/')
                        ? asset($car->main_image)
                        : Storage::url($car->main_image));
            @endphp
            <img src="{{ $cardImageUrl }}" alt="{{ $car->name }}" loading="lazy" decoding="async"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            <div class="absolute top-4 right-4 bg-primary text-white text-xs font-bold px-3 py-1 rounded-full z-20">
                {{ $car->category }}
            </div>
        </div>

        <div class="p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-xl font-bold text-secondary mb-1">
                        <span class="group-hover:text-primary transition">{{ $car->name }}</span>
                    </h3>
                    <p class="text-sm text-gray-500 italic">{{ optional($car->brand)->name }} • {{ $car->type }}</p>
                </div>
                <div class="text-left flex flex-col items-end">
                    @if ($car->discount_price)
                        <span
                            class="text-xs text-gray-400 line-through mb-[-5px]">{{ number_format($car->price) }}</span>
                        <span class="text-xl font-bold text-primary">
                            {{ number_format($car->discount_price) }}
                            <span class="icon-saudi_riyal text-gray-400 text-xl"></span>
                        </span>
                    @else
                        <span class="text-xl font-bold text-primary">
                            {{ number_format($car->price) }}
                            <span class="icon-saudi_riyal text-gray-400 text-xl"></span>
                        </span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 py-4 border-t border-b border-gray-50 mb-6 relative z-20">
                <div class="text-center">
                    <i class="ti-user text-primary mb-1 block"></i>
                    <span class="text-xs text-gray-500 font-bold">{{ $car->seats }} مقاعد</span>
                </div>
                <div class="text-center">
                    <i class="ti-settings text-primary mb-1 block"></i>
                    <span
                        class="text-xs text-gray-500 font-bold">{{ $car->transmission == 'automatic' ? 'أتوماتيك' : 'يدوي' }}</span>
                </div>
                <div class="text-center">
                    <i class="ti-calendar text-primary mb-1 block"></i>
                    <span class="text-xs text-gray-500 font-bold">{{ $car->model_year }}</span>
                </div>
            </div>

            <div class="flex space-x-reverse gap-3 space-x-3 relative z-20">
                <a href="{{ route('cars.show', array_merge(['car' => $car->slug], request()->query())) }}"
                    class="flex-1 bg-gray-100 text-secondary text-center py-2.5 rounded-xl font-bold hover:bg-gray-200 transition text-sm">
                    التفاصيل
                </a>
                <a href="{{ route('cars.booking', $car->slug) }}"
                    class="flex-1 bg-primary text-white text-center py-2.5 rounded-xl font-bold hover:bg-opacity-90 transition text-sm">
                    احجز الآن
                </a>
            </div>
        </div>
    </div>
@else
    <!-- List View Card -->
    <div
        class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group border border-gray-100 relative flex flex-col md:flex-row items-center gap-6 p-4">
        <!-- Overlay Link for entire card -->
        <a href="{{ route('cars.show', array_merge(['car' => $car->slug], request()->query())) }}" class="absolute inset-0 z-10" aria-label="عرض التفاصيل"></a>

        <div class="relative overflow-hidden w-full md:w-1/3 aspect-[16/10] rounded-xl flex-shrink-0">
            @php
                $cardImageUrl = str_starts_with($car->main_image, 'http')
                    ? $car->main_image
                    : (str_starts_with($car->main_image, 'img/')
                        ? asset($car->main_image)
                        : Storage::url($car->main_image));
            @endphp
            <img src="{{ $cardImageUrl }}" alt="{{ $car->name }}" loading="lazy" decoding="async"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            <div
                class="absolute top-2 right-2 bg-primary text-white text-[10px] font-bold px-2 py-0.5 rounded-full z-20">
                {{ $car->category }}
            </div>
        </div>

        <div class="flex-grow w-full">
            <div class="flex flex-col md:flex-row justify-between mb-4 gap-4">
                <div>
                    <h3 class="text-2xl font-black text-secondary group-hover:text-primary transition mb-1">
                        {{ $car->name }}</h3>
                    <p class="text-sm text-gray-500">{{ optional($car->brand)->name }} • {{ $car->type }}</p>
                </div>
                <div class="flex flex-col md:items-end">
                    @if ($car->discount_price)
                        <span
                            class="text-sm text-gray-400 line-through mb-[-5px]">{{ number_format($car->price) }}</span>
                        <span class="text-3xl font-black text-primary">
                            {{ number_format($car->discount_price) }}
                            <span class="icon-saudi_riyal text-2xl"></span>
                        </span>
                    @else
                        <span class="text-3xl font-black text-primary">
                            {{ number_format($car->price) }}
                            <span class="icon-saudi_riyal text-2xl"></span>
                        </span>
                    @endif
                    <span class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">السعر النقدي</span>
                </div>
            </div>

            <div class="flex flex-wrap gap-6 mb-6 relative z-20">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                        <i class="ti-user text-xs"></i>
                    </div>
                    <span class="text-xs font-bold text-gray-600">{{ $car->seats }} مقاعد</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                        <i class="ti-settings text-xs"></i>
                    </div>
                    <span
                        class="text-xs font-bold text-gray-600">{{ $car->transmission == 'automatic' ? 'أتوماتيك' : 'يدوي' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                        <i class="ti-calendar text-xs"></i>
                    </div>
                    <span class="text-xs font-bold text-gray-600">موديل {{ $car->model_year }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                        <i class="ti-shine text-xs"></i>
                    </div>
                    <span class="text-xs font-bold text-gray-600">{{ $car->fuel_type ?? 'بنزين' }}</span>
                </div>
            </div>

            <div class="flex gap-4 relative z-20">
                <a href="{{ route('cars.show', array_merge(['car' => $car->slug], request()->query())) }}"
                    class="flex-1 md:flex-none md:px-8 bg-gray-100 text-secondary text-center py-3 rounded-xl font-bold hover:bg-gray-200 transition text-sm">
                    التفاصيل
                </a>
                <a href="{{ route('cars.booking', $car->slug) }}"
                    class="flex-1 md:flex-none md:px-8 bg-primary text-white text-center py-3 rounded-xl font-bold hover:bg-opacity-90 transition text-sm">
                    احجز الآن
                </a>
            </div>
        </div>
    </div>
@endif
