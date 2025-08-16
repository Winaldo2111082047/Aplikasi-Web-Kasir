<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Kasir Ageng') }}</title>

    <!-- Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Fonts Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite Scripts (Tailwind CSS & JS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-gray-50">

        <aside
            class="w-64 bg-white h-screen fixed border-r border-gray-200 transform transition-transform duration-300 ease-in-out z-50
                   md:translate-x-0"
            :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">

            <div class="p-6 border-b border-gray-200">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                     <div class="flex items-center justify-center w-10 h-10 bg-blue-600 rounded-lg shadow-lg">
                         <i class="fas fa-cash-register text-white text-xl"></i>
                     </div>
                    <span class="text-xl font-bold text-gray-800">Kasir Ageng</span>
                </a>
            </div>

            <nav class="mt-6 p-2">
                <p class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu</p>
                <ul class="space-y-1">
                    @can('is-admin')
                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center py-2.5 px-4 rounded-lg transition duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-900' }}">
                            <i class="fas fa-chart-pie w-6 text-center"></i>
                            <span class="ml-3 font-medium">Dashboard</span>
                        </a>
                    </li>
                    @endcan
                    <li>
                        <a href="{{ route('kasir.index') }}" class="flex items-center py-2.5 px-4 rounded-lg transition duration-200 {{ request()->routeIs('kasir.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-900' }}">
                            <i class="fas fa-cash-register w-6 text-center"></i>
                            <span class="ml-3 font-medium">Kasir</span>
                        </a>
                    </li>

                    @can('is-admin')
                    <p class="px-4 pt-4 pb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Manajemen</p>

                    <li>
                        <a href="{{ route('laporan.index') }}" class="flex items-center py-2.5 px-4 rounded-lg transition duration-200 {{ request()->routeIs('laporan.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-900' }}">
                            <i class="fas fa-file-alt w-6 text-center"></i>
                            <span class="ml-3 font-medium">Laporan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('products.index') }}" class="flex items-center py-2.5 px-4 rounded-lg transition duration-200 {{ request()->routeIs('products.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-900' }}">
                           <i class="fas fa-boxes w-6 text-center"></i>
                            <span class="ml-3 font-medium">Produk</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('categories.index') }}" class="flex items-center py-2.5 px-4 rounded-lg transition duration-200 {{ request()->routeIs('categories.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-900' }}">
                           <i class="fas fa-tags w-6 text-center"></i>
                            <span class="ml-3 font-medium">Kategori</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('users.index') }}" class="flex items-center py-2.5 px-4 rounded-lg transition duration-200 {{ request()->routeIs('users.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-900' }}">
                            <i class="fas fa-users-cog w-6 text-center"></i>
                            <span class="ml-3 font-medium">Pengguna</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </nav>
        </aside>

        <!-- Overlay untuk mobile -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"></div>

        <!-- B. KONTEN UTAMA -->
        <div class="flex-1 flex flex-col md:ml-64">
            <header class="bg-white p-4 flex items-center justify-between border-b border-gray-200">
                <div class="md:hidden">
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-md text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
                <div class="hidden md:block"></div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center space-x-2 p-1 rounded-full hover:bg-gray-100 transition">
                                    {{-- Tampilkan Avatar di sini --}}
                                    <img class="h-9 w-9 rounded-full object-cover" src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=7F9CF5&background=EBF4FF' }}" alt="{{ Auth::user()->name }}">
                                    <span class="text-gray-700 font-medium hidden md:inline">{{ Auth::user()->name }}</span>
                                    <i class="fas fa-chevron-down text-gray-500 text-xs"></i>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="px-4 py-3 border-b">
                                    <p class="text-sm">Masuk sebagai</p>
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>
