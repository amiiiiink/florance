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
}
