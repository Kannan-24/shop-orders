<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="{{ asset('assets/logo.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 px-3">
            <div class="w-full flex justify-center sm:justify-start">
            <a href="/">
                <div class="relative sm:absolute sm:top-6 sm:left-6 flex justify-center">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="w-24 h-24 sm:w-32 sm:h-32" />
                </div>
            </a>
            </div>

            <div class="w-full max-w-xs sm:max-w-md mt-6 px-4 sm:px-6 py-4 bg-white shadow-md overflow-hidden rounded-lg sm:rounded-lg">
            {{ $slot }}
            </div>
        </div>
    </body>
</html>
