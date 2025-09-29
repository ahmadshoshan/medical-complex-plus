<!DOCTYPE html>
<html lang="ar">

</html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>



    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])




    <title>إدارة المجمع الطبي</title>
      <!-- تم إزالة Tailwind CDN واستبداله بأسلوب داخلي لضمان العمل بدون انترنت -->
    <style>
        body {
            font-family: Arial, sans-serif;
            direction: rtl; /* Set text direction to right-to-left for Arabic */
        }
        /* Tailwind CSS equivalent classes for offline functionality */
        .bg-gray-100 { background-color: #f3f4f6; }
        .flex { display: flex; }
        .items-center { align-items: center; }
        .justify-center { justify-content: center; }
        .min-h-screen { min-height: 100vh; }
        .p-4 { padding: 1rem; }
        .bg-white { background-color: #ffffff; }
        .rounded-3xl { border-radius: 1.5rem; }
        .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
        .p-8 { padding: 2rem; }
        .sm\:p-12 { padding: 3rem; }
        .w-full { width: 100%; }
        .max-w-lg { max-width: 32rem; }
        .text-center { text-align: center; }
        .transform { transform: scale(1); }
        .transition-all { transition-property: all; }
        .duration-300 { transition-duration: 300ms; }
        .hover\:scale-105:hover { transform: scale(1.05); }
        .mb-6 { margin-bottom: 1.5rem; }
        .h-20 { height: 5rem; }
        .w-20 { width: 5rem; }
        .text-blue-500 { color: #3b82f6; }
        .mx-auto { margin-left: auto; margin-right: auto; }
        .text-3xl { font-size: 1.875rem; line-height: 2.25rem; }
        .sm\:text-4xl { font-size: 2.25rem; line-height: 2.5rem; }
        .font-extrabold { font-weight: 800; }
        .text-blue-800 { color: #1e40af; }
        .mb-4 { margin-bottom: 1rem; }
        .text-gray-600 { color: #4b5563; }
        .mb-8 { margin-bottom: 2rem; }
        .text-sm { font-size: 0.875rem; line-height: 1.25rem; }
        .sm\:text-base { font-size: 1rem; line-height: 1.5rem; }
        .flex-col { flex-direction: column; }
        .sm\:flex-row { flex-direction: row; }
        .gap-4 { gap: 1rem; }
        .justify-center { justify-content: center; }
        .bg-blue-600 { background-color: #2563eb; }
        .text-white { color: #ffffff; }
        .font-bold { font-weight: 700; }
        .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
        .px-8 { padding-left: 2rem; padding-right: 2rem; }
        .rounded-full { border-radius: 9999px; }
        .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
        .hover\:bg-blue-700:hover { background-color: #1d4ed8; }
        .bg-blue-100 { background-color: #dbeafe; }
        .text-blue-700 { color: #1d4ed8; }
        .hover\:bg-blue-200:hover { background-color: #bfdbfe; }
        a { text-decoration: none; } /* Ensure links are styled correctly */
    </style>

</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    <!-- Main Card Container -->
    <div class="bg-white rounded-3xl shadow-2xl p-8 sm:p-12 w-full max-w-lg text-center transform transition-all duration-300 hover:scale-105">

        <!-- Hospital Icon (or Image) -->
        <div class="mb-6">
            <svg class="h-20 w-20 text-blue-500 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm.5 14h-1V9h1v7zm-1-8H12v-1h-.5V8zM12 11c-2.21 0-4 1.79-4 4h-2c0-3.31 2.69-6 6-6s6 2.69 6 6h-2c0-2.21-1.79-4-4-4z" />
                <path d="M12 11h-1v-1h1v1z" />
            </svg>
        </div>

        <!-- Title -->
        <h1 class="text-3xl sm:text-4xl font-extrabold text-blue-800 mb-4">
            أهلاً بك في نظام إدارة <br /> المجمع الطبي
        </h1>

        <!-- Description -->
        <p class="text-gray-600 mb-8 text-sm sm:text-base">
            يسعدنا أن تكون جزءاً من فريقنا. الرجاء اختيار الخيار المناسب للمتابعة.
        </p>

        <!-- Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/tv/t-v" class="bg-blue-600 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:bg-blue-700 transition duration-300">
                شاشة العرض
            </a>
            <a href="/admin" class="bg-blue-100 text-blue-700 font-bold py-3 px-8 rounded-full shadow-lg hover:bg-blue-200 transition duration-300">
                لوحة الإدارة
            </a>
        </div>
    </div>

</body>

</html>
