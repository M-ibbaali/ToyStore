<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        // Filter ONLY stock alerts
        // Also: We need to load related products. Since 'data' is JSON, we can't eager load easily.
        // We will fetch notifications first, then fetch products in bulk to attach them.
        
        $notifications = auth()->user()->notifications()
            ->where('data->type', 'stock') // JSON query support in MySQL 5.7+ / MariaDB
            ->paginate(20);

        // Pre-fetch products to avoid N+1
        $productIds = $notifications->pluck('data.product_id')->filter();
        $products = \App\Models\Product::whereIn('id', $productIds)->get()->keyBy('id');

        // Attach product objects to notification object for easy access in view
        foreach ($notifications as $notification) {
            $pid = $notification->data['product_id'] ?? null;
            $notification->product = $pid ? ($products[$pid] ?? null) : null;
        }

        return view('admin.notifications.index', compact('notifications'));
    }

    public function updateStock(Request $request, $id)
    {
        // $id is the Notification ID, not Product ID (we need to delete the note)
        $notification = auth()->user()->notifications()->findOrFail($id);
        
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $notification->data['product_id'] ?? null;
        if (!$productId) {
            return response()->json(['error' => 'Product logic error'], 400);
        }

        $product = \App\Models\Product::find($productId);
        if ($product) {
            $product->increment('stock', $request->quantity);
            // $product->update(['stock' => ...]); // increment does auto-save
        }

        // Delete the notification as the issue is resolved
        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Stock updated and alert resolved.',
            'new_count' => auth()->user()->unreadNotifications()->count()
        ]);
    }

    public function destroy($id)
    {
        auth()->user()->notifications()->where('id', $id)->delete();
        auth()->user()->notifications()->where('id', $id)->delete();
        
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true, 
                'message' => 'Notification dismissed.',
                'new_count' => auth()->user()->unreadNotifications()->count()
            ]);
        }
        
        return back()->with('success', 'Notification dismissed.');
    }

    public function clearAll()
    {
        // Only clear STOCK notifications? Or all? 
        // User asked "Transform page...". Usually clear all on this page means clear visible ones.
        auth()->user()->notifications()->where('data->type', 'stock')->delete();
        return back()->with('success', 'All stock alerts cleared.');
    }
}
