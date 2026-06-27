<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Rap2hpoutre\FastExcel\FastExcel;

class DataImportController extends Controller
{
    public function index()
    {
        return view('data-import.index');
    }

    public function exportProducts()
    {
        return (new FastExcel(Product::all()))->download('products.xlsx', function ($product) {
            return [
                'ID' => $product->id,
                'Name' => $product->name,
                'SKU' => $product->sku,
                'Category ID' => $product->category_id,
                'Price' => $product->price,
                'Cost' => $product->cost,
                'Stock' => $product->stock_quantity,
                'Minimum Stock' => $product->minimum_stock,
                'Active' => $product->is_active ? 'Yes' : 'No',
            ];
        });
    }

    public function importProducts(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            $collection = (new FastExcel)->import($request->file('excel_file'));

            foreach ($collection as $row) {
                // Determine category_id, default to 1 if not set or invalid
                $categoryId = isset($row['Category ID']) && is_numeric($row['Category ID']) ? $row['Category ID'] : 1;
                
                Product::updateOrCreate(
                    ['sku' => $row['SKU']],
                    [
                        'name' => $row['Name'],
                        'category_id' => $categoryId,
                        'price' => $row['Price'] ?? 0,
                        'cost' => $row['Cost'] ?? 0,
                        'stock_quantity' => $row['Stock'] ?? 0,
                        'minimum_stock' => $row['Minimum Stock'] ?? 0,
                        'is_active' => isset($row['Active']) && strtolower($row['Active']) === 'yes' ? true : false,
                    ]
                );
            }

            return redirect()->route('data-import.index')->with('success', 'Products imported successfully!');
        } catch (\Exception $e) {
            return redirect()->route('data-import.index')->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }
}
