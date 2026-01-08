@extends('layouts.frontend')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 font-sans">
    <!-- Breadcrumbs -->
    <nav class="flex items-center space-x-2 text-sm text-gray-400 mb-6 px-4 sm:px-0">
        <a href="{{ route('home') }}" class="hover:text-black transition-colors">Home</a>
        <span class="text-gray-300">/</span>
        <a href="{{ route('shop.index') }}" class="hover:text-black transition-colors">Shop</a>
        <span class="text-gray-300">/</span>
        <span class="text-gray-500 font-bold">{{ $product->category->name }}</span>
    </nav>

    <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- LEFT COLUMN: Images -->
        <div class="flex flex-col" 
             x-data="{ 
                currentIndex: 0, 
                images: [
                    @foreach($product->images as $image)
                        '{{ str_starts_with($image->image, 'http') ? $image->image : asset('storage/' . $image->image) }}'{{ !$loop->last ? ',' : '' }}
                    @endforeach
                ],
                prev() { this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length },
                next() { this.currentIndex = (this.currentIndex + 1) % this.images.length }
             }">
            <!-- Main Image Wrapper -->
            <div class="relative group">
                <!-- Main Image -->
                <div class="w-full aspect-square bg-white border border-gray-100 p-8 rounded-3xl relative flex items-center justify-center mb-6 overflow-hidden cursor-crosshair"
                     x-data="{ zoom: false, x: 0, y: 0 }"
                     @mousemove="zoom = true; x = (($event.clientX - $el.getBoundingClientRect().left) / $el.clientWidth) * 100; y = (($event.clientY - $el.getBoundingClientRect().top) / $el.clientHeight) * 100"
                     @mouseleave="zoom = false">
                     
                    <img id="mainImage" :src="images[currentIndex]" 
                         alt="{{ $product->name }}" 
                         class="w-full h-full object-contain transition-opacity duration-300"
                         :class="{ 'scale-150': zoom, 'scale-100': !zoom }"
                         :style="zoom ? `transform-origin: ${x}% ${y}%` : ''">

                    @if($product->original_price > $product->price)
                    <div class="absolute top-4 left-4 bg-black text-white px-3 py-1 text-xs font-bold rounded-full z-10">
                        -{{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}%
                    </div>
                    @endif
                </div>

                <!-- Navigation Arrows -->
                @if($product->images->count() > 1)
                <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/80 hover:bg-white rounded-full flex items-center justify-center shadow-md transition-all opacity-0 group-hover:opacity-100 focus:outline-none z-20 translate-x-4 group-hover:translate-x-0" title="Previous Image">
                    <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" /></svg>
                </button>
                <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/80 hover:bg-white rounded-full flex items-center justify-center shadow-md transition-all opacity-0 group-hover:opacity-100 focus:outline-none z-20 -translate-x-4 group-hover:translate-x-0" title="Next Image">
                    <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
                </button>
                @endif
            </div>

            <!-- Thumbnails -->
            @if($product->images->count() > 1)
            <div class="flex gap-4 overflow-x-auto pb-2 custom-scrollbar scrollbar-hide justify-center lg:justify-start">
                <template x-for="(image, index) in images" :key="index">
                    <div class="flex-shrink-0 w-20 h-20 bg-white border rounded-xl overflow-hidden cursor-pointer transition-all p-2"
                         :class="currentIndex === index ? 'border-black ring-1 ring-black' : 'border-gray-200 hover:border-black'"
                         @click="currentIndex = index">
                        <img :src="image" 
                             :alt="'{{ $product->name }} ' + index" 
                             class="w-full h-full object-contain">
                    </div>
                </template>
            </div>
            @endif
        </div>

        <!-- RIGHT COLUMN: Info & Actions -->
        <div class="flex flex-col items-start pt-2">

            <!-- SKU placeholder if available or just ID for now since reference has SKU -->
            <div class="text-xs text-gray-400 font-bold mb-2">Sku: {{ $product->id }}</div>

            <!-- Review Stars -->
            <div class="flex items-center gap-1 mb-3">
                <div class="flex text-blue-500 text-sm">
                    @for($i=1; $i<=5; $i++)
                        <span>{{ $i <= round($product->average_rating) ? '★' : '☆' }}</span>
                    @endfor
                </div>
                <span class="text-xs text-gray-500 ml-1">({{ $product->review_count }})</span>
            </div>

            <!-- Title -->
            <h1 class="text-4xl font-serif font-bold text-gray-900 mb-4 tracking-tight leading-tight">{{ $product->name }}</h1>

            <!-- Price -->
            <div class="flex items-center gap-3 mb-6">
                <span class="text-3xl font-bold text-blue-500">{{ formatPrice($product->price) }}</span>
                @if($product->original_price > $product->price)
                    <span class="text-lg text-gray-400 line-through font-medium">{{ formatPrice($product->original_price) }}</span>
                    <span class="bg-blue-500 text-white text-xs font-bold px-2 py-1 rounded-full uppercase">Sale</span>
                @endif
            </div>

            <!-- Stock Status -->
            @if($product->stock > 0)
                <div class="mb-8 w-full">
                    <p class="text-sm text-gray-500 mb-2">Only <span class="text-black font-bold">{{ $product->stock }}</span> items in stock!</p>
                    <div class="w-full h-1 bg-gray-100 rounded-full overflow-hidden max-w-xs">
                        <div class="h-full bg-blue-500" style="width: {{ min(100, ($product->stock / 20) * 100) }}%"></div>
                    </div>
                </div>
            @else
                <p class="text-red-500 font-bold mb-8">Out of Stock</p>
            @endif

            <!-- Variants Placeholder (Color/Weight) - Visual only if data existed, but looping category as mock 'Brand' above -->
            <!-- Keeping strictly to existing data, so no fake variants. -->

            <!-- Actions Form -->
            @if($product->stock > 0)
            <div class="w-full max-w-md space-y-6">
                <!-- Quantity Label -->
                <div class="space-y-2">
                    <label class="font-bold text-sm text-gray-900">Quantity</label>
                    <div class="flex gap-4">
                        <!-- Quantity Input -->
                        <div class="flex items-center border border-gray-300 rounded-md h-12 w-32">
                            <button type="button" onclick="this.nextElementSibling.stepDown()" class="w-10 h-full text-gray-500 hover:text-black text-xl flex items-center justify-center">-</button>
                            <input type="number" id="quantity-input" name="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                   class="w-full bg-transparent border-none focus:ring-0 text-center font-bold text-gray-900 p-0 h-full text-lg">
                            <button type="button" onclick="this.previousElementSibling.stepUp()" class="w-10 h-full text-gray-500 hover:text-black text-xl flex items-center justify-center">+</button>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col gap-3">
                    <button type="button" onclick="addToCart({{ $product->id }}, document.getElementById('quantity-input').value)" 
                            class="w-full bg-blue-500 hover:bg-blue-600 text-white h-12 rounded-md font-bold text-sm uppercase tracking-wider transition-colors shadow-sm">
                        Add to Cart
                    </button>
                    <!-- Buy Now Button (Requested NOT to add, so omitted) -->
                </div>
            </div>
            @endif

            <!-- Safe Checkout Logos (Static Image or Icons) -->
            <div class="mt-8 mb-8">
                <p class="text-xs text-gray-500 mb-2">Guaranteed safe checkout</p>
                <div class="flex gap-2 grayscale opacity-70">
                    <!-- Simple SVG placeholders for credit cards -->
                    <svg class="h-6" viewBox="0 0 38 24" fill="none"><rect width="38" height="24" rx="2" fill="#1A1F71"/><path d="M22.5 12h-10M22.5 15h-10" stroke="white" stroke-linecap="round"/></svg>
                    <svg class="h-6" viewBox="0 0 38 24" fill="none"><rect width="38" height="24" rx="2" fill="#EB001B"/><circle cx="13" cy="12" r="6" fill="#F79E1B" fill-opacity="0.8"/><circle cx="25" cy="12" r="6" fill="#EB001B" fill-opacity="0.8"/></svg>
                    <svg class="h-6" viewBox="0 0 38 24" fill="none"><rect width="38" height="24" rx="2" fill="#0079C1"/><path d="M10 8h18M10 12h12M10 16h8" stroke="white" stroke-linecap="round"/></svg>
                </div>
            </div>

            <!-- Accordion Sections -->
            <div class="w-full border-t border-gray-100" x-data="{ active: 'desc' }">
                <!-- Description -->
                <div class="border-b border-gray-100">
                    <button @click="active = active === 'desc' ? null : 'desc'" class="w-full py-4 flex items-center justify-between text-left group">
                        <span class="font-bold text-lg text-gray-900 flex items-center gap-2">
                            <span class="text-sm">☆</span> Product Description
                        </span>
                        <svg class="w-4 h-4 text-gray-400 transform transition-transform" :class="active === 'desc' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="active === 'desc'" x-collapse class="pb-4 text-gray-600 leading-relaxed text-sm">
                        {{ $product->description }}
                    </div>
                </div>


            </div>
            


        </div>
    <!-- End of 2-column grid -->
    </div>


    <!-- Reviews Section Redesign -->
    <section class="mt-24 mb-24 bg-white rounded-[2rem] p-6 sm:p-12 shadow-sm border border-gray-100" id="reviews-section" x-data="{ starFilter: 'all' }">
        <h2 class="text-2xl sm:text-3xl font-serif font-bold text-gray-900 mb-8 sm:mb-12 text-center sm:text-left">Customer Reviews</h2>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-10 lg:gap-16 items-start">
            <!-- LEFT COLUMN: Summary Card -->
            <div class="lg:col-span-1">
                <div class="bg-gray-50 border border-gray-100 rounded-2xl p-6 sm:p-8">
                    <div class="flex flex-col items-center text-center pb-6 sm:pb-8 border-b border-gray-200">
                        <div class="text-5xl sm:text-6xl font-bold text-gray-900 mb-2">{{ number_format($product->average_rating, 1) }}</div>
                        <div class="flex text-yellow-400 text-lg sm:text-xl mb-2">
                            @for($i=1; $i<=5; $i++)
                                <span>{{ $i <= round($product->average_rating) ? '★' : '☆' }}</span>
                            @endfor
                        </div>
                        <div class="text-gray-500 font-medium text-sm sm:text-base">{{ $product->review_count }} Reviews</div>
                    </div>

                    <!-- Rating Breakdown -->
                    <div class="py-6 sm:py-8 space-y-3">
                        @for($i=5; $i>=1; $i--)
                        @php
                            $count = $product->reviews()->where('rating', $i)->count();
                            $total = $product->review_count > 0 ? $product->review_count : 1;
                            $percent = round(($count / $total) * 100);
                        @endphp
                        <div class="flex items-center gap-3 text-xs sm:text-sm group cursor-pointer" @click="starFilter = {{ $i }}">
                            <div class="flex items-center gap-1 w-8">
                                <span class="font-bold text-gray-700">{{ $i }}</span>
                                <span class="text-yellow-400 text-[10px] text-center">★</span>
                            </div>
                            <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-yellow-400 rounded-full" style="width: {{ $percent }}%"></div>
                            </div>
                            <div class="w-10 text-right text-gray-400 font-medium">{{ $percent }}%</div>
                        </div>
                        @endfor
                    </div>

                    <!-- Write a Review Button -->
                    <div class="pt-6 sm:pt-8 border-t border-gray-200 text-center">
                        <p class="text-sm text-gray-600 mb-1 font-medium">Review this product</p>
                        <p class="text-[11px] text-gray-400 mb-6 leading-tight">Share your thoughts with other customers</p>
                        <button type="button" 
                                @click="document.getElementById('review-form-modal')?.classList.remove('hidden')"
                                class="w-full bg-[#333c4e] hover:bg-[#2a3140] text-white py-3 rounded-lg font-bold text-sm transition-all shadow-md">
                            Write a review
                        </button>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: Reviews List -->
            <div class="lg:col-span-3">
                <!-- Filters Header -->
                <div class="flex items-center gap-2 mb-8 overflow-x-auto pb-3 scrollbar-hide -mx-2 px-2">
                    <button @click="starFilter = 'all'" 
                            :class="starFilter === 'all' ? 'bg-[#333c4e] text-white shadow-lg' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 border border-gray-100'"
                            class="px-5 sm:px-6 py-2 sm:py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all whitespace-nowrap">
                        All
                    </button>
                </div>

                <!-- Actual Reviews -->
                <div class="divide-y divide-gray-100">
                    @forelse($product->reviews()->latest()->get() as $review)
                    <div class="py-10 first:pt-0 last:pb-0" 
                         x-show="starFilter === 'all' || starFilter === {{ $review->rating }}">
                        <div class="flex flex-col sm:flex-row sm:items-start gap-4 sm:gap-5 mb-4">
                            <!-- Avatar + Info Row -->
                            <div class="flex items-center sm:items-start gap-4 flex-1">
                                <!-- Avatar -->
                                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-[#c0392b] flex items-center justify-center text-white font-bold text-lg sm:text-xl flex-shrink-0 shadow-sm">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-1">
                                        <div class="font-bold text-gray-900 text-base sm:text-lg">{{ $review->user->name }}</div>
                                        <div class="text-[11px] sm:text-sm text-gray-400 font-medium">Reviewed on {{ $review->created_at->format('d/m/Y') }}</div>
                                    </div>
                                    <div class="flex text-yellow-400 text-xs sm:text-sm">
                                        @for($i=1; $i<=5; $i++)
                                            <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pl-0 sm:pl-[76px]">
                            <p class="text-gray-600 text-sm sm:text-[15px] leading-relaxed max-w-2xl">{{ $review->comment }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="bg-gray-50 rounded-3xl p-16 text-center">
                        <div class="text-4xl mb-4">📝</div>
                        <p class="text-gray-500 font-medium italic">No reviews yet for this product.</p>
                    </div>
                    @endforelse
                </div>

                <!-- Load More Placeholder -->
                @if($product->review_count > 5)
                <div class="mt-12 text-center">
                    <button class="px-8 py-3 rounded-xl border border-gray-200 text-gray-700 font-bold text-sm hover:bg-gray-50 transition-colors">
                        Load More Reviews
                    </button>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Review Form Modal (Alpine controlled visibility) -->
    <div id="review-form-modal" 
         class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm transition-opacity duration-300"
         x-data="{ closeModal() { document.getElementById('review-form-modal').classList.add('hidden') } }"
         @keydown.escape.window="closeModal()">
        
        <!-- Backdrop clickable to close -->
        <div class="absolute inset-0" @click="closeModal()"></div>

        <div class="bg-white rounded-3xl w-full max-w-xl shadow-2xl overflow-hidden relative animate-in fade-in zoom-in duration-300" 
             @click.stop>
            <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-[#333c4e] text-white">
                <h3 class="text-xl font-bold">Write a Review</h3>
                <button @click="closeModal()" class="hover:rotate-90 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            
            <div class="p-8">
                @auth
                    @if(!$product->reviews()->where('user_id', auth()->id())->exists())
                        <form action="{{ route('reviews.store', $product->id) }}" method="POST" class="space-y-6">
                            @csrf
                            <div x-data="{ rating: 0, hover: 0 }">
                                <label class="block text-sm font-bold text-gray-700 mb-2">How would you rate it?</label>
                                <div class="flex gap-2">
                                    <input type="hidden" name="rating" :value="rating" required>
                                    <template x-for="i in 5">
                                        <button type="button" 
                                                @click="rating = i" 
                                                @mouseover="hover = i" 
                                                @mouseleave="hover = 0"
                                                class="focus:outline-none transition-transform hover:scale-125">
                                            <svg class="w-8 h-8 transition-colors" 
                                                 :class="(hover > 0 ? i <= hover : i <= rating) ? 'text-yellow-400 fill-current' : 'text-gray-300'"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-1.724 1.44-1.121.859l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.784.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                            </svg>
                                        </button>
                                    </template>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Your Thoughts</label>
                                <textarea name="comment" rows="5" 
                                          class="w-full border-gray-200 rounded-xl focus:ring-[#333c4e] focus:border-[#333c4e] text-sm" 
                                          placeholder="What did you like or dislike? How was the quality?"></textarea>
                            </div>

                            <div class="flex gap-4 pt-2">
                                <button type="button" @click="closeModal()" 
                                        class="flex-1 bg-gray-100 text-gray-700 py-4 rounded-xl font-bold uppercase tracking-widest hover:bg-gray-200 transition">
                                    Cancel
                                </button>
                                <button type="submit" class="flex-[2] bg-[#333c4e] text-white py-4 rounded-xl font-bold uppercase tracking-widest hover:bg-[#2a3140] transition shadow-lg">
                                    Submit Review
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="text-center py-8">
                            <div class="text-5xl mb-4">✨</div>
                            <h4 class="text-xl font-bold text-gray-900 mb-2">Already Reviewed!</h4>
                            <p class="text-gray-500 mb-8">Thank you for sharing your feedback on this product.</p>
                            <button @click="closeModal()" class="bg-[#333c4e] text-white px-8 py-3 rounded-xl font-bold">
                                Close
                            </button>
                        </div>
                    @endif
                @else
                    <div class="text-center py-12">
                        <p class="text-gray-600 mb-8">Please log in to share your experience with other customers.</p>
                        <div class="flex flex-col gap-3 max-w-xs mx-auto">
                            <a href="{{ route('login') }}" class="w-full bg-[#333c4e] text-white py-4 rounded-xl font-bold transition shadow-lg">
                                Login Now
                            </a>
                            <button @click="closeModal()" class="w-full bg-gray-100 text-gray-700 py-4 rounded-xl font-bold">
                                Back to Product
                            </button>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Related Products Redesign -->
    @if($relatedProducts->count() > 0)
    <section class="mt-24 mb-24 bg-white rounded-[2rem] p-6 sm:p-12 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-12">
            <h2 class="text-3xl font-serif font-bold text-gray-900">More Fun Finds ✨</h2>
            <a href="{{ route('shop.index') }}" class="text-sm font-bold text-gray-400 hover:text-gray-900 border-b border-gray-200 hover:border-gray-900 transition-all pb-1 uppercase tracking-widest">See All Toys</a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($relatedProducts as $related)
            <div class="group bg-gray-50 rounded-3xl overflow-hidden border border-gray-100 hover:border-gray-200 hover:shadow-xl transition-all duration-500 flex flex-col h-full">
                <a href="{{ route('product.show', $related->slug) }}" class="flex-grow flex flex-col">
                    <div class="aspect-square overflow-hidden bg-white relative">
                        @if($related->images->count() > 0)
                            @php
                                $firstRelImage = $related->images->first()->image;
                                $relImagePath = str_starts_with($firstRelImage, 'http') ? $firstRelImage : asset('storage/' . $firstRelImage);
                            @endphp
                            <img src="{{ $relImagePath }}" 
                                 alt="{{ $related->name }}" 
                                 class="w-full h-full object-contain group-hover:scale-110 transition duration-700 p-4">
                        @endif
                    </div>
                    <div class="p-6">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">{{ $related->category->name }}</p>
                        <h3 class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors mb-4 line-clamp-1">{{ $related->name }}</h3>
                        <div class="flex items-center justify-between mt-auto">
                            <span class="text-xl font-bold text-gray-900">{{ formatPrice($related->price) }}</span>
                            <div class="w-10 h-10 bg-white border border-gray-200 text-gray-400 rounded-xl flex items-center justify-center group-hover:bg-[#333c4e] group-hover:text-white group-hover:border-[#333c4e] transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
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
@endsection
