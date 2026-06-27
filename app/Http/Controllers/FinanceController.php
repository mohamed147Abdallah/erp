<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\PurchaseOrder;
use App\Models\Expense;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function profitLoss(Request $request)
    {
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        // Revenue (Paid Invoices)
        $revenue = Invoice::where('status', 'paid')
            ->whereMonth('invoice_date', $month)
            ->whereYear('invoice_date', $year)
            ->sum('subtotal'); // Not including tax for true P&L

        // Cost of Goods Sold (Received Purchase Orders)
        $cogs = PurchaseOrder::where('status', 'received')
            ->whereMonth('order_date', $month)
            ->whereYear('order_date', $year)
            ->sum('subtotal');

        // Operating Expenses
        $expenses = Expense::whereMonth('expense_date', $month)
            ->whereYear('expense_date', $year)
            ->sum('amount');

        $grossProfit = $revenue - $cogs;
        $netProfit = $grossProfit - $expenses;

        return view('finance.profit-loss', compact(
            'month', 'year', 'revenue', 'cogs', 'expenses', 'grossProfit', 'netProfit'
        ));
    }
}
