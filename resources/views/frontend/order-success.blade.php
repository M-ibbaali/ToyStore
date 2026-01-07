@extends('layouts.frontend')

@section('title', 'Toy Order Placed! ✨')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
    <div class="bg-white rounded-[3rem] shadow-xl shadow-gray-200/50 border-2 border-gray-100 p-12">
        <div class="w-24 h-24 bg-toy-bg rounded-full flex items-center justify-center mx-auto mb-8 relative">
            <svg class="w-12 h-12 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
            </svg>
            <div class="absolute -top-2 -right-2 text-2xl animate-bounce">🎉</div>
        </div>
        
        <h1 class="text-4xl font-black text-toys-text mb-4">Toy Order Placed!</h1>
        <p class="text-gray-500 font-bold mb-10 text-lg">Hooray! Your toys are getting ready for their new home!</p>
        
        <div class="bg-toy-bg rounded-3xl p-8 mb-10 border-2 border-white shadow-inner">
            <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Your Secret Order Number</p>
            <p class="text-4xl font-black text-primary">#{{ $order->id }}</p>
        </div>
        
        <div class="text-left mb-10 bg-gray-50 rounded-3xl p-8">
            <h2 class="font-black text-xl text-toys-text mb-6">What's in the Box? 📦</h2>
            <div class="space-y-4">
                @foreach($order->items as $item)
                <div class="flex justify-between items-center text-gray-600 font-bold">
                    <span class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-secondary"></span>
                        {{ $item->product->name }} <span class="text-gray-400 text-sm ml-1">x{{ $item->quantity }}</span>
                    </span>
                    <span class="text-toys-text">{{ formatPrice($item->price * $item->quantity) }}</span>
                </div>
                @endforeach
                <div class="border-t-2 border-dashed border-gray-200 pt-6 flex justify-between items-center">
                    <span class="text-xl font-black text-toys-text">Total Fun</span>
                    <span class="text-3xl font-black text-primary">{{ formatPrice($order->total) }}</span>
                </div>
            </div>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('dashboard') }}" class="px-8 py-4 bg-primary text-white rounded-2xl hover:bg-secondary transition-all transform hover:-translate-y-1 shadow-lg shadow-primary/20 font-black uppercase tracking-widest active:scale-95">
                My Favorites
            </a>
            <a href="{{ route('shop.index') }}" class="px-8 py-4 bg-white border-4 border-toy-bg text-secondary rounded-2xl hover:bg-toy-bg transition-all transform hover:-translate-y-1 font-black uppercase tracking-widest active:scale-95">
                Continue Playing
            </a>
        </div>
    </div>
</div>
@endsection
