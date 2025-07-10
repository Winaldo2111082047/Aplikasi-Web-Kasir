<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <header class="mb-8">
            <h1 class="text-4xl font-extrabold text-gray-800 leading-tight">Manajemen Pengguna</h1>
            <p class="mt-2 text-lg text-gray-500">Atur semua akun pengguna yang terdaftar di sistem.</p>
        </header>
        <div>
            <div class="flex justify-end mb-4">
                <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-blue-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                    Tambah Pengguna
                </a>
            </div>
            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6" role="alert">
                    <p class="font-bold text-green-800">Sukses</p>
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            @endif
             @if (session('error'))
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6" role="alert">
                    <p class="font-bold text-red-800">Error</p>
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
            @endif
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <table class="min-w-full">
                    <thead class="border-b border-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Role</th>
                            <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-base font-semibold text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-3">
                                    <a href="{{ route('users.edit', $user->id) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                    @if(auth()->id() != $user->id)
                                    <span class="text-gray-300">|</span>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-10 text-gray-500">Tidak ada data pengguna.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">{{ $users->links() }}</div>
        </div>
    </div>
</x-app-layout>
