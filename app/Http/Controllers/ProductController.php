<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'purchase_unit' => 'required',
            'unit_per_purchase' => 'required|integer|min:1',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'محصول اضافه شد.');
    }
}
