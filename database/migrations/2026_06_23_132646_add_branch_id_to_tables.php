<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = ['users', 'employees', 'invoices', 'purchase_orders', 'stock_movements', 'expenses'];
        foreach ($tables as $table_name) {
            Schema::table($table_name, function (Blueprint $table) {
                $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        $tables = ['users', 'employees', 'invoices', 'purchase_orders', 'stock_movements', 'expenses'];
        foreach ($tables as $table_name) {
            Schema::table($table_name, function (Blueprint $table) {
                $table->dropForeign(['branch_id']);
                $table->dropColumn('branch_id');
            });
        }
    }
};
