<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Sale;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
//    public function index()
//    {
//        $today = now()->toDateString();
//
//        // دریافت فروش‌های امروز
//        $salesToday = Sale::whereDate('created_at', $today)->get();
//
//        // جمع کل تعداد محصولات فروخته شده امروز
//        $totalQuantity = $salesToday->sum('quantity');
//
//        // محاسبه مجموع کل قیمت‌ها بدون تخفیف
//        $totalRevenue = $salesToday->sum('total_price');
//
//        // جمع کل مقدار تخفیف‌های اعمال‌شده روی فاکتورها
//        $totalDiscount = $salesToday->sum('discount');
//
//        // محاسبه درآمد نهایی پس از کسر تخفیف
//        $finalRevenue = max($totalRevenue - $totalDiscount, 0);
//        $invoices = Invoice::whereDate('created_at', $today)->with('sales.product')->orderBy('created_at', 'desc')->get();
//
//        // پیدا کردن پرفروش‌ترین محصول امروز
//        $bestSellingProduct = Sale::whereDate('created_at', $today)
//            ->selectRaw('product_id, SUM(quantity) as total_quantity')
//            ->groupBy('product_id')
//            ->orderByDesc('total_quantity')
//            ->first();
//
//        return view('dashboard', compact('salesToday', 'totalQuantity', 'totalRevenue','invoices', 'totalDiscount', 'finalRevenue', 'bestSellingProduct'));
//    }

    public function index(){


        $today = now()->toDateString();

        // دریافت فروش‌های امروز با pagination

        $salesToday = Sale::whereDate('created_at', now()->toDateString())
            ->get();

        // جمع کل تعداد محصولات فروخته شده امروز
        $totalQuantity = $salesToday->sum('quantity');

        // محاسبه مجموع کل قیمت‌ها بدون تخفیف
        $totalRevenue = $salesToday->sum('total_price');

        // جمع کل مقدار تخفیف‌های اعمال‌شده روی فاکتورها
        $totalDiscount = $salesToday->sum('discount');

        // محاسبه درآمد نهایی پس از کسر تخفیف
        $finalRevenue = max($totalRevenue - $totalDiscount, 0);

        // فاکتورهای امروز با pagination
//        $invoices = Invoice::whereDate('created_at', $today)->with('sales.product')->orderBy('created_at', 'desc')->paginate(1); // paginate 10 records per page
        $invoices = Invoice::whereDate('created_at', now()->toDateString())->latest()
            ->paginate(10, ['*'], 'invoice_page');

        // پیدا کردن پرفروش‌ترین محصول امروز
        $bestSellingProduct = Sale::whereDate('created_at', $today)
            ->selectRaw('product_id, SUM(quantity) as total_quantity')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->first();

        return view('dashboard', compact('salesToday', 'totalQuantity', 'totalRevenue','invoices', 'totalDiscount', 'finalRevenue', 'bestSellingProduct'));
    }





}
