<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private function getOrCreateCart()
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(['user_id' => Auth::id()]);
        } else {
            $sessionId = session()->getId();
            $cart = Cart::firstOrCreate(['session_id' => $sessionId]);
            
            // Explicitly store guest_cart_id in session for reliable merging after login
            session(['guest_cart_id' => $cart->id]);
            
            return $cart;
        }
    }

    public function index()
    {
        $cart = $this->getOrCreateCart();
        $cartItems = $cart->items()->with('product.images')->get();
        
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('frontend.cart', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = $this->getOrCreateCart();
        
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $validated['quantity'];
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity']
            ]);
        }

        if ($request->wantsJson()) {
            $cartCount = $cart->items()->sum('quantity');
            $cartSubtotal = $cart->items->sum(function($item) {
                return $item->product->price * $item->quantity;
            });
            
            $html = view('partials.mini-cart', compact('cart', 'cartCount', 'cartSubtotal'))->render();

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart!',
                'cartCount' => $cartCount,
                'cartTotal' => number_format($cartSubtotal, 2),
                'html' => $html
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = CartItem::with('product')->findOrFail($id);
        
        // Stock Validation
        if ($validated['quantity'] > $cartItem->product->stock) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only ' . $cartItem->product->stock . ' items available in stock.'
                ], 422);
            }
            return back()->with('error', 'Not enough stock available.');
        }

        $cartItem->update($validated);

        if ($request->wantsJson()) {
            $cart = $cartItem->cart;
            $cartItems = $cart->items()->with('product')->get();
            
            $cartTotal = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            $cartCount = $cartItems->sum('quantity');
            $cartSubtotal = $cartTotal;

            $html = view('partials.mini-cart', compact('cart', 'cartCount', 'cartSubtotal'))->render();

            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully!',
                'cartCount' => $cartCount,
                'itemSubtotal' => number_format($cartItem->product->price * $cartItem->quantity, 2),
                'cartTotal' => number_format($cartTotal, 2),
                'html' => $html
            ]);
        }

        return back()->with('success', 'Cart updated!');
    }

    public function remove(Request $request, $id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cart = $cartItem->cart;
        $cartItem->delete();

        if ($request->wantsJson()) {
            $cartCount = $cart->items()->sum('quantity');
            $cartSubtotal = $cart->items->sum(function($item) {
                return $item->product->price * $item->quantity;
            });
            
            $html = view('partials.mini-cart', compact('cart', 'cartCount', 'cartSubtotal'))->render();

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart!',
                'cartCount' => $cartCount,
                'cartTotal' => number_format($cartSubtotal, 2),
                'html' => $html
            ]);
        }

        return back()->with('success', 'Item removed from cart!');
    }

    public function fetchMiniCart()
    {
        $cart = null;
        $cartCount = 0;
        $cartSubtotal = 0;
        
        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->id())->with('items.product')->first();
        } else {
            $cart = Cart::where('session_id', session()->getId())->with('items.product')->first();
        }

        if ($cart) {
            $cartCount = $cart->items->sum('quantity');
            $cartSubtotal = $cart->items->sum(function($item) {
                return $item->product->price * $item->quantity;
            });
        }

        return response()->json([
            'html' => view('partials.mini-cart', compact('cart', 'cartCount', 'cartSubtotal'))->render(),
            'cartCount' => $cartCount
        ]);
    }
}
