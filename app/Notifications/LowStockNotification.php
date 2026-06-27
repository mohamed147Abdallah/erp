<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LowStockNotification extends Notification
{
    use Queueable;

    public $product;
    public $branch;

    public function __construct($product, $branch = null)
    {
        $this->product = $product;
        $this->branch = $branch;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $branchName = $this->branch ? $this->branch->name : 'Main Store';
        return [
            'type' => 'low_stock',
            'product_id' => $this->product->id,
            'title' => 'Low Stock Alert',
            'message' => "Product '{$this->product->name}' is running low in {$branchName}. Current stock: {$this->product->stock_quantity}",
        ];
    }
}
