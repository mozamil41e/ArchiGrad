<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام أرشفة مشاريع التخرج</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Google Fonts - Cairo -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }
        .error-glow {
            text-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Navigation Bar -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-reverse space-x-8">
                    <h1 class="text-xl font-bold text-blue-600">نظام أرشفة المشاريع</h1>
                </div>
                <div class="flex items-center space-x-reverse space-x-6 text-sm">
                    <a href="{{ route('home') }}" class="text-blue-600 font-semibold hover:text-blue-700 transition">الرئيسية</a>
                    <a href="{{ route('projects.index') }}" class="text-gray-600 hover:text-blue-600 transition">البحث</a>
                    <a href="categories.html" class="text-gray-600 hover:text-blue-600 transition">التصنيفات</a>
                    <a href="admin-archive.html" class="text-gray-600 hover:text-blue-600 transition">أرشفة مشروع</a>
                    <a href="admin-users.html" class="text-gray-600 hover:text-blue-600 transition">إدارة المستخدمين</a>
                    <a href="admin-supervisors.html" class="text-gray-600 hover:text-blue-600 transition">إدارة المشرفين</a>
                    <a href="admin-departments.html" class="text-gray-600 hover:text-blue-600 transition">إدارة الأقسام</a>
                    <div class="h-6 w-px bg-gray-200"></div>
                    <a href="login.html" class="text-gray-600 hover:text-blue-600 transition">دخول</a>
                    <a href="register.html" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-sm">تسجيل</a>
                </div>
            </div>
        </div>
    </nav>


   <!-- Main -->
      {{ $slot }}



</body>
</html>
