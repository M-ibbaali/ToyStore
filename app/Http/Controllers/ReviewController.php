<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        $product = Product::findOrFail($productId);

        // 1. Verify if user ordered the product
        // We check if there is ANY order by this user that has this product in its items
        $hasOrdered = Order::where('user_id', $user->id)
            ->whereHas('items', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            // Optional: Check if order is 'completed' or 'delivered' if you have those statuses
            // ->where('status', 'completed')
            ->exists();

        if (!$hasOrdered) {
            return back()->with('error', 'You can only review products you have purchased.');
        }

        // 2. Check for duplicate review
        $alreadyReviewed = Review::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->exists();

        if ($alreadyReviewed) {
             return back()->with('error', 'You have already reviewed this product.');
        }

        // 3. Create Review
        Review::create([
            'user_id' => $user->id,
            'product_id' => $productId,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Thank you for your review!');
    }
}
