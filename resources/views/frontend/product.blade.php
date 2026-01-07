@extends('layouts.frontend')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
   <!-- Breadcrumbs -->
<nav class="flex items-center space-x-2 text-sm font-bold text-gray-400 
            mb-8 mt-6 bg-white w-fit px-4 py-2 rounded-full shadow-sm border border-gray-100">
    <a href="{{ route('home') }}" class="hover:text-secondary transition-colors">Home</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
    </svg>
    <a href="{{ route('shop.index') }}" class="hover:text-secondary transition-colors">Shop</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
    </svg>
    <span class="text-toys-text">{{ $product->name }}</span>
</nav>

    <div class="flex flex-col lg:flex-row gap-12 mb-20 justify-center items-start">
    <!-- Product Images Section -->
    <div class="flex-1 lg:max-w-[40%] flex gap-6 lg:max-h-[500px]">
        <!-- Thumbnails -->
        @if($product->images->count() > 1)
        <div class="flex lg:flex-col gap-4 overflow-x-auto lg:overflow-visible lg:w-20 pb-2 lg:pb-0 custom-scrollbar scrollbar-hide">
            @foreach($product->images as $image)
            @php
                $thumbPath = str_starts_with($image->image, 'http') ? $image->image : asset('storage/' . $image->image);
            @endphp
            <div class="flex-shrink-0 w-20 h-24 bg-white rounded-lg overflow-hidden cursor-pointer border-2 border-transparent hover:border-secondary transition-all shadow-sm"
                 onclick="document.getElementById('mainImage').src='{{ $thumbPath }}'">
                <img src="{{ $thumbPath }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-full object-cover">
            </div>
            @endforeach
        </div>
        @endif

        <!-- Main Image -->
        <div class="flex-1 aspect-[4/5] bg-white rounded-none overflow-hidden relative group cursor-zoom-in"
             x-data="{ zoom: false, x: 0, y: 0 }"
             @mousemove="zoom = true; x = (($event.clientX - $el.getBoundingClientRect().left) / $el.clientWidth) * 100; y = (($event.clientY - $el.getBoundingClientRect().top) / $el.clientHeight) * 100"
             @mouseleave="zoom = false">
            <img id="mainImage" src="{{ $product->image_url }}" 
                 alt="{{ $product->name }}" 
                 class="w-full h-full object-cover transition-transform duration-200"
                 :class="{ 'scale-150': zoom, 'scale-100': !zoom }"
                 :style="zoom ? `transform-origin: ${x}% ${y}%` : ''">

            @if($product->original_price > $product->price)
            <div class="absolute top-4 left-4 bg-primary text-white px-3 py-1 text-xs font-bold uppercase tracking-widest z-10 pointer-events-none">
                Sale
            </div>
            @endif
        </div>
    </div>
    
    <!-- Product Info + Description Column (Right) -->
    <div class="flex-1 lg:max-w-[40%] flex flex-col">
        <div class="mb-6">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">BRAND: {{ $product->category->name }}</p>
            <h1 class="text-3xl font-bold text-toys-text mb-2">{{ $product->name }}</h1>
            
            <!-- Rating Stars -->
            <div class="flex items-center gap-2 mb-6">
                <div class="flex text-primary text-sm">
                    @for($i=1; $i<=5; $i++)
                        <span>{{ $i <= round($product->average_rating) ? '★' : '☆' }}</span>
                    @endfor
                </div>
                <span class="text-xs font-bold text-gray-400 underline cursor-pointer" @click="activeTab = 'reviews'; $el.scrollIntoView({behavior: 'smooth'})">{{ $product->review_count }} REVIEWS</span>
                <span class="text-xs font-bold text-gray-300">|</span>
                <span class="text-xs font-bold text-gray-400 cursor-pointer" @click="activeTab = 'reviews'; $el.scrollIntoView({behavior: 'smooth'})">Write Review</span>
            </div>

            <div class="flex items-center gap-4 mb-8">
                <span class="text-3xl font-bold text-toys-text">{{ formatPrice($product->price) }}</span>
                @if($product->original_price > $product->price)
                <span class="text-lg text-gray-400 line-through font-bold decoration-red-500">{{ formatPrice($product->original_price) }}</span>
                @endif
            </div>

            @if($product->stock > 0)
            <div class="space-y-6">
                <!-- Quantity & Add to Cart Container -->
                <div class="flex flex-col gap-4">
                    <div class="flex items-center border border-gray-300 rounded-full w-full h-12 px-4 relative">
                        <button type="button" onclick="this.nextElementSibling.stepDown()" class="w-8 h-full text-gray-500 hover:text-black font-bold text-xl absolute left-4">-</button>
                        <input type="number" id="quantity-input" name="quantity" value="1" min="1" max="{{ $product->stock }}" 
                               class="w-full bg-transparent border-none focus:ring-0 text-center font-bold text-toys-text p-0 h-full">
                        <button type="button" onclick="this.previousElementSibling.stepUp()" class="w-8 h-full text-gray-500 hover:text-black font-bold text-xl absolute right-4">+</button>
                    </div>
                    
                    <div class="flex gap-4">
                        <button type="button" onclick="addToCart({{ $product->id }}, document.getElementById('quantity-input').value)" class="flex-1 bg-primary text-white h-12 rounded-full hover:bg-primary-700 transition-all font-bold text-sm uppercase tracking-widest shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                            Add to Cart
                        </button>

                        <button type="button" onclick="toggleFavorite({{ $product->id }})" 
                                class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center hover:bg-gray-200 transition-colors group/fav"
                                title="Add to Favorites">
                            <svg class="fav-icon-{{ $product->id }} w-5 h-5 transition-colors {{ auth()->check() && auth()->user()->favorites->contains($product->id) ? 'text-red-500' : 'text-gray-400' }}" 
                                 fill="{{ auth()->check() && auth()->user()->favorites->contains($product->id) ? 'currentColor' : 'none' }}" 
                                 stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            @else
                <div class="w-full h-12 bg-gray-100 rounded-full flex items-center justify-center text-gray-400 font-bold uppercase tracking-widest">
                    Out of Stock
                </div>
            @endif

            <!-- Description Section -->
            <div class="mt-8 p-6 bg-white rounded-lg shadow-sm">
                <h3 class="text-xl font-bold mb-4">Product Details</h3>
                <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
            </div>
        </div>
    </div>
</div>


    <!-- Reviews Section -->
    <section class="mt-20 mb-20 bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-10">
            <h2 class="text-4xl font-black text-toys-text">Customer Reviews 💬</h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
             <!-- Reviews List (Left) -->
             <div class="lg:col-span-7 space-y-8">
                <h3 class="text-xl font-bold">Reviews</h3>
                @forelse($product->reviews()->latest()->get() as $review)
                     <div class="border-b border-gray-100 pb-8">
                         <div class="flex justify-between items-start mb-2">
                             <div class="flex items-center gap-3">
                                 <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center font-bold text-gray-500">
                                    {{ substr($review->user->name, 0, 1) }}
                                 </div>
                                 <span class="font-bold text-sm uppercase tracking-wider">{{ $review->user->name }}</span>
                             </div>
                             <span class="text-xs text-gray-400">{{ $review->created_at->format('m/d/y') }}</span>
                         </div>
                         <div class="flex text-primary text-xs mb-3">
                             @for($i=1; $i<=5; $i++)
                                 <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                             @endfor
                         </div>
                         <p class="text-gray-600 text-sm leading-relaxed">{{ $review->comment }}</p>
                     </div>
                 @empty
                     <p class="text-gray-500 italic">No reviews yet.</p>
                 @endforelse
                 
                 <div class="text-center pt-8">
                    <button class="px-8 py-3 rounded-full border border-primary text-primary font-bold text-sm uppercase hover:bg-primary hover:text-white transition-colors">
                        Load More Reviews
                    </button>
                 </div>
             </div>

             <!-- Review Form & Stats (Right) -->
             <div class="lg:col-span-5 border border-primary rounded-none p-8 h-fit">
                 <div class="flex items-center justify-between mb-6 border-b border-gray-200 pb-6">
                     <div>
                         <span class="text-3xl font-bold">{{ number_format($product->average_rating, 1) }}</span>
                         <span class="text-gray-400 text-xs font-bold uppercase ml-2">of 5 stars</span>
                     </div>
                     <div class="flex text-primary">
                         @for($i=1; $i<=5; $i++)
                             <span>{{ $i <= round($product->average_rating) ? '★' : '☆' }}</span>
                         @endfor
                     </div>
                 </div>
                 
                 <!-- Star Bars -->
                 <div class="space-y-3 mb-10">
                    @for($i=5; $i>=1; $i--)
                     <div class="flex items-center gap-4 text-xs font-bold text-gray-400">
                         <div class="flex text-primary w-20">
                             @for($star=1; $star<=5; $star++)
                                 <span class="{{ $star <= $i ? 'text-primary' : 'text-gray-200' }}">★</span>
                             @endfor
                         </div>
                         <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                             @php
                                 $count = $product->reviews()->where('rating', $i)->count();
                                 $total = $product->review_count > 0 ? $product->review_count : 1;
                                 $percent = ($count / $total) * 100;
                             @endphp
                             <div class="h-full bg-primary" style="width: {{ $percent }}%"></div>
                         </div>
                         <span class="w-6 text-right">{{ $count }}</span>
                     </div>
                    @endfor
                 </div>

                <!-- Form -->
                @auth
                    @if(!$product->reviews()->where('user_id', auth()->id())->exists())
                        <h4 class="font-bold uppercase tracking-widest text-sm mb-4">Write a Review</h4>
                        <form action="{{ route('reviews.store', $product->id) }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="flex gap-2 mb-2" x-data="{ rating: 0, hover: 0 }">
                                <label class="text-xs font-bold pt-1">Rating:</label>
                                <div class="flex gap-1 cursor-pointer">
                                    <input type="hidden" name="rating" :value="rating" required>
                                    <template x-for="i in 5">
                                        <button type="button" 
                                                @click="rating = i" 
                                                @mouseover="hover = i" 
                                                @mouseleave="hover = 0"
                                                class="focus:outline-none transition-transform duration-100 hover:scale-110">
                                            <span class="text-2xl" 
                                                  :class="(hover > 0 ? i <= hover : i <= rating) ? 'text-yellow-400' : 'text-gray-300'">★</span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                            <textarea name="comment" rows="4" class="w-full border border-gray-300 p-3 text-sm focus:border-primary focus:ring-0" placeholder="Your review..."></textarea>
                            <button type="submit" class="w-full bg-primary text-white py-3 font-bold uppercase tracking-widest hover:bg-primary-700 transition">Submit Now</button>
                        </form>
                    @else
                        <div class="bg-green-50 p-6 border border-green-100 text-center">
                            <span class="text-3xl block mb-2">✨</span>
                            <p class="text-green-700 font-bold mb-1">Thanks for sharing!</p>
                            <p class="text-green-600 text-sm">You have already reviewed this product.</p>
                        </div>
                    @endif
                @else
                     <p class="text-sm text-center text-gray-500">Please <a href="{{ route('login') }}" class="underline font-bold">login</a> to write a review.</p>
                @endauth
             </div>
        </div>
    </section>

        <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <section class="mt-20">
        <div class="flex items-center justify-between mb-10">
            <h2 class="text-4xl font-black text-toys-text">More Fun Finds ✨</h2>
            <a href="{{ route('shop.index') }}" class="text-secondary font-black border-b-4 border-secondary/20 hover:border-secondary transition-all pb-1 uppercase tracking-widest text-sm">See All Toys</a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($relatedProducts as $related)
            <div class="group bg-white rounded-[2rem] overflow-hidden border-2 border-transparent hover:border-primary shadow-sm hover:shadow-2xl transition-all duration-500 flex flex-col h-full">
                <a href="{{ route('product.show', $related->slug) }}" class="flex-grow flex flex-col">
                    <div class="aspect-[4/5] overflow-hidden bg-toy-bg relative">
                        @if($related->images->count() > 0)
                            @php
                                $firstRelImage = $related->images->first()->image;
                                $relImagePath = str_starts_with($firstRelImage, 'http') ? $firstRelImage : asset('storage/' . $firstRelImage);
                            @endphp
                            <img src="{{ $relImagePath }}" 
                                 alt="{{ $related->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        @endif
                    </div>
                    <div class="p-6">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">{{ $related->category->name }}</p>
                        <h3 class="font-black text-toys-text group-hover:text-secondary transition-colors mb-4 line-clamp-1">{{ $related->name }}</h3>
                        <div class="flex items-center justify-between mt-auto">
                            <span class="text-xl font-black text-primary">{{ formatPrice($related->price) }}</span>
                            <div class="w-10 h-10 bg-toy-bg text-secondary rounded-xl flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </section>
    @endif
</div>
</div>
    


   
</div>
