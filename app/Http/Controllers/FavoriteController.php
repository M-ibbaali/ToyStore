<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()->favorites()->with('images', 'category')->paginate(12);
        return view('frontend.favorites', compact('favorites'));
    }

    public function toggleFavorite(Product $product)
    {
        $user = Auth::user();
        
        if ($user->favorites()->where('product_id', $product->id)->exists()) {
            $user->favorites()->detach($product->id);
            $favorited = false;
        } else {
            $user->favorites()->attach($product->id);
            $favorited = true;
        }

        return response()->json([
            'favorited' => $favorited,
            'count' => $user->favorites()->count(),
            'html' => view('partials.mini-wishlist', [
                'wishlistCount' => $user->favorites()->count(),
                'wishlistProducts' => $user->favorites()->with('images')->latest()->get()
            ])->render()
        ]);
    }

    public function getFavoritesCount()
    {
        return response()->json([
            'count' => Auth::user()->favorites()->count()
        ]);
    }

    public function getFavoritesList()
    {
        $user = Auth::user();
        return response()->json([
            'count' => $user->favorites()->count(),
            'favorites' => $user->favorites()->with('images')->latest()->get()->map(function($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'image' => $p->image_url,
                    'price' => $p->price,
                    'url' => route('product.show', $p->slug)
                ];
            })
        ]);
    }

    public function clearAll()
    {
        Auth::user()->favorites()->detach();
        return response()->json([
            'message' => 'Wishlist cleared successfully',
            'count' => 0
        ]);
    }
}
