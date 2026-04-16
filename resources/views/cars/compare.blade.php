@extends('layouts.app')

@section('title', __('مقارنة السيارات'))

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <style>
        .animate-fadeIn { animation: fadeIn 0.4s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        
        /* Glassmorphism for floating selector */
        .glass-panel {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
        }

        .comparison-table { border-collapse: separate; border-spacing: 0; }
        .comparison-table tr:last-child td:first-child { border-bottom-right-radius: 2rem; }
        .comparison-table tr:last-child td:last-child { border-bottom-left-radius: 2rem; }
        
        /* العمود الأول الثابت أفقياً */
        .sticky-col { 
            position: sticky; 
            right: 0; 
            z-index: 20; 
            background: rgba(249, 250, 251, 0.95) !important;
            backdrop-filter: blur(8px);
            width: 120px;
            border-left: 2px solid #f3f4f6;
            font-size: 0.75rem;
        }

        @media (min-width: 768px) {
            .sticky-col { width: 220px; font-size: 0.9rem; }
        }

        /* الصف الأول الثابت رأسياً */
        .comparison-table thead th {
            position: sticky;
            top: 0;
            z-index: 30;
            background: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .comparison-table thead th:first-child { z-index: 40; }
        
        .ts-control { 
            border-radius: 1.25rem !important; 
            padding: 12px 16px !important; 
            border: 2px solid transparent !important;
            background-color: #f3f4f6 !important;
            transition: all 0.3s ease !important;
            font-weight: 700;
        }

        .ts-control:hover { background-color: #e5e7eb !important; }
        .ts-control:focus { background-color: white !important; border-color: #c19b76 !important; box-shadow: 0 10px 15px -3px rgba(193, 155, 118, 0.1) !important; }
        
        .car-card-header { transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1); min-width: 180px; }
        .car-card-header:hover { transform: translateY(-5px); }

        @media (max-width: 767px) {
            .comparison-table th, .comparison-table td { padding: 0.75rem !important; }
            .sticky-col { font-size: 0.7rem; width: 100px; }
        }

        .overflow-x-auto { scroll-snap-type: x mandatory; }
        .comparison-table td, .comparison-table th:not(:first-child) { scroll-snap-align: center; }

        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
@endpush

@section('content')
    <!-- Page Header -->
    <section class="bg-secondary py-16 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <img src="{{ asset('img/slider/2.jpg') }}" alt="" class="w-full h-full object-cover">
        </div>
        <div class="container mx-auto px-4 lg:px-8 relative z-10 text-center">
            <h1 class="text-3xl lg:text-4xl font-black text-white mb-4">{{ __('أداة المقارنة الذكية') }}</h1>
            <p class="text-gray-400 max-w-2xl mx-auto italic">{{ __('قارن بين مواصفات وأسعار السيارات المفضلة لديك جنباً إلى جنب.') }}</p>
        </div>
    </section>

    <!-- Comparison Section -->
    <section class="py-12 md:py-20 bg-gray-50 min-h-screen relative">
        <div class="container mx-auto px-4 lg:px-8">
            
            <!-- Selection Area - Floating Glass Concept -->
            <div class="glass-panel p-8 md:p-12 rounded-[2.5rem] md:rounded-[3.5rem] mb-12 relative z-50 -mt-24">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-10">
                    @for ($i = 1; $i <= 3; $i++)
                        <div class="relative">
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-primary text-white flex items-center justify-center text-[10px]">{{ $i }}</span>
                                {{ __('اختيار السيارة') }}
                            </label>
                            <select id="car-select-{{ $i }}" class="car-selector" placeholder="{{ __('ابحث عن سيارة...') }}">
                                <option value="">{{ __('اختر سيارة للمقارنة...') }}</option>
                                @foreach($allCars as $car)
                                    <option value="{{ $car->id }}">{{ $car->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endfor
                </div>
                
                <!-- Advanced Controls -->
                <div class="mt-8 pt-8 border-t border-gray-100 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="diffToggle" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                            <span class="mr-3 text-sm font-bold text-gray-500">{{ __('إظهار الاختلافات فقط') }}</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Comparison Table Container -->
            <div id="comparisonContainer" class="hidden">
                <div class="overflow-x-auto pb-10 scrollbar-hide">
                    <table class="w-full bg-white rounded-[2rem] md:rounded-[2.5rem] shadow-2xl overflow-hidden comparison-table table-fixed min-w-[750px] md:min-w-[900px]">
                        <thead>
                            <tr class="bg-white">
                                <th class="p-8 text-right align-middle sticky-col min-w-[120px] md:min-w-[220px]">
                                    <div class="text-primary font-black text-xs md:text-sm uppercase mb-2">{{ __('مقارنة') }}</div>
                                    <h3 class="text-lg md:text-2xl font-black text-secondary leading-none">{{ __('المواصفات') }}</h3>
                                </th>
                                <!-- Car Headers will be injected here -->
                                <th id="header-col-1" class="p-4 md:p-8"></th>
                                <th id="header-col-2" class="p-4 md:p-8"></th>
                                <th id="header-col-3" class="p-4 md:p-8"></th>
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
            <div id="emptyState" class="py-24 md:py-40 text-center bg-white rounded-[3rem] md:rounded-[4rem] shadow-sm border border-gray-100 overflow-hidden relative">
                <div class="absolute inset-0 bg-gradient-to-tr from-primary/5 to-transparent pointer-events-none"></div>
                <div class="relative z-10">
                    <div class="w-32 h-32 bg-primary/5 rounded-full flex items-center justify-center mx-auto mb-10 group">
                        <i class="ti-layers-alt text-5xl text-primary transform group-hover:rotate-12 transition-transform duration-500"></i>
                    </div>
                    <h3 class="text-3xl font-black text-secondary mb-4">{{ __('ابدأ المقارنة الآن') }}</h3>
                    <p class="text-gray-500 max-w-sm mx-auto leading-relaxed">{{ __('قم باختيار سيارة واحدة على الأقل من القوائم أعلاه لعرض جدول المقارنة الفني والأسعار.') }}</p>
                </div>
            </div>

            <!-- Loading Spinner -->
            <div id="loadingOverlay" class="hidden fixed inset-0 bg-white/60 backdrop-blur-[2px] z-[100] flex flex-col items-center justify-center">
                <div class="w-16 h-16 border-4 border-primary border-t-transparent rounded-full animate-spin mb-4"></div>
                <p class="text-primary font-black animate-pulse">{{ __('جاري جلب المواصفات...') }}</p>
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
            <div class="text-2xl font-black text-primary mb-6">CAR_PRICE <span class="text-xs font-bold opacity-70">{{ __('ريال') }}</span></div>
            <a href="CAR_URL" class="inline-block w-full py-3 bg-secondary text-white rounded-xl text-xs font-black hover:bg-black transition-all">{{ __('عرض التفاصيل') }}</a>
        </div>
    </template>

    <template id="carFooterTemplate">
        <div class="animate-fadeIn">
            <a href="CAR_BOOKING_URL" class="block w-full py-5 bg-primary text-white rounded-2xl font-black hover:shadow-2xl transition-all shadow-lg shadow-primary/20">{{ __('احجز هذه السيارة') }}</a>
        </div>
    </template>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const STORAGE_KEY = 'hubcar_compare_ids';
            const selects = [];
            const urlParams = new URLSearchParams(window.location.search);
            const initialCarId = urlParams.get('car_id');
            let isInitializing = true;

            // Load saved IDs from LocalStorage
            let savedIds = JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]');
            
            // Clean up savedIds to ensure they are strings and valid
            savedIds = savedIds.map(id => String(id)).filter(id => id && id !== 'null' && id !== 'undefined');

            // If a car_id is provided in the URL, process it
            if (initialCarId) {
                const idStr = String(initialCarId);
                // Move to beginning if exists, or add to beginning
                const existingIndex = savedIds.indexOf(idStr);
                if (existingIndex !== -1) {
                    savedIds.splice(existingIndex, 1);
                }
                savedIds.unshift(idStr);
                savedIds = savedIds.slice(0, 3);
                localStorage.setItem(STORAGE_KEY, JSON.stringify(savedIds));
                
                // Clean URL without refresh
                window.history.replaceState({}, document.title, window.location.pathname);
            }

            // Initialize TomSelect for all 3 selectors
            for (let i = 1; i <= 3; i++) {
                const ts = new TomSelect(`#car-select-${i}`, {
                    create: false,
                    onChange: () => {
                        if (!isInitializing) updateComparison();
                    }
                });
                selects.push(ts);
            }

            // Populate selectors with saved IDs
            savedIds.forEach((id, index) => {
                if (index < 3 && id) {
                    selects[index].setValue(id);
                }
            });

            isInitializing = false;
            updateComparison();

            async function updateComparison() {
                const ids = selects.map(s => s.getValue()).filter(v => v !== '');
                
                // Save current selection to LocalStorage
                localStorage.setItem(STORAGE_KEY, JSON.stringify(ids));

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

            // Difference Highlighting Logic
            document.getElementById('diffToggle').addEventListener('change', function(e) {
                const showOnlyDiff = e.target.checked;
                const rows = document.querySelectorAll('#comparisonBody tr:not(.separator-row)');
                
                rows.forEach(row => {
                    const cells = Array.from(row.querySelectorAll('td:not(.sticky-col)'));
                    const values = cells.map(c => c.textContent.trim()).filter(v => v !== '-' && v !== '');
                    
                    if (showOnlyDiff && values.length > 1) {
                        const allSame = values.every(v => v === values[0]);
                        if (allSame) {
                            row.classList.add('hidden');
                        } else {
                            row.classList.remove('hidden');
                        }
                    } else {
                        row.classList.remove('hidden');
                    }
                });
            });

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
                        <div class="h-full rounded-2xl md:rounded-3xl border-2 border-dashed border-gray-100 flex items-center justify-center opacity-30 p-4 md:p-10">
                            <i class="ti-plus text-xl md:text-3xl"></i>
                        </div>
                    `;
                }

                // Body Rows
                const rows = [
                    { label: '{{ __('الموديل') }}', key: 'model_year' },
                    { label: '{{ __('سعة المحرك / الوقود') }}', key: 'fuel_type' },
                    { label: '{{ __('ناقل الحركة') }}', key: 'transmission' },
                    { label: '{{ __('عدد الركاب') }}', key: 'seats' },
                    { label: '{{ __('حالة السيارة') }}', key: 'condition' },
                    { label: '{{ __('الفئة') }}', key: 'category' },
                    { label: '{{ __('أقل قسط شهري') }}', key: 'starting_installment', suffix: ' {{ __('ريال') }}' }
                ];

                const tbody = document.getElementById('comparisonBody');
                tbody.innerHTML = '';

                rows.forEach(row => {
                    const tr = document.createElement('tr');
                    tr.className = "hover:bg-gray-50/50 transition-colors";
                    
                    let html = `<td class="p-6 font-bold text-gray-400 text-right pr-6 md:pr-10 sticky-col">${row.label}</td>`;
                    
                    for (let i = 0; i < 3; i++) {
                        const car = cars[i];
                        const val = car ? (car[row.key] || '{{ __('غير متوفر') }}') : '-';
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
                    sep.className = "separator-row";
                    sep.innerHTML = `<td colspan="4" class="bg-gray-50 p-4 pr-6 md:pr-10 text-secondary font-black text-[10px] md:text-xs uppercase tracking-widest text-right sticky-col">{{ __('مواصفات تقنية إضافية') }}</td>`;
                    tbody.appendChild(sep);

                    specKeys.forEach(key => {
                        const tr = document.createElement('tr');
                        tr.className = "hover:bg-gray-50/50 transition-colors";
                        let html = `<td class="p-6 font-bold text-gray-400 text-right pr-6 md:pr-10 sticky-col">${key}</td>`;
                        for (let i = 0; i < 3; i++) {
                            const car = cars[i];
                            const val = (car && car.specs && car.specs[key]) ? car.specs[key] : '-';
                            html += `<td class="p-6 text-center text-secondary font-black">${val}</td>`;
                        }
                        tr.innerHTML = html;
                        tbody.appendChild(tr);
                    });
                }

                // Trigger diff filter if active
                if (document.getElementById('diffToggle').checked) {
                    document.getElementById('diffToggle').dispatchEvent(new Event('change'));
                }
            }
        });
    </script>
    @endpush
@endsection
