<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Address;
use App\Models\User;
use App\Notifications\LowStockNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        
        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty!');
        }

        $cartItems = $cart->items()->with('product.images')->get();
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $addresses = Address::where('user_id', Auth::id())->get();
        $user = Auth::user();

        return view('frontend.checkout', compact('cartItems', 'total', 'addresses', 'user'));
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:cod,stripe',
            'fullname' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:255',
            'address' => 'required|string',
        ]);

        $cart = Cart::where('user_id', Auth::id())->first();

        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty!');
        }

        DB::beginTransaction();

        try {
            // Save address
            Address::create([
                'user_id' => Auth::id(),
                'fullname' => $validated['fullname'],
                'phone' => $validated['phone'],
                'city' => $validated['city'],
                'address' => $validated['address'],
            ]);

            // Calculate total
            $total = $cart->items->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'status' => 'pending',
                'payment_method' => $validated['payment_method'],
                'payment_status' => $validated['payment_method'] == 'cod' ? 'pending' : 'pending',
            ]);

            // Create order items & update stock
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                ]);

                // Reduce stock
                $product = $item->product;
                $product->decrement('stock', $item->quantity);

                // Low stock check
                if ($product->stock <= 5) {
                    $admins = User::where('role', 'admin')->get();
                    
                    // Check if a low stock notification was already sent recently
                    $alreadyNotified = DB::table('notifications')
                        ->where('notifiable_type', User::class)
                        ->whereJsonContains('data->product_id', $product->id)
                        ->whereJsonContains('data->type', 'low_stock')
                        ->where('read_at', null)
                        ->exists();

                    if (!$alreadyNotified) {
                        foreach ($admins as $admin) {
                            $admin->notify(new LowStockNotification($product));
                        }
                    }
                }
            }

            // Create payment record
            Payment::create([
                'order_id' => $order->id,
                'amount' => $total,
                'method' => $validated['payment_method'],
                'status' => 'pending',
            ]);

            // Clear cart
            $cart->items()->delete();

            DB::commit();

            return redirect()->route('order.success', $order->id)->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function success($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->with('items.product')
            ->firstOrFail();

        return view('frontend.order-success', compact('order'));
    }
}
