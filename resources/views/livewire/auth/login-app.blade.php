<div>
  <main class="flex-grow flex items-center justify-center mt-20 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-2xl shadow-xl border border-gray-100">
      <div class="text-center">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-2">
          تسجيل الدخول
        </h2>
        <p class="text-gray-600">
          مرحباً بك مجدداً، سجل الدخول للوصول إلى حسابك
        </p>
      </div>

      <form wire:submit="submitForm" class="mt-8 space-y-6">
        <div class="space-y-4">
          <!-- Email -->
          <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
              البريد الإلكتروني
            </label>
            <input
              id="email"
              type="email"
              wire:model="email"
              class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
              :class="@error('email') 'border-red-500' @enderror"
              placeholder="example@univ.edu.sa"
            />
            @error('email')
              <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Password -->
          <div>
            <div class="flex items-center justify-between mb-2">
              <label for="password" class="block text-sm font-semibold text-gray-700">
                كلمة المرور
              </label>
              {{-- <a href="#" class="text-xs font-semibold text-blue-600 hover:text-blue-500">
                نسيت كلمة المرور؟
              </a> --}}
            </div>
            <input
              id="password"
              type="password"
              wire:model="password"
              class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
              :class="@error('password') 'border-red-500' @enderror"
              placeholder="••••••••"
            />
            @error('password')
              <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <div class="flex items-center">
          <input
            id="remember-me"
            type="checkbox"
            wire:model="rememberMe"
            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
          />
          <label for="remember-me" class="mr-2 block text-sm text-gray-700">
            تذكرني
          </label>
        </div>

        <div>
          <button
            wire:loading.attr="disabled"
            type="submit"
            class="group relative w-full flex justify-center items-center py-3 px-4 border border-transparent text-sm font-bold rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition shadow-lg"
          >
            <!-- نص الزر العادي يظهر عندما لا يكون هناك تحميل -->
            <span wire:loading.remove>تسجيل الدخول</span>

            <!-- نص التحميل يظهر أثناء التحميل -->
            <span wire:loading class="flex items-center gap-2">
              <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
              </svg>
            </span>
          </button>
        </div>

        {{-- <div class="text-center text-sm">
          <span class="text-gray-600">ليس لديك حساب؟</span>
          <a href="/register" class="font-bold text-blue-600 hover:text-blue-500 mr-1">
            سجل الآن
          </a>
        </div> --}}
      </form>
    </div>
  </main>
</div>
