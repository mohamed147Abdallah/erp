<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function overview()
    {
        $products = Product::with('category')
            ->orderBy('stock_quantity', 'asc') // Show lowest stock first
            ->paginate(15);
            
        return view('inventory.overview', compact('products'));
    }
}
