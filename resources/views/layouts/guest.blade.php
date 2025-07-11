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
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:flex-row">
            <!-- Kolom Kiri (Branding) -->
            <div class="w-full sm:w-1/2 bg-gradient-to-br from-blue-600 to-indigo-700 flex flex-col justify-center items-center p-12 text-white">
                <a href="/" class="flex flex-col items-center space-y-4 mb-8">
                    {{-- --- PERUBAHAN DI SINI --- --}}
                    {{-- Mengganti ikon dengan tag <img> untuk menampilkan logo Anda --}}
                    <img src="{{ asset('images/cashier11.png') }}" alt="Logo Kasir Ageng" class="w-28 h-28">

                    <span class="text-4xl font-bold">Kasir Ageng</span>
                </a>
                <p class="text-center text-indigo-200 text-lg max-w-sm">
                    Aplikasi Point of Sale modern untuk mengelola bisnis Anda dengan mudah dan efisien.
                </p>
            </div>

            <!-- Kolom Kanan (Form) -->
            <div class="w-full sm:w-1/2 flex justify-center items-center bg-slate-50">
                <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
