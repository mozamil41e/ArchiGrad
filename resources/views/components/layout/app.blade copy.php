<!DOCTYPE html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>لوحة التحكم — نظام إدارة المشاريع</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: {
              sans: ["Cairo", "Inter", "ui-sans-serif", "system-ui", "Segoe UI", "Roboto", "Helvetica Neue", "Arial"],
            },
            boxShadow: {
              soft: "0 10px 25px -5px rgba(0,0,0,0.15), 0 8px 10px -6px rgba(0,0,0,0.1)",
            },
          },
        },
      };
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  </head>
  <body class="min-h-screen bg-slate-50 font-sans text-slate-800">
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-[280px_1fr]">
      <!-- Sidebar -->
      <aside class="bg-gradient-to-b from-indigo-600 via-purple-600 to-pink-600 text-white p-6 lg:min-h-screen">
        <div class="flex items-center gap-3 mb-8">
          <div class="h-10 w-10 rounded-xl bg-white/20 flex items-center justify-center">
            <!-- Heroicon: academic-cap -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 14.25L3.75 9.75 12 5.25 20.25 9.75 12 14.25zM3.75 14.25L12 18.75l8.25-4.5M12 18.75V21" />
            </svg>
          </div>
            <div>
              <div class="text-lg font-semibold">نظام إدارة المشاريع</div>
              <div class="text-xs text-white/80">إدارة المشاريع الأكاديمية</div>
            </div>
        </div>
       
        <nav class="space-y-1">


          <x-nav-link href="{{ route('dashboard') }} " :active="request()->is('dashboard')">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.125 1.125 0 011.591 0L21.75 12" /><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5V21h15V10.5" /></svg>
    
               <span>لوحة التحكم</span>    
          </x-nav-link>


          <x-nav-link href="{{ route('projects') }}" :active="request()->is('projects')">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V6.75A2.25 2.25 0 014.5 4.5h4.318c.414 0 .816.165 1.109.458l2.565 2.565c.293.293.695.457 1.11.457H19.5a2.25 2.25 0 012.25 2.25v7.5A2.25 2.25 0 0119.5 21H4.5A2.25 2.25 0 012.25 18.75v-6z"/></svg>
           
           <span>المشاريع</span>
          </x-nav-link>

        
          {{-- <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/15 hover:bg-white/20 transition {{ $activeRoute === 'dashboard' ? 'bg-white/20' : '' }}">
            <!-- Home -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.125 1.125 0 011.591 0L21.75 12" /><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5V21h15V10.5" /></svg>
            <span>لوحة التحكم</span>
          </a>

          <a href="{{ route('projects') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition {{ $activeRoute == 'projects' ? 'bg-white/20' : '' }}">
            <!-- Folder -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V6.75A2.25 2.25 0 014.5 4.5h4.318c.414 0 .816.165 1.109.458l2.565 2.565c.293.293.695.457 1.11.457H19.5a2.25 2.25 0 012.25 2.25v7.5A2.25 2.25 0 0119.5 21H4.5A2.25 2.25 0 012.25 18.75v-6z"/></svg>
            <span>المشاريع</span>
          </a>

          <a href="evaluations.html" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition">
            <!-- Clipboard Document Check -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75l2.25 2.25L15 11.25M9.75 6.75h4.5m-8.25 0h.008v.008H6V6.75z"/><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75A2.25 2.25 0 016 4.5h12a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25H6A2.25 2.25 0 013.75 18V6.75z"/></svg>
            <span>التقييمات</span>
          </a>

          <a href="archive.html" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition">
            <!-- Archive box -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 7.5h16.5M5.25 7.5V18a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25V7.5M9 7.5V6.75A2.25 2.25 0 0111.25 4.5h1.5A2.25 2.25 0 0115 6.75V7.5"/></svg>
            <span>الأرشيف</span>
          </a>

          <a href="settings.html" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition">
            <!-- Cog -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h3m-7.5 6h12m-9 6h6"/></svg>
            <span>الإعدادات</span>
          </a>
           --}}
        </nav>
      </aside>

      <!-- Main -->
      {{ $slot }}




    </div>
  </body>
  </html>


