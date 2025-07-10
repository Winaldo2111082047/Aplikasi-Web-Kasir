<?php

namespace App\Providers;

use App\Models\User; // <-- Tambahkan ini
use Illuminate\Support\Facades\Gate; // <-- Tambahkan ini
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // --- TAMBAHKAN KODE GATE DI SINI ---
        Gate::define('is-admin', function (User $user) {
            return $user->role === 'admin';
        });
        // --- BATAS KODE TAMBAHAN ---
    }
}
