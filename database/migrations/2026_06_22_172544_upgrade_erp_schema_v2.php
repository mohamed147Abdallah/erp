<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add fields to products
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'minimum_stock')) {
                $table->integer('minimum_stock')->default(0)->after('stock_quantity');
            }
            if (!Schema::hasColumn('products', 'image')) {
                $table->string('image')->nullable()->after('description');
            }
            if (!Schema::hasColumn('products', 'created_by')) {
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
                $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            }
        });

        // Add fields to customers
        Schema::table('customers', function (Blueprint $table) {
            if (!Schema::hasColumn('customers', 'deleted_at')) {
                $table->softDeletes();
            }
            if (!Schema::hasColumn('customers', 'created_by')) {
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
                $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            }
        });

        // Add fields to suppliers
        Schema::table('suppliers', function (Blueprint $table) {
            if (!Schema::hasColumn('suppliers', 'deleted_at')) {
                $table->softDeletes();
            }
            if (!Schema::hasColumn('suppliers', 'created_by')) {
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
                $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            }
        });

        // Add audit to invoices
        Schema::table('invoices', function (Blueprint $table) {
            if (!Schema::hasColumn('invoices', 'created_by')) {
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
                $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            }
        });

        // Add audit to purchase orders
        Schema::table('purchase_orders', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_orders', 'created_by')) {
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
                $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            }
        });
        
        // Add audit to expenses
        Schema::table('expenses', function (Blueprint $table) {
            if (!Schema::hasColumn('expenses', 'created_by')) {
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
                $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert products
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'created_by')) {
                $table->dropForeign(['created_by']);
                $table->dropForeign(['updated_by']);
                $table->dropColumn(['minimum_stock', 'image', 'created_by', 'updated_by']);
            }
        });

        // Revert customers
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            $table->dropColumn(['deleted_at', 'created_by', 'updated_by']);
        });

        // Revert suppliers
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            $table->dropColumn(['deleted_at', 'created_by', 'updated_by']);
        });

        // Revert invoices
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            $table->dropColumn(['created_by', 'updated_by']);
        });

        // Revert purchase orders
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            $table->dropColumn(['created_by', 'updated_by']);
        });
        
        // Revert expenses
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            $table->dropColumn(['created_by', 'updated_by']);
        });
    }
};
