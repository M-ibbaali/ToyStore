@extends('layouts.frontend')

@section('title', 'My Orders - ToyStore')

@section('content')
<x-dashboard-layout>
    <!-- Header -->
    <div class="mb-12">
        <h1 class="text-4xl font-black text-toys-text tracking-tight mb-2 uppercase">My Toy Orders</h1>
        <p class="text-gray-500 font-bold uppercase text-xs tracking-widest text-secondary">Every fun package you've ever ordered.</p>
    </div>

    @if($orders->count() > 0)
        <!-- Order List Table -->
        <div class="overflow-x-auto -mx-8 lg:-mx-12 px-8 lg:px-12">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 border-b border-gray-50">
                        <th class="py-4">Order ID</th>
                        <th class="py-4">Date & Time</th>
                        <th class="py-4">Status</th>
                        <th class="py-4">Total Amount</th>
                        <th class="py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($orders as $order)
                        <tr class="group hover:bg-[#FBFBFB] transition-colors">
                            <td class="py-7 pr-4">
                                <span class="text-sm font-black text-toys-text block">#{{ $order->id }}</span>
                                <span class="text-[10px] font-bold text-primary uppercase tracking-widest">Confirmed 🧸</span>
                            </td>
                            <td class="py-7 px-4">
                                <span class="text-sm font-black text-toys-text block">{{ $order->created_at->format('M d, Y') }}</span>
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $order->created_at->format('h:i A') }}</span>
                            </td>
                            <td class="py-7 px-4">
                                <span class="inline-flex items-center px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest
                                    @if($order->status == 'delivered') bg-green-50 text-green-600
                                    @elseif($order->status == 'cancelled') bg-red-50 text-red-600
                                    @elseif($order->status == 'shipped') bg-blue-50 text-blue-600
                                    @else bg-secondary/5 text-secondary @endif border border-transparent group-hover:border-current/10 transition-colors">
                                    <span class="w-1.5 h-1.5 rounded-full mr-2 
                                        @if($order->status == 'delivered') bg-green-500
                                        @elseif($order->status == 'cancelled') bg-red-500
                                        @elseif($order->status == 'shipped') bg-blue-500
                                        @else bg-secondary @endif"></span>
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="py-7 px-4">
                                <span class="text-lg font-black text-toys-text font-mono">{{ formatPrice($order->total) }}</span>
                            </td>
                            <td class="py-7 pl-4 text-right">
                                <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-50 text-toys-text border border-gray-100 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-primary hover:text-white hover:border-primary hover:shadow-lg hover:shadow-primary/20 transition-all duration-300">
                                    Details
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="mt-12 pt-8 border-t border-gray-50">
                {{ $orders->links() }}
            </div>
        @endif

    @else
        <!-- Empty State -->
        <div class="text-center py-24 bg-gray-50/50 rounded-[3rem] border border-dashed border-gray-200">
            <div class="w-24 h-24 bg-white rounded-[2rem] flex items-center justify-center mx-auto mb-8 shadow-sm border border-gray-50">
                <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-black text-toys-text mb-3 uppercase tracking-tight">Your Toy Box is Empty</h3>
            <p class="text-gray-400 font-bold mb-10 max-w-sm mx-auto uppercase text-[10px] tracking-[0.2em] leading-loose">Looks like you haven't started your collection yet. Let's find some joy!</p>
            <a href="{{ route('shop.index') }}" class="inline-flex items-center px-10 py-5 bg-primary text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-primary/20 hover:bg-secondary transition-all hover:-translate-y-1 active:scale-95">
                Explore The Shop
            </a>
        </div>
    @endif
</x-dashboard-layout>
@endsection
