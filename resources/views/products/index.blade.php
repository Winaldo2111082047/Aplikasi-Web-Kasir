<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <!-- HEADER HALAMAN -->
        <header class="mb-8">
            <h1 class="text-4xl font-extrabold text-gray-800 leading-tight">
                Manajemen Produk
            </h1>
            <p class="mt-2 text-lg text-gray-500">
                Atur semua produk yang dijual di toko Anda.
            </p>
        </header>

        <!-- AREA KONTEN UTAMA -->
        <div>
            <!-- AREA TOMBOL DAN PENCARIAN -->
            <div class="flex justify-between items-center mb-4">
                <!-- Form Pencarian -->
                <form action="{{ route('products.index') }}" method="GET">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Cari produk..."
                               class="pl-10 pr-4 py-2 border rounded-lg"
                               value="{{ request('search') }}">
                        <div class="absolute top-0 left-0 inline-flex items-center p-2">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                </form>

                <!-- Tombol Tambah -->
                <a href="{{ route('products.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-transform transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                    Tambah Produk
                </a>
            </div>

            <!-- PESAN SUKSES -->
            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6" role="alert">
                    <div class="flex">
                        <div class="py-1">
                            <svg class="h-6 w-6 text-green-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold text-green-800">Sukses</p>
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- TABEL PRODUK -->
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <table class="min-w-full">
                    <thead class="border-b border-gray-200">
                        <tr>
                            {{-- Kolom baru untuk gambar --}}
                            <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Gambar</th>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Produk</th>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Kategori</th>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Harga</th>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Stok</th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Aksi</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($products as $product)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            {{-- Tampilkan gambar di sini --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-12 w-12 object-cover rounded-md">
                                @else
                                    <div class="h-12 w-12 bg-gray-200 flex items-center justify-center rounded-md">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"></path></svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-base font-semibold text-gray-900">{{ $product->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->category->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->stock }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-3">
                                    <a href="{{ route('products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-800 transition">Edit</a>
                                    <span class="text-gray-300">|</span>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 transition">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-10 text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    <p class="mt-4">Tidak ada produk yang cocok dengan pencarian Anda.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
             <!-- PAGINATION -->
             <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
