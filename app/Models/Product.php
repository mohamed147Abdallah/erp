<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Product extends Model
{
    use HasFactory, SoftDeletes, Auditable, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected $fillable = [
        'category_id',
        'name',
        'sku',
        'barcode',
        'description',
        'price',
        'cost',
        'stock_quantity',
        'minimum_stock',
        'image',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
