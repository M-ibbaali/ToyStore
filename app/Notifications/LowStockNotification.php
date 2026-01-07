<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LowStockNotification extends Notification
{
    use Queueable;

    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'quantity' => $this->product->stock,
            'message' => "Low stock alert: '{$this->product->name}' has only {$this->product->stock} left in inventory.",
            'type' => 'low_stock'
        ];
    }
}
