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
        <!-- Top Bar for Mobile/User Info (Optional, keeping simple as requested) -->
        
        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto bg-gray-50 p-8">
            <!-- Toast Notification Container -->
            <div id="toast-container" class="fixed top-5 right-5 z-50 flex flex-col gap-3 pointer-events-none">
                <!-- Toast items will be injected here with javascript, make sure enable pointer-events -->
                @if(session('success'))
                    <div class="bg-white border-l-4 border-green-500 text-gray-700 p-4 rounded-lg shadow-xl flex items-center gap-3 transform transition-all duration-500 animate-slide-in-right pointer-events-auto min-w-[300px]" role="alert">
                        <div class="p-2 bg-green-100 rounded-full text-green-600">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold text-sm">Success</p>
                            <p class="text-sm opacity-90">{{ session('success') }}</p>
                        </div>
                        <button onclick="this.parentElement.remove()" class="ml-auto text-gray-400 hover:text-gray-600 focus:outline-none">&times;</button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-white border-l-4 border-red-500 text-gray-700 p-4 rounded-lg shadow-xl flex items-center gap-3 transform transition-all duration-500 animate-slide-in-right pointer-events-auto min-w-[300px]" role="alert">
                         <div class="p-2 bg-red-100 rounded-full text-red-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold text-sm">Error</p>
                            <p class="text-sm opacity-90">{{ session('error') }}</p>
                        </div>
                        <button onclick="this.parentElement.remove()" class="ml-auto text-gray-400 hover:text-gray-600 focus:outline-none">&times;</button>
                    </div>
                @endif
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const toasts = document.querySelectorAll('#toast-container > div');
                    toasts.forEach(toast => {
                        setTimeout(() => {
                            toast.style.opacity = '0';
                            toast.style.transform = 'translate(100%, 0)';
                            setTimeout(() => toast.remove(), 500); 
                        }, 5000);
                    });
                });
            </script>

            @yield('content')
        </div>
    </main>
</body>
</html>
