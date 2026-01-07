@extends('layouts.frontend')

@section('title', 'Order Details #' . $order->id . ' - ToyStore')

@section('content')
<x-dashboard-layout>
    <!-- Breadcrumbs -->
    <nav class="flex mb-8 text-[10px] font-black uppercase tracking-[0.2em]" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
            <li>
                <a href="{{ route('home') }}" class="text-gray-400 hover:text-primary transition-colors">Home</a>
            </li>
            <li class="flex items-center space-x-2">
                <svg class="w-2.5 h-2.5 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/></svg>
                <a href="{{ route('orders.index') }}" class="text-gray-400 hover:text-primary transition-colors">My Orders</a>
            </li>
            <li class="flex items-center space-x-2">
                <svg class="w-2.5 h-2.5 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/></svg>
                <span class="text-primary">Order #{{ $order->id }}</span>
            </li>
        </ol>
    </nav>

    <!-- Header Actions -->
    <div class="mb-10 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
        <div>
            <h1 class="text-4xl font-black text-toys-text tracking-tight mb-2">Order #{{ $order->id }}</h1>
            <p class="text-gray-500 font-bold uppercase text-[10px] tracking-widest flex items-center gap-2">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v14a2 2 0 002 2z"/></svg>
                Placed on {{ $order->created_at->format('M d, Y') }} at {{ $order->created_at->format('H:i') }}
            </p>
        </div>
        
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center px-6 py-2.5 rounded-full text-[10px] font-black uppercase tracking-widest shadow-sm border
                @if($order->status == 'delivered') bg-green-50 text-green-600 border-green-100
                @elseif($order->status == 'cancelled') bg-red-50 text-red-600 border-red-100
                @elseif($order->status == 'shipped') bg-blue-50 text-blue-600 border-blue-100
                @else bg-secondary/5 text-secondary border-secondary/10 @endif">
                <span class="w-1.5 h-1.5 rounded-full mr-3
                    @if($order->status == 'delivered') bg-green-500
                    @elseif($order->status == 'cancelled') bg-red-500
                    @elseif($order->status == 'shipped') bg-blue-500
                    @else bg-secondary @endif"></span>
                {{ $order->status }}
            </span>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-10">
        
        <!-- Left Side: Items & Progress -->
        <div class="xl:col-span-2 space-y-10">
            
            <!-- Order Progress -->
            <div class="bg-gray-50/50 p-8 lg:p-12 rounded-[2.5rem] border border-gray-100">
                <div class="flex justify-between items-center mb-12">
                    <h3 class="text-lg font-black text-toys-text uppercase tracking-tight">Order Journey</h3>
                    <a href="#" class="text-[10px] font-black text-primary uppercase tracking-widest border-b-2 border-primary/10 pb-1">Track Shipment →</a>
                </div>

                @php
                    $status = strtolower($order->status);
                    $steps = ['pending', 'confirmed', 'shipped', 'delivered'];
                    $currentStepIndex = array_search($status, $steps);
                    if ($status === 'cancelled') $currentStepIndex = -1;
                @endphp

                @if($status === 'cancelled')
                    <div class="bg-red-50 border border-red-100 rounded-3xl p-6 flex items-center gap-5">
                        <div class="w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center text-red-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                        </div>
                        <p class="text-sm font-bold text-red-800">This order has been cancelled and is no longer being processed.</p>
                    </div>
                @else
                    <div class="relative flex justify-between">
                        <!-- Progress Line -->
                        <div class="absolute top-1/2 left-0 w-full h-1 bg-gray-100 -translate-y-1/2 rounded-full overflow-hidden" aria-hidden="true">
                            <div class="h-full bg-primary transition-all duration-1000" style="width: {{ $currentStepIndex >= 0 ? ($currentStepIndex / (count($steps) - 1)) * 100 : 0 }}%"></div>
                        </div>

                        <!-- Step Markers -->
                        @foreach($steps as $index => $step)
                            <div class="relative z-10 flex flex-col items-center gap-4">
                                @if($index <= $currentStepIndex)
                                    <div class="w-12 h-12 lg:w-14 lg:h-14 bg-white border-4 border-primary rounded-2xl flex items-center justify-center shadow-lg shadow-primary/10 scale-110">
                                        <svg class="w-5 h-5 lg:w-6 lg:h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                @elseif($index == $currentStepIndex + 1)
                                    <div class="w-12 h-12 lg:w-14 lg:h-14 bg-white border-4 border-gray-100 rounded-2xl flex items-center justify-center animate-pulse">
                                        <div class="w-2.5 h-2.5 bg-gray-200 rounded-full"></div>
                                    </div>
                                @else
                                    <div class="w-12 h-12 lg:w-14 lg:h-14 bg-gray-50 border-4 border-white rounded-2xl flex items-center justify-center">
                                        <div class="w-2 h-2 bg-gray-100 rounded-full"></div>
                                    </div>
                                @endif
                                <span class="text-[9px] font-black uppercase tracking-[0.2em] {{ $index <= $currentStepIndex ? 'text-toys-text' : 'text-gray-300' }}">
                                    {{ $step }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Items List -->
            <div class="space-y-6">
                <h3 class="text-xl font-black text-toys-text uppercase tracking-tight px-2">Toy Box Items</h3>
                <div class="divide-y divide-gray-50 border border-gray-50 rounded-[2.5rem] overflow-hidden">
                    @foreach($order->items as $item)
                        <div class="p-8 bg-white flex flex-col sm:flex-row items-center sm:items-start gap-8 group hover:bg-gray-50/50 transition-all duration-300">
                            <!-- Product Image -->
                            <div class="w-28 h-28 flex-shrink-0 bg-gray-50 rounded-[2rem] overflow-hidden border border-gray-100 group-hover:scale-105 transition-transform duration-500">
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            </div>

                            <!-- Product Info -->
                            <div class="flex-1 text-center sm:text-left">
                                <p class="text-[10px] font-black uppercase tracking-widest text-primary mb-2">{{ $item->product->category->name ?? 'Toy' }}</p>
                                <h4 class="text-lg font-black text-toys-text mb-4 group-hover:text-primary transition-colors">{{ $item->product->name }}</h4>
                                <div class="flex flex-wrap justify-center sm:justify-start gap-4">
                                    <span class="inline-flex items-center px-4 py-2 bg-gray-50 rounded-xl text-[10px] font-black uppercase tracking-widest text-gray-500 border border-gray-100">
                                        Qty: {{ $item->quantity }}
                                    </span>
                                    <span class="inline-flex items-center px-4 py-2 bg-gray-50 rounded-xl text-[10px] font-black uppercase tracking-widest text-gray-500 border border-gray-100">
                                        Price: {{ formatPrice($item->price) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Subtotal -->
                            <div class="text-right sm:self-center">
                                <p class="text-2xl font-black text-toys-text font-mono tracking-tight">{{ formatPrice($item->price * $item->quantity) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Side: Address & Totals -->
        <div class="space-y-10">
            
            <!-- Shipping Address -->
            <div class="bg-white p-8 lg:p-10 rounded-[2.5rem] border border-gray-100 shadow-sm">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 bg-secondary/10 rounded-2xl flex items-center justify-center text-secondary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="text-base font-black text-toys-text uppercase tracking-tight">Shipping To</h3>
                </div>
                
                <div class="space-y-4">
                    <div class="pb-6 border-b border-gray-50">
                        <p class="text-lg font-black text-toys-text">{{ $order->user->name }}</p>
                        <p class="text-sm font-bold text-gray-400 capitalize">{{ $order->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-1">Destination Hub</p>
                        @if($order->user->address)
                            <p class="text-sm font-bold text-toys-text leading-relaxed">
                                {{ $order->user->address }}<br>
                                <span class="text-secondary">{{ $order->user->city }}</span>
                            </p>
                        @else
                            <p class="text-sm font-bold text-gray-300 italic">No destination set 🛸</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Payment & Summary -->
            <div class="bg-gray-50 p-8 lg:p-10 rounded-[2.5rem] border border-gray-100">
                <h3 class="text-base font-black text-toys-text uppercase tracking-tight mb-8">Order Summary</h3>
                
                <div class="space-y-4 mb-8">
                    <div class="flex justify-between items-center text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">
                        <span>Payment Mode</span>
                        <span class="text-toys-text">{{ $order->payment_method }}</span>
                    </div>
                    <div class="flex justify-between items-center text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">
                        <span>Payment Status</span>
                        <span class="px-3 py-1 bg-white rounded-full {{ strtolower($order->payment_status) == 'paid' ? 'text-green-500' : 'text-yellow-500' }}">
                            {{ strtoupper($order->payment_status) }}
                        </span>
                    </div>
                </div>

                <div class="space-y-4 py-8 border-y-2 border-dashed border-gray-200/50 mb-8">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-black text-toys-text tracking-tight">Subtotal</span>
                        <span class="text-sm font-black text-toys-text font-mono">{{ formatPrice($order->total) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-black text-toys-text tracking-tight">Toy Shipping</span>
                        <span class="text-xs font-black text-secondary tracking-widest uppercase">✨ FREE ✨</span>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-xl font-black text-toys-text uppercase tracking-tighter">Total Fun</span>
                    <span class="text-3xl font-black text-primary font-mono tracking-tighter">{{ formatPrice($order->total) }}</span>
                </div>

                <div class="mt-10">
                    <a href="{{ route('orders.index') }}" class="flex items-center justify-center w-full py-5 bg-white text-toys-text border border-gray-100 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-primary hover:text-white hover:border-primary transition-all duration-300 group">
                        <svg class="w-4 h-4 mr-3 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Back to My Orders
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-dashboard-layout>
@endsection
