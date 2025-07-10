<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name')->get();
        return view('cashier.index', compact('products'));
    }
}
