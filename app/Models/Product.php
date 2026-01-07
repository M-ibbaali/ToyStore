<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'slug', 'description', 'price', 'original_price', 'stock', 'status'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function getImageUrlAttribute()
    {
        $primaryImage = $this->images()->where('is_primary', true)->first() ?? $this->images()->first();
        
        if ($primaryImage) {
            $image = $primaryImage->image;
            return str_starts_with($image, 'http') ? $image : asset('storage/' . $image);
        }

        return 'https://images.unsplash.com/photo-1532330393533-443990a51d10?q=80&w=300&auto=format&fit=crop'; // Default Toy Placeholder
    }

    public function promotion()
    {
        return $this->hasOne(Promotion::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function isFavoritedBy($userId)
    {
        return $this->favoritedBy()->where('user_id', $userId)->exists();
    }

    // Discount Calculation Accessors
    public function getHasDiscountAttribute()
    {
        return $this->original_price && $this->original_price > $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        if (!$this->has_discount) {
            return 0;
        }
        return round((($this->original_price - $this->price) / $this->original_price) * 100);
    }

    public function getFinalPriceAttribute()
    {
        return $this->price; // Always return the current selling price
    }
    // Reviews Relationship
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute()
    {
        return round($this->reviews()->avg('rating'), 1);
    }

    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }

    // Scope for filtering in-stock products (frontend only)
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }
}
