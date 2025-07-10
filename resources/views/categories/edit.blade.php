<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {{-- HEADER HALAMAN --}}
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">
                Edit Kategori
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                Perbarui nama untuk kategori ini.
            </p>
        </header>

        {{-- KARTU FORM --}}
        <div class="bg-white shadow-md rounded-lg">
            {{-- Perhatikan action dan method form di sini --}}
            <form method="POST" action="{{ route('categories.update', $category->id) }}">
                @csrf
                @method('PUT')
                {{-- Bagian Isi Form --}}
                <div class="p-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Nama Kategori
                        </label>
                        <div class="mt-1">
                            {{-- Perhatikan value input di sini --}}
                            <input type="text" name="name" id="name"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                   value="{{ old('name', $category->name) }}"
                                   required>
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Bagian Tombol Aksi --}}
                <div class="px-6 py-4 bg-gray-50 text-right">
                    <a href="{{ route('categories.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex justify-center ml-3 px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
