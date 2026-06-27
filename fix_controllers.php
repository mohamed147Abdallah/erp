<?php

$controllers = [
    'StockMovementController.php' => "return view('inventory.movements.index');",
    'StockAdjustmentController.php' => "return view('inventory.adjustments.index');",
    'InvoiceController.php' => "return view('sales.invoices.index');",
    'PurchaseOrderController.php' => "return view('purchases.orders.index');",
    'ExpenseController.php' => "return view('finance.expenses.index');",
];

$basePath = __DIR__ . '/app/Http/Controllers/';

foreach ($controllers as $file => $returnStatement) {
    $path = $basePath . $file;
    if (file_exists($path)) {
        $content = file_get_contents($path);
        // Replace empty index method with return statement
        $content = preg_replace(
            '/public function index\(\)\s*\{\s*\/\/\s*\}/',
            "public function index()\n    {\n        $returnStatement\n    }",
            $content
        );
        file_put_contents($path, $content);
        echo "Updated $file\n";
    }
}

// Special case for FinanceController and returns
$financePath = $basePath . 'FinanceController.php';
if (file_exists($financePath)) {
    $content = file_get_contents($financePath);
    // if not already there
    if (strpos($content, 'profitLoss') === false) {
        $content = str_replace(
            "class FinanceController extends Controller\n{",
            "class FinanceController extends Controller\n{\n    public function profitLoss()\n    {\n        return view('finance.profit-loss');\n    }\n",
            $content
        );
        file_put_contents($financePath, $content);
        echo "Updated FinanceController\n";
    }
}

// Special cases for Returns in InvoiceController and PurchaseOrderController
$invoicePath = $basePath . 'InvoiceController.php';
if (file_exists($invoicePath)) {
    $content = file_get_contents($invoicePath);
    if (strpos($content, 'returns') === false) {
        $content = str_replace(
            "class InvoiceController extends Controller\n{",
            "class InvoiceController extends Controller\n{\n    public function returns()\n    {\n        return view('sales.returns');\n    }\n",
            $content
        );
        file_put_contents($invoicePath, $content);
    }
}

$poPath = $basePath . 'PurchaseOrderController.php';
if (file_exists($poPath)) {
    $content = file_get_contents($poPath);
    if (strpos($content, 'returns') === false) {
        $content = str_replace(
            "class PurchaseOrderController extends Controller\n{",
            "class PurchaseOrderController extends Controller\n{\n    public function returns()\n    {\n        return view('purchases.returns');\n    }\n",
            $content
        );
        file_put_contents($poPath, $content);
    }
}

echo "Done.\n";
