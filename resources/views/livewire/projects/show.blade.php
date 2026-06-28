<div x-data="projectDetails()" >
    <div class="bg-white border-b border-gray-200" >
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-reverse space-x-2">
                    <li>
                        <a wire:navigate href="{{ route('home.page') }}" class="text-gray-500 hover:text-blue-600 transition">الرئيسية</a>
                    </li>
                    <li>
                        <span class="text-gray-400 mx-2">/</span>
                    </li>
                    <li>
                        <a wire:navigate href="{{ route('projects-live.index') }}" class="text-gray-500 hover:text-blue-600 transition">البحث</a>
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
            <a wire:navigate href="{{ route('projects-live.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 transition">
                <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                <span>العودة إلى نتائج البحث</span>
            </a>
        </div>

        <!-- Success Message -->
        @if (session()->has('message'))
            <div wire:key="msg-success-{{ uniqid() }}">
                <x-messages.success> {{ session('message') }}</x-messages.success>
            </div>
        @endif

        <!-- Error Message -->
        @if (session()->has('error'))
            <div wire:key="msg-error-{{ uniqid() }}">
                <x-messages.erorr>{{ session('error') }}</x-messages.erorr>
            </div>
        @endif

        @auth
            <!-- Project Title -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-6">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 flex-1" x-text="project.title"></h1>
                    <div class="flex items-center gap-2">

                       @if(!$project->is_archiv)
                        <a wire:navigate href="{{ route('projects-live.edit', $project->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-sm hover:shadow-md whitespace-nowrap">
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            تعديل
                        </a>
                        @endif
                    @if($project->grade != "لم يتم التقييم بعد")
                        @if($project->is_archiv)
                            <button type="button" @click="
                                Swal.fire({
                                    title: 'تأكيد الإلغاء',
                                    text: 'هل أنت متأكد من أنك تريد إلغاء أرشفة هذا المشروع؟',
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonColor: '#16a34a',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'نعم، قم بالإلغاء',
                                    cancelButtonText: 'تراجع'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $wire.unarchiveProject();
                                    }
                                })
                            " wire:key="unarchive-btn" class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition shadow-sm hover:shadow-md whitespace-nowrap">
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                </svg>
                                إلغاء الأرشفة
                            </button>
                        @else
                            <button type="button" @click="
                                Swal.fire({
                                    title: 'تأكيد الأرشفة',
                                    text: 'هل أنت متأكد من أنك تريد أرشفة هذا المشروع؟',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#4b5563',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'نعم، قم بالأرشفة',
                                    cancelButtonText: 'تراجع'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $wire.archiveProject();
                                    }
                                })
                            " wire:key="archive-btn" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition shadow-sm hover:shadow-md whitespace-nowrap">
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                </svg>
                                أرشفة
                            </button>
                        @endif
                    @endif
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium" x-text="project.department.name"></span>
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium" x-text="'السنة: ' + project.year"></span>
                </div>
            </div>

        @endauth

        <!-- Project Information Card -->

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-6">

                <h1 class="text-2xl font-bold text-gray-900 mb-6"x-text="project.title"></h1>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Students -->
                    <div>
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">فريق المشروع (الطلاب)</h3>
                        <div class="flex flex-col gap-3">
                            <template x-for="student in project.students" :key="student.id">
                                <div class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-xl shadow-sm hover:border-blue-400 hover:ring-1 hover:ring-blue-400 hover:shadow-md transition-all group">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center ml-3 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900" x-text="student.name"></p>
                                            <p class="text-[11px] text-gray-500 mt-0.5">طالب / باحث</p>
                                        </div>
                                    </div>
                                    <div class="text-left">
                                        <span class="inline-flex items-center px-2.5 py-1 bg-gray-50 text-gray-700 text-xs font-bold rounded-lg font-mono border border-gray-200 shadow-sm" x-text="student.university_number"></span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Supervisor -->
                    <div>
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">المشرف الأكاديمي</h3>
                        <div class="flex items-center p-3 bg-white border border-gray-200 rounded-xl shadow-sm hover:border-green-400 hover:ring-1 hover:ring-green-400 hover:shadow-md transition-all group">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-50 text-green-600 flex items-center justify-center ml-3 group-hover:bg-green-600 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-base font-bold text-gray-900" x-text="project.supervisor.name"></p>
                                <p class="text-xs text-gray-500 mt-0.5">أستاذ المادة / المشرف</p>
                            </div>
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
                            <p class="text-lg text-gray-900 font-semibold" x-text="project.submission_deadline ? project.submission_deadline.split('T')[0] : ''"></p>
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
            <p class="text-gray-700 leading-relaxed text-lg whitespace-pre-wrap break-words" x-text="project.description"></p>
        </div>


        <!-- Download Section -->
        @if ($project->file_path && $project->is_archiv) {{-- @unless (empty($project->file_path)) --}}
            <div class="bg-gradient-to-br from-blue-50 to-white rounded-lg shadow-sm border border-blue-200 p-8 mb-6">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="mb-4 md:mb-0">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">تحميل ملف المشروع</h3>
                        <p class="text-gray-600">قم بتحميل الملف الكامل للمشروع بصيغة PDF</p>
                    </div>

                    <button wire:click="downloadPdf" wire:loading.attr="disabled" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-md hover:shadow-lg disabled:opacity-50">
                        <svg wire:loading.remove wire:target="downloadPdf" class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <svg wire:loading wire:target="downloadPdf" class="animate-spin h-5 w-5 ml-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>تحميل PDF</span>
                    </button>
                </div>
            </div>
        @endif



    </div>

</div>


<script>
    function projectDetails() {
        return {
            project: @json($project)
        }
    }
</script>
