@extends('layouts.frontend')

@section('title', 'Dashboard - ToyStore')

@section('content')
<x-dashboard-layout>
    <!-- Header -->
    <div class="mb-12">
        <h1 class="text-4xl font-black text-toys-text tracking-tight mb-2">Account Overview</h1>
        <p class="text-gray-500 font-bold">Welcome back! Manage your toy collection and fun orders here.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-12">
        <!-- Total Orders -->
        <div class="bg-gray-50 p-8 rounded-[2rem] border border-gray-100 flex items-center justify-between group hover:bg-white hover:shadow-xl hover:shadow-primary/5 transition-all duration-500 cursor-default">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-primary mb-1">Total Orders</p>
                <h3 class="text-3xl font-black text-toys-text">{{ $totalOrders }}</h3>
            </div>
            <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-primary shadow-sm group-hover:scale-110 transition-transform duration-500">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="bg-gray-50 p-8 rounded-[2rem] border border-gray-100 flex items-center justify-between group hover:bg-white hover:shadow-xl hover:shadow-secondary/5 transition-all duration-500 cursor-default">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-secondary mb-1">In Preparation</p>
                <h3 class="text-3xl font-black text-toys-text">{{ $pendingOrders }}</h3>
            </div>
            <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-secondary shadow-sm group-hover:scale-110 transition-transform duration-500">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Total Spent -->
        <div class="bg-gray-50 p-8 rounded-[2rem] border border-gray-100 flex items-center justify-between group hover:bg-white hover:shadow-xl hover:shadow-green-500/5 transition-all duration-500 cursor-default">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-green-500 mb-1">Total Fun</p>
                <h3 class="text-3xl font-black text-toys-text">{{ formatPrice($totalSpent) }}</h3>
            </div>
            <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-green-500 shadow-sm group-hover:scale-110 transition-transform duration-500">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="relative">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-black text-toys-text tracking-tight uppercase">Recent Orders</h2>
            <a href="{{ route('orders.index') }}" class="text-xs font-black uppercase tracking-widest text-primary hover:text-secondary transition-colors border-b-2 border-primary/20 pb-0.5">View All</a>
        </div>

        @if($recentOrders->count() > 0)
            <div class="overflow-x-auto -mx-8 lg:-mx-12 px-8 lg:px-12">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 border-b border-gray-50">
                            <th class="py-4">Order ID</th>
                            <th class="py-4">Status</th>
                            <th class="py-4">Total</th>
                            <th class="py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($recentOrders as $order)
                            <tr class="group hover:bg-gray-50/50 transition-colors">
                                <td class="py-6 pr-4">
                                    <span class="text-sm font-black text-toys-text block">#{{ $order->id }}</span>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $order->created_at->format('M d, Y') }}</span>
                                </td>
                                <td class="py-6 px-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                                        @if($order->status == 'delivered') bg-green-50 text-green-600
                                        @elseif($order->status == 'cancelled') bg-red-50 text-red-600
                                        @elseif($order->status == 'shipped') bg-blue-50 text-blue-600
                                        @else bg-secondary/5 text-secondary @endif">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="py-6 px-4">
                                    <span class="text-sm font-black text-toys-text font-mono">{{ formatPrice($order->total) }}</span>
                                </td>
                                <td class="py-6 pl-4 text-right">
                                    <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center justify-center w-10 h-10 border border-gray-100 rounded-xl text-gray-400 hover:text-primary hover:border-primary hover:bg-primary/5 transition-all duration-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-20 bg-gray-50/50 rounded-[2.5rem] border border-dashed border-gray-200">
                <div class="w-20 h-20 bg-white rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-sm border border-gray-50">
                    <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h4 class="text-xl font-black text-toys-text mb-2 uppercase tracking-tight">Empty Toy Box</h4>
                <p class="text-gray-400 font-bold mb-8">You haven't placed any fun orders yet!</p>
                <a href="{{ route('shop.index') }}" class="inline-flex items-center px-8 py-3.5 bg-primary text-white text-xs font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-primary/20 hover:bg-secondary transition-all">Start Shopping</a>
            </div>
        @endif
    </div>
</x-dashboard-layout>
@endsection
