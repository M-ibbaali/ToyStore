<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\User;
use App\Notifications\SystemAlert;
use Illuminate\Support\Facades\Notification;

class ProductObserver
{
    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        // Check if stock is low (<= 5) AND it wasn't low before (to avoid spam)
        if ($product->isDirty('stock')) {
            $newStock = $product->stock;
            $oldStock = $product->getOriginal('stock');

            if ($newStock <= 5 && $newStock > 0 && $oldStock > 5) {
                // Trigger Alert
                $admins = User::where('role', 'admin')->get();
                
                $data = [
                    'type' => 'stock',
                    'product_id' => $product->id, // Critical for stock management actions
                    'icon' => 'exclamation-circle',
                    'color' => 'bg-red-100 text-red-600',
                    'title' => 'Low Stock Alert',
                    'description' => "{$product->name} has only {$newStock} left.",
                    'url' => route('admin.products.edit', $product->id),
                ];

                Notification::send($admins, new SystemAlert($data));
            }
        }
    }
}
