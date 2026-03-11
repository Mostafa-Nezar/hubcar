<div class="bg-white p-8 rounded-3xl shadow-2xl -mt-24 relative z-10 border border-gray-100 max-w-5xl mx-auto">
    <form action="{{ route('cars.index') }}" method="GET">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Brand -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">الماركة</label>
                <select name="brand"
                    class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary text-gray-600 appearance-none">
                    <option value="">جميع الماركات</option>
                    <option value="toyota">تويوتا</option>
                    <option value="hyundai">هيونداي</option>
                    <option value="mercedes">مرسيدس</option>
                    <option value="bmw">بي إم دبليو</option>
                </select>
            </div>

            <!-- Type -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">نوع السيارة</label>
                <select name="type"
                    class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary text-gray-600 appearance-none">
                    <option value="">جميع الأنواع</option>
                    <option value="sedan">سيدان</option>
                    <option value="suv">SUV</option>
                    <option value="luxury">فاخرة</option>
                </select>
            </div>

            <!-- Year -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">السنة</label>
                <select name="year"
                    class="w-full bg-gray-50 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary text-gray-600 appearance-none">
                    <option value="">جميع السنوات</option>
                    <option value="2025">2025</option>
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                </select>
            </div>

            <!-- Submit -->
            <div class="flex items-end">
                <button type="submit"
                    class="w-full bg-secondary text-white font-bold py-3 px-6 rounded-xl hover:bg-gray-800 transition shadow-lg flex items-center justify-center">
                    <i class="ti-search ml-2"></i>
                    <span>ابحث عن سيارة</span>
                </button>
            </div>
        </div>
    </form>
</div>
