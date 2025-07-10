<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // --- DATA UNTUK KARTU STATISTIK ---
        $todayIncome = Transaction::whereDate('created_at', Carbon::today())->sum('total_amount');
        $todayTransactions = Transaction::whereDate('created_at', Carbon::today())->count();
        $todayProductsSold = Transaction::whereDate('created_at', Carbon::today())
            ->with('details')
            ->get()
            ->sum(function ($transaction) {
                return $transaction->details->sum('quantity');
            });
        $totalUsers = User::count();

        // --- DATA BARU UNTUK GRAFIK PENJUALAN 7 HARI TERAKHIR ---
        $salesData = [];
        $dateLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $sales = Transaction::whereDate('created_at', $date)->sum('total_amount');

            // Simpan label tanggal (e.g., "09 Jul")
            $dateLabels[] = $date->format('d M');
            // Simpan data penjualan
            $salesData[] = $sales;
        }

        // Kirim semua data ke view
        return view('dashboard', compact(
            'todayIncome',
            'todayTransactions',
            'todayProductsSold',
            'totalUsers',
            'salesData', // Data penjualan untuk grafik
            'dateLabels' // Label tanggal untuk grafik
        ));
    }
}   
