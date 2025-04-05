<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::all();
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

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required',
            'description' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);


        Expense::create([
            'name' => $request->name,
            'amount' => $request->amount,
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
}
