@extends('layouts.app')

@section('title', 'مقارنة السيارات')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <style>
        .animate-fadeIn { animation: fadeIn 0.4s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        
        /* تحسين شكل الجدول */
        .comparison-table { border-collapse: separate; border-spacing: 0; }
        .comparison-table th, .comparison-table td { border-bottom: 1px solid #f3f4f6; }
        .comparison-table th:first-child, .comparison-table td:first-child { 
            position: sticky; 
            right: 0; 
            z-index: 20; 
            background: #f9fafb !important;
            width: 250px;
            border-left: 2px solid #eee;
        }
        
        .ts-control { border-radius: 1.25rem !important; padding: 14px 20px !important; border: 2px solid #f3f4f6 !important; font-weight: 700; }
        .ts-control:focus { border-color: #c19b76 !important; box-shadow: 0 0 0 4px rgba(193, 155, 118, 0.1) !important; }
        
        .car-card-header { transition: all 0.3s ease; }
        .car-card-header:hover { transform: translateY(-5px); }
    </style>
@endpush

@section('content')
    <!-- Page Header -->
    <section class="bg-secondary py-16 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <img src="{{ asset('img/slider/2.jpg') }}" alt="" class="w-full h-full object-cover">
        </div>
        <div class="container mx-auto px-4 lg:px-8 relative z-10 text-center">
            <h1 class="text-3xl lg:text-4xl font-black text-white mb-4">أداة المقارنة الذكية</h1>
            <p class="text-gray-400 max-w-2xl mx-auto italic">قارن بين مواصفات وأسعار السيارات المفضلة لديك جنباً إلى جنب.</p>
        </div>
    </section>

    <!-- Comparison Section -->
    <section class="py-12 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 lg:px-8">
            
            <!-- Selection Area -->
            <div class="bg-white p-10 rounded-[2.5rem] shadow-xl border border-gray-100 mb-12 relative z-30">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    @for ($i = 1; $i <= 3; $i++)
                        <div class="relative">
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-primary text-white flex items-center justify-center text-[10px]">{{ $i }}</span>
                                اختيار السيارة
                            </label>
                            <select id="car-select-{{ $i }}" class="car-selector" placeholder="ابحث عن سيارة...">
                                <option value="">اختر سيارة للمقارنة...</option>
                                @foreach($allCars as $car)
                                    <option value="{{ $car->id }}">{{ $car->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Comparison Table Container -->
            <div id="comparisonContainer" class="hidden">
                <div class="overflow-x-auto pb-10">
                    <table class="w-full bg-white rounded-[2.5rem] shadow-2xl overflow-hidden comparison-table table-fixed min-w-[900px]">
                        <thead>
                            <tr class="bg-white">
                                <th class="p-8 text-right align-middle">
                                    <div class="text-primary font-black text-sm uppercase mb-2">مقارنة</div>
                                    <h3 class="text-2xl font-black text-secondary leading-none">المواصفات</h3>
                                </th>
                                <!-- Car Headers will be injected here -->
                                <th id="header-col-1" class="w-1/4 p-8"></th>
                                <th id="header-col-2" class="w-1/4 p-8"></th>
                                <th id="header-col-3" class="w-1/4 p-8"></th>
                            </tr>
                        </thead>
                        <tbody id="comparisonBody">
                            <!-- Rows will be injected here -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="p-8 bg-gray-50/50 border-none"></td>
                                <td id="footer-col-1" class="p-8 text-center border-none"></td>
                                <td id="footer-col-2" class="p-8 text-center border-none"></td>
                                <td id="footer-col-3" class="p-8 text-center border-none"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="py-24 text-center bg-white rounded-[3rem] shadow-sm border border-gray-100">
                <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="ti-layers-alt text-4xl text-gray-200"></i>
                </div>
                <h3 class="text-2xl font-bold text-secondary mb-3">ابدأ المقارنة الآن</h3>
                <p class="text-gray-400 max-w-sm mx-auto">قم باختيار سيارة واحدة على الأقل من القوائم أعلاه لعرض جدول المقارنة الفني والأسعار.</p>
            </div>

            <!-- Loading Spinner -->
            <div id="loadingOverlay" class="hidden fixed inset-0 bg-white/60 backdrop-blur-[2px] z-[100] flex flex-col items-center justify-center">
                <div class="w-16 h-16 border-4 border-primary border-t-transparent rounded-full animate-spin mb-4"></div>
                <p class="text-primary font-black animate-pulse">جاري جلب المواصفات...</p>
            </div>
        </div>
    </section>

    <!-- Column Templates (Hidden) -->
    <template id="carHeaderTemplate">
        <div class="car-card-header text-center animate-fadeIn">
            <div class="mb-6 aspect-[16/10] rounded-2xl overflow-hidden shadow-lg bg-gray-100">
                <img src="CAR_IMAGE" alt="CAR_NAME" class="w-full h-full object-cover">
            </div>
            <h4 class="text-xl font-black text-secondary mb-1">CAR_NAME</h4>
            <div class="text-sm text-gray-400 font-bold mb-4">CAR_BRAND</div>
            <div class="text-2xl font-black text-primary mb-6">CAR_PRICE <span class="text-xs font-bold opacity-70">ريال</span></div>
            <a href="CAR_URL" class="inline-block w-full py-3 bg-secondary text-white rounded-xl text-xs font-black hover:bg-black transition-all">عرض التفاصيل</a>
        </div>
    </template>

    <template id="carFooterTemplate">
        <div class="animate-fadeIn">
            <a href="CAR_BOOKING_URL" class="block w-full py-5 bg-primary text-white rounded-2xl font-black hover:shadow-2xl transition-all shadow-lg shadow-primary/20">احجز هذه السيارة</a>
        </div>
    </template>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selects = [];
            const urlParams = new URLSearchParams(window.location.search);
            const initialCarId = urlParams.get('car_id');

            // Initialize TomSelect for all 3 selectors
            for (let i = 1; i <= 3; i++) {
                const ts = new TomSelect(`#car-select-${i}`, {
                    create: false,
                    onChange: () => updateComparison()
                });
                selects.push(ts);
            }

            // Set initial car from URL if exists
            if (initialCarId) {
                setTimeout(() => {
                    selects[0].setValue(initialCarId);
                    updateComparison(); // Explicitly trigger
                }, 100);
            }

            async function updateComparison() {
                const ids = selects.map(s => s.getValue()).filter(v => v !== '');
                
                const container = document.getElementById('comparisonContainer');
                const emptyState = document.getElementById('emptyState');
                const loading = document.getElementById('loadingOverlay');

                if (ids.length === 0) {
                    container.classList.add('hidden');
                    emptyState.classList.remove('hidden');
                    return;
                }

                emptyState.classList.add('hidden');
                loading.classList.remove('hidden');

                try {
                    // Send as a comma-separated string for simplicity
                    const response = await fetch(`{{ route('api.cars.compare') }}?ids=${ids.join(',')}`);
                    if (!response.ok) throw new Error('Query failed');
                    
                    const cars = await response.json();
                    renderTable(cars);
                    container.classList.remove('hidden');
                } catch (error) {
                    console.error('Comparison Error:', error);
                } finally {
                    loading.classList.add('hidden');
                }
            }

            function renderTable(cars) {
                const headerTpl = document.getElementById('carHeaderTemplate').innerHTML;
                const footerTpl = document.getElementById('carFooterTemplate').innerHTML;
                
                // Clear all columns
                for (let i = 1; i <= 3; i++) {
                    document.getElementById(`header-col-${i}`).innerHTML = '';
                    document.getElementById(`footer-col-${i}`).innerHTML = '';
                }

                // Fill columns
                cars.forEach((car, index) => {
                    const colNum = index + 1;
                    
                    // Header with Global Replacement
                    let headerHtml = headerTpl
                        .replace(/CAR_IMAGE/g, car.image)
                        .replace(/CAR_NAME/g, car.name)
                        .replace(/CAR_BRAND/g, car.brand)
                        .replace(/CAR_PRICE/g, car.discount_price || car.price)
                        .replace(/CAR_URL/g, car.url);

                    document.getElementById(`header-col-${colNum}`).innerHTML = headerHtml;

                    // Footer with Global Replacement
                    let footerHtml = footerTpl
                        .replace(/CAR_BOOKING_URL/g, car.booking_url);
                        
                    document.getElementById(`footer-col-${colNum}`).innerHTML = footerHtml;
                });

                // Fill placeholders for empty columns
                for (let i = cars.length + 1; i <= 3; i++) {
                    document.getElementById(`header-col-${i}`).innerHTML = `
                        <div class="h-full rounded-3xl border-2 border-dashed border-gray-100 flex items-center justify-center opacity-30 p-10">
                            <i class="ti-plus text-3xl"></i>
                        </div>
                    `;
                }

                // Body Rows
                const rows = [
                    { label: 'الموديل', key: 'model_year' },
                    { label: 'سعة المحرك / الوقود', key: 'fuel_type' },
                    { label: 'ناقل الحركة', key: 'transmission' },
                    { label: 'عدد الركاب', key: 'seats' },
                    { label: 'حالة السيارة', key: 'condition' },
                    { label: 'الفئة', key: 'category' },
                    { label: 'أقل قسط شهري', key: 'starting_installment', suffix: ' ريال' }
                ];

                const tbody = document.getElementById('comparisonBody');
                tbody.innerHTML = '';

                rows.forEach(row => {
                    const tr = document.createElement('tr');
                    tr.className = "hover:bg-gray-50/50 transition-colors";
                    
                    let html = `<td class="p-6 font-bold text-gray-400 text-right pr-10">${row.label}</td>`;
                    
                    for (let i = 0; i < 3; i++) {
                        const car = cars[i];
                        const val = car ? (car[row.key] || 'غير متوفر') : '-';
                        html += `<td class="p-6 text-center text-secondary font-black text-lg">${val}${car && row.suffix ? row.suffix : ''}</td>`;
                    }
                    
                    tr.innerHTML = html;
                    tbody.appendChild(tr);
                });

                // Dynamic Specs
                const specKeys = new Set();
                cars.forEach(car => { if(car.specs) Object.keys(car.specs).forEach(k => specKeys.add(k)) });

                if (specKeys.size > 0) {
                    const sep = document.createElement('tr');
                    sep.innerHTML = `<td colspan="4" class="bg-gray-50 p-4 pr-10 text-secondary font-black text-xs uppercase tracking-widest text-right">مواصفات تقنية إضافية</td>`;
                    tbody.appendChild(sep);

                    specKeys.forEach(key => {
                        const tr = document.createElement('tr');
                        tr.className = "hover:bg-gray-50/50 transition-colors";
                        let html = `<td class="p-6 font-bold text-gray-400 text-right pr-10">${key}</td>`;
                        for (let i = 0; i < 3; i++) {
                            const car = cars[i];
                            const val = (car && car.specs && car.specs[key]) ? car.specs[key] : '-';
                            html += `<td class="p-6 text-center text-secondary font-black">${val}</td>`;
                        }
                        tr.innerHTML = html;
                        tbody.appendChild(tr);
                    });
                }
            }
        });
    </script>
    @endpush
@endsection
