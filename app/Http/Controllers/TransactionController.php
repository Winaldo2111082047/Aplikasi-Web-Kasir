<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf; // <-- Tambahkan ini

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('details.product');

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $transactions = $query->latest()->paginate(10)->withQueryString();

        return view('transactions.index', compact('transactions'));
    }

    // --- TAMBAHKAN FUNGSI BARU INI ---
    public function exportPDF(Request $request)
    {
        // Logika filter sama persis dengan fungsi index()
        $query = Transaction::with('details.product');

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Ambil semua data tanpa paginasi
        $transactions = $query->latest()->get();

        // Siapkan data untuk dikirim ke view PDF
        $data = [
            'transactions' => $transactions,
            'startDate' => $request->start_date,
            'endDate' => $request->end_date,
        ];

        // Buat PDF
        $pdf = Pdf::loadView('transactions.pdf', $data);

        // Download file PDF dengan nama laporan-penjualan.pdf
        return $pdf->download('laporan-penjualan-' . now()->format('d-m-Y') . '.pdf');
    }
    // --- BATAS FUNGSI BARU ---

    public function show(Transaction $transaction)
    {
        $transaction->load('details.product');
        return view('transactions.show', compact('transaction'));
    }

    public function store(Request $request)
    {
        // ... (kode fungsi store tidak berubah) ...
        $request->validate([
            'cart' => 'required|array|min:1',
            'cart.*.id' => 'required|exists:products,id',
            'cart.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();
            $cart = $request->cart;
            $totalAmount = 0;
            foreach ($cart as $item) {
                $product = Product::find($item['id']);
                if ($product->stock < $item['quantity']) {
                    DB::rollBack();
                    return response()->json(['message' => 'Stok untuk produk ' . $product->name . ' tidak mencukupi.'], 400);
                }
                $totalAmount += $product->price * $item['quantity'];
            }
            $transaction = Transaction::create([
                'total_amount' => $totalAmount,
            ]);
            foreach ($cart as $item) {
                $product = Product::find($item['id']);
                $transaction->details()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'subtotal' => $product->price * $item['quantity'],
                ]);
                $product->decrement('stock', $item['quantity']);
            }
            DB::commit();
            return response()->json(['message' => 'Transaksi berhasil disimpan!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan saat memproses transaksi.'], 500);
        }
    }
}
