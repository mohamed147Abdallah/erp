<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['name', 'address', 'phone', 'is_main'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
}
