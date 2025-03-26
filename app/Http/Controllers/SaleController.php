<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        try {
            $sale = $product->sell($request->quantity);
            return back()->with('success', 'فروش ثبت شد.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
