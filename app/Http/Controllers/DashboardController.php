<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();
        $salesToday = Sale::whereDate('created_at', $today)->get();
//        $totalRevenue = $salesToday->sum(fn($sale) => $sale->total_price * $sale->quantity);
        $totalRevenue = $salesToday->sum('total_price');

        $bestSellingProduct = Sale::whereDate('created_at', $today)
            ->selectRaw('product_id, SUM(quantity) as total_quantity')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->first();


        return view('dashboard', compact('salesToday', 'totalRevenue', 'bestSellingProduct'));
    }
}
