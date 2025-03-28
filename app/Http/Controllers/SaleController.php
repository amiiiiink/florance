<?php
namespace App\Http\Controllers;


use App\Models\Invoice;
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
            'quantity' => 'required|array',
            'quantity.*' => 'integer|min:1',
            'price' => 'required|array',
            'price.*' => 'numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'product_id' => 'required|array',
            'product_id.*' => 'nullable|string|max:255', // چون محصول ممکن است جدید باشد، استرینگ دریافت می‌کنیم
        ]);

        $totalPrice = 0;

        // ایجاد فاکتور جدید
        $invoice = Invoice::create([
            'total_price' => 0,
            'discount' => $request->discount ?? 0,
            'final_price' => 0,
        ]);

        // ذخیره محصولات فاکتور
        foreach ($request->product_id as $index => $productNameOrId) {
            // بررسی اینکه آیا مقدار ارسالی عددی است (یعنی یک ID از قبل ثبت شده است) یا نام محصول جدید است
            $product = is_numeric($productNameOrId)
                ? Product::find($productNameOrId) // جستجوی محصول با ID
                : Product::firstOrCreate(['name' => $productNameOrId,'sale_price'=>2000]); // اگر محصول یافت نشد، ایجاد شود

            $productTotal = $request->price[$index] * $request->quantity[$index];
            $totalPrice += $productTotal;

            Sale::create([
                'invoice_id' => $invoice->id,
                'product_id' => $product->id, // ذخیره شناسه محصول (ID)
                'quantity' => $request->quantity[$index],
                'total_price' => $productTotal,
            ]);
        }

        // بروزرسانی فاکتور با مبلغ نهایی
        $invoice->update([
            'total_price' => $totalPrice,
            'final_price' => max($totalPrice - $invoice->discount, 0),
        ]);

        return redirect()->route('dashboard')->with('success', 'فاکتور با موفقیت ثبت شد.');
    }






}
