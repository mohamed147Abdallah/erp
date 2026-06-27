<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\Scopes\BranchScope;

class PurchaseOrder extends Model
{
    protected static function booted(): void
    {
        static::addGlobalScope(new BranchScope);
    }
    use HasFactory, SoftDeletes, Auditable, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected $guarded = [];

    protected $casts = [
        'order_date' => 'date',
        'expected_delivery_date' => 'date',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
