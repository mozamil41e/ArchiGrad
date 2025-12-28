<x-layout.app>
    <div x-data="searchApp()" x-init="init()" class="min-h-screen flex flex-col">
<!-- Page Header with Filters -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
                <!-- Title Section -->
                <div class="flex-shrink-0">
                    <h2 class="text-2xl font-bold text-gray-900 mb-1">البحث عن المشاريع</h2>
                    <p class="text-sm text-gray-600">ابحث في قاعدة بيانات مشاريع التخرج</p>
                </div>

                <!-- Filters Section -->
                <div class="flex-1">
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-3">
                        <!-- Search Input -->
                        <div class="md:col-span-2">
                            <input
                                type="text"
                                x-model="searchQuery"
                                placeholder="ابحث بالعنوان..."
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        </div>

                        <!-- Year Filter -->
                        <div>
                            <select
                                x-model="selectedYear"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">جميع السنوات</option>
                                <template x-for="(y, index) in years" :key="index">
                                    <option :value="y" x-text="y"></option>
                                </template>
                            </select>
                        </div>

                        <!-- Department Filter -->
                        <div>
                            <select
                                x-model="selectedDepartment"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">جميع التخصصات</option>
                                  <template x-for="department in departments" :key="department">
                                    <option :value="department" x-text="department"></option>
                                </template>
                            </select>
                        </div>

                        <!-- Supervisor Filter -->
                        <div>
                            <select
                                x-model="selectedSupervisor"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">جميع المشرفين</option>
                                <template x-for="supervisor in supervisors" :key="supervisor">
                                    <option :value="supervisor" x-text="supervisor"></option>
                                </template>

                            </select>
                        </div>
                    </div>
                </div>

                <!-- Reset Button -->
                <div class="flex-shrink-0">
                    <button
                        @click="resetFilters()"
                        class="p-3 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-400 transition whitespace-nowrap"
                    >
                        إعادة تعيين
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Results Section -->
        <div>
            <!-- Projects Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                <template x-for="project in paginatedProjects" :key="project.id">
                    <a :href="`projects/${project.id}`"
                       class="group bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-lg hover:border-blue-300 transition-all duration-300 cursor-pointer">
                        <!-- Project Title -->
                        <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition line-clamp-2" x-text="project.title"></h3>

                        <!-- Student Name -->
                        <div class="flex items-center text-sm text-gray-600 mb-3">
                            <svg class="w-4 h-4 ml-1.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span x-text="project.supervisor.name"></span>
                        </div>

                        <!-- Project Info Grid -->
                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <!-- Year -->
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 ml-1.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span x-text="project.year"></span>
                            </div>

                            <!-- Supervisor -->
                            {{-- <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 ml-1.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <span class="truncate" x-text="project.supervisor.name"></span>
                            </div> --}}
                        </div>

                        <!-- Department Badge -->
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-blue-100 text-blue-800" x-text="project.department.name"></span>

                            <!-- View Details Arrow -->
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </div>
                    </a>
                </template>
            </div>

            <!-- Pagination -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 px-4 py-3">
                <div class="flex items-center justify-between">
                    <div class="text-xs text-gray-600">
                        عرض <span x-text="startIndex + 1"></span> إلى <span x-text="endIndex"></span> من <span x-text="filteredProjects.length"></span> مشروع
                    </div>
                    <div class="flex space-x-reverse space-x-2">
                        <button
                            @click="previousPage()"
                            :disabled="currentPage === 1"
                            :class="currentPage === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-200'"
                            class="px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-xs font-medium text-gray-700 transition"
                        >
                            السابق
                        </button>
                        <div class="flex items-center space-x-reverse space-x-1">
                            <template x-for="page in totalPages" :key="page">
                                <button
                                    @click="currentPage = page"
                                    :class="currentPage === page ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100'"
                                    class="px-2.5 py-1.5 border border-gray-300 rounded-lg text-xs font-medium transition"
                                    x-text="page"
                                ></button>
                            </template>
                        </div>
                        <button
                            @click="nextPage()"
                            :disabled="currentPage === totalPages"
                            :class="currentPage === totalPages ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-200'"
                            class="px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-xs font-medium text-gray-700 transition"
                        >
                            التالي
                        </button>
                    </div>
                </div>
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
        function searchApp() {
            return {
                searchQuery: '',
                selectedYear: '',
                selectedDepartment: '',
                selectedSupervisor: '',
                currentPage: 1,
                itemsPerPage: 12,
                supervisors: [],
                departments: [],
                years: [],


                init() {
                    const currentYear = new Date().getFullYear();
                    for (let i = 0; i < 10; i++) {
                        this.years.push((currentYear - i).toString());
                    }
                    this.departments = [...new Set(this.projects.map(project => project.department.name))];
                    this.supervisors = [...new Set(this.projects.map(project => project.supervisor.name))];
                },

                // projects: [
                //     { id: 1, title: 'نظام إدارة المكتبات الجامعية', student: 'محمد أحمد علي', year: '2024', department: 'علوم الحاسوب', supervisor: 'د. أحمد محمد' },
                //     { id: 2, title: 'تطبيق ذكي للتعلم الإلكتروني', student: 'فاطمة حسن محمود', year: '2024', department: 'هندسة البرمجيات', supervisor: 'د. فاطمة علي' },
                //     { id: 3, title: 'نظام كشف الاحتيال في المعاملات المالية', student: 'عمر خالد سعيد', year: '2023', department: 'الذكاء الاصطناعي', supervisor: 'د. محمود حسن' },
                //     { id: 4, title: 'منصة التجارة الإلكترونية للمنتجات المحلية', student: 'سارة عبدالله إبراهيم', year: '2023', department: 'نظم المعلومات', supervisor: 'د. سارة عبدالله' },
                //     { id: 5, title: 'تطبيق الواقع المعزز للتعليم الطبي', student: 'أحمد محمد حسن', year: '2024', department: 'علوم الحاسوب', supervisor: 'د. أحمد محمد' },
                //     { id: 6, title: 'نظام التحكم الآلي في الإضاءة الذكية', student: 'نور الدين يوسف', year: '2022', department: 'الهندسة الكهربائية', supervisor: 'د. محمود حسن' },
                //     { id: 7, title: 'تطبيق تحليل البيانات الضخمة للتسويق', student: 'ليلى عبدالرحمن', year: '2023', department: 'نظم المعلومات', supervisor: 'د. فاطمة علي' },
                //     { id: 8, title: 'نظام التعرف على الوجه باستخدام التعلم العميق', student: 'كريم صلاح الدين', year: '2024', department: 'الذكاء الاصطناعي', supervisor: 'د. أحمد محمد' },
                //     { id: 9, title: 'منصة إدارة المشاريع الرشيقة', student: 'هدى محمود علي', year: '2022', department: 'هندسة البرمجيات', supervisor: 'د. سارة عبدالله' },
                //     { id: 10, title: 'تطبيق الصحة الإلكترونية للمرضى', student: 'يوسف عبدالله أحمد', year: '2023', department: 'نظم المعلومات', supervisor: 'د. محمود حسن' },
                //     { id: 11, title: 'نظام إنترنت الأشياء للمنازل الذكية', student: 'مريم حسن خالد', year: '2024', department: 'الهندسة الكهربائية', supervisor: 'د. فاطمة علي' },
                //     { id: 12, title: 'تطبيق الترجمة الآلية باستخدام الذكاء الاصطناعي', student: 'عبدالرحمن سعيد', year: '2022', department: 'الذكاء الاصطناعي', supervisor: 'د. أحمد محمد' },
                // ],

                projects: @json($projects),

                get filteredProjects() {
                    const query = (this.searchQuery || '').toString().toLowerCase();
                    return (this.projects || []).filter(project => {
                        const title = (project.title ?? '').toString().toLowerCase();

                        let studentName = '';
                        if (project.student) {
                            studentName = typeof project.student === 'string' ? project.student : (project.student.name ?? '');
                        }
                        studentName = studentName.toString().toLowerCase();

                        const matchesSearch = !query || title.includes(query) || studentName.includes(query);

                        const matchesYear = !this.selectedYear || project.year === this.selectedYear;
                        const matchesDepartment = !this.selectedDepartment || (project.department && project.department.name === this.selectedDepartment);
                        const matchesSupervisor = !this.selectedSupervisor || (project.supervisor && project.supervisor.name === this.selectedSupervisor);

                        return matchesSearch && matchesYear && matchesDepartment && matchesSupervisor;
                    });
                },

                get totalPages() {
                    return Math.ceil(this.filteredProjects.length / this.itemsPerPage);
                },

                get startIndex() {
                    return (this.currentPage - 1) * this.itemsPerPage;
                },

                get endIndex() {
                    const end = this.currentPage * this.itemsPerPage;
                    return end > this.filteredProjects.length ? this.filteredProjects.length : end;
                },

                get paginatedProjects() {
                    return this.filteredProjects.slice(this.startIndex, this.endIndex);
                },

                nextPage() {
                    if (this.currentPage < this.totalPages) {
                        this.currentPage++;
                    }
                },

                previousPage() {
                    if (this.currentPage > 1) {
                        this.currentPage--;
                    }
                },

                resetFilters() {
                    this.searchQuery = '';
                    this.selectedYear = '';
                    this.selectedDepartment = '';
                    this.selectedSupervisor = '';
                    this.currentPage = 1;
                }
            }
        }
    </script>
    </div>

</x-layout.app>
