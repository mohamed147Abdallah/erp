<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;
use App\Models\Scopes\BranchScope;

class Expense extends Model
{
    protected static function booted(): void
    {
        static::addGlobalScope(new BranchScope);
    }
    use HasFactory, SoftDeletes, Auditable;

    protected $guarded = [];

    protected $casts = [
        'expense_date' => 'date',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
