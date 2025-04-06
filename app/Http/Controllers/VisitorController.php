<?php
namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{

    public function index()
    {
        $visitors = Visitor::latest()->get();
        return view('visitors.index', compact('visitors'));
    }


    public function create()
    {
        return view('visitors.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'visitor_name' => 'required|string|max:255',
            'visitor_number' => 'required|string|max:20',
            'description' => 'nullable|string',
        ]);

        Visitor::create($request->all());

        return redirect()->route('visitors.index')->with('success', 'بازدیدکننده با موفقیت اضافه شد.');
    }


    public function edit(Visitor $visitor)
    {
        return view('visitors.edit', compact('visitor'));
    }


    public function update(Request $request, Visitor $visitor)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'visitor_name' => 'required|string|max:255',
            'visitor_number' => 'required|string|max:20',
            'description' => 'nullable|string',
        ]);

        $visitor->update($request->all());

        return redirect()->route('visitors.index')->with('success', 'اطلاعات بازدیدکننده ویرایش شد.');
    }


    public function destroy(Visitor $visitor)
    {
        $visitor->delete();
        return redirect()->route('visitors.index')->with('success', 'بازدیدکننده حذف شد.');
    }
}
