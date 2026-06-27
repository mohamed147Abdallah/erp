<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\BranchScope;

class Employee extends Model
{
    protected static function booted(): void
    {
        static::addGlobalScope(new BranchScope);
    }
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'department',
        'position',
        'salary',
        'hire_date',
        'status',
        'branch_id',
        'user_id',
        'commission_rate',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
