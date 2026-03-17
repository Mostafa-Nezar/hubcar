@props(['banks'])

<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="text-center mb-16">
            <h6 class="text-primary font-bold tracking-widest uppercase text-sm mb-2">شركاؤنا</h6>
            <h2 class="text-4xl font-bold text-secondary">جهات تمويل <span class="text-primary">معتمدة</span></h2>
            <p class="text-gray-500 mt-4 max-w-2xl mx-auto italic">نتعاون مع أفضل المؤسسات المالية لتوفير حلول تمويلية
                مرنة تناسب احتياجاتكم.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8 items-center justify-center opacity-70">
            @foreach ($banks as $bank)
                <div class="flex justify-center p-8 bg-white rounded-2xl shadow-sm hover:shadow-md transition">
                    <img src="{{ asset($bank->logo) }}" alt="{{ $bank->name }}" loading="lazy" decoding="async"
                        class="h-10 object-contain">
                </div>
            @endforeach
        </div>
    </div>
</section>