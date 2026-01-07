@extends('layouts.admin')

@section('title', 'Stock Alerts')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">Stock Alerts</h1>
            <p class="text-sm text-gray-500 font-bold mt-1">Manage low stock products and replenish inventory.</p>
        </div>

        @if($notifications->count() > 0)
        <form action="{{ route('admin.notifications.clearAll') }}" method="POST" onsubmit="return confirm('Clear all stock alerts?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-600 rounded-xl hover:bg-red-50 hover:text-red-600 hover:border-red-100 transition-all duration-200 shadow-sm text-sm font-bold">
                Clear All
            </button>
        </form>
        @endif
    </div>

    <!-- Alerts List -->
    <div class="space-y-4" id="stock-alerts-list">
        @forelse($notifications as $notification)
            @php
                $product = $notification->product;
                // If product is deleted but notification exists, we handle it gracefully
            @endphp

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex flex-col md:flex-row items-center gap-6 transition-all duration-300 hover:shadow-md" id="notification-{{ $notification->id }}">
                
                <!-- Product Image -->
                <div class="w-20 h-20 rounded-xl bg-gray-50 flex-shrink-0 overflow-hidden border border-gray-100">
                    @if($product && $product->image_url)
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                </div>

                <!-- Content -->
                <div class="flex-1 text-center md:text-left w-full">
                    <div class="flex items-center justify-center md:justify-between mb-1">
                        <h3 class="text-lg font-bold text-gray-900">
                            {{ $product ? $product->name : 'Product Unavailable' }}
                        </h3>
                        <span class="text-xs font-bold text-red-500 bg-red-50 px-2 py-1 rounded-full whitespace-nowrap">
                            Stock: {{ $product ? $product->stock : 'N/A' }}
                        </span>
                    </div>
                    
                    <p class="text-sm text-gray-500 mb-3">
                        {{ $notification->data['description'] }}
                    </p>
                    
                    <p class="text-xs text-gray-400 font-medium">
                        Alerted {{ $notification->created_at->diffForHumans() }}
                    </p>
                </div>

                <!-- Action: Add Stock -->
                @if($product)
                <div class="w-full md:w-auto bg-gray-50 p-3 rounded-xl border border-gray-100">
                    <form onsubmit="updateStock(event, '{{ $notification->id }}')" class="flex items-center gap-2">
                        <div class="relative">
                            <input type="number" 
                                   name="quantity" 
                                   min="1" 
                                   value="10" 
                                   class="w-20 px-3 py-2 rounded-lg border border-gray-200 text-sm font-bold text-center focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                                   required>
                            <span class="absolute right-8 top-1/2 -translate-y-1/2 text-xs text-gray-400 font-bold pointer-events-none">+</span>
                        </div>
                        
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg shadow-sm shadow-blue-200 transition-all active:scale-95 whitespace-nowrap">
                            Add Stock
                        </button>
                    </form>
                </div>
                @endif
            </div>
        @empty
            <div class="flex flex-col items-center justify-center p-16 text-center bg-white rounded-3xl border border-dashed border-gray-200">
                <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-xl font-black text-gray-900">Inventory Looks Good!</h3>
                <p class="text-gray-500 mt-2 max-w-sm">There are no low stock alerts at the moment. Keep up the good work!</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $notifications->links() }}
    </div>
</div>

<script>
    async function updateStock(e, id) {
        e.preventDefault();
        const form = e.target;
        const btn = form.querySelector('button');
        const originalText = btn.innerText;
        const quantity = form.quantity.value;

        // UI Loading State
        btn.disabled = true;
        btn.innerText = 'Updating...';
        btn.classList.add('opacity-75', 'cursor-not-allowed');

        try {
            const response = await fetch(`/toystore-admin/notifications/${id}/update-stock`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ quantity: quantity })
            });

            const data = await response.json();

            if (data.success) {
                // Show success toast (using our global alert system)
                if (window.showAlert) {
                    window.showAlert('success', 'Stock updated successfully!');
                }

                // Animate removal
                const card = document.getElementById(`notification-${id}`);
                card.style.transform = 'scale(0.95)';
                card.style.opacity = '0';
                
                setTimeout(() => {
                    card.remove();
                    // Check if list is empty to show empty state (optional simple check)
                    const container = document.getElementById('stock-alerts-list');
                    if(container.children.length === 0) {
                        location.reload(); // Reload to show empty state or fetch next page
                    }
                }, 300);

            } else {
                throw new Error(data.message || 'Error updating stock');
            }

        } catch (error) {
            console.error(error);
            if (window.showAlert) {
                window.showAlert('error', 'Failed to update stock. Try again.');
            } else {
                alert('Failed to update stock.');
            }
            // Reset Button
            btn.disabled = false;
            btn.innerText = originalText;
            btn.classList.remove('opacity-75', 'cursor-not-allowed');
        }
    }
</script>
@endsection
