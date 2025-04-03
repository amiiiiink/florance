<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory
    {
        $query = Product::query();

        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(20);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'purchase_price' => convertPersianToEnglish($request->purchase_price),
            'sale_price' => convertPersianToEnglish($request->sale_price),
            'items_per_unit' => convertPersianToEnglish($request->items_per_unit),
            'stock_quantity' => convertPersianToEnglish($request->stock_quantity),
        ]);
        $request->validate([
            'name' => 'required',
            'purchase_price' => 'required|string',
            'sale_price' => 'required|string',
            'purchase_unit' => 'required|in:carton,box,package,single',
            'stock_quantity' => 'required|string',
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
