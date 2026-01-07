<div>
 <!-- Page Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">أرشفة مشروع جديد</h2>
            <p class="text-gray-600">قم بإضافة مشروع تخرج جديد إلى قاعدة البيانات</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Success Message -->
        @if (session()->has('message'))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 3000)"
                x-show="show"
                x-transition
                class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4"
            >
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-green-800 font-medium">{{ session('message') }}</p>
                </div>
            </div>
        @endif

        <!-- Error Message -->
        @if (session()->has('error'))
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-600 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-red-800 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Step Indicator -->
        <div class="mb-8">
            <div class="flex items-center justify-center">
                <div class="flex items-center space-x-4 space-x-reverse">
                    <!-- Step 1 -->
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full transition-colors
                             {{ $currentStep === 1 ? 'bg-blue-600 text-white' : 'bg-green-600 text-white' }}">
                            @if($currentStep === 1)
                                <span class="font-semibold">1</span>
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="mr-3 text-right">
                            <p class="text-sm font-semibold {{ $currentStep === 1 ? 'text-blue-600' : 'text-green-600' }}">الخطوة الأولى</p>
                            <p class="text-xs text-gray-500">المعلومات الأساسية</p>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="w-16 h-1 transition-colors {{ $currentStep === 2 ? 'bg-blue-600' : 'bg-gray-300' }}"></div>

                    <!-- Step 2 -->
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full transition-colors
                             {{ $currentStep === 2 ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-600' }}">
                            <span class="font-semibold">2</span>
                        </div>
                        <div class="mr-3 text-right">
                            <p class="text-sm font-semibold {{ $currentStep === 2 ? 'text-blue-600' : 'text-gray-500' }}">الخطوة الثانية</p>
                            <p class="text-xs text-gray-500">التفاصيل الإضافية</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form wire:submit="save" class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">

            <!-- Step 1: Basic Information -->
            @if($currentStep === 1)
            <div>
                <!-- Project Title -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                        عنوان المشروع <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="title"
                        wire:model="title"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                        placeholder="أدخل عنوان المشروع"
                    >
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Project Summary -->
                <div class="mb-6">
                    <label for="summary" class="block text-sm font-semibold text-gray-700 mb-2">
                        ملخص المشروع <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        id="summary"
                        wire:model="summary"
                        rows="6"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none @error('summary') border-red-500 @enderror"
                        placeholder="أدخل ملخصاً شاملاً للمشروع..."
                    ></textarea>
                    @error('summary')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">الحد الأدنى: 100 حرف</p>
                </div>
            </div>
            @endif

            <!-- Step 2: Additional Details -->
            @if($currentStep === 2)
            <div>
                <!-- Student Names -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            اسم الطالب/الطلاب <span class="text-red-500">*</span>
                        </label>
                        <button
                            type="button"
                            wire:click="addStudent"
                            class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition shadow-sm hover:shadow-md"
                        >
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>إضافة طالب</span>
                        </button>
                    </div>

                    <div class="space-y-3">
                        @foreach($students as $index => $student)
                            <div class="flex items-start gap-2" wire:key="student-{{ $index }}">
                                <div class="flex-1">
                                    <input
                                        type="text"
                                        wire:model="students.{{ $index }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('students.'.$index) border-red-500 @enderror"
                                        placeholder="أدخل اسم الطالب {{ $index + 1 }}"
                                    >
                                    @error('students.'.$index)
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                @if(count($students) > 1)
                                    <button
                                        type="button"
                                        wire:click="removeStudent({{ $index }})"
                                        class="mt-3 p-2.5 text-red-600 hover:bg-red-50 rounded-lg transition"
                                        title="حذف الطالب"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    @error('students')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Supervisor -->
                <div class="mb-6">
                    <label for="supervisor_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        المشرف <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="supervisor_id"
                        wire:model="supervisor_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('supervisor_id') border-red-500 @enderror"
                    >
                        <option value="">اختر المشرف</option>
                        @foreach($supervisors as $supervisor)
                            <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
                        @endforeach
                    </select>
                    @error('supervisor_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Year and Department Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Academic Year -->
                    <div>
                        <label for="year" class="block text-sm font-semibold text-gray-700 mb-2">
                            السنة الأكاديمية <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="year"
                            wire:model="year"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('year') border-red-500 @enderror"
                        >
                            <option value="">اختر السنة</option>
                            @foreach($years as $y)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endforeach
                        </select>
                        @error('year')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Department -->
                    <div>
                        <label for="department_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            التخصص <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="department_id"
                            wire:model="department_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('department_id') border-red-500 @enderror"
                        >
                            <option value="">اختر التخصص</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Defense Date and Grade Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Defense Date -->
                    <div>
                        <label for="defenseDate" class="block text-sm font-semibold text-gray-700 mb-2">
                            تاريخ المناقشة <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="date"
                            id="defenseDate"
                            wire:model="defenseDate"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('defenseDate') border-red-500 @enderror"
                        >
                        @error('defenseDate')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Grade -->
                    <div>
                        <label for="grade" class="block text-sm font-semibold text-gray-700 mb-2">
                            التقدير <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="grade"
                            wire:model="grade"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('grade') border-red-500 @enderror"
                        >
                            <option value="">اختر التقدير</option>
                            <option value="A">ممتاز</option>
                            <option value="B+">جيد جداً</option>
                            <option value="C+">جيد</option>
                            <option value="C">مقبول</option>
                        </select>
                        @error('grade')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Keywords -->
                <div class="mb-6">
                    <label for="keywords" class="block text-sm font-semibold text-gray-700 mb-2">
                        الكلمات المفتاحية <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="keywords"
                        wire:model="keywords"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('keywords') border-red-500 @enderror"
                        placeholder="أدخل الكلمات المفتاحية مفصولة بفواصل (مثال: تعلم آلي, قواعد بيانات, تطبيقات ويب)"
                    >
                    @error('keywords')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File Upload -->
                <div class="mb-8">
                    <label for="pdfFile" class="block text-sm font-semibold text-gray-700 mb-2">
                        ملف المشروع (PDF) <span class="text-red-500">*</span>
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 transition @error('pdfFile') border-red-500 @enderror">
                        <input
                            type="file"
                            id="pdfFile"
                            wire:model="pdfFile"
                            accept=".pdf"
                            class="hidden"
                        >
                        <label for="pdfFile" class="cursor-pointer">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-600">
                                <span class="font-semibold text-blue-600 hover:text-blue-700">اضغط لاختيار ملف</span>
                                أو اسحب الملف هنا
                            </p>
                            <p class="mt-1 text-xs text-gray-500">PDF فقط (الحد الأقصى: 10MB)</p>
                        </label>
                        @if ($pdfFile)
                            <p class="mt-3 text-sm text-green-600 font-medium">تم اختيار: {{ $pdfFile->getClientOriginalName() }}</p>
                        @endif
                    </div>
                    @error('pdfFile')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            @endif

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <!-- Step 1 Buttons -->
                @if($currentStep === 1)
                    <div class="w-full flex items-center justify-end space-x-reverse space-x-4">
                        <a href="{{ route('projects-live.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition">
                            إلغاء
                        </a>
                        <button
                            type="button"
                            wire:click="nextStep"
                            class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-md hover:shadow-lg inline-flex items-center"
                        >
                            <span>التالي</span>
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                    </div>
                @endif

                <!-- Step 2 Buttons -->
                @if($currentStep === 2)
                    <div class="w-full flex items-center justify-between">
                        <button
                            type="button"
                            wire:click="previousStep"
                            class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition inline-flex items-center"
                        >
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span>السابق</span>
                        </button>
                        <div class="flex items-center space-x-reverse space-x-4">
                            <a href="{{ route('projects-live.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition">
                                إلغاء
                            </a>
                            <button
                                type="submit"
                                class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-md hover:shadow-lg inline-flex items-center"
                            >
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>حفظ المشروع</span>
                            </button>
                        </div>
                    </div>
                @endif
            </div>

        </form>

    </div>
</div>
