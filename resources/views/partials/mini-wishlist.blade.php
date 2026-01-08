<div class="px-3 mb-3 flex justify-between items-center border-b border-gray-100 pb-2">
    <span class="text-xs font-black text-toys-text uppercase tracking-widest">My Wishlist</span>
    <span class="text-[10px] font-bold text-primary px-2 py-0.5 bg-primary/10 rounded-full" id="fav-dropdown-count">{{ $wishlistCount }} Items</span>
</div>

<div id="fav-dropdown-list" class="space-y-3 max-h-80 overflow-y-auto px-1 custom-scrollbar">
    @forelse($wishlistProducts as $favProduct)
        <div class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-xl transition group/item relative" data-dropdown-id="{{ $favProduct->id }}">
            <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-50 flex-shrink-0">
                <img src="{{ $favProduct->image_url }}" class="w-full h-full object-cover">
            </div>
            <div class="flex-1 min-w-0">
                <a href="{{ route('product.show', $favProduct->slug) }}" class="text-xs font-bold text-toys-text truncate block hover:text-blue-500 transition uppercase">{{ $favProduct->name }}</a>
                <p class="text-[10px] font-black text-primary">{{ formatPrice($favProduct->price) }}</p>
            </div>
            <!-- Supprimer Button -->
            <button onclick="event.preventDefault(); toggleFavorite({{ $favProduct->id }})" 
                    class="absolute -top-1 -right-1 bg-white text-red-500 hover:bg-red-500 hover:text-white w-6 h-6 flex items-center justify-center rounded-full text-[8px] font-black uppercase transition-all duration-300 shadow-sm border border-gray-100 z-10 group/btn"
                    title="Supprimer">
                <svg class="w-2.5 h-2.5 transition-transform group-hover/btn:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    @empty
        <div class="py-6 text-center">
            <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Wishlist is empty</p>
        </div>
    @endforelse
</div>

<div class="mt-4 pt-3 border-t border-gray-50 px-2 text-center">
    <a href="{{ route('favorites.index') }}" class="text-[10px] font-black text-secondary hover:text-primary transition uppercase tracking-widest">View All Favorites →</a>
</div>
