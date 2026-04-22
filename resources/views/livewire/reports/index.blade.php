<div class="min-h-screen flex flex-col" dir="rtl">
    <style>
        @media print {
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            @page { size: A4; margin: 15mm; }
            body { background: white !important; color: black !important; padding: 0; margin: 0; }
            .max-w-7xl { max-width: 100% !important; padding: 0 !important; }
            .bg-white { border: 1px solid #eee !important; box-shadow: none !important; }
            .shadow-sm, .shadow-md, .shadow-lg { box-shadow: none !important; }
            .rounded-xl { border-radius: 4px !important; }
            .grid { gap: 1rem !important; }
            /* Force black text for better contrast */
            .text-gray-900, .text-gray-700, .text-gray-600 { color: black !important; }
            /* Keep badge colors but subtle */
            .bg-blue-100, .bg-green-100, .bg-teal-100, .bg-yellow-100, .bg-orange-100, .bg-red-100 {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }
        .print-only { display: none; }
    </style>
    <!-- Page Header with Filters -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <!-- Header Section (Title) -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                <div class="flex-shrink-0">
                    <h2 class="text-2xl font-bold text-gray-900 mb-1">التقارير والإحصائيات</h2>
                    <p class="text-sm text-gray-600">نظرة عامة على أداء الأقسام والمشاريع</p>
                </div>
                <div class="flex items-center gap-2 no-print">
                    <button
                        onclick="window.print()"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2-2v4h10z"></path>
                        </svg>
                        طباعة التقرير
                    </button>
                </div>
            </div>

            <!-- Print-Only Header -->
            <div class="print-only border-b-2 border-gray-900 pb-4 mb-8">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-black text-gray-900">تقرير المشاريع والإحصائيات</h1>
                        <p class="text-sm text-gray-600 mt-1">تاريخ الطباعة: {{ now()->format('Y-m-d H:i') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-bold uppercase text-gray-500">نظام إدارة مشاريع التخرج</p>
                    </div>
                </div>
                <div class="mt-4 flex flex-wrap gap-x-8 gap-y-2 text-sm">
                    <div>
                        <span class="font-bold">السنة:</span>
                        <span>{{ $year ?: 'جميع السنوات' }}</span>
                    </div>
                    <div>
                        <span class="font-bold">الحالة:</span>
                        <span>{{ $is_archiv === '0' ? 'نشطة' : ($is_archiv === '1' ? 'مؤرشفة' : 'الكل') }}</span>
                    </div>
                    <div>
                        <span class="font-bold">القسم:</span>
                        <span>{{ $department_id ? \App\Models\Department::find($department_id)?->name : 'جميع الأقسام' }}</span>
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 no-print">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 items-end">
                    <!-- Year Filter -->
                    <div wire:key="filter-year">
                        <label class="block text-xs font-medium text-gray-700 mb-1">السنة</label>
                        <select
                            wire:model.live="year"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow"
                        >
                            <option value="">جميع السنوات</option>
                            @foreach($years as $y)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div wire:key="filter-status">
                        <label class="block text-xs font-medium text-gray-700 mb-1">حالة المشروع</label>
                        <select
                            wire:model.live="is_archiv"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow"
                        >
                            <option value="">جميع المشاريع</option>
                            <option value="0">المشاريع النشطة</option>
                            <option value="1">المشاريع المؤرشفة</option>
                        </select>
                    </div>

                    <!-- Department Filter -->
                    <div wire:key="filter-department">
                        <label class="block text-xs font-medium text-gray-700 mb-1">القسم</label>
                        <select
                            wire:model.live="department_id"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow"
                        >
                            <option value="">جميع الأقسام</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Reset Button -->
                    <div class="flex items-center">
                        <button
                            wire:click="resetFilters"
                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
                        >
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            إعادة تعيين
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-1" wire:loading.class="opacity-60">

        <!-- Stats Cards (Bonus) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Projects -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">إجمالي المشاريع</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $data['stats']['total_projects'] }}</h3>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Overall Avg Grade (letter) -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">المعدل العام للدرجات</p>
                        <div class="mt-2">
                            <span class="px-4 py-1.5 inline-flex text-xl font-black rounded-full {{ $data['stats']['avg_grade_color'] }}">
                                {{ $data['stats']['avg_grade_label'] }}
                            </span>
                        </div>
                    </div>
                    <div class="bg-green-50 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Top Department -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">أفضل قسم أداءً</p>
                        <h3 class="text-base font-bold text-gray-900 mt-1 truncate max-w-[160px]">{{ $data['stats']['top_department'] }}</h3>
                        @if($data['stats']['top_department'] !== 'N/A')
                            <span class="mt-1 px-2.5 py-0.5 inline-flex text-sm font-bold rounded-full {{ $data['stats']['top_dept_color'] }}">
                                {{ $data['stats']['top_dept_grade'] }}
                            </span>
                        @endif
                    </div>
                    <div class="bg-yellow-50 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grade Scale Reference -->
        <div class="mb-8 bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <p class="text-xs font-semibold text-gray-500 mb-3 uppercase tracking-wider">مقياس الدرجات</p>
            <div class="flex flex-wrap gap-2">
                <span class="px-3 py-1 rounded-full text-sm font-bold bg-blue-100 text-blue-800">A &nbsp;(90-100)</span>
                <span class="px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-800">B+ (80-90)</span>
                <span class="px-3 py-1 rounded-full text-sm font-bold bg-teal-100 text-teal-800">B &nbsp;(70-80)</span>
                <span class="px-3 py-1 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800">C+ (60-70)</span>
                <span class="px-3 py-1 rounded-full text-sm font-bold bg-orange-100 text-orange-800">C &nbsp;(50-60)</span>
                <span class="px-3 py-1 rounded-full text-sm font-bold bg-red-100 text-red-800">F &nbsp;(أقل من 50)</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- A. Top Departments -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900">أعلى الأقسام أداءً</h3>
                    <span class="text-xs text-gray-500">مرتبة حسب المعدل</span>
                </div>
                <div class="p-0">
                    @if($data['top_departments']->isEmpty())
                        <div class="text-center py-10 text-gray-400 text-sm">لا توجد بيانات</div>
                    @else
                        <table class="w-full text-right border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-600 text-xs font-semibold uppercase tracking-wider">
                                    <th class="px-6 py-3">#</th>
                                    <th class="px-6 py-3">القسم</th>
                                    <th class="px-6 py-3">المشاريع</th>
                                    <th class="px-6 py-3">المعدل</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($data['top_departments'] as $i => $dept)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 text-sm text-gray-400">{{ $i + 1 }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $dept->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $dept->projects_count }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 inline-flex text-sm font-bold rounded-full {{ $dept->grade_color }}">
                                                {{ $dept->avg_letter }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

            <!-- B. Weak Departments -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900">تنبيهات الأداء (الأقسام الضعيفة)</h3>
                    <span class="text-xs text-red-500 font-medium">أقل من {{ $this->thresholdLabel() }}</span>
                </div>
                <div class="p-6">
                    @forelse($data['weak_departments'] as $dept)
                        <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg mb-4 last:mb-0 border border-red-100">
                            <div class="flex items-center">
                                <div class="bg-red-100 p-2 rounded-full ml-3">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-red-900">{{ $dept->name }}</h4>
                                    <p class="text-xs text-red-700">عدد المشاريع: {{ $dept->projects_count }}</p>
                                </div>
                            </div>
                            <div class="text-left">
                                <span class="px-3 py-1 inline-flex text-base font-black rounded-full bg-red-100 text-red-800">
                                    {{ $dept->avg_letter }}
                                </span>
                                <p class="text-[10px] text-red-500 uppercase text-center mt-1">متوسط منخفض</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <div class="bg-green-50 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-gray-500 text-sm">جميع الأقسام تؤدي بشكل جيد حالياً</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- C. Projects Count per Department -->
        <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900">توزيع المشاريع حسب القسم</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($data['departments']->sortByDesc('projects_count') as $dept)
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex items-center transition-all hover:shadow-md">
                            <div class="bg-white p-3 rounded-lg border border-gray-100 ml-4 text-center min-w-[48px]">
                                <span class="text-xl font-bold text-blue-600">{{ $dept->projects_count }}</span>
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <h4 class="text-sm font-bold text-gray-900 truncate">{{ $dept->name }}</h4>
                                <div class="flex items-center gap-1 mt-1">
                                    @if($dept->avg_letter !== 'N/A')
                                        <span class="px-2 py-0.5 text-xs font-bold rounded-full {{ $dept->grade_color }}">
                                            {{ $dept->avg_letter }}
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400">لا توجد درجات</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>
