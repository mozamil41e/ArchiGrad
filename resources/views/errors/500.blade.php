<x-layouts.app>
 <div class="min-h-screen flex items-center justify-center">
     <div class="max-w-4xl w-full text-center">
        <!-- Error Illustration/Icon -->
        <div class="mb-12 relative inline-block">
            <div class="text-[120px] md:text-[180px] font-black text-red-600 opacity-10 leading-none select-none">500</div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="bg-white p-8 rounded-2xl shadow-xl border border-red-50">
                     <svg class="w-24 h-24 text-red-500 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Error Message -->
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 transition-all hover:scale-105 duration-300">
            عذراً، حدث خطأ داخلي في الخادم!
        </h1>
        <p class="text-lg text-gray-600 mb-10 max-w-lg mx-auto leading-relaxed">
            نحن نواجه بعض المشاكل الفنية حالياً. فريقنا يعمل على إصلاحها. يرجى المحاولة مرة أخرى لاحقاً أو العودة للرئيسية.
        </p>

        <!-- CTAs -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('home.page') }}" class="w-full sm:w-auto px-8 py-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg hover:shadow-blue-200 group flex items-center justify-center gap-2">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m12 0l-4-4m4 4l-4 4"></path>
                </svg>
                <span>العودة للرئيسية</span>
            </a>
            <button onclick="window.location.reload()" class="w-full sm:w-auto px-8 py-4 bg-white text-gray-700 font-bold border-2 border-gray-200 rounded-xl hover:border-red-500 hover:text-red-600 transition flex items-center justify-center gap-2">
                <svg class="w-5 h-5 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                <span>تحديث الصفحة</span>
            </button>
        </div>

        <!-- Footer Info -->
        <div class="mt-12">
            <x-footer />
        </div>
    </div>
 </div>

 <style>
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin-slow {
        animation: spin-slow 8s linear infinite;
    }
 </style>
</x-layouts.app>
