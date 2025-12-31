<x-layout.app>
    <div x-data="searchApp()" class="min-h-screen flex flex-col">
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
                <form method="GET" action="{{ route('projects.index') }}" class="flex-1">
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-3">
                        <!-- Search Input -->
                        <div class="md:col-span-2">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="ابحث بالعنوان..."
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        </div>

                        <!-- Year Filter -->
                        <div>
                            <select
                                name="year"
                                onchange="this.form.submit()"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">جميع السنوات</option>
                                @foreach($years as $year)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Department Filter -->
                        <div>
                            <select
                                name="department_id"
                                onchange="this.form.submit()"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">جميع التخصصات</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Supervisor Filter -->
                        <div>
                            <select
                                name="supervisor_id"
                                onchange="this.form.submit()"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">جميع المشرفين</option>
                                @foreach($supervisors as $supervisor)
                                    <option value="{{ $supervisor->id }}" {{ request('supervisor_id') == $supervisor->id ? 'selected' : '' }}>
                                        {{ $supervisor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>

                <!-- Reset Button -->
                <div class="flex-shrink-0">
                    <a
                        href="{{ route('projects.index') }}"
                        class="block p-3 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-400 transition whitespace-nowrap text-center"
                    >
                        إعادة تعيين
                    </a>
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
                        عرض <span x-text="startIndex + 1"></span> إلى <span x-text="endIndex"></span> من <span x-text="total"></span> مشروع
                    </div>
                    <div class="flex items-center space-x-reverse space-x-2">
                        <button
                            @click="previousPage()"
                            :disabled="currentPage === 1"
                            :class="currentPage === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-200'"
                            class="px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-xs font-medium text-gray-700 transition"
                        >
                            السابق
                        </button>
                        <div class="text-xs text-gray-600 px-2">
                            صفحة <span x-text="currentPage"></span> من <span x-text="lastPage"></span>
                        </div>
                        <button
                            @click="nextPage()"
                            :disabled="currentPage === lastPage"
                            :class="currentPage === lastPage ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-200'"
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
                // Pagination data from server
                paginationData: @js($projects),

                // Get projects array from paginated data
                get projects() {
                    return this.paginationData.data || [];
                },

                // Get current page from server
                get currentPage() {
                    return this.paginationData.current_page || 1;
                },

                // Get last page from server
                get lastPage() {
                    return this.paginationData.last_page || 1;
                },

                // Get total items from server
                get total() {
                    return this.paginationData.total || 0;
                },

                // Get items per page
                get perPage() {
                    return this.paginationData.per_page || 12;
                },

                // Calculate start index for display
                get startIndex() {
                    return this.paginationData.from ? this.paginationData.from - 1 : 0;
                },

                // Calculate end index for display
                get endIndex() {
                    return this.paginationData.to || 0;
                },

                // Display projects (no filtering - done on server)
                get paginatedProjects() {
                    return this.projects;
                },

                nextPage() {
                    if (this.paginationData.next_page_url) {
                        window.location.href = this.paginationData.next_page_url;
                    }
                },

                previousPage() {
                    if (this.paginationData.prev_page_url) {
                        window.location.href = this.paginationData.prev_page_url;
                    }
                }
            }
        }
    </script>
    </div>

</x-layout.app>
