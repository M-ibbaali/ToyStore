<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\User;
use App\Notifications\SystemAlert;
use Illuminate\Support\Facades\Notification;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        // Notify Admins
        $admins = User::where('role', 'admin')->get();
        
        $data = [
            'type' => 'order',
            'icon' => 'shopping-bag', // Store purely icon name or logic in view
            'color' => 'bg-blue-100 text-blue-600',
            'title' => 'New Order #' . $order->id,
            'description' => "Order of " . formatPrice($order->total) . " placed.",
            'url' => route('admin.orders.show', $order->id),
        ];

        Notification::send($admins, new SystemAlert($data));
    }
}
