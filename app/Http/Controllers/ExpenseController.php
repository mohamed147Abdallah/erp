<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::latest('expense_date')->paginate(15);
        
        $totalExpenses = Expense::sum('amount');
        $thisMonthExpenses = Expense::whereMonth('expense_date', date('m'))->sum('amount');
        
        return view('finance.expenses.index', compact('expenses', 'totalExpenses', 'thisMonthExpenses'));
    }

    public function create()
    {
        return view('finance.expenses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'reference' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Expense::create($validated);

        return redirect()->route('finance.expenses.index')->with('success', 'Expense logged successfully.');
    }
}
