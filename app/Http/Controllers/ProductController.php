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
    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'purchase_price' => 'required|string',
            'sale_price' => 'required|string',
            'purchase_unit' => 'required|in:carton,box,package,single',
            'items_per_unit' => 'required|integer|min:1',
        ]);
        $data = $request->all();
        $data['purchase_price'] = str_replace(',', '', $data['purchase_price']);
        $data['sale_price'] = str_replace(',', '', $data['sale_price']);

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'محصول اضافه شد.');
    }
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'purchase_unit' => 'required|string',
            'items_per_unit' => 'required|integer',
        ]);

        $product->update($request->all());
        return redirect()->route('products.index')->with('success', 'محصول ویرایش شد.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'محصول حذف شد.');
    }
}
