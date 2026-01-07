<div class="min-h-screen flex flex-col">
    <!-- Page Header with Filters -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <!-- Back Button -->
            <!-- <div class="mb-4">
                <button onclick="history.back()" class="inline-flex items-center text-gray-500 hover:text-blue-600 transition">
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                    <span>رجوع</span>
                </button>
            </div> -->

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
                        <div class="md:col-span-2" wire:key="filter-search">
                            <input
                                type="text"
                                wire:model.live.debounce.800ms="search"
                                placeholder="ابحث بالعنوان..."
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        </div>

                        <!-- Year Filter -->
                        <div wire:key="filter-year">
                            <select
                                wire:model.live="year"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">جميع السنوات</option>
                                @foreach($years as $y)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Department Filter -->
                        <div wire:key="filter-department">
                            <select
                                wire:model.live="department_id"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">جميع التخصصات</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Supervisor Filter -->
                        <div wire:key="filter-supervisor">
                            <select
                                wire:model.live="supervisor_id"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">جميع المشرفين</option>
                                @foreach($supervisors as $supervisor)
                                    <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Reset Button -->
                <div class="flex-shrink-0">
                    <button
                        wire:click="resetFilters"
                        class="p-3 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-400 transition whitespace-nowrap"
                    >
                        إعادة تعيين
                    </button>
                </div>


                <!-- Add Project Button -->
                <div class="flex-shrink-0">


                <button
                    wire:navigate
                    href="{{ route('projects-live.create') }}"
                class="p-3 inline-flex items-center  bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-800 transition shadow-md"
                >
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                إضافة مشروع
                </button>
                </div>


            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-1">
        <!-- Results Section -->
        <div wire:loading.class="opacity-50" class="transition-opacity duration-200">
            <!-- Projects Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @forelse($projects as $project)
                    <a wire:navigate href="{{ route('projects-live.show', $project->id) }}"
                       class="group bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-xl hover:border-blue-400 transition-all duration-300 cursor-pointer flex flex-col justify-between">
                        <div>
                            <!-- Project Title -->
                            <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition line-clamp-2">
                                {{ $project->title }}
                            </h3>

                            <!-- Supervisor Name -->
                            <div class="flex items-center text-gray-600 mb-4">
                                <svg class="w-5 h-5 ml-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="text-base">{{ $project->supervisor->name }}</span>
                            </div>

                            <!-- Project Info Grid -->
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <!-- Year -->
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-5 h-5 ml-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>{{ $project->year }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Info -->
                        <div class="flex items-center justify-between pt-5 border-t border-gray-50">
                            <span class="px-4 py-1.5 inline-flex text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $project->department->name }}
                            </span>

                            <!-- View Details Arrow -->
                            <svg class="w-6 h-6 text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <div class="text-gray-400 mb-4">
                            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-xl text-gray-500 font-medium">لا توجد مشاريع تطابق معايير البحث</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <!-- Pagination -->
            <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-100 px-6 py-4">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <!-- Results Info -->
                    <div class="text-sm text-gray-500">
                        عرض <span class="font-semibold text-gray-900">{{ $projects->firstItem() ?? 0 }}</span> إلى
                        <span class="font-semibold text-gray-900">{{ $projects->lastItem() ?? 0 }}</span> من
                        <span class="font-semibold text-gray-900">{{ $projects->total() }}</span> مشروع
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex items-center space-x-reverse space-x-3">
                        <button
                            wire:click="previousPage"
                            wire:loading.attr="disabled"
                            @if($projects->onFirstPage()) disabled @endif
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium transition-all duration-200
                            {{ $projects->onFirstPage() ? 'text-gray-300 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-50 hover:border-blue-300 hover:text-blue-600 shadow-sm' }}"
                        >
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            السابق
                        </button>

                        <div class="flex items-center px-4 h-9 bg-gray-50 rounded-lg text-xs font-semibold text-gray-600 border border-gray-100">
                            صفحة {{ $projects->currentPage() }} من {{ $projects->lastPage() }}
                        </div>

                        <button
                            wire:click="nextPage"
                            wire:loading.attr="disabled"
                            @if(!$projects->hasMorePages()) disabled @endif
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium transition-all duration-200
                            {{ !$projects->hasMorePages() ? 'text-gray-300 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-50 hover:border-blue-300 hover:text-blue-600 shadow-sm' }}"
                        >
                            التالي
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


