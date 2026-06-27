<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ImportController extends Controller
{
    public function index()
    {
        return view('imports.index');
    }

    public function template($type)
    {
        $headers = [];
        $filename = "{$type}_template.csv";

        switch ($type) {
            case 'products':
                $headers = ['sku', 'name', 'description', 'price', 'cost_price', 'stock_quantity'];
                break;
            case 'customers':
                $headers = ['name', 'email', 'phone', 'company', 'address'];
                break;
            case 'suppliers':
                $headers = ['name', 'email', 'phone', 'company', 'address'];
                break;
            default:
                abort(404);
        }

        $handle = fopen('php://output', 'w');
        
        return Response::stream(
            function () use ($handle, $headers) {
                fputcsv($handle, $headers);
                fclose($handle);
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ]
        );
    }

    public function process(Request $request)
    {
        $request->validate([
            'import_type' => 'required|in:products,customers,suppliers',
            'import_file' => 'required|file|mimes:xlsx,xls,csv,txt|max:10240', // 10MB max
        ]);

        $type = $request->input('import_type');
        $file = $request->file('import_file');
        
        $successCount = 0;
        $errorCount = 0;

        try {
            $collection = (new \Rap2hpoutre\FastExcel\FastExcel)->import($file);

            if ($collection->isEmpty()) {
                return back()->withErrors(['error' => 'The uploaded file is empty or only contains headers.']);
            }

            foreach ($collection as $row) {
                // Ensure keys are somewhat normalized or just expect exact matches
                // FastExcel uses first row as keys.
                
                try {
                    if ($type === 'products') {
                        if (empty($row['sku']) || empty($row['name']) || !isset($row['price'])) {
                            $errorCount++;
                            continue;
                        }
                        
                        Product::updateOrCreate(
                            ['sku' => $row['sku']],
                            [
                                'name' => $row['name'],
                                'description' => $row['description'] ?? null,
                                'price' => floatval($row['price']),
                                'cost' => isset($row['cost_price']) && $row['cost_price'] !== '' ? floatval($row['cost_price']) : null,
                                'stock_quantity' => isset($row['stock_quantity']) && $row['stock_quantity'] !== '' ? intval($row['stock_quantity']) : 0,
                                'minimum_stock' => isset($row['minimum_stock']) && $row['minimum_stock'] !== '' ? intval($row['minimum_stock']) : 0,
                                'category_id' => 1, 
                            ]
                        );
                        $successCount++;
                    } 
                    elseif ($type === 'customers') {
                        if (empty($row['name']) || empty($row['email'])) {
                            $errorCount++;
                            continue;
                        }
                        
                        Customer::updateOrCreate(
                            ['email' => $row['email']],
                            [
                                'name' => $row['name'],
                                'phone' => $row['phone'] ?? null,
                                'company' => $row['company'] ?? null,
                                'address' => $row['address'] ?? null,
                            ]
                        );
                        $successCount++;
                    }
                    elseif ($type === 'suppliers') {
                        if (empty($row['name']) || empty($row['email'])) {
                            $errorCount++;
                            continue;
                        }
                        
                        Supplier::updateOrCreate(
                            ['email' => $row['email']],
                            [
                                'name' => $row['name'],
                                'phone' => $row['phone'] ?? null,
                                'company' => $row['company'] ?? null,
                                'address' => $row['address'] ?? null,
                            ]
                        );
                        $successCount++;
                    }
                } catch (\Exception $e) {
                    $errorCount++;
                }
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to parse Excel file. Ensure it is a valid xlsx/csv file.']);
        }

        $message = "Import completed! Successfully imported {$successCount} records.";
        if ($errorCount > 0) {
            $message .= " Failed to import {$errorCount} rows (missing required data or duplicate errors).";
        }

        return redirect()->route('imports.index')->with('success', $message);
    }
}
