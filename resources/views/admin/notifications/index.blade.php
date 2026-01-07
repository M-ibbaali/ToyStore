@extends('layouts.admin')

@section('title', 'Notifications')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-extrabold text-gray-900">Notifications</h1>
    @if($notifications->count() > 0)
        <form action="{{ route('admin.notifications.clearAll') }}" method="POST" onsubmit="return confirm('Clear all notifications?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-6 py-2 bg-red-100 text-red-600 rounded-xl font-bold hover:bg-red-200 transition">
                Clear All
            </button>
        </form>
    @endif
</div>

<div class="space-y-4">
    @forelse($notifications as $notification)
        <div class="bg-white p-6 rounded-2xl shadow-sm border {{ $notification->unread() ? 'border-blue-200 bg-blue-50/30' : 'border-gray-100' }} flex items-start justify-between group transition-all">
            <div class="flex gap-4">
                <div class="p-3 {{ $notification->data['color'] ?? 'bg-blue-100 text-blue-600' }} rounded-xl h-fit">
                    @php $type = $notification->data['type'] ?? 'info'; @endphp
                    @if($type === 'stock')
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    @elseif($type === 'order')
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    @elseif($type === 'message')
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    @elseif($type === 'user')
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    @else
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    @endif
                </div>
                <div>
                    <h3 class="font-black text-gray-800 uppercase tracking-tight">{{ $notification->data['title'] ?? 'Notification' }}</h3>
                    <p class="text-gray-600 mt-1">{{ $notification->data['description'] ?? '' }}</p>
                    <div class="flex items-center gap-3 mt-2">
                        <span class="text-xs text-gray-400 font-bold">{{ $notification->created_at->diffForHumans() }}</span>
                        @if(isset($notification->data['url']))
                            <a href="{{ $notification->data['url'] }}" class="text-xs font-bold text-blue-600 hover:underline">View Details &rarr;</a>
                        @endif
                    </div>
                </div>
            </div>
            
            <form action="{{ route('admin.notifications.destroy', $notification->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-gray-300 hover:text-red-500 transition opacity-0 group-hover:opacity-100" title="Delete Notification">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </form>
        </div>
    @empty
        <div class="bg-white p-12 rounded-[2rem] shadow-sm border border-gray-100 text-center">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            </div>
            <p class="text-gray-400 font-bold uppercase tracking-widest text-sm">No notifications found</p>
        </div>
    @endforelse
</div>

<div class="mt-6">
    {{ $notifications->links() }}
</div>
@endsection
