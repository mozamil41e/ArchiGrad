<div>
    <!-- Page Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">تصنيف المشاريع</h2>
            <p class="text-gray-600">تصفح المشاريع حسب التخصص أو السنة الأكاديمية</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="categoriesApp()" x-init="init()">

        <!-- Tabs -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="border-b border-gray-200">
                <nav class="flex space-x-reverse space-x-8 px-6" aria-label="Tabs">
                    <button
                        @click="activeTab = 'department'"
                        :class="activeTab === 'department' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="py-4 px-1 border-b-2 font-semibold text-sm transition"
                    >
                        التصنيف حسب التخصص
                    </button>
                    <button
                        @click="activeTab = 'year'"
                        :class="activeTab === 'year' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="py-4 px-1 border-b-2 font-semibold text-sm transition"
                    >
                        التصنيف حسب السنة
                    </button>
                </nav>
            </div>
        </div>

        <!-- Department Categories -->
        <div x-show="activeTab === 'department'" x-transition>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="(category, index) in departmentCategories" :key="category.name">
                          <a :href="'projects-live?department_id=' + encodeURIComponent(category.id)"
                              class="group bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-lg hover:border-blue-300 transition-all duration-300" wire:navigate>
                        <div class="flex items-center justify-between mb-4">
                               <div class="flex items-center justify-center w-12 h-12 rounded-lg transition"
                                   :style="'background-color: ' + colors[index % colors.length].bg">
                                  <svg class="w-6 h-6" :style="'color: ' + colors[index % colors.length].text" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div class="text-3xl font-bold" :style="'color: ' + colors[index % colors.length].text" x-text="category.projects_count"></div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition" x-text="category.name"></h3>
                        <p class="text-gray-600 text-sm">اضغط لعرض جميع المشاريع</p>
                    </a>
                </template>
            </div>
        </div>

        <!-- Year Categories -->
        <div x-show="activeTab === 'year'" x-transition>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <template x-for="category in yearCategories" :key="category.year">
                    <a wire:navigate :href="'projects-live?year=' + category.year"
                       class="group bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-lg hover:border-blue-300 transition-all duration-300">
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition" x-text="category.year"></h3>
                            <div class="text-3xl font-bold text-blue-600 mb-2" x-text="category.total"></div>
                            <p class="text-gray-600 text-sm">مشروع</p>
                        </div>
                    </a>
                </template>
            </div>
        </div>

        <!-- Statistics Section -->
        <div class="mt-12 bg-gradient-to-br from-blue-50 to-white rounded-lg shadow-sm border border-blue-200 p-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">إحصائيات عامة</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-600 mb-2">{{ $total_projects }}</div>
                    <div class="text-gray-600">إجمالي المشاريع</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-green-600 mb-2">{{ $total_departments }}</div>
                    <div class="text-gray-600">التخصصات</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-purple-600 mb-2">{{ $total_students }}</div>
                    <div class="text-gray-600">الطلاب</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="mb-4 md:mb-0">
                    <h3 class="text-lg font-bold text-gray-900 mb-1">لم تجد ما تبحث عنه؟</h3>
                    <p class="text-gray-600">استخدم البحث المتقدم للعثور على مشاريع محددة</p>
                </div>
                <a wire:navigate href="{{ route('projects-live.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span>البحث المتقدم</span>
                </a>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-gray-400 mb-2">نظام أرشفة مشاريع التخرج © 2025</p>
                <p class="text-gray-500 text-sm">جميع الحقوق محفوظة</p>
            </div>
        </div>
    </footer>

    <script>
        function categoriesApp() {
            return {
                activeTab: 'department',
                    colors: [
                        { bg: '#DBEAFE', text: '#2563EB' },
                        { bg: '#D1FAE5', text: '#059669' },
                        { bg: '#E9D5FF', text: '#7C3AED' },
                        { bg: '#FFF7ED', text: '#DD6B20' },
                        { bg: '#FEE2E2', text: '#DC2626' },
                        { bg: '#E0E7FF', text: '#4F46E5' },
                        { bg: '#CCFBF1', text: '#0D9488' },
                        { bg: '#FCE7F3', text: '#DB2777' },
                        { bg: '#FEF9C3', text: '#D97706' }
                    ],
                    color: null,

                init() {
                    this.color = this.colors[Math.floor(Math.random() * this.colors.length)];
                },
                // departmentCategories: [
                //     {
                //         name: 'علوم الحاسوب',
                //         count: 342,
                //         color: 'bg-blue-100',
                //         iconColor: 'text-blue-600',
                //         textColor: 'text-blue-600'
                //     },
                //     {
                //         name: 'هندسة البرمجيات',
                //         count: 289,
                //         color: 'bg-green-100',
                //         iconColor: 'text-green-600',
                //         textColor: 'text-green-600'
                //     },
                //     {
                //         name: 'نظم المعلومات',
                //         count: 215,
                //         color: 'bg-purple-100',
                //         iconColor: 'text-purple-600',
                //         textColor: 'text-purple-600'
                //     },
                //     {
                //         name: 'الذكاء الاصطناعي',
                //         count: 178,
                //         color: 'bg-orange-100',
                //         iconColor: 'text-orange-600',
                //         textColor: 'text-orange-600'
                //     },
                //     {
                //         name: 'الهندسة الكهربائية',
                //         count: 143,
                //         color: 'bg-red-100',
                //         iconColor: 'text-red-600',
                //         textColor: 'text-red-600'
                //     },
                //     {
                //         name: 'هندسة الاتصالات',
                //         count: 80,
                //         color: 'bg-indigo-100',
                //         iconColor: 'text-indigo-600',
                //         textColor: 'text-indigo-600'
                //     }
                // ],

                departmentCategories: @json($department_Categories),

                yearCategories: @json($year_Categories)
            }
        }
    </script>
</div>
