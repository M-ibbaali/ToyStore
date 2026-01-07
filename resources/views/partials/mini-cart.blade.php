<div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-4">
    <h3 class="font-black text-xs uppercase tracking-widest text-toys-text">Shopping Cart</h3>
    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ $cartCount }} Items</span>
</div>

<div class="space-y-6 max-h-[350px] overflow-y-auto custom-scrollbar pr-2 mb-6">
    @if($cart && $cart->items->count() > 0)
        @foreach($cart->items as $item)
            <div class="flex gap-4 group/item" id="cart-item-{{ $item->id }}">
                <div class="w-16 h-20 bg-toy-bg rounded-xl overflow-hidden flex-shrink-0 relative">
                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-start">
                        <a href="{{ route('product.show', $item->product->slug) }}" class="text-xs font-black text-toys-text hover:text-secondary transition line-clamp-2 uppercase leading-tight mb-1">{{ $item->product->name }}</a>
                        <button onclick="removeFromCart({{ $item->id }})" class="ml-2 text-gray-300 hover:text-red-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                    <div class="flex items-center justify-between mt-2">
                        <span class="text-[10px] font-bold text-gray-400">{{ $item->quantity }} x</span>
                        <span class="text-sm font-black text-primary">{{ formatPrice($item->product->price) }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="py-12 text-center">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Your cart is empty</p>
        </div>
    @endif
</div>

@if($cartCount > 0)
    <div class="border-t border-gray-100 pt-6 space-y-4">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Subtotal</span>
            <span class="text-xl font-black text-toys-text">{{ formatPrice($cartSubtotal) }}</span>
        </div>
        <div class="grid grid-cols-2 gap-3 pt-2">
            <a href="{{ route('cart.index') }}" class="flex items-center justify-center h-11 rounded-full border-2 border-toy-bg text-secondary font-black text-[10px] uppercase tracking-widest hover:bg-toy-bg transition-colors">
                View Cart
            </a>
            <a href="{{ route('checkout.index') }}" class="flex items-center justify-center h-11 rounded-full bg-secondary text-white font-black text-[10px] uppercase tracking-widest hover:bg-primary transition-all shadow-lg shadow-secondary/20 hover:shadow-primary/20">
                Checkout
            </a>
        </div>
    </div>
@endif
