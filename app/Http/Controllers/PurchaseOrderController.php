<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $orders = PurchaseOrder::with('supplier')->latest()->paginate(15);
        return view('purchases.orders.index', compact('orders'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        
        $orderNumber = 'PO-' . strtoupper(uniqid());
        
        return view('purchases.orders.create', compact('suppliers', 'products', 'orderNumber'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'order_number' => 'required|unique:purchase_orders,order_number',
            'order_date' => 'required|date',
            'expected_delivery_date' => 'nullable|date|after_or_equal:order_date',
            'status' => 'required|in:draft,ordered,received,cancelled',
            'notes' => 'nullable|string',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $subtotal = 0;
            
            foreach ($request->products as $item) {
                $subtotal += $item['quantity'] * $item['unit_price'];
            }
            
            $tax_amount = $subtotal * 0.15; // 15% VAT assumption
            $total_amount = $subtotal + $tax_amount;

            $order = PurchaseOrder::create([
                'supplier_id' => $validated['supplier_id'],
                'order_number' => $validated['order_number'],
                'order_date' => $validated['order_date'],
                'expected_delivery_date' => $validated['expected_delivery_date'] ?? null,
                'subtotal' => $subtotal,
                'tax_amount' => $tax_amount,
                'total_amount' => $total_amount,
                'status' => $validated['status'],
                'notes' => $validated['notes'],
            ]);

            foreach ($request->products as $item) {
                $total = $item['quantity'] * $item['unit_price'];
                
                PurchaseOrderItem::create([
                    'purchase_order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total' => $total,
                ]);

                // Increase stock only if received
                if ($validated['status'] == 'received') {
                    $product = Product::find($item['id']);
                    $product->stock_quantity += $item['quantity'];
                    $product->save();
                }
            }

            DB::commit();
            return redirect()->route('purchases.orders.index')->with('success', 'Purchase Order created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Failed to create PO: ' . $e->getMessage()]);
        }
    }
    
    public function returns()
    {
        return view('purchases.returns');
    }
}
