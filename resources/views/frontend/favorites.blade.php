@extends('layouts.frontend')

@section('title', 'My Wishlist - ToyStore')

@section('content')
<x-dashboard-layout>
    <!-- Header -->
    <div class="mb-12 flex flex-col sm:flex-row sm:items-end justify-between gap-6">
        <div>
            <h1 class="text-4xl font-black text-toys-text tracking-tight mb-2 uppercase">My Toy Wishlist</h1>
            <p class="text-gray-500 font-bold uppercase text-xs tracking-widest text-primary">Your favorite finds and future adventures.</p>
        </div>

        @if($favorites->count() > 0)
            <button id="clear-wishlist-btn" onclick="clearWishlist()" class="px-8 py-3.5 bg-gray-50 text-red-400 rounded-2xl text-[10px] font-black uppercase tracking-widest border border-gray-100 hover:bg-red-50 hover:text-red-500 hover:border-red-100 transition-all flex items-center gap-3 group">
                <svg class="w-4 h-4 group-hover:shake" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Clear My Wishlist
            </button>
        @endif
    </div>

    <div id="wishlist-container">
        @if($favorites->count() > 0)
            <!-- Favorites Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8" id="favorites-grid">
                @foreach($favorites as $product)
                    <div class="product-card group bg-white rounded-[2.5rem] border border-gray-50 overflow-hidden hover:shadow-2xl hover:shadow-gray-200/50 transition-all duration-500" data-product-id="{{ $product->id }}">
                        <!-- Image Wrapper -->
                        <div class="relative aspect-square overflow-hidden">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            
                            <!-- Actions -->
                            <div class="absolute top-4 right-4 flex flex-col gap-2 z-20">
                                <button onclick="toggleFavorite({{ $product->id }})" 
                                        class="w-8 h-8 bg-white/90 backdrop-blur-sm shadow-lg rounded-full flex items-center justify-center text-red-500 hover:bg-red-500 hover:text-white transition-all ring-1 ring-gray-100 group/btn"
                                        title="Supprimer de la liste">
                                    <svg class="w-4 h-4 transition-transform group-hover/btn:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>

                            <!-- Brand Badge -->
                            <div class="absolute bottom-4 left-4">
                                <span class="px-4 py-1.5 bg-white/90 backdrop-blur-md rounded-full text-[10px] font-black uppercase tracking-widest text-toys-text shadow-sm border border-white/50">
                                    {{ $product->category->name ?? 'Toy' }}
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-8">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-base font-black text-toys-text uppercase tracking-tight group-hover:text-primary transition-colors pr-4 truncate">{{ $product->name }}</h3>
                                <span class="text-lg font-black text-secondary font-mono">{{ formatPrice($product->price) }}</span>
                            </div>

                            <a href="{{ route('product.show', $product->slug) }}" class="flex items-center justify-center w-full py-4 bg-gray-50 text-toys-text rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-primary hover:text-white hover:shadow-xl hover:shadow-primary/20 transition-all duration-300">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div id="wishlist-pagination" class="mt-12 pt-8 border-t border-gray-50 {{ !$favorites->hasPages() ? 'hidden' : '' }}">
                {{ $favorites->links() }}
            </div>
        @else
            @include('partials.wishlist-empty')
        @endif
    </div>
</x-dashboard-layout>

<!-- Empty State Template (Hidden until needed) -->
<template id="empty-wishlist-template">
    <div class="text-center py-24 bg-gray-50/50 rounded-[3rem] border border-dashed border-gray-200 animate-fade-in">
        <div class="w-24 h-24 bg-white rounded-[2rem] flex items-center justify-center mx-auto mb-8 shadow-sm border border-gray-50">
            <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
        </div>
        <h3 class="text-2xl font-black text-toys-text mb-3 uppercase tracking-tight">Your Wishlist is Empty</h3>
        <p class="text-gray-400 font-bold mb-10 max-w-sm mx-auto uppercase text-[10px] tracking-[0.2em] leading-loose">Save your favorite toys here to keep track of the fun!</p>
        <a href="{{ route('shop.index') }}" class="inline-flex items-center px-10 py-5 bg-primary text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-primary/20 hover:bg-secondary transition-all hover:-translate-y-1 active:scale-95">
            Go Exploring
        </a>
    </div>
</template>

@push('scripts')
<script>
// Specialized callback for the favorites page grid
function removeFromWishlistGrid(productId, newCount) {
    const card = document.querySelector(`.product-card[data-product-id="${productId}"]`);
    if (!card) return;

    // Animation for removal
    card.style.transform = 'scale(0.9) translateY(20px)';
    card.style.opacity = '0';
    
    setTimeout(() => {
        card.remove();
        
        // If no items left, show empty state
        const grid = document.getElementById('favorites-grid');
        if (grid && grid.children.length === 0) {
            showEmptyState();
        }
    }, 500);
}

async function clearWishlist() {
    if (!confirm('Are you sure you want to clear your entire wishlist?')) return;

    try {
        const response = await fetch('{{ route("favorites.clear") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        });

        if (response.ok) {
            const data = await response.json();
            
            const grid = document.getElementById('favorites-grid');
            if (grid) {
                grid.style.opacity = '0';
                grid.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    showEmptyState();
                    
                    // Update counters with animation
                    const badges = document.querySelectorAll('#fav-badge');
                    badges.forEach(badge => {
                        badge.textContent = '0';
                        badge.classList.add('hidden');
                        badge.classList.add('animate-bounce-scale');
                        setTimeout(() => badge.classList.remove('animate-bounce-scale'), 500);
                    });

                    const dropdownCount = document.getElementById('fav-dropdown-count');
                    if (dropdownCount) dropdownCount.textContent = '0 Items';
                    
                    const dropdownList = document.getElementById('fav-dropdown-list');
                    if (dropdownList) {
                        dropdownList.innerHTML = `
                            <div class="py-6 text-center">
                                <p class="text-sm font-bold text-gray-400">No favorite products yet</p>
                            </div>
                        `;
                    }
                }, 500);
            }
        }
    } catch (error) {
        console.error('Error clearing wishlist:', error);
    }
}

function showEmptyState() {
    const container = document.getElementById('wishlist-container');
    const template = document.getElementById('empty-wishlist-template');
    const clearBtn = document.getElementById('clear-wishlist-btn');
    const pagination = document.getElementById('wishlist-pagination');

    if (container && template) {
        container.innerHTML = template.innerHTML;
    }
    
    if (clearBtn) clearBtn.remove();
    if (pagination) pagination.remove();
}
</script>
@endpush
@endsection
