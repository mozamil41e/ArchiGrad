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
        <nav class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                <a wire:navigate href="{{ route('home.reports') }}">
                    <div class="flex items-center space-x-reverse space-x-8">
                            <h1 class="text-xl font-bold text-pink-500">نظام أرشفة المشاريع</h1>
                    </div>
                </a>
                    <div class="flex items-center space-x-reverse space-x-6 text-sm">


                        <x-nav-link href="/" active="home.page">
                            الرئيسية
                        </x-nav-link>

                        <x-nav-link href="/projects-live" active="projects-live.*">
                            المشاريع
                        </x-nav-link>

                        <x-nav-link href="/categorys" active="home.categorys">
                            التصنيفات
                        </x-nav-link>


                    </div>
                </div>
            </div>
        </nav>

        {{ $slot }}

        {{-- Livewire --}}
        @livewireScripts
    </body>
</html>
