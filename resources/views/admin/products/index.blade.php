@extends('layouts.admin')

@section('title', 'Products')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-10">
    <div>
        <h1 class="text-3xl font-black text-gray-900 tracking-tight">Products</h1>
        <p class="text-xs text-gray-400 font-bold mt-2 uppercase tracking-widest opacity-70">Inventory Management</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="group flex items-center gap-2 px-6 py-3 bg-blue-600 text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-gray-900 transition-all duration-300 shadow-xl shadow-blue-600/20 active:scale-95">
        <svg class="w-4 h-4 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        <span>Add New Product</span>
    </a>
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
                    <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Item</th>
                    <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest hidden md:table-cell">Category</th>
                    <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Price</th>
                    <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Stock</th>
                    <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest hidden sm:table-cell">Status</th>
                    <th class="px-8 py-5 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-14 h-14 object-cover rounded-2xl shadow-lg shadow-gray-200 border border-gray-100 group-hover:scale-105 transition-transform duration-300">
                                @if($product->stock < 5)
                                    <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 border-2 border-white rounded-full"></span>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-black text-gray-900">{{ $product->name }}</p>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1 md:hidden">{{ $product->category->name }}</p>
                                <p class="text-[10px] text-gray-400 font-bold mt-0.5">ID: #{{ $product->id }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap hidden md:table-cell">
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 text-[10px] font-black uppercase tracking-wider rounded-lg">{{ $product->category->name }}</span>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <p class="text-sm font-black text-blue-600 tracking-tight">{{ formatPrice($product->price) }}</p>
                        @if($product->original_price > $product->price)
                            <p class="text-[10px] text-gray-400 line-through font-bold mt-1">{{ formatPrice($product->original_price) }}</p>
                        @endif
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="flex flex-col gap-1.5">
                            <span class="text-sm font-black {{ $product->stock <= 0 ? 'text-red-500' : ($product->stock < 10 ? 'text-orange-500' : 'text-gray-900') }}">{{ $product->stock }}</span>
                            <div class="w-16 h-1 bg-gray-100 rounded-full overflow-hidden">
                                @php $stockPercent = min(100, ($product->stock / 20) * 100) @endphp
                                <div class="h-full {{ $product->stock <= 0 ? 'bg-red-500' : ($product->stock < 10 ? 'bg-orange-500' : 'bg-green-500') }} transition-all duration-1000" style="width: {{ $stockPercent }}%"></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap hidden sm:table-cell">
                        <span class="px-3 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-xl {{ $product->status == 'active' ? 'bg-green-50 text-green-600 border border-green-100' : 'bg-red-50 text-red-600 border border-red-100' }}">
                            {{ $product->status }}
                        </span>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="p-2.5 bg-gray-50 text-gray-400 hover:text-blue-600 hover:bg-blue-50 hover:border-blue-100 border border-transparent rounded-xl transition-all active:scale-95 group/btn" title="Edit Item">
                                <svg class="w-5 h-5 group-hover/btn:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Careful! This will permanently delete this product. Proceed?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2.5 bg-gray-50 text-gray-400 hover:text-red-600 hover:bg-red-50 hover:border-red-100 border border-transparent rounded-xl transition-all active:scale-95 group/btn" title="Delete Item">
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
                            <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <p class="text-sm font-black text-gray-900">No products found</p>
                        <p class="text-xs text-gray-400 mt-2 font-medium">Try adding some toys to your inventory!</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-10">
    {{ $products->links() }}
</div>
@endsection
