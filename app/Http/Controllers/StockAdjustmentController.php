<?php

namespace App\Http\Controllers;

use App\Models\StockAdjustment;
use App\Models\Product;
use Illuminate\Http\Request;

class StockAdjustmentController extends Controller
{
    public function index()
    {
        $adjustments = StockAdjustment::with('product')->latest()->paginate(15);
        return view('inventory.adjustments.index', compact('adjustments'));
    }

    public function create(Request $request)
    {
        $products = Product::all();
        $selectedProductId = $request->query('product_id');
        return view('inventory.adjustments.create', compact('products', 'selectedProductId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'adjusted_quantity' => 'required|integer', // can be negative or positive
            'reason' => 'required|string|max:255',
        ]);

        StockAdjustment::create($validated);

        // Update product stock
        $product = Product::find($validated['product_id']);
        $product->stock_quantity += $validated['adjusted_quantity'];
        $product->save();

        return redirect()->route('inventory.overview')->with('success', 'Stock adjusted successfully.');
    }
}
