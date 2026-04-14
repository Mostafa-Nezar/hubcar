<div>
    <!-- Filters Toolbar -->
    <div class="bg-white p-6 md:p-8 rounded-3xl shadow-xl border border-gray-100 mb-12 relative z-30">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            <!-- Search -->
            <div class="lg:col-span-1">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">البحث</label>
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="ابحث عن سيارة..."
                        class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary text-sm">
                    <div wire:loading wire:target="search" class="absolute left-3 top-3">
                        <div class="animate-spin h-4 w-4 border-2 border-primary border-t-transparent rounded-full">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Brand -->
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">الماركة</label>
                <select wire:model.live="brand_id"
                    class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary text-sm appearance-none">
                    <option value="">جميع الماركات</option>
                    @foreach ($brands_list as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Type -->
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">النوع</label>
                <select wire:model.live="type" @if(empty($brand_id)) disabled @endif
                    class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary text-sm appearance-none disabled:opacity-50 disabled:cursor-not-allowed">
                    <option value="">{{ !empty($brand_id) ? 'جميع الأنواع' : 'اختر الماركة أولاً' }}</option>
                    @foreach ($types_list as $t)
                        <option value="{{ $t }}">{{ $t }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Category -->
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">الفئة</label>
                <select wire:model.live="category" @if(empty($type)) disabled @endif
                    class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary text-sm appearance-none disabled:opacity-50 disabled:cursor-not-allowed">
                    <option value="">{{ !empty($type) ? 'جميع الفئات' : 'اختر النوع أولاً' }}</option>
                    @foreach ($categories_list as $c)
                        <option value="{{ $c }}">{{ $c }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Year -->
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">الموديل</label>
                <select wire:model.live="year" @if(empty($category)) disabled @endif
                    class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary text-sm appearance-none disabled:opacity-50 disabled:cursor-not-allowed">
                    <option value="">{{ !empty($category) ? 'جميع السنوات' : 'اختر الفئة أولاً' }}</option>
                    @foreach ($years_list as $y)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Reset & Sort Footer -->
        <div class="mt-6 pt-6 border-t border-gray-100 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-6">
                <span class="text-sm text-gray-500 font-medium">نتائج البحث: <span
                        class="text-secondary font-bold">{{ $cars->total() }} سيارة</span></span>
                @if ($brand_id || $type || $category || $year || $search)
                    <button wire:click="resetFilters()"
                        class="text-xs text-red-500 hover:text-red-700 font-bold transition flex items-center gap-1">
                        <i class="ti-trash"></i>
                        مسح الفلاتر
                    </button>
                @endif
            </div>

            <div class="flex items-center gap-6">
                <!-- Sorting -->
                <div class="flex items-center gap-3">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">ترتيب حسب:</label>
                    <select wire:model.live="sort"
                        class="bg-white border text-xs rounded-lg px-3 py-1.5 focus:ring-1 focus:ring-primary">
                        <option value="newest">الأحدث (إضافة)</option>
                        <option value="price_low">السعر: من الأقل</option>
                        <option value="price_high">السعر: من الأعلى</option>
                        <option value="year_newest">الموديل: الأحدث</option>
                        <option value="year_oldest">الموديل: الأقدم</option>
                    </select>
                </div>

                <!-- View Switcher -->
                <div class="flex bg-gray-100 p-1 rounded-xl">
                    <button wire:click="$set('viewMode', 'grid')"
                        class="w-10 h-10 flex items-center justify-center rounded-lg transition-all {{ $viewMode === 'grid' ? 'bg-white shadow-sm text-primary' : 'text-gray-400 hover:text-primary' }}">
                        <i class="ti-layout-grid2"></i>
                    </button>
                    <button wire:click="$set('viewMode', 'list')"
                        class="w-10 h-10 flex items-center justify-center rounded-lg transition-all {{ $viewMode === 'list' ? 'bg-white shadow-sm text-primary' : 'text-gray-400 hover:text-primary' }}">
                        <i class="ti-view-list"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Grid/List View -->
    <div class="relative min-h-[400px]">
        <!-- Loading Overlay -->
        <div wire:loading.flex
            class="absolute inset-0 bg-white/40 backdrop-blur-[1px] z-50 items-center justify-center rounded-3xl transition-opacity">
            <div class="flex flex-col items-center gap-4">
                <div class="w-12 h-12 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
                <span class="text-primary font-bold animate-pulse text-sm">جاري التحديث...</span>
            </div>
        </div>

        @if ($cars->count() > 0)
            <div
                class="{{ $viewMode === 'grid' ? 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8' : 'flex flex-col gap-6' }}">
                @foreach ($cars as $car)
                    <div wire:key="car-{{ $car->id }}-{{ $viewMode }}" class="animate-fadeIn">
                        <x-car-card :car="$car" :viewMode="$viewMode" />
                    </div>
                @endforeach
            </div>

            <!-- Custom Pagination -->
            <div class="mt-16 flex justify-center">
                {{ $cars->links('vendor.pagination.tailwind') }}
            </div>
        @else
            <!-- Empty State -->
            <div class="py-20 text-center bg-gray-50 rounded-[3rem] border-2 border-dashed border-gray-200">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="ti-search text-4xl text-gray-300"></i>
                </div>
                <h3 class="text-2xl font-bold text-secondary mb-2">عذراً، لا توجد نتائج</h3>
                <p class="text-gray-500 max-w-xs mx-auto mb-8">لم نجد أي سيارة تطابق معايير البحث الحالية. جرب تغيير
                    الفلاتر.</p>
                <button wire:click="resetFilters()"
                    class="bg-primary text-white px-8 py-3 rounded-xl font-bold hover:shadow-lg transition">إعادة ضبط
                    البحث</button>
            </div>
        @endif
    </div>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.4s ease-out forwards;
        }
    </style>
</div>
