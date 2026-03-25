<footer class="bg-secondary text-gray-400 py-16 mt-20">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
            <!-- About Section -->
            <div>
                <h4 class="text-white text-xl font-bold mb-6 italic">{{ $settings?->site_name ?? 'RENAX' }}</h4>
                <p class="mb-6 leading-relaxed">
                    {{ $settings?->footer_description ?? 'نحن معرض سيارات رائد في المملكة العربية السعودية، نقدم أفضل السيارات الجديدة والمستعملة بأفضل الأسعار وأعلى معايير الجودة.' }}
                </p>
                <div class="flex gap-4">
                    @if ($settings?->facebook)
                        <a href="{{ $settings->facebook }}" target="_blank"
                            class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:text-primary transition">
                            <i class="fa-brands fa-facebook"></i>
                        </a>
                    @endif

                    @if ($settings?->instagram)
                        <a href="{{ $settings->instagram }}" target="_blank"
                            class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:text-primary transition">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                    @endif

                    @if ($settings?->whatsapp)
                        <a href="https://wa.me/{{ $settings->whatsapp }}" target="_blank"
                            class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:text-primary transition">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                    @endif

                    @if ($settings?->twitter)
                        <a href="{{ $settings->twitter }}" target="_blank"
                            class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:text-primary transition">
                            <i class="fa-brands fa-twitter"></i>
                        </a>
                    @endif

                    @if ($settings?->snapchat)
                        <a href="{{ $settings->snapchat }}" target="_blank"
                            class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:text-primary transition">
                            <i class="fa-brands fa-snapchat"></i>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-white text-lg font-bold mb-6">روابط سريعة</h4>
                <ul class="space-y-4">
                    <li><a href="{{ route('about') }}" class="hover:text-primary transition">من نحن</a></li>
                    <li><a href="{{ route('cars.index') }}" class="hover:text-primary transition">سياراتنا</a></li>
                    <li><a href="{{ route('banks') }}" class="hover:text-primary transition">جهات التمويل</a></li>
                    <li><a href="{{ route('faq') }}" class="hover:text-primary transition">الأسئلة الشائعة</a></li>
                </ul>
            </div>

            <!-- More Links -->
            <div>
                <h4 class="text-white text-lg font-bold mb-6">روابط قانونية</h4>
                <ul class="space-y-4">
                    <li><a href="{{ route('terms') }}" class="hover:text-primary transition">الشروط والأحكام</a></li>
                    <li><a href="{{ route('privacy') }}" class="hover:text-primary transition">سياسة الخصوصية</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-primary transition">تواصل معنا</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div>
                <h4 class="text-white text-lg font-bold mb-6">النشرة الإخبارية</h4>
                <p class="mb-6">اشترك معنا ليصلك أحدث العروض والسيارات.</p>
                <form class="flex">
                    <input type="email" placeholder="البريد الإلكتروني"
                        class="bg-gray-800 text-white px-4 py-2 rounded-r-lg w-full focus:outline-none focus:ring-1 focus:ring-primary border-none">
                    <button class="bg-primary text-white px-4 py-2 rounded-l-lg hover:bg-opacity-90 transition">
                        <i class="ti-arrow-left"></i>
                    </button>
                </form>
            </div>
        </div>

        <div
            class="border-t border-gray-800 mt-16 pt-8 flex flex-col md:flex-row items-center justify-between gap-6 text-sm">
            <p>&copy; {{ date('Y') }} جميع الحقوق محفوظة لـ {{ $settings?->site_name ?? 'RENAX' }}</p>
            <div class="flex items-center gap-4 group">
                <span class="text-gray-500">تصميم وتطوير بواسطة:</span>
                <a href="https://highsolve.com/" target="_blank" rel="noopener noreferrer"
                    class="transition-opacity hover:opacity-100">
                    <img src="{{ asset('img/developer-logo.png') }}" alt="High Solve Logo" loading="lazy"
                        decoding="async" class="h-8 md:h-10 w-auto transition-all">
                </a>
            </div>
        </div>
    </div>
</footer>