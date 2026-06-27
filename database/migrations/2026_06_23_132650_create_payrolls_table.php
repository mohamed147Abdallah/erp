<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->integer('month');
            $table->integer('year');
            $table->decimal('basic_salary', 10, 2);
            $table->decimal('deductions', 10, 2)->default(0);
            $table->decimal('commissions', 10, 2)->default(0);
            $table->decimal('net_salary', 10, 2);
            $table->enum('status', ['draft', 'paid'])->default('draft');
            $table->date('payment_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
