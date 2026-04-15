@extends('layouts.app')

@section('title', 'العروض الحصرية والقوية - ' . config('app.name'))

@section('description', 'استكشف أقوى العروض والخصومات الحصرية على مجموعة واسعة من السيارات. عروض لفترة محدودة بأسعار تنافسية.')

@section('content')
    <!-- Hero Section -->
    <section class="relative py-20 bg-secondary overflow-hidden">
        <div class="absolute inset-0 bg-[url('/img/bg-pattern.png')] bg-repeat opacity-5"></div>
        <div class="container mx-auto px-4 lg:px-8 relative z-10">
            <div class="max-w-3xl">
                <span class="inline-block bg-primary/20 text-primary px-4 py-1 rounded-full text-xs font-black uppercase tracking-widest mb-6">Limited Time Deals</span>
                <h1 class="text-4xl md:text-6xl font-black text-white mb-6 leading-tight">عروض <span class="text-primary italic">حصرية</span> لا تفوتك! 🔥</h1>
                <p class="text-gray-400 text-lg md:text-xl leading-relaxed mb-8">نقدم لك في هب كار أفضل الصفقات على الإطلاق. سيارات فارهة، دفع رباعي، وسيارات عائلية بأسعار استثنائية وعروض تمويلية ميسرة.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="#offers-list" class="bg-primary text-white px-8 py-4 rounded-2xl font-black hover:bg-opacity-90 transition shadow-xl shadow-primary/20">استكشف العروض الآن</a>
                    <a href="{{ route('contact') }}" class="bg-white/5 border border-white/10 text-white px-8 py-4 rounded-2xl font-black hover:bg-white/10 transition">طلب تواصل خاص</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Offers Grid -->
    <section id="offers-list" class="py-12 md:py-24 bg-gray-50">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex items-center justify-between mb-12">
                <div>
                    <h2 class="text-3xl font-black text-secondary">أحدث عروضنا</h2>
                    <p class="text-gray-500 italic mt-2">نحدث هذه القائمة باستمرار لضمان حصولك على الأفضل</p>
                </div>
                <div class="flex items-center gap-2 text-primary font-bold">
                    <span class="w-8 h-[2px] bg-primary"></span>
                    <span>{{ $cars->total() }} عرض متاح</span>
                </div>
            </div>

            @if($cars->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($cars as $car)
                        <x-car-card :car="$car" />
                    @endforeach
                </div>

                <div class="mt-16">
                    {{ $cars->links('vendor.pagination.tailwind') }}
                </div>
            @else
                <div class="bg-white rounded-[3rem] p-12 md:p-20 text-center shadow-sm border border-gray-100">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-8 text-gray-300">
                        <i class="ti-gift text-5xl"></i>
                    </div>
                    <h2 class="text-2xl font-black text-secondary mb-4">لا توجد عروض حالياً</h2>
                    <p class="text-gray-500 max-w-sm mx-auto mb-10 leading-relaxed">ترقبونا قريباً! نحن نجهز قائمة من العروض القوية التي ستنال إعجابكم بالتأكيد.</p>
                    <a href="{{ route('cars.index') }}"
                        class="inline-flex items-center gap-3 bg-secondary text-white font-black px-8 py-4 rounded-2xl hover:bg-gray-800 transition shadow-xl shadow-secondary/20">
                         تصفح السيارات المتاحة
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Why Us Section -->
    <section class="py-20 bg-white border-t border-gray-50">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="flex gap-6">
                    <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center text-2xl text-primary shrink-0">
                        <i class="ti-check-box"></i>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-secondary mb-2">فحص دقيق</h4>
                        <p class="text-gray-500 text-sm leading-relaxed">جميع سيارات العروض تخضع لفحص شامل لضمان أعلى مستويات الجودة والأمان.</p>
                    </div>
                </div>
                <div class="flex gap-6">
                    <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center text-2xl text-primary shrink-0">
                        <i class="ti-money"></i>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-secondary mb-2">أفضل سعر</h4>
                        <p class="text-gray-500 text-sm leading-relaxed">نضمن لك الحصول على أفضل سعر في السوق مع عروضنا الحصرية وخصوماتنا الحقيقية.</p>
                    </div>
                </div>
                <div class="flex gap-6">
                    <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center text-2xl text-primary shrink-0">
                        <i class="ti-headphone-alt"></i>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-secondary mb-2">دعم مستمر</h4>
                        <p class="text-gray-500 text-sm leading-relaxed">فريقنا متواجد دائماً لمساعدتك في إنهاء إجراءات الشراء والتمويل بكل سهولة.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
