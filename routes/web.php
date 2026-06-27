<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Language Switcher
Route::get('lang/{locale}', [LanguageController::class, 'switchLang'])->name('lang.switch');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::resource('employees', \App\Http\Controllers\EmployeeController::class);
    
    // HR & Payroll
    Route::resource('attendances', \App\Http\Controllers\AttendanceController::class);
    Route::resource('payrolls', \App\Http\Controllers\PayrollController::class);
    Route::post('payrolls/generate', [\App\Http\Controllers\PayrollController::class, 'generate'])->name('payrolls.generate');
    
    // CRM
    Route::resource('customers', \App\Http\Controllers\CustomerController::class);
    Route::resource('suppliers', \App\Http\Controllers\SupplierController::class);
    
    // Catalog
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
    Route::resource('products', \App\Http\Controllers\ProductController::class);

    // Inventory
    Route::get('inventory/overview', [\App\Http\Controllers\InventoryController::class, 'overview'])->name('inventory.overview');
    Route::resource('inventory/movements', \App\Http\Controllers\StockMovementController::class)->names('inventory.movements');
    Route::resource('inventory/adjustments', \App\Http\Controllers\StockAdjustmentController::class)->names('inventory.adjustments');
    
    // Sales
    Route::resource('sales/invoices', \App\Http\Controllers\InvoiceController::class)->names('sales.invoices');
    Route::get('sales/invoices/{invoice}/pdf', [\App\Http\Controllers\InvoiceController::class, 'downloadPdf'])->name('sales.invoices.pdf');
    // For returns, we can just point to invoices for now or create a placeholder route
    Route::get('sales/returns', [\App\Http\Controllers\InvoiceController::class, 'returns'])->name('sales.returns');

    // Purchases
    Route::resource('purchases/orders', \App\Http\Controllers\PurchaseOrderController::class)->names('purchases.orders');
    Route::get('purchases/returns', [\App\Http\Controllers\PurchaseOrderController::class, 'returns'])->name('purchases.returns');

    // Finance
    Route::resource('finance/expenses', \App\Http\Controllers\ExpenseController::class)->names('finance.expenses');
    Route::get('/finance/profit-loss', [FinanceController::class, 'profitLoss'])->name('finance.profit-loss');

    // Administration & Settings (Restricted to Admin)
    Route::middleware(['role:Admin'])->group(function () {
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::resource('branches', \App\Http\Controllers\BranchController::class);
            Route::resource('users', UserController::class);
            Route::resource('roles', RoleController::class);
            Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
            Route::get('activity-logs', [\App\Http\Controllers\ActivityLogController::class, 'index'])->name('activity-logs.index');
        });

        // Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');
    });

    // Data Import/Export (Available to Managers/Admins, but let's restrict to Admin for now or we can use middleware 'role:Admin|Manager')
    Route::middleware(['role:Admin|Manager'])->prefix('data-import')->name('data-import.')->group(function () {
        Route::get('/', [\App\Http\Controllers\DataImportController::class, 'index'])->name('index');
        Route::post('/import', [\App\Http\Controllers\DataImportController::class, 'importProducts'])->name('import');
        Route::get('/export', [\App\Http\Controllers\DataImportController::class, 'exportProducts'])->name('export');
    });
    
    // Data Import
    Route::get('/imports', [App\Http\Controllers\ImportController::class, 'index'])->name('imports.index');
    Route::post('/imports', [App\Http\Controllers\ImportController::class, 'process'])->name('imports.process');
    Route::get('/imports/template/{type}', [App\Http\Controllers\ImportController::class, 'template'])->name('imports.template');

    // Global Search
    Route::get('/search', [\App\Http\Controllers\SearchController::class, 'index'])->name('search.index');
});

require __DIR__.'/auth.php';
