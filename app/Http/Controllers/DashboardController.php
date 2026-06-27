<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\PurchaseOrder;
use App\Models\Expense;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // KPI Stats
        $totalRevenue  = Invoice::where('status', 'Paid')->sum('total_amount');
        $totalCogs     = PurchaseOrder::where('status', 'Received')->sum('total_amount');
        $totalExpenses = Expense::sum('amount');
        $netProfit     = $totalRevenue - ($totalCogs + $totalExpenses);

        // Percentage Change Calculations (This Month vs Last Month)
        $thisMonthStart = Carbon::now()->startOfMonth();
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd   = Carbon::now()->subMonth()->endOfMonth();

        $thisMonthRevenue = Invoice::where('status', 'Paid')->where('created_at', '>=', $thisMonthStart)->sum('total_amount');
        $lastMonthRevenue = Invoice::where('status', 'Paid')->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->sum('total_amount');

        $thisMonthCogs = PurchaseOrder::where('status', 'Received')->where('created_at', '>=', $thisMonthStart)->sum('total_amount');
        $lastMonthCogs = PurchaseOrder::where('status', 'Received')->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->sum('total_amount');

        $thisMonthExpenses = Expense::where('expense_date', '>=', $thisMonthStart)->sum('amount');
        $lastMonthExpenses = Expense::whereBetween('expense_date', [$lastMonthStart, $lastMonthEnd])->sum('amount');

        $thisMonthProfit = $thisMonthRevenue - ($thisMonthCogs + $thisMonthExpenses);
        $lastMonthProfit = $lastMonthRevenue - ($lastMonthCogs + $lastMonthExpenses);

        $calculatePercentage = function($current, $previous) {
            if ($previous == 0) return $current > 0 ? 100 : 0;
            return (($current - $previous) / $previous) * 100;
        };

        $revenueChange  = $calculatePercentage($thisMonthRevenue, $lastMonthRevenue);
        $cogsChange     = $calculatePercentage($thisMonthCogs, $lastMonthCogs);
        $expensesChange = $calculatePercentage($thisMonthExpenses, $lastMonthExpenses);
        $profitChange   = $calculatePercentage($thisMonthProfit, $lastMonthProfit);

        // Recent Invoices
        $recentInvoices = Invoice::with('customer')->orderBy('created_at', 'desc')->take(5)->get();

        // Chart Data (Last 6 months)
        $months      = [];
        $revenueData = [];
        $expenseData = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->format('M Y');

            $revenue = Invoice::where('status', 'Paid')
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('total_amount');
            $revenueData[] = $revenue;

            $cogs = PurchaseOrder::where('status', 'Received')
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('total_amount');
            $expenses = Expense::whereMonth('expense_date', $month->month)
                ->whereYear('expense_date', $month->year)
                ->sum('amount');
            $expenseData[] = $cogs + $expenses;
        }

        return view('dashboard', compact(
            'totalRevenue',
            'totalCogs',
            'totalExpenses',
            'netProfit',
            'recentInvoices',
            'months',
            'revenueData',
            'expenseData',
            'revenueChange',
            'cogsChange',
            'expensesChange',
            'profitChange'
        ));
    }
}
