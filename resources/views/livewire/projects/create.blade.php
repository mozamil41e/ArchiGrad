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
            <x-messages.success> {{ session('message') }}</x-messages.success>
        @endif

        <!-- Error Message -->
        @if (session()->has('error'))
            <x-messages.erorr>{{ session('error') }}</x-messages.erorr>
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
                        wire:model.blur="form.title"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('form.title') border-red-500 @enderror"
                        placeholder="أدخل عنوان المشروع"
                    >
                    @error('form.title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    {{-- Similarity Warning --}}
                    @if(!empty($similarProjects))
                        <div class="mt-4 p-4 bg-yellow-50 border-r-4 border-yellow-400 rounded-lg">
                            <div class="flex items-center mb-2">
                                <svg class="w-5 h-5 text-yellow-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <h4 class="text-sm font-bold text-yellow-800"> ⚠️  تنبيه: تم العثور على مشاريع مشابهة قبل اقل من ثلاث سنوات</h4>
                            </div>
                            <ul class="space-y-1">
                                @foreach($similarProjects as $project)
                                    <li class="text-xs text-yellow-700 flex justify-between items-center">
                                        <span>{{ $project['existing_title'] }}</span>
                                        <span class="font-bold mr-2">{{ $project['similarity'] }}%</span>
                                    </li>
                                @endforeach
                            </ul>
                            <p class="mt-2 text-xs text-yellow-600 italic">يرجى التأكد من أن مشروعك يقدم فكرة جديدة أو تطوير ملموس للمشاريع السابقة.</p>
                        </div>
                    @endif
                </div>

                <!-- Project Summary -->
                <div class="mb-6">
                    <label for="summary" class="block text-sm font-semibold text-gray-700 mb-2">
                        ملخص المشروع <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        id="summary"
                        wire:model="form.summary"
                        rows="6"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none @error('form.summary') border-red-500 @enderror"
                        placeholder="أدخل ملخصاً شاملاً للمشروع..."
                    ></textarea>
                    @error('form.summary')
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
                    <!-- Header Row -->
                    <div class="grid grid-cols-3 gap-2 mb-3 px-4 py-2 bg-gray-50 rounded-lg border border-gray-200">
                        <span class="text-xs font-semibold text-gray-600">اسم الطالب</span>
                        <span class="text-xs font-semibold text-gray-600">الرقم الجامعي</span>
                        <span class="text-xs font-semibold text-gray-600 text-end">الإجراءات</span>
                    </div>

                    <div class="space-y-3">
                        @foreach($form->students as $index => $student)
                            <div class="grid grid-cols-3 gap-2 items-start" wire:key="student-{{ $index }}">
                                <div class="flex-1">
                                    <input
                                        type="text"
                                        wire:model="form.students.{{ $index }}.name"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('form.students.'.$index.'.name') border-red-500 @enderror"
                                        placeholder="أدخل اسم الطالب {{ $index + 1 }}"
                                    >
                                    @error('form.students.'.$index.'.name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex-1"
                                     x-data="{
                                         uniError: '',
                                         validate(val) {
                                             if (!val) { this.uniError = ''; return; }
                                             if (!/^\d+$/.test(val)) { this.uniError = 'يُسمح بالأرقام فقط'; return; }
                                             if (val.length < 11) { this.uniError = 'يجب أن يتكوّن من 11 أرقام (مُدخل: ' + val.length + ')'; return; }
                                             this.uniError = '';
                                         }
                                     }">
                                    <input
                                        type="text"
                                        wire:model="form.students.{{ $index }}.university_number"
                                        inputmode="numeric"
                                        maxlength="11"
                                        :class="uniError ? 'border-red-500 focus:ring-red-400' : ($el.value && $el.value.length === 11 ? 'border-green-500 focus:ring-green-400' : 'border-gray-300 focus:ring-blue-500')"
                                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:border-transparent transition-colors @error('form.students.'.$index.'.university_number') border-red-500 @enderror"
                                        placeholder="الرقم الجامعي (11 أرقام)"
                                        @input="
                                            $el.value = $el.value.replace(/\D/g, '').slice(0, 11);
                                            validate($el.value);
                                        "
                                    >
                                    {{-- Alpine real-time error --}}
                                    <p x-show="uniError" x-text="uniError" class="mt-1 text-sm text-red-600" style="display:none;"></p>
                                    {{-- Livewire server-side error --}}
                                    @error('form.students.'.$index.'.university_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex justify-end">
                                    @if(count($form->students) > 1)
                                        <button
                                            type="button"
                                            wire:click="removeStudent({{ $index }})"
                                            class="p-2.5 text-red-600 hover:bg-red-50 rounded-lg transition"
                                            title="حذف الطالب"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('form.students')
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
                        wire:model="form.supervisor_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('form.supervisor_id') border-red-500 @enderror"
                    >
                        <option value="">اختر المشرف</option>
                        @foreach($supervisors as $supervisor)
                            <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
                        @endforeach
                    </select>
                    @error('form.supervisor_id')
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
                            wire:model="form.year"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('form.year') border-red-500 @enderror"
                        >
                            <option value="">اختر السنة</option>
                            @foreach($years as $y)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endforeach
                        </select>
                        @error('form.year')
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
                            wire:model="form.department_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('form.department_id') border-red-500 @enderror"
                        >
                            <option value="">اختر التخصص</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                        @error('form.department_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Defense Date -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="defenseDate" class="block text-sm font-semibold text-gray-700 mb-2">
                            تاريخ المناقشة <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="date"
                            id="defenseDate"
                            wire:model="form.defenseDate"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('form.defenseDate') border-red-500 @enderror"
                        >
                        @error('form.defenseDate')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
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
