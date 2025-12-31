<x-layout.app>
 <div class="min-h-screen flex items-center justify-center">
     <div class="max-w-4xl w-full text-center">
        <!-- Error Illustration/Icon -->
        <div class="mb-12 relative inline-block">
            <div class="text-[120px] md:text-[180px] font-black text-blue-600 opacity-10 leading-none select-none">404</div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="bg-white p-8 rounded-2xl shadow-xl border border-blue-50">
                     <svg class="w-24 h-24 text-blue-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Error Message -->
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 transition-all hover:scale-105 duration-300">
            عذراً، لم نتمكن من العثور على هذه الصفحة!
        </h1>
        <p class="text-lg text-gray-600 mb-10 max-w-lg mx-auto leading-relaxed">
            يبدو أن الرابط الذي تحاول الوصول إليه غير موجود، أو ربما تم نقله إلى مكان آخر. لا تقلق، يمكنك العودة والبدء من جديد.
        </p>

        <!-- CTAs -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('home.reports') }}" class="w-full sm:w-auto px-8 py-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg hover:shadow-blue-200 group flex items-center justify-center gap-2">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m12 0l-4-4m4 4l-4 4"></path>
                </svg>
                <span>العودة للرئيسية</span>
            </a>
            <a href="{{ route('projects.index') }}" class="w-full sm:w-auto px-8 py-4 bg-white text-gray-700 font-bold border-2 border-gray-200 rounded-xl hover:border-blue-500 hover:text-blue-600 transition flex items-center justify-center gap-2">
                <svg class="w-5 h-5 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <span>ابحث عن مشروع</span>
            </a>
        </div>

        <!-- Footer Info -->
        <div class="mt-20 border-t border-gray-200 pt-8">
            <p class="text-sm text-gray-400">ArchiGrad &copy; <span x-text="new Date().getFullYear()"></span> - جميع الحقوق محفوظة</p>
        </div>
    </div>
    </div>

</x-layout.app>
