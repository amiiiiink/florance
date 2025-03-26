<?php
namespace App\Http\Controllers;


use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function create()
    {
        $products = Product::all();
        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($request->product_id);
        $total_price = $product->sale_price * $request->quantity;

        Sale::create([
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'total_price' => $total_price,
            'sale_date' => now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'فروش با موفقیت ثبت شد.');
    }
}
