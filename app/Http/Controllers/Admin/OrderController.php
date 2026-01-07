<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'user');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled'
        ]);

        $newStatus = $validated['status'];
        $oldStatus = $order->status;

        // Prevent redundant status updates
        if ($newStatus === $oldStatus) {
            return back()->with('info', 'Order is already ' . $newStatus);
        }

        try {
            return \Illuminate\Support\Facades\DB::transaction(function() use ($order, $newStatus, $oldStatus) {
                // Logic for confirmation (Stock Reduction)
                if ($newStatus === 'confirmed' && $oldStatus === 'pending') {
                    foreach ($order->items as $item) {
                        $product = $item->product;
                        
                        // Check if enough stock
                        if ($product->stock < $item->quantity) {
                            throw new \Exception("Insufficient stock for product: {$product->name}. Current stock: {$product->stock}");
                        }

                        // Reduce stock
                        $product->decrement('stock', $item->quantity);
                    }
                }

                // Logic for cancellation (Optional: Restore Stock if it was already confirmed)
                // If you want to restore stock when cancelling a previously confirmed order:
                /*
                if ($newStatus === 'cancelled' && $oldStatus !== 'pending' && $oldStatus !== 'cancelled') {
                    foreach ($order->items as $item) {
                        $item->product->increment('stock', $item->quantity);
                    }
                }
                */

                $order->update(['status' => $newStatus]);

                // Auto-update payment status for COD if delivered
                if ($newStatus === 'delivered' && $order->payment_method === 'cod') {
                    $order->update(['payment_status' => 'paid']);
                }

                return back()->with('success', "Order status updated to {$newStatus} successfully!");
            });
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully!');
    }
}
