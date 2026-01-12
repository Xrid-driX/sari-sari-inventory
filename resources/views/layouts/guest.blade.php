<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sari-Sari Inventory') }}</title>

        <!-- 1. BROWSER TAB LOGO (FAVICON) -->
        <!-- Make sure you have a file at public/images/logo.png -->
        <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Icons -->
        <script src="https://unpkg.com/lucide@latest"></script>
    </head>
    <body class="font-sans text-gray-900 antialiased">

        <!-- CENTERED FLOATING CARD LAYOUT -->
        <!-- Background: Light gray to make the card pop -->
        <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 p-4">

            <!-- MAIN CARD CONTAINER -->
            <!-- max-w-4xl limits the width, rounded-3xl gives curved corners, shadow-2xl gives depth -->
            <div class="w-full max-w-5xl bg-white dark:bg-gray-800 shadow-2xl overflow-hidden rounded-3xl flex flex-col md:flex-row">

                <!-- LEFT COLUMN: Form Area -->
                <div class="w-full md:w-1/2 p-8 sm:p-12 flex items-center justify-center bg-white dark:bg-gray-800">
                    <div class="w-full max-w-sm space-y-6">
                        <!-- Login Form Slot -->
                        {{ $slot }}
                    </div>
                </div>

                <!-- RIGHT COLUMN: Theme/Branding Area -->
                <!-- Hidden on small screens (md:block) -->
                <div class="hidden md:flex w-1/2 bg-purple-900 relative overflow-hidden items-center justify-center p-12">

                     <!-- Background Gradient -->
                     <div class="absolute inset-0 bg-gradient-to-br from-purple-600 via-purple-800 to-indigo-900 opacity-90"></div>

                     <!-- Content -->
                     <div class="relative z-10 text-center text-white">
                         <div class="mb-6 flex justify-center">
                            <!-- 2. MAIN LOGO IMAGE -->
                            <!-- We replaced the component with a standard img tag -->
                            <div class="bg-white/20 p-4 rounded-full backdrop-blur-sm">
                                <img src="{{ asset('images/logo.png') }}" alt="Store Logo" class="w-20 h-20 object-contain">
                            </div>
                         </div>
                         <h2 class="text-3xl font-bold mb-4 tracking-tight">Amberlee Sari-Sari Inventory</h2>
                         <p class="text-purple-100 text-base leading-relaxed">
                            "Ang tindahan na laging maaasahan."<br>
                            Manage your stocks and sales with ease.
                         </p>
                     </div>

                     <!-- Decorative Shapes -->
                     <div class="absolute top-0 right-0 -mr-12 -mt-12 w-64 h-64 rounded-full bg-purple-500 opacity-20 blur-3xl"></div>
                     <div class="absolute bottom-0 left-0 -ml-12 -mb-12 w-48 h-48 rounded-full bg-indigo-500 opacity-30 blur-3xl"></div>
                </div>

            </div>
        </div>
        <script>
            lucide.createIcons();
        </script>
    </body>
</html>
