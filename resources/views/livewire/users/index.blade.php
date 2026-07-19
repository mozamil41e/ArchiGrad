<div>

    <!-- Page Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">إدارة المستخدمين</h2>
                    <p class="text-gray-600">إدارة حسابات المستخدمين وصلاحياتهم في النظام</p>
                </div>
                <button
                    wire:click="openModal"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-md"
                >
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    إضافة مستخدم جديد
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-grow">

        <!-- Success Message -->
        @if (session()->has('message'))
            <x-messages.success>{{ session('message') }}</x-messages.success>
        @endif

        <!-- Error Message -->
        @if (session()->has('error'))
            <x-messages.erorr>{{ session('error') }}</x-messages.erorr>
        @endif

        <!-- Search -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 mb-8">
            <div class="max-w-md">
                <div class="relative">
                    <input
                        type="text"
                        wire:model.live.debounce.500ms="search"
                        placeholder="ابحث بالاسم أو البريد الإلكتروني..."
                        class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-sm font-bold text-gray-700">الاسم</th>
                            <th class="px-6 py-4 text-sm font-bold text-gray-700">البريد الإلكتروني</th>
                            <th class="px-6 py-4 text-sm font-bold text-gray-700">الدور</th>
                            <th class="px-6 py-4 text-sm font-bold text-gray-700">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $user->name }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-0.5 inline-flex text-xs font-bold rounded-full {{ $user->role === \App\Enums\Role::Admin ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-700' }}">
                                        {{ $user->role->label() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-reverse space-x-2">
                                        <button wire:click="edit({{ $user->id }})" class="text-blue-600 hover:text-blue-900 p-1" title="تعديل">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <button wire:click="confirmDelete({{ $user->id }})" class="text-red-600 hover:text-red-900 p-1" title="حذف">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                    لا يوجد مستخدمون مطابقون للبحث
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-100 px-6 py-4">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <!-- Results Info -->
                    <div class="text-sm text-gray-500">
                        عرض <span class="font-semibold text-gray-900">{{ $users->firstItem() ?? 0 }}</span> إلى
                        <span class="font-semibold text-gray-900">{{ $users->lastItem() ?? 0 }}</span> من
                        <span class="font-semibold text-gray-900">{{ $users->total() }}</span> مستخدم
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex items-center space-x-reverse space-x-3">
                        <button
                            wire:click="previousPage"
                            wire:loading.attr="disabled"
                            @if($users->onFirstPage()) disabled @endif
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium transition-all duration-200
                            {{ $users->onFirstPage() ? 'text-gray-300 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-50 hover:border-blue-300 hover:text-blue-600 shadow-sm' }}"
                        >
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            السابق
                        </button>

                        <div class="flex items-center px-4 h-9 bg-gray-50 rounded-lg text-xs font-semibold text-gray-600 border border-gray-100">
                            صفحة {{ $users->currentPage() }} من {{ $users->lastPage() }}
                        </div>

                        <button
                            wire:click="nextPage"
                            wire:loading.attr="disabled"
                            @if(!$users->hasMorePages()) disabled @endif
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium transition-all duration-200
                            {{ !$users->hasMorePages() ? 'text-gray-300 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-50 hover:border-blue-300 hover:text-blue-600 shadow-sm' }}"
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
    </main>

    <!-- Modal (Add/Edit) -->
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">{{ $isEditMode ? 'تعديل المستخدم' : 'إضافة مستخدم جديد' }}</h3>
                    <form wire:submit.prevent="save">
                        <div class="space-y-4 text-right">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">الاسم</label>
                                <input
                                    type="text"
                                    wire:model="form.name"
                                    x-init="$nextTick(() => $el.focus())"
                                    class="w-full px-4 py-2 border @error('form.name') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                                    placeholder="مثال: أحمد محمد"
                                >
                                @error('form.name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">البريد الإلكتروني</label>
                                <input
                                    type="email"
                                    wire:model="form.email"
                                    class="w-full px-4 py-2 border @error('form.email') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                                    placeholder="example@domain.com"
                                >
                                @error('form.email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    كلمة المرور
                                    @if($isEditMode)
                                        <span class="text-gray-400 font-normal">(اتركها فارغة للإبقاء على كلمة المرور الحالية)</span>
                                    @endif
                                </label>
                                <input
                                    type="password"
                                    wire:model="form.password"
                                    class="w-full px-4 py-2 border @error('form.password') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                                    placeholder="********"
                                >
                                @error('form.password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">الدور</label>
                                <select
                                    wire:model="form.role"
                                    class="w-full px-4 py-2 border @error('form.role') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                                >
                                    @foreach($roles as $roleOption)
                                        <option value="{{ $roleOption->value }}">{{ $roleOption->label() }}</option>
                                    @endforeach
                                </select>
                                @error('form.role') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-reverse space-x-3">
                            <button type="button" wire:click="closeModal" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">إلغاء</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                <span wire:loading.remove wire:target="save">{{ $isEditMode ? 'حفظ التعديلات' : 'إضافة المستخدم' }}</span>
                                <span wire:loading wire:target="save">جاري الحفظ...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    <livewire:shared.delete-modal />

    <x-footer />
</div>
