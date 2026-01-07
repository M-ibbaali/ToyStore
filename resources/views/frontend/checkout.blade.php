@extends('layouts.frontend')

@section('title', 'Ready to Play? ')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-4xl font-black text-toys-text mb-8 flex items-center gap-3">
        <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        Ready to Play?
    </h1>

    @if($errors->any())
        <div class="bg-red-50 border-2 border-red-100 text-red-700 px-6 py-4 rounded-xl mb-8 font-bold">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Back to Cart Link -->
    <div class="mb-6">
        <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-widest text-gray-400 hover:text-primary transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" /></svg>
            Back to Cart
        </a>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Left: Billing Address Form -->
            <div class="lg:col-span-8">
                <h2 class="text-2xl font-black text-toys-text mb-8 uppercase tracking-wide">Billing Address</h2>
                
                <div class="space-y-4 md:space-y-6">
                    <!-- Complete Name -->
                    <div class="relative">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-2 mb-1 block">Full Name</label>
                        <input type="text" name="fullname" required 
                               value="{{ old('fullname', Auth::user()->name) }}"
                               placeholder="e.g. John Doe"
                               class="w-full h-12 md:h-14 px-6 border border-gray-100 bg-white rounded-2xl focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all font-bold text-sm placeholder-gray-300">
                    </div>
                    
                    <!-- Email Address -->
                    <div class="relative">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-2 mb-1 block">Email Address</label>
                        <input type="email" name="email" 
                               value="{{ old('email', Auth::user()->email) }}"
                               placeholder="e.g. john@example.com"
                               class="w-full h-12 md:h-14 px-6 border border-gray-100 bg-white rounded-2xl focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all font-bold text-sm placeholder-gray-300">
                    </div>

                    <!-- Country -->
                    <div class="relative">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-2 mb-1 block">Country</label>
                        <input type="text" name="country" 
                               value="{{ old('country', Auth::user()->country ?? 'Morocco') }}"
                               placeholder="Country"
                               class="w-full h-12 md:h-14 px-6 border border-gray-100 bg-white rounded-2xl focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all font-bold text-sm placeholder-gray-300">
                    </div>

                    <!-- City & Phone -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        <div class="relative">
                             <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-2 mb-1 block">City</label>
                             <input type="text" name="city" 
                               value="{{ old('city', Auth::user()->city) }}"
                               placeholder="City"
                               class="w-full h-12 md:h-14 px-6 border border-gray-100 bg-white rounded-2xl focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all font-bold text-sm placeholder-gray-300">
                        </div>

                        <div class="relative">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-2 mb-1 block">Phone Number</label>
                            <input type="text" name="phone" required value="{{ old('phone', Auth::user()->phone) }}"
                                   placeholder="Phone Number"
                                   class="w-full h-12 md:h-14 px-6 border border-gray-100 bg-white rounded-2xl focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all font-bold text-sm placeholder-gray-300">
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="relative">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-2 mb-1 block">Detailed Address</label>
                        <textarea name="address" required rows="3"
                               placeholder="Street, Building, Apartment..."
                               class="w-full px-6 py-4 border border-gray-100 bg-white rounded-[2rem] focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all font-bold text-sm placeholder-gray-300 min-h-[120px]">{{ old('address', Auth::user()->address) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Right: Sidebar (Order Summary & Totals) -->
            <div class="lg:col-span-4">
                <div class="bg-gray-50 p-8 border border-gray-100 sticky top-24">
                    <h3 class="text-sm font-black uppercase tracking-widest text-toys-text mb-6">Order Items</h3>
                    
                    <!-- Product List -->
                    <div class="space-y-4 mb-10 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($cartItems as $item)
                        <div class="flex items-center gap-4 bg-white p-3 border border-gray-100 shadow-sm">
                            <div class="flex-shrink-0 w-12 h-12 bg-toy-bg rounded overflow-hidden">
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-[11px] font-black text-toys-text truncate uppercase">{{ $item->product->name }}</h4>
                                <p class="text-[10px] font-bold text-gray-400">Qty: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-[11px] font-black text-primary">{{ formatPrice($item->product->price * $item->quantity) }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <h3 class="text-sm font-black uppercase tracking-widest text-toys-text mb-6">Cart Totals</h3>
                    
                    <!-- Totals Box -->
                    <div class="border border-red-800 p-8 space-y-6 bg-white mb-10">
                        <div class="flex justify-between items-center py-2">
                            <span class="text-xs font-black uppercase tracking-widest text-toys-text">Subtotal</span>
                            <span class="text-sm font-black text-toys-text">{{ formatPrice($total) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 pb-6">
                            <span class="text-xs font-black uppercase tracking-widest text-toys-text">Delivery</span>
                            <span class="text-[10px] font-black uppercase tracking-widest text-gray-500">Free</span>
                        </div>
                        <div class="flex justify-between items-center pt-2">
                            <span class="text-xs font-black uppercase tracking-widest text-toys-text">Total</span>
                            <span class="text-sm font-black text-toys-text">{{ formatPrice($total) }}</span>
                        </div>
                    </div>

                    <!-- Payment Method Section -->
                    <div class="space-y-6">
                        <h3 class="text-sm font-black uppercase tracking-widest text-toys-text">Payment Method</h3>
                        
                        <div class="space-y-4">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" name="payment_method" value="bank" class="w-4 h-4 text-primary border-gray-300 focus:ring-primary">
                                <span class="text-xs font-bold text-gray-600 group-hover:text-toys-text transition-colors">Bank Payment</span>
                            </label>
                            
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" name="payment_method" value="check" class="w-4 h-4 text-primary border-gray-300 focus:ring-primary">
                                <span class="text-xs font-bold text-gray-600 group-hover:text-toys-text transition-colors">Check Payment</span>
                            </label>

                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" name="payment_method" value="paypal" class="w-4 h-4 text-primary border-gray-300 focus:ring-primary">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold text-gray-600 group-hover:text-toys-text transition-colors">PayPal</span>
                                    <div class="flex gap-1">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" class="h-3 opacity-70">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" class="h-3 opacity-70">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" class="h-3 opacity-70">
                                    </div>
                                </div>
                            </label>

                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" name="payment_method" value="cod" checked class="w-4 h-4 text-primary border-gray-300 focus:ring-primary">
                                <span class="text-xs font-bold text-gray-600 group-hover:text-toys-text transition-colors">Cash on Delivery</span>
                            </label>
                        </div>

                        <!-- CTA Button -->
                        <div class="pt-6">
                            <button type="submit" class="w-full bg-primary text-white py-4 rounded-full text-xs font-black uppercase tracking-widest hover:bg-secondary transition shadow-lg shadow-primary/20 transform active:scale-95 duration-200">
                                Order Placed
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-8 text-center lg:text-left px-4">
                    <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-widest text-secondary hover:underline transition-all">
                        ← Return to Shoppping Bag
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
