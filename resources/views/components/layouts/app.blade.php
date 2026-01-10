<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        {{-- Livewire --}}
        @livewireStyles

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Google Fonts - Cairo -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">

        <style>
            body {
                font-family: 'Cairo', sans-serif;
            }
            .error-glow {
                text-shadow: 0 0 20px rgba(214, 38, 161, 0.3);
            }
        </style>

        <title>{{ $title ?? 'نظام أرشفة مشاريع التخرج' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <!-- Navigation Bar -->
        <nav x-data="{ open: false }" class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <a wire:navigate href="{{ route('home.reports') }}">
                        <div class="flex items-center">
                            <h1 class="text-xl font-bold text-pink-500">نظام أرشفة المشاريع</h1>
                        </div>
                    </a>

                    <!-- Desktop Menu -->
                    <div class="hidden md:flex items-center space-x-reverse space-x-6 text-sm">
                        <x-nav-link href="{{ route('home.page') }}" active="home.page">
                            الرئيسية
                        </x-nav-link>

                        <x-nav-link href="{{ route('projects-live.index') }}" active="projects-live.*">
                            المشاريع
                        </x-nav-link>

                        <x-nav-link href="{{ route('home.categorys') }}" active="home.categorys">
                            التصنيفات
                        </x-nav-link>

                        <x-nav-link href="{{ route('departments-live.index') }}" active="departments-live.index">
                            إدارة الاقسام
                        </x-nav-link>

                        <x-nav-link href="{{ route('supervisors-live.index') }}" active="supervisors-live.index">
                            إدارة المشرفين
                        </x-nav-link>

                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="md:hidden flex items-center">
                        <button @click="open = !open" class="text-gray-500 hover:text-pink-500 focus:outline-none transition-colors">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                <path x-show="open" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="open" x-cloak x-transition class="md:hidden border-t border-gray-100 bg-white px-4 pt-2 pb-4 space-y-1">
                <div class="flex flex-col space-y-2">
                    <x-nav-link href="{{ route('home.page') }}" active="home.page">
                        الرئيسية
                    </x-nav-link>

                    <x-nav-link href="{{ route('projects-live.index') }}" active="projects-live.*">
                        المشاريع
                    </x-nav-link>

                    <x-nav-link href="{{ route('home.categorys') }}" active="home.categorys">
                        التصنيفات
                    </x-nav-link>

                    <x-nav-link href="{{ route('departments-live.index') }}" active="departments-live.index">
                        إدارة الاقسام
                    </x-nav-link>
                </div>
            </div>
        </nav>

        {{ $slot }}

        {{-- Livewire --}}
        @livewireScripts
    </body>
</html>
