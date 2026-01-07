<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 h-screen flex text-gray-800 font-sans">
    
    <!-- Sidebar -->
    <aside class="w-72 bg-gray-900 text-white flex flex-col shadow-2xl z-10 transition-all duration-300">
        <!-- Logo / Brand -->
        <div class="h-20 flex items-center px-8 border-b border-gray-800">
             <div class="flex items-center gap-3">
                 <h1 class="text-xl font-bold tracking-tight bg-gradient-to-r from-yellow-400 to-blue-600 bg-clip-text text-transparent">Toystore</h1>
             </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Main Menu</p>
            
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 shadow-lg shadow-blue-900/50 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-500 group-hover:text-blue-400' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span class="font-medium">Dashboard</span>
            </a>

            <a href="{{ route('admin.orders.index') }}" 
               class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.orders.*') ? 'bg-blue-600 shadow-lg shadow-blue-900/50 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.orders.*') ? 'text-white' : 'text-gray-500 group-hover:text-blue-400' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                <span class="font-medium">Orders</span>
                @if(isset($pendingOrders) && $pendingOrders > 0)
                   <span class="ml-auto bg-blue-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $pendingOrders }}</span>
                @endif
            </a>

            <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-6 mb-2">Management</p>

            <a href="{{ route('admin.products.index') }}" 
               class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.products.*') ? 'bg-blue-600 shadow-lg shadow-blue-900/50 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.products.*') ? 'text-white' : 'text-gray-500 group-hover:text-blue-400' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                <span class="font-medium">Products</span>
            </a>

            <a href="{{ route('admin.categories.index') }}" 
               class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.categories.*') ? 'bg-blue-600 shadow-lg shadow-blue-900/50 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                 <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-gray-500 group-hover:text-blue-400' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                <span class="font-medium">Categories</span>
            </a>

            <a href="{{ route('admin.users.index') }}" 
               class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.users.*') ? 'bg-blue-600 shadow-lg shadow-blue-900/50 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                 <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-gray-500 group-hover:text-blue-400' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span class="font-medium">Users</span>
            </a>

            @php
                $unreadNotifications = auth()->user()->unreadNotifications->count();
                $unreadMessages = \App\Models\ContactMessage::count(); 
            @endphp
            
            <a href="{{ route('admin.messages.index') }}" 
               class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.messages.*') ? 'bg-blue-600 shadow-lg shadow-blue-900/50 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.messages.*') ? 'text-white' : 'text-gray-500 group-hover:text-blue-400' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span class="font-medium">Messages</span>
                {{-- Optional: Add count badge if needed --}}
            </a>

            <a href="{{ route('admin.notifications.index') }}" 
               class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.notifications.*') ? 'bg-blue-600 shadow-lg shadow-blue-900/50 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                 <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.notifications.*') ? 'text-white' : 'text-gray-500 group-hover:text-blue-400' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                <span class="font-medium">Notifications</span>
                @if($unreadNotifications > 0)
                    <span class="ml-auto bg-red-500 text-white text-[10px] font-black px-1.5 py-0.5 rounded-full">{{ $unreadNotifications }}</span>
                @endif
            </a>
        </nav>

        <!-- User Profile / Logout -->
        <div class="p-4 border-t border-gray-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full px-4 py-3 text-gray-400 hover:bg-gray-800 hover:text-white rounded-xl transition-all duration-200 group">
                    <svg class="w-5 h-5 mr-3 group-hover:text-red-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span class="font-medium">Sign Out</span>
                </button>
            </form>
        </div>
    </aside>
    
    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden relative">
        <!-- Top Bar -->
        <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-8 z-30 shrink-0">
            <!-- Greeting/Title -->
            <div>
                <h2 class="text-xl font-black text-gray-800 tracking-tight">Hi, {{ auth()->user()->name }} 👋</h2>
                <p class="text-xs text-gray-500 font-bold mt-1">Here's what's happening with your store today.</p>
            </div>

            <!-- Right Actions -->
            <div class="flex items-center gap-6">
                <!-- Notifications Dropdown -->
                <style>[x-cloak] { display: none !important; }</style>
                <div x-data="{ open: false }" class="relative" x-cloak>
                    <!-- Button -->
                    <button @click="open = !open" 
                            class="relative p-2 rounded-xl text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-all duration-300 group focus:outline-none">
                        <!-- Bell Icon -->
                        <svg class="w-6 h-6 transform group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        
                        <!-- Unread Dot -->
                        @if(isset($adminUnreadCount) && $adminUnreadCount > 0)
                            <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full animate-pulse"></span>
                        @endif
                    </button>

                    <!-- Dropdown Panel -->
                    <div x-show="open" 
                         @click.outside="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                         class="absolute right-0 mt-4 w-96 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50 origin-top-right ring-1 ring-black ring-opacity-5"
                         style="display: none;">
                        
                        <div class="p-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                            <h3 class="font-black text-gray-800 text-sm uppercase tracking-wider">Notifications</h3>
                            @if(isset($adminUnreadCount) && $adminUnreadCount > 0)
                                <span class="bg-blue-100 text-blue-700 text-[10px] font-black px-2 py-0.5 rounded-full uppercase tracking-wide">{{ $adminUnreadCount }} New</span>
                            @endif
                        </div>

                        <div class="max-h-[400px] overflow-y-auto custom-scrollbar">
                            @forelse($adminNotifications as $notification)
                                <a href="{{ $notification['action_url'] }}" class="block p-4 hover:bg-gray-50 transition-colors border-b border-gray-50 last:border-none group {{ is_null($notification['read_at']) ? 'bg-blue-50/40' : '' }}">
                                    <div class="flex items-start gap-4">
                                        <!-- Icon -->
                                        <div class="flex-shrink-0 w-10 h-10 rounded-xl {{ $notification['color'] }} flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform duration-300">
                                            @if($notification['type'] === 'stock')
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                            @elseif($notification['type'] === 'order')
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                            @else
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                            @endif
                                        </div>

                                        <!-- Content -->
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-bold text-gray-900 truncate">{{ $notification['title'] }}</p>
                                            <p class="text-xs text-gray-400 mt-0.5 truncate">{{ $notification['description'] }}</p>
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex flex-col items-end gap-1">
                                            <span class="text-[10px] font-bold text-gray-300 whitespace-nowrap">{{ $notification['time']->diffForHumans(null, true, true) }}</span>

                                            <!-- Delete Button -->
                                            <button @click.prevent="deleteNotification('{{ $notification['id'] }}', $el.closest('a'))" 
                                                    class="p-1 rounded-md text-gray-300 hover:text-red-500 hover:bg-red-50 transition-colors"
                                                    title="Dismiss">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="p-8 text-center">
                                    <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    </div>
                                    <p class="text-sm font-bold text-gray-900">All clear!</p>
                                    <p class="text-xs text-gray-400 mt-1">No actionable alerts at the moment.</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Footer -->
                        @if(collect($adminNotifications)->count() > 0)
                        <div class="p-4 bg-gray-50 border-t border-gray-100 text-center">
                            <a href="{{ route('admin.notifications.index') }}" class="text-xs font-black text-blue-600 hover:text-blue-700 uppercase tracking-wide hover:underline">View All Alerts</a>
                        </div>
                        @endif
                    </div>
                </div>

                <script>
                    async function deleteNotification(id, element) {
                        if(!id) return;
                        
                        // Animate removal
                        element.style.transform = 'translate(10px, 0)';
                        element.style.opacity = '0';
                        
                        try {
                            const response = await fetch(`/toystore-admin/notifications/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                }
                            });
                            
                            const data = await response.json();
                            
                            if (response.ok) {
                                setTimeout(() => {
                                    element.remove();
                                    // Optional: Refresh global unread count logic if needed
                                }, 300);
                            } else {
                                // Revert visual if failed
                                element.style.transform = 'none';
                                element.style.opacity = '1';
                            }
                        } catch (e) {
                            console.error('Failed to delete notification', e);
                            element.style.transform = 'none';
                            element.style.opacity = '1';
                        }
                    }
                </script>

                <!-- Admin Profile Short -->
                <div class="flex items-center gap-3 pl-6 border-l border-gray-100">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-black text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Administrator</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-gray-900 text-white flex items-center justify-center font-black shadow-lg shadow-gray-200">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto bg-gray-50 p-8">
            <!-- Alert Component -->
            <x-admin.alert />

            @yield('content')
        </div>
    </main>
</body>
</html>
