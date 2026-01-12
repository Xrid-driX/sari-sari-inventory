<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Icons (Lucide) -->
        <script src="https://unpkg.com/lucide@latest"></script>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <!--
            THEME BACKGROUND:
            A rich gradient from deep purple to indigo.
        -->
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-purple-900 via-purple-800 to-indigo-900 dark:bg-gray-900">

            <!-- Login Card -->
            <div class="w-full sm:max-w-lg mt-6 px-10 py-10 bg-white dark:bg-gray-800 shadow-2xl overflow-hidden rounded-3xl">
                {{ $slot }}
            </div>
        </div>
        <script>
            lucide.createIcons();
        </script>
    </body>
</html>
