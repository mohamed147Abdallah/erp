<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Notifications\LargeInvoiceNotification;
use App\Notifications\LowStockNotification;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('customer')->orderBy('created_at', 'desc')->paginate(10);
        return view('sales.invoices.index', compact('invoices'));
    }

    public function downloadPdf(Invoice $invoice)
    {
        $invoice->load(['customer', 'items.product']);
        $pdf = Pdf::loadView('sales.invoices.pdf', compact('invoice'));
        return $pdf->download("invoice_{$invoice->invoice_number}.pdf");
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::where('stock_quantity', '>', 0)->get();
        
        // Generate a random invoice number
        $invoiceNumber = 'INV-' . strtoupper(uniqid());
        
        return view('sales.invoices.create', compact('customers', 'products', 'invoiceNumber'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_number' => 'required|unique:invoices,invoice_number',
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:invoice_date',
            'status' => 'required|in:draft,sent,paid,overdue,cancelled',
            'notes' => 'nullable|string',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $subtotal = 0;
            
            // Calculate totals
            foreach ($request->products as $item) {
                $subtotal += $item['quantity'] * $item['unit_price'];
            }
            
            $tax_amount = $subtotal * 0.15; // Assuming 15% VAT for simplicity
            $total_amount = $subtotal + $tax_amount;

            $invoice = Invoice::create([
                'customer_id' => $validated['customer_id'],
                'invoice_number' => $validated['invoice_number'],
                'invoice_date' => $validated['invoice_date'],
                'due_date' => $validated['due_date'] ?? null,
                'subtotal' => $subtotal,
                'tax_amount' => $tax_amount,
                'total_amount' => $total_amount,
                'status' => $validated['status'],
                'notes' => $validated['notes'],
            ]);

            foreach ($request->products as $item) {
                $total = $item['quantity'] * $item['unit_price'];
                
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total' => $total,
                ]);

                // Deduct stock if invoice is not just a draft
                if ($validated['status'] != 'draft') {
                    $product = Product::find($item['id']);
                    $product->stock_quantity -= $item['quantity'];
                    $product->save();

                    // Check for low stock
                    if ($product->stock_quantity <= 10) {
                        $admins = User::role('Admin')->get();
                        foreach ($admins as $admin) {
                            $admin->notify(new LowStockNotification($product, $invoice->branch));
                        }
                    }
                }
            }

            // Check for large invoice
            if ($invoice->total_amount > 10000) {
                $admins = User::role('Admin')->get();
                foreach ($admins as $admin) {
                    $admin->notify(new LargeInvoiceNotification($invoice));
                }
            }

            DB::commit();
            return redirect()->route('sales.invoices.index')->with('success', 'Invoice created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Failed to create invoice: ' . $e->getMessage()]);
        }
    }
    
    public function returns()
    {
        return view('sales.returns');
    }
}
