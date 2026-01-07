@extends('layouts.frontend')

@section('title', 'My Toy Box')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-4xl font-black text-toys-text mb-8 flex items-center gap-3">
        <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
        My Toy Box
    </h1>
    
    
    <div id="cart-content-wrapper" class="{{ $cartItems->count() > 0 ? '' : 'hidden' }}">
        <!-- Cart Table -->
        <div class="bg-white border border-gray-200 overflow-hidden mb-8">
            <!-- Table Header -->
            <div class="hidden md:grid grid-cols-12 bg-primary text-white font-black text-[11px] uppercase tracking-widest py-4 px-6">
                <div class="col-span-5">Product Detail</div>
                <div class="col-span-2 text-center">Price</div>
                <div class="col-span-3 text-center">Quantity</div>
                <div class="col-span-2 text-center">Total</div>
            </div>

            <!-- Table Body -->
            <div id="cart-item-list" class="divide-y divide-gray-200">
                @foreach($cartItems as $item)
                <div id="full-cart-item-{{ $item->id }}" class="flex flex-col md:grid md:grid-cols-12 items-center p-6 gap-6 relative transition-all duration-500 hover:bg-gray-50/50">
                    <!-- Product Info -->
                    <div class="w-full md:col-span-5 flex items-center gap-6">
                        <div class="flex-shrink-0 w-24 h-24 bg-toy-bg border border-gray-100 rounded-2xl overflow-hidden shadow-sm">
                            <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ $item->product->category->name }}</p>
                            <h3 class="text-sm font-black text-toys-text hover:text-secondary transition uppercase tracking-wide truncate">
                                <a href="{{ route('product.show', $item->product->slug) }}">{{ $item->product->name }}</a>
                            </h3>
                        </div>
                    </div>

                    <!-- Price & Quantity Wrapper (Mobile Layout) -->
                    <div class="w-full md:col-span-5 flex flex-wrap items-center justify-between gap-4">
                        <!-- Price -->
                        <div class="md:hidden">
                            <span class="text-xs font-bold text-gray-400 uppercase mr-2 text-[10px] tracking-tighter">Price</span>
                            <span class="text-sm font-black text-toys-text">{{ formatPrice($item->product->price) }}</span>
                        </div>
                        <div class="hidden md:block w-full text-center">
                            <span class="text-sm font-black text-toys-text">{{ formatPrice($item->product->price) }}</span>
                        </div>

                        <!-- Quantity -->
                        <div class="flex justify-center items-center">
                            <div class="flex items-center bg-white border-2 border-toy-bg rounded-xl h-10 px-1 shadow-sm">
                                <button type="button" 
                                        onclick="updateQuantity({{ $item->id }}, -1)" 
                                        id="btn-minus-{{ $item->id }}"
                                        class="w-8 h-full flex items-center justify-center text-gray-400 hover:text-secondary transition-colors"
                                        {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M20 12H4" /></svg>
                                </button>
                                <span id="quantity-{{ $item->id }}" class="w-8 text-center text-xs font-black text-toys-text">{{ $item->quantity }}</span>
                                <button type="button" 
                                        onclick="updateQuantity({{ $item->id }}, 1)" 
                                        id="btn-plus-{{ $item->id }}"
                                        class="w-8 h-full flex items-center justify-center text-gray-400 hover:text-secondary transition-colors"
                                        {{ $item->quantity >= $item->product->stock ? 'disabled' : '' }}>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M12 4v16m8-8H4" /></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="w-full md:col-span-2 flex items-center justify-between md:justify-center border-t border-dashed border-gray-100 pt-4 md:border-none md:pt-0">
                        <span class="md:hidden text-xs font-bold text-gray-400 uppercase text-[10px] tracking-tighter">Total</span>
                        <span class="text-sm font-black text-primary"><span id="item-subtotal-{{ $item->id }}">{{ formatPrice($item->product->price * $item->quantity) }}</span></span>
                    </div>

                    <!-- Remove -->
                    <button type="button" 
                            onclick="removeFromFullCart({{ $item->id }})" 
                            class="absolute top-4 right-4 md:top-1/2 md:-translate-y-1/2 text-gray-200 hover:text-red-500 transition-colors p-2"
                            title="Remove from cart">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                @endforeach
            </div>
        </div>



        <!-- Lower Sections Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 pt-8 border-t border-gray-100">


            <!-- Right: Cart Totals -->
            <div class="bg-gray-50 p-8 rounded-none h-fit">
                <h3 class="text-sm font-black uppercase tracking-widest text-toys-text mb-6">Cart Totals</h3>
                
                <div class="border border-red-800 p-6 space-y-4 bg-white mb-6">
                    <div class="flex justify-between items-center text-sm">
                        <span class="font-bold text-toys-text">Sub Total</span>
                        <span class="font-black">DH<span id="cart-subtotal">{{ number_format($total, 2) }}</span></span>
                    </div>
                    <div class="flex justify-between items-center text-sm border-b border-gray-100 pb-4">
                        <span class="font-bold text-toys-text">Delivery</span>
                        <span class="font-bold text-gray-500 text-xs">Free</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm font-bold uppercase tracking-widest">Total</span>
                        <span class="text-lg font-black text-toys-text">DH<span id="cart-total">{{ number_format($total, 2) }}</span></span>
                    </div>
                </div>

                <p class="text-[10px] text-gray-400 font-bold mb-8">Tax included and shipping calculated at checkout</p>

                <div class="flex items-center gap-3 mb-8">
                    <input type="checkbox" id="terms" class="w-4 h-4 text-primary focus:ring-primary border-gray-300 rounded">
                    <label for="terms" class="text-[11px] font-bold text-toys-text">I agree with the <a href="#" class="underline">Terms & Conditions</a></label>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('checkout.index') }}" class="flex-1 bg-primary text-white py-3 px-4 rounded-lg text-xs font-black uppercase tracking-widest hover:bg-secondary transition text-center shadow-lg shadow-primary/20">
                        Proceed to Checkout
                    </a>
                    <a href="{{ route('shop.index') }}" class="flex-1 border border-primary text-secondary py-3 px-4 rounded-lg text-xs font-black uppercase tracking-widest hover:bg-toy-bg transition text-center">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div id="empty-cart-message" class="{{ $cartItems->count() > 0 ? 'hidden' : '' }} text-center py-20 bg-white rounded-3xl shadow-sm border-2 border-gray-100">
        <div class="w-24 h-24 bg-toy-bg rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
        </div>
        <h2 class="text-3xl font-black text-toys-text mb-4">Your toy box is empty!</h2>
        <p class="text-gray-500 font-bold mb-8">Time to find some new favorites to play with!</p>
        <a href="{{ route('shop.index') }}" class="inline-block px-10 py-4 bg-primary text-white rounded-2xl hover:bg-secondary transition-all transform hover:-translate-y-1 shadow-lg shadow-primary/20 font-black uppercase tracking-widest active:scale-95">
            Start Shopping
        </a>
    </div>
</div>
@push('scripts')
<script>
    function updateQuantity(itemId, change) {
        const currentQty = parseInt(document.getElementById(`quantity-${itemId}`).textContent);
        const newQuantity = currentQty + change;
        if (newQuantity < 1) return;

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const url = `/cart/${itemId}`;

        // Optimitic update or loading state?
        const btnMinus = document.getElementById(`btn-minus-${itemId}`);
        const btnPlus = document.getElementById(`btn-plus-${itemId}`);
        if(btnMinus) btnMinus.disabled = true;
        if(btnPlus) btnPlus.disabled = true;

        fetch(url, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                quantity: newQuantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update quantity display
                const quantitySpan = document.getElementById(`quantity-${itemId}`);
                if (quantitySpan) quantitySpan.textContent = newQuantity;

                // Update item subtotal
                const itemSubtotalSpan = document.getElementById(`item-subtotal-${itemId}`);
                if (itemSubtotalSpan) itemSubtotalSpan.textContent = data.itemSubtotal;

                // Update cart totals using the returned cartTotal
                updateAllTotals(data.cartTotal, data.cartCount);
                
                // Update mini cart
                const miniCartDropdown = document.getElementById('mini-cart-dropdown');
                if (miniCartDropdown && data.html) {
                    miniCartDropdown.innerHTML = data.html;
                }

                // Update button states
                if (btnMinus) btnMinus.disabled = newQuantity <= 1;
                if (btnPlus) btnPlus.disabled = false; 

            } else {
                console.error(data.message || 'Error updating cart');
                if (btnMinus) btnMinus.disabled = currentQty <= 1;
                if (btnPlus) btnPlus.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (btnMinus) btnMinus.disabled = currentQty <= 1;
            if (btnPlus) btnPlus.disabled = false;
        });
    }

    function removeFromFullCart(itemId) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const itemElement = document.getElementById(`full-cart-item-${itemId}`);
        
        if (itemElement) {
            itemElement.classList.add('cart-item-fade-out');
        }

        setTimeout(() => {
            fetch(`/cart/${itemId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (itemElement) itemElement.remove();
                    
                    // Update totals
                    updateAllTotals(data.cartTotal, data.cartCount);
                    
                    // Update mini cart since it's in the same page
                    const miniCartDropdown = document.getElementById('mini-cart-dropdown');
                    if (miniCartDropdown) {
                        miniCartDropdown.innerHTML = data.html;
                    }

                    // Check if cart is empty now
                    if (data.cartCount === 0) {
                        document.getElementById('cart-content-wrapper').classList.add('hidden');
                        document.getElementById('empty-cart-message').classList.remove('hidden');
                    }
                } else {
                    console.error('Error removing item');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }, 300);
    }

    function updateAllTotals(totalString, count) {
        const cartSubtotalSpan = document.getElementById('cart-subtotal');
        if (cartSubtotalSpan) cartSubtotalSpan.textContent = totalString;

        const cartTotalSpan = document.getElementById('cart-total');
        if (cartTotalSpan) cartTotalSpan.textContent = totalString;

        // Update header badges
        updateCartCount(count);
    }
</script>
@endpush
@endsection
