<?php

namespace App\Listeners;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Session;

class MergeCartAfterLogin
{
    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;
        $sessionId = Session::getId();
        $guestCartId = Session::get('guest_cart_id');

        // Find guest cart by stored ID or fallback to session ID
        $guestCart = null;
        if ($guestCartId) {
            $guestCart = Cart::find($guestCartId);
        }
        
        if (!$guestCart) {
            $guestCart = Cart::where('session_id', $sessionId)->first();
        }

        if (!$guestCart) {
            return;
        }

        // Find or create user cart
        $userCart = Cart::firstOrCreate(['user_id' => $user->id]);

        // Merge guest cart items into user cart
        $guestItems = $guestCart->items;

        foreach ($guestItems as $guestItem) {
            $existingItem = CartItem::where('cart_id', $userCart->id)
                ->where('product_id', $guestItem->product_id)
                ->first();

            if ($existingItem) {
                // Update quantity if item already exists in user cart
                $existingItem->quantity += $guestItem->quantity;
                $existingItem->save();
                $guestItem->delete();
            } else {
                // Reassign guest item to user cart
                $guestItem->cart_id = $userCart->id;
                $guestItem->save();
            }
        }

        // Delete guest cart record as it's no longer needed
        $guestCart->delete();
    }
}
