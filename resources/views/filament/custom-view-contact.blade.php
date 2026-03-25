<x-filament-panels::page class="space-y-6">

    <!-- Header -->
    <x-filament::section class="!p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">

            <!-- User Info -->
            <div class="flex items-center gap-5">
                <x-filament::avatar size="lg"
                    :src="'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&color=FFFFFF&background=c19b76'" />

                <div class="space-y-1">
                    <h2 class="text-2xl font-bold tracking-tight">
                        {{ $record->name }}
                    </h2>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        بتاريخ: {{ $record->created_at?->translatedFormat('d F Y - h:i A') }}
                    </p>
                </div>
            </div>
        </div>
    </x-filament::section>


    <!-- Contact Info -->
    <x-filament::section class="py-6 space-y-6">
        <x-slot name="heading">
            معلومات الاتصال
        </x-slot>

        <div class="space-y-5">
            <div class="space-y-1">
                <span class="text-sm font-medium text-gray-500">البريد الإلكتروني</span>
                <a href="mailto:{{ $record->email }}"
                    class="block text-lg font-semibold text-primary-600 hover:underline">
                    {{ $record->email ?: 'غير متوفر' }}
                </a>
            </div>

            <div class="space-y-1">
                <span class="text-sm font-medium text-gray-500">رقم الهاتف</span>
                <a href="tel:{{ $record->phone }}" dir="ltr"
                    class="block text-lg font-semibold text-gray-900 dark:text-gray-100 hover:underline">
                    {{ $record->phone ?? 'غير متوفر' }}
                </a>
            </div>
        </div>
    </x-filament::section>

    <!-- Message Details -->
    <x-filament::section class="!p-6 space-y-6">
        <x-slot name="heading">
            تفاصيل الاستفسار
        </x-slot>

        <div class="space-y-5">
            <div class="space-y-1">
                <span class="text-sm font-medium text-gray-500">الموضوع</span>
                <span class="block text-lg font-semibold text-gray-900 dark:text-gray-100">
                    {{ $record->subject ?? 'تواصل عام' }}
                </span>
            </div>

            <div class="space-y-2">
                <span class="text-sm font-medium text-gray-500">نص الرسالة</span>

                <div class="p-5 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 mt-2">
                    <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap leading-loose">
                        {{ $record->message }}
                    </p>
                </div>
            </div>
        </div>
    </x-filament::section>

</x-filament-panels::page>