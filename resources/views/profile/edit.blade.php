<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Profil Saya</h1>
            <p class="text-gray-500 mt-1">Kelola informasi akun dan preferensi Anda.</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Kolom Kiri: Info Pengguna -->
            <div class="md:col-span-1">
                <div class="bg-white shadow-md rounded-lg p-6 text-center">
                    <img class="h-32 w-32 rounded-full object-cover mx-auto shadow-lg"
                         src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=FFFFFF&background=0284C7' }}"
                         alt="{{ $user->name }}">
                    <h2 class="mt-4 text-2xl font-bold text-gray-800">{{ $user->name }}</h2>
                    <p class="text-gray-500">{{ $user->email }}</p>
                    <span class="mt-4 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $user->role === 'admin' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
            </div>

            <!-- Kolom Kanan: Form Edit -->
            <div class="md:col-span-2 space-y-8">
                <!-- Bagian Informasi Profil -->
                <div class="bg-white shadow-md rounded-lg">
                    <div class="p-6 border-b">
                        <h2 class="text-xl font-semibold text-gray-800">Informasi Profil</h2>
                        <p class="mt-1 text-sm text-gray-600">Perbarui data profil dan alamat email Anda.</p>
                    </div>
                    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="p-6 space-y-6">
                            <!-- Unggah Foto Profil -->
                            <div>
                                <label for="avatar" class="block text-sm font-medium text-gray-700">Ganti Foto Profil</label>
                                <input type="file" name="avatar" id="avatar" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                            </div>

                            <!-- Nama -->
                            <div>
                                <x-input-label for="name" :value="__('Nama')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-gray-50 text-right flex items-center">
                            <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
                            @if (session('status') === 'profile-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 ml-4">{{ __('Tersimpan.') }}</p>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Bagian Update Password -->
                <div class="bg-white shadow-md rounded-lg">
                    <div class="p-6 border-b">
                        <h2 class="text-xl font-semibold text-gray-800">Update Password</h2>
                        <p class="mt-1 text-sm text-gray-600">Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.</p>
                    </div>
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')
                        <div class="p-6 space-y-6">
                            <div>
                                <x-input-label for="current_password" :value="__('Password Saat Ini')" />
                                <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="password" :value="__('Password Baru')" />
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" />
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-gray-50 text-right flex items-center">
                            <x-primary-button>{{ __('Simpan Password') }}</x-primary-button>
                            @if (session('status') === 'password-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 ml-4">{{ __('Tersimpan.') }}</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
