<x-layout.app>
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-blue-50 to-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                نظام أرشفة مشاريع التخرج
            </h2>
            <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                منصة شاملة لأرشفة واسترجاع مشاريع التخرج الجامعية بسهولة وفعالية
            </p>

            <!-- Search Bar -->
            <div class="max-w-2xl mx-auto">
                <form action="search.html" method="get" class="relative">
                    <input
                        type="text"
                        name="q"
                        placeholder="ابحث عن مشروع بالعنوان، الطالب، أو المشرف..."
                        class="w-full px-6 py-4 pr-12 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:outline-none text-lg shadow-sm"
                    >
                    <button type="submit" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Quick Links -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Link 1: البحث -->
                <a href="{{ route('projects.index') }}" class="group block p-6 bg-gradient-to-br from-blue-50 to-white border border-gray-200 rounded-lg hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg mb-4 group-hover:bg-blue-600 transition">
                        <svg class="w-6 h-6 text-blue-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">البحث المتقدم</h3>
                    <p class="text-gray-600">ابحث في قاعدة بيانات المشاريع باستخدام فلاتر متقدمة</p>
                </a>

                <!-- Link 2: التصنيفات -->
                <a href="categories.html" class="group block p-6 bg-gradient-to-br from-green-50 to-white border border-gray-200 rounded-lg hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg mb-4 group-hover:bg-green-600 transition">
                        <svg class="w-6 h-6 text-green-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">التصنيفات</h3>
                    <p class="text-gray-600">تصفح المشاريع حسب التخصص أو السنة الأكاديمية</p>
                </a>

                <!-- Link 3: حول النظام -->
                <a href="#about" class="group block p-6 bg-gradient-to-br from-purple-50 to-white border border-gray-200 rounded-lg hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center justify-center w-12 h-12 bg-purple-100 rounded-lg mb-4 group-hover:bg-purple-600 transition">
                        <svg class="w-6 h-6 text-purple-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">حول النظام</h3>
                    <p class="text-gray-600">تعرف على المزيد حول نظام الأرشفة وكيفية استخدامه</p>
                </a>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-2xl font-bold text-center text-gray-900 mb-10">إحصائيات النظام</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Stat 1 -->
                <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 text-center">
                    <div class="text-4xl font-bold text-blue-600 mb-2">{{ $archived_projects }}</div>
                    <div class="text-gray-600">مشروع مؤرشف</div>
                </div>

                <!-- Stat 2 -->
                <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 text-center">
                    <div class="text-4xl font-bold text-blue-600 mb-2">{{ $new_projects }}</div>
                    <div class="text-gray-600">مشروع جديد</div>
                </div>

                <!-- Stat 3 -->
                <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 text-center">
                    <div class="text-4xl font-bold text-green-600 mb-2">{{ $total_departments }}</div>
                    <div class="text-gray-600">تخصص أكاديمي</div>
                </div>

                <!-- Stat 4 -->
                <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 text-center">
                    <div class="text-4xl font-bold text-purple-600 mb-2">{{ $distinct_years }}</div>
                    <div class="text-gray-600">سنوات من الأرشفة</div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h3 class="text-3xl font-bold text-gray-900 mb-6">حول النظام</h3>
            <p class="text-lg text-gray-600 leading-relaxed mb-6">
                نظام أرشفة مشاريع التخرج هو منصة رقمية متطورة تهدف إلى حفظ وتنظيم مشاريع التخرج الجامعية بطريقة منهجية وسهلة الوصول. يوفر النظام إمكانية البحث المتقدم والتصنيف حسب التخصصات والسنوات الأكاديمية.
            </p>
            <p class="text-lg text-gray-600 leading-relaxed">
                يساعد هذا النظام الطلاب والباحثين على الاستفادة من الأعمال السابقة، ويسهل على الأساتذة والمشرفين متابعة وتقييم المشاريع البحثية.
            </p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-gray-400 mb-2">نظام أرشفة مشاريع التخرج © 2025</p>
                <p class="text-gray-500 text-sm">جميع الحقوق محفوظة</p>
            </div>
        </div>
    </footer>
</x-layout.app>
