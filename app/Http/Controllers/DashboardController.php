<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();
        $salesToday = Sale::whereDate('sale_date', $today)->get();
        $totalRevenue = $salesToday->sum('total_price');
        $bestSellingProduct = Sale::whereDate('sale_date', $today)
            ->selectRaw('product_id, SUM(quantity) as total_quantity')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->first();

        return view('dashboard', compact('salesToday', 'totalRevenue', 'bestSellingProduct'));
    }
}
