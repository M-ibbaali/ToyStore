@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-10">
    <div>
        <h1 class="text-3xl font-black text-gray-900 tracking-tight">Categories</h1>
        <p class="text-xs text-gray-400 font-bold mt-2 uppercase tracking-widest opacity-70">Shop Organization</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="group flex items-center gap-2 px-6 py-3 bg-gray-900 text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-blue-600 transition-all duration-300 shadow-xl shadow-gray-900/10 active:scale-95">
        <svg class="w-4 h-4 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        <span>Add New Category</span>
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
                    <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Category Name</th>
                    <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest hidden md:table-cell">Slug</th>
                    <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Products</th>
                    <th class="px-8 py-5 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($categories as $category)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div>
                            <p class="text-sm font-black text-gray-900 group-hover:text-blue-600 transition-colors">{{ $category->name }}</p>
                            <p class="text-[10px] text-gray-400 font-bold mt-1 max-w-xs truncate">{{ Str::limit($category->description, 50) }}</p>
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap hidden md:table-cell">
                        <span class="text-xs font-bold text-gray-400">/{{ $category->slug }}</span>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="flex items-center gap-2">
                             <span class="text-sm font-black text-gray-900">{{ $category->products->count() }}</span>
                             <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Items</span>
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="p-2.5 bg-gray-50 text-gray-400 hover:text-blue-600 hover:bg-blue-50 hover:border-blue-100 border border-transparent rounded-xl transition-all active:scale-95 group/btn" title="Edit Category">
                                <svg class="w-5 h-5 group-hover/btn:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Careful! All products in this category will be affected. Delete?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2.5 bg-gray-50 text-gray-400 hover:text-red-600 hover:bg-red-50 hover:border-red-100 border border-transparent rounded-xl transition-all active:scale-95 group/btn" title="Delete Category">
                                    <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-8 py-20 text-center">
                        <div class="w-20 h-20 bg-gray-50 rounded-[2rem] flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        </div>
                        <p class="text-sm font-black text-gray-900">No categories found</p>
                        <p class="text-xs text-gray-400 mt-2 font-medium">Start organizing your toys today!</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-10">
    {{ $categories->links() }}
</div>
@endsection
