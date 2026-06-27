<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LargeInvoiceNotification extends Notification
{
    use Queueable;

    public $invoice;

    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'large_invoice',
            'invoice_id' => $this->invoice->id,
            'title' => 'Large Invoice Created',
            'message' => "A large invoice (#{$this->invoice->invoice_number}) was created for amount " . number_format($this->invoice->total_amount, 2),
            'url' => route('sales.invoices.show', $this->invoice->id)
        ];
    }
}
