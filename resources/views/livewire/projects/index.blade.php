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
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-1">
        <!-- Results Section -->
        <div wire:loading.class="opacity-50" class="transition-opacity duration-200">
            <!-- Projects Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                @forelse($projects as $project)
                    <a wire:navigate href="{{ route('projects-live.show', $project->id) }}"
                       class="group bg-white rounded-lg shadow-sm border border-gray-200 p-5 hover:shadow-lg hover:border-blue-300 transition-all duration-300 cursor-pointer">
                        <!-- Project Title -->
                        <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition line-clamp-2">
                            {{ $project->title }}
                        </h3>

                        <!-- Student Name -->
                        <div class="flex items-center text-sm text-gray-600 mb-3">
                            <svg class="w-4 h-4 ml-1.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>{{ $project->supervisor->name }}</span>
                        </div>

                        <!-- Project Info Grid -->
                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <!-- Year -->
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 ml-1.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>{{ $project->year }}</span>
                            </div>
                        </div>

                        <!-- Department Badge -->
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $project->department->name }}
                            </span>

                            <!-- View Details Arrow -->
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-12 text-center text-gray-500">
                        لا توجد مشاريع تطابق معايير البحث
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


