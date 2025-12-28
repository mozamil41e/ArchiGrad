<x-layout.app>
    <!-- Breadcrumb -->
    <div x-data="projectDetails()" >
    <div class="bg-white border-b border-gray-200" >
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-reverse space-x-2">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-blue-600 transition">الرئيسية</a>
                    </li>
                    <li>
                        <span class="text-gray-400 mx-2">/</span>
                    </li>
                    <li>
                        <a href="{{ route('projects.index') }}" class="text-gray-500 hover:text-blue-600 transition">البحث</a>
                    </li>
                    <li>
                        <span class="text-gray-400 mx-2">/</span>
                    </li>
                    <li>
                        <span class="text-gray-900 font-medium">تفاصيل المشروع</span>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Back Button -->
        <div class="mb-6">
            <a href="search.html" class="inline-flex items-center text-blue-600 hover:text-blue-700 transition">
                <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                <span>العودة إلى نتائج البحث</span>
            </a>
        </div>

        <!-- Project Title -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-6">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4" x-text="project.title"></h1>
            <div class="flex flex-wrap gap-2">
                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium" x-text="project.department.name"></span>
                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium" x-text="'السنة: ' + project.year"></span>
            </div>
        </div>

        <!-- Project Information Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">معلومات المشروع</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Student Name -->
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mr-4">
                        <p class="text-sm font-medium text-gray-500">الطلاب</p>
                        <template x-for="student in project.students" :key="student.id">
                            <p class="text-lg text-gray-900 font-semibold" x-text="student.name"></p>
                        </template>
                    </div>
                </div>

                <!-- Supervisor -->
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-10 h-10 bg-green-100 rounded-lg">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mr-4">
                        <p class="text-sm font-medium text-gray-500">المشرف</p>
                        <p class="text-lg text-gray-900 font-semibold" x-text="project.supervisor.name"></p>
                    </div>
                </div>

                <!-- Academic Year -->
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-10 h-10 bg-purple-100 rounded-lg">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mr-4">
                        <p class="text-sm font-medium text-gray-500">السنة الأكاديمية</p>
                        <p class="text-lg text-gray-900 font-semibold" x-text="project.year"></p>
                    </div>
                </div>

                <!-- Department -->
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-10 h-10 bg-orange-100 rounded-lg">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mr-4">
                        <p class="text-sm font-medium text-gray-500">التخصص</p>
                        <p class="text-lg text-gray-900 font-semibold" x-text="project.department.name"></p>
                    </div>
                </div>

                <!-- Defense Date -->
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-10 h-10 bg-red-100 rounded-lg">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mr-4">
                        <p class="text-sm font-medium text-gray-500">تاريخ المناقشة</p>
                        <p class="text-lg text-gray-900 font-semibold" x-text="project.submission_deadline"></p>
                    </div>
                </div>

                <!-- Grade -->
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-10 h-10 bg-yellow-100 rounded-lg">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mr-4">
                        <p class="text-sm font-medium text-gray-500">التقدير</p>
                        <p class="text-lg text-gray-900 font-semibold" x-text="project.grade"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Project Summary -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">ملخص المشروع</h2>
            <p class="text-gray-700 leading-relaxed text-lg" x-text="project.description"></p>
        </div>

        <!-- Keywords -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">الكلمات المفتاحية</h2>
            <div class="flex flex-wrap gap-2">
                <template x-for="keyword in project.keywords" :key="keyword">
                    <span class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium border border-gray-200" x-text="keyword"></span>
                </template>
            </div>
        </div>

        <!-- Download Section -->
        <div class="bg-gradient-to-br from-blue-50 to-white rounded-lg shadow-sm border border-blue-200 p-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="mb-4 md:mb-0">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">تحميل ملف المشروع</h3>
                    <p class="text-gray-600">قم بتحميل الملف الكامل للمشروع بصيغة PDF</p>
                </div>
                <button class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>تحميل PDF</span>
                </button>
            </div>
        </div>

    </div>

<div>
    <script>
        function projectDetails() {
            return {
                project: @json($project)
            }
        }
    </script>
</x-layout.app>
