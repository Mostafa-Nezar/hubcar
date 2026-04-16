@props(['banks'])

<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="text-center mb-16">
            <h6 class="text-primary font-bold tracking-widest uppercase text-sm mb-2">{{ __('شركاؤنا') }}</h6>
            <h2 class="text-4xl font-bold text-secondary">{{ __('جهات تمويل') }} <span class="text-primary">{{ __('معتمدة') }}</span></h2>
            <p class="text-gray-500 mt-4 max-w-2xl mx-auto italic">{{ __('نتعاون مع أفضل المؤسسات المالية لتوفير حلول تمويلية مرنة تناسب احتياجاتكم.') }}</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8 items-center justify-center opacity-70">
            @foreach ($banks as $bank)
                <div class="flex justify-center p-8 bg-white rounded-2xl shadow-sm hover:shadow-md transition">
                    @php
                        $logoUrl = blank($bank->logo)
                            ? null
                            : (str_starts_with($bank->logo, 'http')
                                ? $bank->logo
                                : Storage::url($bank->logo));
                    @endphp
                    @if ($logoUrl)
                        <img src="{{ $logoUrl }}" alt="{{ $bank->name }}" loading="lazy" decoding="async"
                        class="h-10 object-contain">
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>