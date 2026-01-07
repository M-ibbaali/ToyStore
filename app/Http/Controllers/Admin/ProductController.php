<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0|gte:price',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_urls.*' => 'nullable|url'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        return \Illuminate\Support\Facades\DB::transaction(function() use ($validated, $request) {
            $product = Product::create($validated);
            $hasPrimary = false;

            // Handle file uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $path,
                        'is_primary' => !$hasPrimary
                    ]);
                    $hasPrimary = true;
                }
            }

            // Handle image URLs
            if ($request->has('image_urls')) {
                foreach ($request->image_urls as $url) {
                    if ($url) {
                        ProductImage::create([
                            'product_id' => $product->id,
                            'image' => $url,
                            'is_primary' => !$hasPrimary
                        ]);
                        $hasPrimary = true;
                    }
                }
            }

            return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
        });
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0|gte:price',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_urls.*' => 'nullable|url'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        return \Illuminate\Support\Facades\DB::transaction(function() use ($validated, $request, $product) {
            $product->update($validated);
            $hasPrimary = $product->images()->where('is_primary', true)->exists();

            // Handle new file uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $path,
                        'is_primary' => !$hasPrimary
                    ]);
                    $hasPrimary = true;
                }
            }

            // Handle new image URLs
            if ($request->has('image_urls')) {
                foreach ($request->image_urls as $url) {
                    if ($url) {
                        // Check if URL already exists for this product to avoid duplicates
                        $exists = ProductImage::where('product_id', $product->id)
                            ->where('image', $url)
                            ->exists();
                        
                        if (!$exists) {
                            ProductImage::create([
                                'product_id' => $product->id,
                                'image' => $url,
                                'is_primary' => !$hasPrimary
                            ]);
                            $hasPrimary = true;
                        }
                    }
                }
            }

            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
        });
    }

    public function destroy(Product $product)
    {
        // Delete associated images
        foreach ($product->images as $image) {
            if (!str_starts_with($image->image, 'http')) {
                Storage::disk('public')->delete($image->image);
            }
            $image->delete();
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }

    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);
        if (!str_starts_with($image->image, 'http')) {
            Storage::disk('public')->delete($image->image);
        }
        $image->delete();

        return back()->with('success', 'Image deleted successfully!');
    }
}
