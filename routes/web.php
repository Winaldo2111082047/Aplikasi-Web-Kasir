<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return app(DashboardController::class)->index();
    } else {
        return redirect()->route('kasir.index');
    }
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'verified'])->group(function () {

    // Rute yang bisa diakses SEMUA role (admin dan kasir)
    Route::get('/kasir', [CashierController::class, 'index'])->name('kasir.index');
    Route::post('/transaksi', [TransactionController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{transaction}/nota', [TransactionController::class, 'show'])->name('transaksi.show');

    // Grup rute yang dilindungi oleh middleware 'is-admin'
    Route::middleware('is-admin')->group(function () {
        // Kita tidak perlu lagi mendefinisikan /dashboard di sini
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::get('/laporan', [TransactionController::class, 'index'])->name('laporan.index');

        // --- TAMBAHKAN BARIS INI ---
        Route::get('/laporan/pdf', [TransactionController::class, 'exportPDF'])->name('laporan.pdf');

        Route::resource('users', UserController::class);
    });
});

require __DIR__.'/auth.php';
