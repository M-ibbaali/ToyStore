@extends('layouts.admin')

@section('title', 'Notifications')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
    <div>
        <h1 class="text-3xl font-black text-gray-900 tracking-tight">Updates</h1>
        <p class="text-xs text-gray-400 font-bold mt-2 uppercase tracking-widest opacity-70">Stock Alerts & Activity</p>
    </div>

    @if($notifications->count() > 0)
    <form action="{{ route('admin.notifications.clearAll') }}" method="POST" onsubmit="return confirm('Clear all stock alerts?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="flex items-center gap-2 px-6 py-3 bg-white border border-gray-100 text-[10px] font-black uppercase tracking-widest text-gray-400 rounded-2xl hover:bg-red-50 hover:text-red-500 hover:border-red-100 transition-all duration-300 shadow-sm active:scale-95">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            Clear All Alerts
        </button>
    </form>
    @endif
</div>

<div class="max-w-4xl mx-auto space-y-4" id="stock-alerts-list">
    @forelse($notifications as $notification)
        @php $product = $notification->product; @endphp
        <div class="group bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-6 sm:p-8 flex flex-col sm:flex-row items-center gap-6 sm:gap-8 transition-all duration-500 hover:shadow-2xl hover:border-blue-100" id="notification-{{ $notification->id }}">
            
            <!-- Product Image -->
            <div class="relative w-24 h-24 sm:w-28 sm:h-28 flex-shrink-0">
                <div class="absolute inset-0 bg-blue-600 rounded-[2rem] rotate-6 group-hover:rotate-12 transition-transform duration-500 opacity-5"></div>
                <div class="relative w-full h-full bg-white rounded-[2rem] overflow-hidden border border-gray-50 shadow-inner">
                    @if($product && $product->image_url)
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-200">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1 text-center sm:text-left">
                <div class="flex flex-col sm:flex-row sm:items-center justify-center sm:justify-between gap-2 mb-3">
                    <h3 class="text-lg font-black text-gray-900 tracking-tight">
                        {{ $product ? $product->name : 'Product Unavailable' }}
                    </h3>
                    <span class="inline-flex items-center px-3 py-1 text-[10px] font-black text-red-600 bg-red-50 border border-red-100 rounded-lg uppercase tracking-widest self-center sm:self-auto">
                        Stock: {{ $product ? $product->stock : '0' }}
                    </span>
                </div>
                
                <p class="text-[13px] text-gray-500 font-medium leading-relaxed mb-4">
                    {{ $notification->data['description'] }}
                </p>
                
                <div class="flex items-center justify-center sm:justify-start gap-2">
                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full animate-pulse"></span>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                        Alerted {{ $notification->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>

            <!-- Action: Add Stock -->
            @if($product)
            <div class="w-full sm:w-auto bg-gray-50/50 p-6 rounded-[2rem] border border-gray-50">
                <form onsubmit="updateStock(event, '{{ $notification->id }}')" class="flex flex-col gap-3">
                    <div class="relative">
                        <input type="number" 
                               name="quantity" 
                               min="1" 
                               value="10" 
                               class="w-full sm:w-24 px-4 py-3 bg-white border border-gray-100 rounded-xl text-xs font-black text-gray-900 text-center focus:ring-4 focus:ring-blue-600/10 focus:border-blue-600 outline-none transition-all shadow-sm"
                               required>
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs text-blue-600 font-black pointer-events-none">+</span>
                    </div>
                    
                    <button type="submit" class="w-full px-6 py-3 bg-blue-600 hover:bg-gray-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl shadow-xl shadow-blue-600/10 transition-all active:scale-95 whitespace-nowrap">
                        Fill Stock
                    </button>
                </form>
            </div>
            @endif
        </div>
    @empty
        <div class="flex flex-col items-center justify-center p-20 text-center bg-white rounded-[3rem] border border-dashed border-gray-200">
            <div class="w-24 h-24 bg-green-50 rounded-full flex items-center justify-center mb-8">
                <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-xl font-black text-gray-900 tracking-tight">Everything is Shipshape!</h3>
            <p class="text-gray-400 mt-3 max-w-sm text-sm font-medium leading-relaxed">Your inventory levels are healthy. No replenishment needed at this moment.</p>
        </div>
    @endforelse
</div>

<div class="mt-12">
    {{ $notifications->links() }}
</div>

<script>
    async function updateStock(e, id) {
        e.preventDefault();
        const form = e.target;
        const btn = form.querySelector('button');
        const originalText = btn.innerText;
        const quantity = form.quantity.value;

        btn.disabled = true;
        btn.innerText = 'UPDATING...';
        btn.classList.add('opacity-50', 'cursor-not-allowed');

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
                const card = document.getElementById(`notification-${id}`);
                card.classList.add('scale-75', 'opacity-0', 'blur-lg');
                
                setTimeout(() => {
                    card.remove();
                    const container = document.getElementById('stock-alerts-list');
                    if(container.children.length === 0) location.reload();
                }, 500);

            } else {
                throw new Error(data.message || 'Error updating stock');
            }

        } catch (error) {
            btn.disabled = false;
            btn.innerText = originalText;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
            alert('Failed to update stock. Please check your connection.');
        }
    }
</script>
@endsection
