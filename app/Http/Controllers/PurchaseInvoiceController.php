<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseInvoice;
use Illuminate\Support\Facades\Storage;

class PurchaseInvoiceController extends Controller
{
    public function index()
    {
        $invoices = PurchaseInvoice::latest()->paginate(10);
        return view('purchase_invoices.index', compact('invoices'));
    }

    public function create()
    {
        return view('purchase_invoices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'status' => 'required|in:new,submitted',
            'description' => 'nullable|string'
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
//            $filePath = $request->file('file')->store('purchase_invoices');
            $filePath = $request->file('file')->store('purchase_invoices', 'public');

        }

        PurchaseInvoice::create([
            'title' => $request->title,
            'file_path' => $filePath,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('purchase_invoices.index')->with('success', 'فاکتور با موفقیت ثبت شد.');
    }

    public function show(PurchaseInvoice $purchaseInvoice)
    {
        return view('purchase_invoices.show', compact('purchaseInvoice'));
    }

    public function edit(PurchaseInvoice $purchaseInvoice)
    {
        return view('purchase_invoices.edit', compact('purchaseInvoice'));
    }

    public function update(Request $request, PurchaseInvoice $purchaseInvoice)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'status' => 'required|in:pending,paid,canceled',
        ]);

        if ($request->hasFile('file')) {
            if ($purchaseInvoice->file_path) {
                Storage::delete($purchaseInvoice->file_path);
            }
            $purchaseInvoice->file_path = $request->file('file')->store('purchase_invoices');
        }

        $purchaseInvoice->update([
            'title' => $request->title,
            'status' => $request->status,
            'file_path' => $purchaseInvoice->file_path,
        ]);

        return redirect()->route('purchase_invoices.index')->with('success', 'فاکتور با موفقیت بروزرسانی شد.');
    }

    public function destroy(PurchaseInvoice $purchaseInvoice)
    {
        if ($purchaseInvoice->file_path) {
            Storage::delete($purchaseInvoice->file_path);
        }
        $purchaseInvoice->delete();

        return redirect()->route('purchase_invoices.index')->with('success', 'فاکتور حذف شد.');
    }
    public function changeStatus(Request $request)
    {
        $invoice = PurchaseInvoice::findOrFail($request->id);
        $invoice->update(['status' => $request->status]);

        return response()->json(['success' => true, 'new_status' => $invoice->status]);
    }

}
