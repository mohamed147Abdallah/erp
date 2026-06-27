<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Invoice;
use App\Models\PurchaseOrder;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        if (empty(trim($query))) {
            return view('search.results', [
                'query' => $query,
                'products' => [],
                'customers' => [],
                'suppliers' => [],
                'invoices' => [],
                'purchaseOrders' => [],
            ]);
        }

        $products = Product::where('name', 'like', "%{$query}%")
            ->orWhere('sku', 'like', "%{$query}%")
            ->orWhere('barcode', 'like', "%{$query}%")
            ->limit(10)
            ->get();

        $customers = Customer::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%")
            ->limit(10)
            ->get();

        $suppliers = Supplier::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhere('company', 'like', "%{$query}%")
            ->limit(10)
            ->get();

        $invoices = Invoice::where('invoice_number', 'like', "%{$query}%")
            ->limit(10)
            ->get();

        $purchaseOrders = PurchaseOrder::where('order_number', 'like', "%{$query}%")
            ->limit(10)
            ->get();

        return view('search.results', compact('query', 'products', 'customers', 'suppliers', 'invoices', 'purchaseOrders'));
    }
}
