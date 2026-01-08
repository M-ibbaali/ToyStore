@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
    <div>
        <h1 class="text-3xl font-black text-gray-900 tracking-tight">Orders</h1>
        <p class="text-xs text-gray-400 font-bold mt-2 uppercase tracking-widest opacity-70">Sales & Shipments</p>
    </div>
    
    <div class="flex items-center gap-3">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="relative group">
            <select name="status" onchange="this.form.submit()" class="appearance-none bg-white border border-gray-100 px-6 py-3 pr-10 rounded-2xl text-xs font-black uppercase tracking-widest text-gray-600 focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition-all shadow-sm">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-50 border border-green-100 text-green-700 px-6 py-4 rounded-2xl mb-8 flex items-center gap-3">
        <div class="w-8 h-8 bg-green-500 text-white rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-green-500/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <p class="text-sm font-bold">{{ session('success') }}</p>
    </div>
@endif

<div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto custom-scrollbar">
        <table class="min-w-full divide-y divide-gray-50">
            <thead class="bg-gray-50/50">
                <tr>
                    <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Order ID</th>
                    <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Customer</th>
                    <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest hidden lg:table-cell">Payment</th>
                    <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Total</th>
                    <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                    <th class="px-8 py-5 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="px-8 py-5 whitespace-nowrap">
                        <span class="text-sm font-black text-gray-900">#{{ $order->id }}</span>
                        <p class="text-[9px] text-gray-300 font-bold mt-1 tracking-wider">{{ $order->created_at->format('M d, H:i') }}</p>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-500 flex items-center justify-center text-xs font-black uppercase tracking-widest">
                                {{ substr($order->user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-black text-gray-800">{{ $order->user->name }}</p>
                                <p class="text-[10px] text-gray-400 font-bold mt-0.5 truncate max-w-[150px]">{{ $order->user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap hidden lg:table-cell">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest bg-gray-50 px-2 py-1 rounded-lg">{{ strtoupper($order->payment_method) }}</span>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <span class="text-sm font-black text-blue-600 tracking-tight">{{ formatPrice($order->total) }}</span>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <span class="px-3 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-xl border
                            {{ $order->status == 'pending' ? 'bg-yellow-50 text-yellow-600 border-yellow-100' : '' }}
                            {{ $order->status == 'confirmed' ? 'bg-blue-50 text-blue-600 border-blue-100' : '' }}
                            {{ $order->status == 'shipped' ? 'bg-purple-50 text-purple-600 border-purple-100' : '' }}
                            {{ $order->status == 'delivered' ? 'bg-green-50 text-green-600 border-green-100' : '' }}
                            {{ $order->status == 'cancelled' ? 'bg-red-50 text-red-600 border-red-100' : '' }}">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.orders.show', $order) }}" class="p-2.5 bg-gray-50 text-gray-400 hover:text-blue-600 hover:bg-blue-50 hover:border-blue-100 border border-transparent rounded-xl transition-all active:scale-95 group/btn" title="View Details">
                                <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('DANGEROUS! Permanently delete this order record?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2.5 bg-gray-50 text-gray-400 hover:text-red-600 hover:bg-red-50 hover:border-red-100 border border-transparent rounded-xl transition-all active:scale-95 group/btn" title="Delete Order">
                                    <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-20 text-center">
                        <div class="w-20 h-20 bg-gray-50 rounded-[2rem] flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <p class="text-sm font-black text-gray-900">No orders found</p>
                        <p class="text-xs text-gray-400 mt-2 font-medium">Your sales strategy will pay off soon!</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-10">
    {{ $orders->links() }}
</div>
@endsection
