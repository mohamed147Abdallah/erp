<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Expense;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run()
    {
        // 1. Seed Categories
        $categories = [
            ['name' => 'Laptops', 'description' => 'High performance laptops'],
            ['name' => 'Smartphones', 'description' => 'Latest mobile devices'],
            ['name' => 'Accessories', 'description' => 'Cables, chargers, and cases'],
            ['name' => 'Office Supplies', 'description' => 'Desks, chairs, and stationery'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['name' => $cat['name']], $cat);
        }

        // 2. Seed Products
        $laptopCategory = Category::where('name', 'Laptops')->first();
        $phoneCategory = Category::where('name', 'Smartphones')->first();
        $accCategory = Category::where('name', 'Accessories')->first();

        $products = [
            [
                'category_id' => $laptopCategory->id,
                'name' => 'MacBook Pro M3 Max',
                'sku' => 'LAP-MBP-M3',
                'barcode' => '123456789012',
                'description' => 'Apple MacBook Pro 16-inch with M3 Max chip.',
                'price' => 3499.00,
                'cost' => 2800.00,
                'stock_quantity' => 25,
                'minimum_stock' => 5,
                'is_active' => true,
            ],
            [
                'category_id' => $laptopCategory->id,
                'name' => 'Dell XPS 15',
                'sku' => 'LAP-DELL-XPS15',
                'barcode' => '123456789013',
                'description' => 'Dell XPS 15 with Intel Core i9 and NVIDIA RTX 4070.',
                'price' => 2499.00,
                'cost' => 1950.00,
                'stock_quantity' => 12,
                'minimum_stock' => 4,
                'is_active' => true,
            ],
            [
                'category_id' => $phoneCategory->id,
                'name' => 'iPhone 15 Pro Max',
                'sku' => 'PHN-IP15-PM',
                'barcode' => '123456789014',
                'description' => 'Apple iPhone 15 Pro Max 256GB Titanium.',
                'price' => 1199.00,
                'cost' => 950.00,
                'stock_quantity' => 50,
                'minimum_stock' => 10,
                'is_active' => true,
            ],
            [
                'category_id' => $phoneCategory->id,
                'name' => 'Samsung Galaxy S24 Ultra',
                'sku' => 'PHN-SGS24-U',
                'barcode' => '123456789015',
                'description' => 'Samsung Galaxy S24 Ultra 512GB.',
                'price' => 1299.00,
                'cost' => 1000.00,
                'stock_quantity' => 45,
                'minimum_stock' => 8,
                'is_active' => true,
            ],
            [
                'category_id' => $accCategory->id,
                'name' => 'Anker 100W USB-C Charger',
                'sku' => 'ACC-ANK-100W',
                'barcode' => '123456789016',
                'description' => 'Fast charging adapter with 2 USB-C ports.',
                'price' => 49.99,
                'cost' => 20.00,
                'stock_quantity' => 200,
                'minimum_stock' => 30,
                'is_active' => true,
            ],
        ];

        foreach ($products as $prod) {
            Product::firstOrCreate(['sku' => $prod['sku']], $prod);
        }

        // 3. Seed Customers
        $customers = [
            ['name' => 'Tech Solutions LLC', 'email' => 'purchasing@techsolutions.com', 'phone' => '1-800-555-0199', 'company_name' => 'Tech Solutions', 'address' => '123 Innovation Drive, Silicon Valley, CA'],
            ['name' => 'Creative Agency', 'email' => 'hello@creativeagency.com', 'phone' => '1-800-555-0200', 'company_name' => 'Creative Inc.', 'address' => '456 Design Avenue, New York, NY'],
            ['name' => 'John Doe', 'email' => 'johndoe@example.com', 'phone' => '+1 234 567 8900', 'company_name' => null, 'address' => '789 Elm Street, Miami, FL'],
        ];

        foreach ($customers as $cust) {
            Customer::firstOrCreate(['email' => $cust['email']], $cust);
        }

        // 4. Seed Suppliers
        $suppliers = [
            ['name' => 'Global Electronics Corp', 'email' => 'sales@globalelectronics.com', 'phone' => '+86 10 1234 5678', 'contact_person' => 'Mr. Wang', 'address' => 'Shenzhen, China'],
            ['name' => 'Premium Accessories Co.', 'email' => 'orders@premiumaccessories.com', 'phone' => '+1 555 987 6543', 'contact_person' => 'Alice', 'address' => 'Los Angeles, CA'],
        ];

        foreach ($suppliers as $sup) {
            Supplier::firstOrCreate(['email' => $sup['email']], $sup);
        }

        // 5. Seed Employees
        $employees = [
            ['first_name' => 'Sarah', 'last_name' => 'Connor', 'email' => 'sarah@erp.com', 'phone' => '555-1010', 'department' => 'Sales', 'position' => 'Sales Manager', 'salary' => 6000, 'hire_date' => '2026-01-10'],
            ['first_name' => 'Michael', 'last_name' => 'Scott', 'email' => 'michael@erp.com', 'phone' => '555-2020', 'department' => 'Management', 'position' => 'Regional Manager', 'salary' => 8000, 'hire_date' => '2026-02-15'],
            ['first_name' => 'Dwight', 'last_name' => 'Schrute', 'email' => 'dwight@erp.com', 'phone' => '555-3030', 'department' => 'Sales', 'position' => 'Sales Rep', 'salary' => 4500, 'hire_date' => '2026-03-20'],
        ];

        foreach ($employees as $emp) {
            Employee::firstOrCreate(['email' => $emp['email']], $emp);
        }

        // 6. Seed Invoices (Sales)
        $customer1 = Customer::first();
        $product1 = Product::where('sku', 'LAP-MBP-M3')->first();
        $product2 = Product::where('sku', 'ACC-ANK-100W')->first();

        if ($customer1 && $product1 && $product2) {
            $invoice = Invoice::firstOrCreate(
                ['invoice_number' => 'INV-2026-0001'],
                [
                    'customer_id' => $customer1->id,
                    'invoice_date' => now()->subDays(5)->toDateString(),
                    'due_date' => now()->addDays(25)->toDateString(),
                    'total_amount' => ($product1->price * 2) + ($product2->price * 5),
                    'status' => 'Paid',
                    'notes' => 'Payment received via Bank Transfer.',
                ]
            );

            InvoiceItem::firstOrCreate([
                'invoice_id' => $invoice->id,
                'product_id' => $product1->id,
            ], [
                'quantity' => 2,
                'unit_price' => $product1->price,
                'total' => $product1->price * 2,
            ]);

            InvoiceItem::firstOrCreate([
                'invoice_id' => $invoice->id,
                'product_id' => $product2->id,
            ], [
                'quantity' => 5,
                'unit_price' => $product2->price,
                'total' => $product2->price * 5,
            ]);
        }

        // 7. Seed Purchase Orders
        $supplier1 = Supplier::first();
        
        if ($supplier1 && $product1) {
            $po = PurchaseOrder::firstOrCreate(
                ['order_number' => 'PO-2026-0001'],
                [
                    'supplier_id' => $supplier1->id,
                    'order_date' => now()->subDays(10)->toDateString(),
                    'expected_delivery_date' => now()->subDays(2)->toDateString(),
                    'subtotal' => $product1->cost * 10,
                    'tax_amount' => 0,
                    'total_amount' => $product1->cost * 10,
                    'status' => 'Received',
                    'notes' => 'Restock for Q3.',
                ]
            );

            PurchaseOrderItem::firstOrCreate([
                'purchase_order_id' => $po->id,
                'product_id' => $product1->id,
            ], [
                'quantity' => 10,
                'unit_price' => $product1->cost,
                'total' => $product1->cost * 10,
            ]);
        }

        // 8. Seed Expenses
        $expenses = [
            ['expense_date' => now()->subDays(15)->toDateString(), 'category' => 'Rent', 'amount' => 2500.00, 'description' => 'Office Rent for June'],
            ['expense_date' => now()->subDays(12)->toDateString(), 'category' => 'Utilities', 'amount' => 350.50, 'description' => 'Electricity Bill'],
            ['expense_date' => now()->subDays(2)->toDateString(), 'category' => 'Marketing', 'amount' => 1200.00, 'description' => 'Google Ads Campaign'],
        ];

        foreach ($expenses as $exp) {
            Expense::firstOrCreate(['description' => $exp['description']], $exp);
        }

        echo "Demo Data Seeded Successfully!\n";
    }
}
