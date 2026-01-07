<?php

namespace App\Http\View\Composers;

use App\Models\Category;
use App\Models\Cart;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class FrontendComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // Get all top-level categories with their children for navigation
        $categories = Category::whereNull('parent_id')->with('children')->orderBy('name')->get();
        
        // Get cart data
        $cart = null;
        $cartCount = 0;
        $cartSubtotal = 0;
        
        // Get wishlist data
        $wishlistCount = 0;
        $wishlistProducts = collect();
        
        if (Auth::check()) {
            $user = Auth::user();
            $wishlistCount = $user->favorites()->count();
            $wishlistProducts = $user->favorites()->with('images')->latest()->get();
            
            $cart = Cart::where('user_id', Auth::id())->with('items.product')->first();
        } else {
            $sessionId = session()->getId();
            $cart = Cart::where('session_id', $sessionId)->with('items.product')->first();
        }

        if ($cart) {
            $cartCount = $cart->items->sum('quantity');
            foreach($cart->items as $item) {
                $cartSubtotal += $item->product->price * $item->quantity;
            }
        }
        
        $view->with([
            'categories' => $categories,
            'cartCount' => $cartCount,
            'cart' => $cart,
            'cartSubtotal' => $cartSubtotal,
            'wishlistCount' => $wishlistCount,
            'wishlistProducts' => $wishlistProducts
        ]);
    }
}
