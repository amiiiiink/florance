<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::query()->orderBy('date', 'asc')->get();
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        $date = Verta::parse($request->date)->DateTime();
        $request->merge([
            'date' => $date->format('Y-m-d'),
        ]);

        $request->merge([
            'amount' => convertPersianToEnglish($request->amount),
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required',
            'description' => 'required',
            'amount' => 'required|string',
            'date' => 'required|date',
        ]);

        $data = $request->all();
        $data['amount'] = str_replace(',', '', $data['amount']);


        Expense::create([
            'name' => $request->name,
            'amount' => $data['amount'],
            'type' => $request->type,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return redirect()->route('expenses.index')->with('success', 'هزینه جدید با موفقیت ثبت شد.');
    }

    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();

        return redirect()->route('expenses.index')->with('success', 'هزینه با موفقیت حذف شد.');
    }
    public function updateStatusAndFile(Request $request)
    {

        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'description' => 'nullable|string',
            'expense_id' => 'required|exists:expenses,id'
        ]);

        $expense = Expense::query()->findOrFail($request->expense_id);

        // Store file if provided
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('expenses', 'public');
        }

        // Append new description to the existing description
        if ($request->filled('description')) {
            $expense->description .= "\n" . $request->description; // Appending new description with a newline (optional)
        }

        // Update the expense record
        $expense->file_path = $filePath;
        $expense->status = 'payed';
//        $expense->description = $request->description;
        $expense->save();

        return redirect()->route('expenses.index')->with('success', 'هزینه با موفقیت به روز رسانی شد.');
    }
}
