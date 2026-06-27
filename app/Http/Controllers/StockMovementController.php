<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use App\Models\Product;
use App\Models\User;
use App\Notifications\LowStockNotification;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function index()
    {
        $movements = StockMovement::with('product')->latest()->paginate(15);
        return view('inventory.movements.index', compact('movements'));
    }

    public function create()
    {
        $products = Product::all();
        return view('inventory.movements.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        StockMovement::create($validated);

        // Update product stock
        $product = Product::find($validated['product_id']);
        if ($validated['type'] == 'in') {
            $product->stock_quantity += $validated['quantity'];
        } else {
            $product->stock_quantity -= $validated['quantity'];
        }
        $product->save();

        if ($product->stock_quantity <= 10) {
            $admins = User::role('Admin')->get();
            foreach ($admins as $admin) {
                // Assuming branch is somehow available or it's main store
                $admin->notify(new LowStockNotification($product, null));
            }
        }

        return redirect()->route('inventory.movements.index')->with('success', 'Stock movement recorded successfully.');
    }
}
