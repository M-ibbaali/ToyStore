<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 h-screen overflow-hidden flex text-gray-800 font-sans" x-data="{ sidebarOpen: false }">
    
    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-40 lg:hidden"
         style="display: none;"></div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           class="fixed inset-y-0 left-0 w-72 bg-gray-900 text-white flex flex-col shadow-2xl z-50 transition-transform duration-300 ease-in-out lg:static lg:inset-auto">
        
        <!-- Sidebar Brand / Logo -->
        <div class="h-24 flex items-center justify-between px-6 border-b border-gray-800/50 bg-gray-900/50 backdrop-blur-sm">
             <a href="{{ route('home') }}" class="flex items-center gap-3 group transition-all duration-300 hover:scale-105">
                 <img src="https://res.cloudinary.com/dcqigi8kc/image/upload/v1767872448/Gemini_Generated_Image_geo7n0geo7n0geo7-removebg-preview_aa9i2e.png" 
                      alt="ToyStore Logo" 
                      class="h-14 w-auto object-contain brightness-0 invert opacity-100 group-hover:opacity-100">
             </a>
             <!-- Close Button (Mobile Only) -->
             <button @click="sidebarOpen = false" class="lg:hidden p-2 rounded-xl text-gray-400 hover:text-white hover:bg-gray-800 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
             </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto custom-scrollbar">
            <p class="px-4 text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-4">Main Menu</p>
            
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 shadow-xl shadow-blue-600/20 text-white scale-[1.02]' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white hover:translate-x-1' }}">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center mr-3 {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : 'bg-gray-800 group-hover:bg-blue-600/20 group-hover:text-blue-400' }} transition-colors">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                </div>
                <span class="font-bold text-sm tracking-tight">Dashboard</span>
            </a>

            <a href="{{ route('admin.orders.index') }}" 
               class="flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.orders.*') ? 'bg-blue-600 shadow-xl shadow-blue-600/20 text-white scale-[1.02]' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white hover:translate-x-1' }}">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center mr-3 {{ request()->routeIs('admin.orders.*') ? 'bg-white/20' : 'bg-gray-800 group-hover:bg-blue-600/20 group-hover:text-blue-400' }} transition-colors">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.orders.*') ? 'text-white' : 'text-gray-400 group-hover:text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <span class="font-bold text-sm tracking-tight">Orders</span>
                @if(isset($pendingOrders) && $pendingOrders > 0)
                   <span class="ml-auto bg-yellow-400 text-gray-900 text-[10px] font-black px-2 py-0.5 rounded-full shadow-sm">{{ $pendingOrders }}</span>
                @endif
            </a>

            <p class="px-4 text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mt-8 mb-4">Store Management</p>

            <a href="{{ route('admin.products.index') }}" 
               class="flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.products.*') ? 'bg-blue-600 shadow-xl shadow-blue-600/20 text-white scale-[1.02]' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white hover:translate-x-1' }}">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center mr-3 {{ request()->routeIs('admin.products.*') ? 'bg-white/20' : 'bg-gray-800 group-hover:bg-blue-600/20 group-hover:text-blue-400' }} transition-colors">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.products.*') ? 'text-white' : 'text-gray-400 group-hover:text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <span class="font-bold text-sm tracking-tight">Products</span>
            </a>

            <a href="{{ route('admin.categories.index') }}" 
               class="flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.categories.*') ? 'bg-blue-600 shadow-xl shadow-blue-600/20 text-white scale-[1.02]' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white hover:translate-x-1' }}">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center mr-3 {{ request()->routeIs('admin.categories.*') ? 'bg-white/20' : 'bg-gray-800 group-hover:bg-blue-600/20 group-hover:text-blue-400' }} transition-colors">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-gray-400 group-hover:text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <span class="font-bold text-sm tracking-tight">Categories</span>
            </a>

            <a href="{{ route('admin.users.index') }}" 
               class="flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.users.*') ? 'bg-blue-600 shadow-xl shadow-blue-600/20 text-white scale-[1.02]' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white hover:translate-x-1' }}">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center mr-3 {{ request()->routeIs('admin.users.*') ? 'bg-white/20' : 'bg-gray-800 group-hover:bg-blue-600/20 group-hover:text-blue-400' }} transition-colors">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-gray-400 group-hover:text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <span class="font-bold text-sm tracking-tight">Users</span>
            </a>

            <p class="px-4 text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mt-8 mb-4">Communication</p>

            @php
                $unreadNotifications = auth()->user()->unreadNotifications->count();
                $unreadMessages = \App\Models\ContactMessage::count(); 
            @endphp
            
            <a href="{{ route('admin.messages.index') }}" 
               class="flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.messages.*') ? 'bg-blue-600 shadow-xl shadow-blue-600/20 text-white scale-[1.02]' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white hover:translate-x-1' }}">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center mr-3 {{ request()->routeIs('admin.messages.*') ? 'bg-white/20' : 'bg-gray-800 group-hover:bg-blue-600/20 group-hover:text-blue-400' }} transition-colors">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.messages.*') ? 'text-white' : 'text-gray-400 group-hover:text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <span class="font-bold text-sm tracking-tight">Messages</span>
            </a>

            <a href="{{ route('admin.notifications.index') }}" 
               class="flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.notifications.*') ? 'bg-blue-600 shadow-xl shadow-blue-600/20 text-white scale-[1.02]' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white hover:translate-x-1' }}">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center mr-3 {{ request()->routeIs('admin.notifications.*') ? 'bg-white/20' : 'bg-gray-800 group-hover:bg-blue-600/20 group-hover:text-blue-400' }} transition-colors">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.notifications.*') ? 'text-white' : 'text-gray-400 group-hover:text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                </div>
                <span class="font-bold text-sm tracking-tight">Notifications</span>
                @if($unreadNotifications > 0)
                    <span class="ml-auto bg-red-500 text-white text-[10px] font-black px-1.5 py-0.5 rounded-full shadow-sm">{{ $unreadNotifications }}</span>
                @endif
            </a>
        </nav>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-gray-800/50">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full px-4 py-3.5 text-gray-400 hover:bg-red-500/10 hover:text-red-400 rounded-2xl transition-all duration-300 group">
                    <div class="w-8 h-8 rounded-xl bg-gray-800 group-hover:bg-red-500/20 flex items-center justify-center mr-3 transition-colors">
                        <svg class="w-5 h-5 group-hover:text-red-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </div>
                    <span class="font-bold text-sm tracking-tight">Sign Out</span>
                </button>
            </form>
        </div>
    </aside>
    
    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden relative min-w-0 bg-[#FBFBFB]">
        <!-- Top Bar -->
        <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-4 sm:px-8 z-30 shrink-0">
            <!-- Left Side: Mobile Toggle & Greeting -->
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="lg:hidden p-2.5 rounded-xl text-gray-500 hover:bg-gray-50 border border-gray-100 transition-all active:scale-95">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>

                <div class="hidden sm:block">
                    <h2 class="text-xl font-black text-gray-900 tracking-tight leading-none">Hi, {{ explode(' ', auth()->user()->name)[0] }} 👋</h2>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1.5 opacity-70">Administrator Dashboard</p>
                </div>
                <!-- Compact Mobile Greeting -->
                <div class="sm:hidden">
                    <h2 class="text-sm font-black text-gray-900 tracking-tight leading-none">Hi, {{ explode(' ', auth()->user()->name)[0] }}</h2>
                </div>
            </div>

            <!-- Right Side: Interactions -->
            <div class="flex items-center gap-2 sm:gap-6">
                <!-- Notifications -->
                <style>[x-cloak] { display: none !important; }</style>
                <div x-data="{ open: false }" class="relative" x-cloak>
                    <button @click="open = !open" 
                            class="relative p-2.5 rounded-xl text-gray-400 hover:text-blue-600 hover:bg-blue-50 border border-transparent hover:border-blue-100 transition-all duration-300 group focus:outline-none">
                        <svg class="w-6 h-6 transform group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        @if(isset($adminUnreadCount) && $adminUnreadCount > 0)
                            <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full animate-pulse shadow-sm shadow-red-500/20"></span>
                        @endif
                    </button>

                    <!-- Dropdown Panel -->
                    <div x-show="open" 
                         @click.outside="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
                         class="absolute right-0 mt-4 w-[calc(100vw-32px)] sm:w-96 bg-white rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.1)] border border-gray-100 overflow-hidden z-50 origin-top-right ring-1 ring-black/5"
                         style="display: none;">
                        
                        <div class="p-6 border-b border-gray-50 flex items-center justify-between bg-white">
                            <h3 class="font-black text-gray-900 text-xs uppercase tracking-widest">Recent Activity</h3>
                            @if(isset($adminUnreadCount) && $adminUnreadCount > 0)
                                <span class="bg-blue-600 text-white text-[8px] font-black px-2 py-0.5 rounded-full uppercase tracking-wider">{{ $adminUnreadCount }} New</span>
                            @endif
                        </div>

                        <div class="max-h-[400px] overflow-y-auto custom-scrollbar bg-gray-50/30">
                            @forelse($adminNotifications as $notification)
                                <a href="{{ $notification['action_url'] }}" class="block p-5 hover:bg-white transition-all border-b border-gray-50 last:border-none group {{ is_null($notification['read_at']) ? 'bg-white/60' : '' }}">
                                    <div class="flex items-start gap-4">
                                        <div class="flex-shrink-0 w-12 h-12 rounded-2xl {{ $notification['color'] }} flex items-center justify-center shadow-lg shadow-current/10 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                            @if($notification['type'] === 'stock')
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                            @elseif($notification['type'] === 'order')
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                            @else
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            @endif
                                        </div>

                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-black text-gray-900 group-hover:text-blue-600 transition-colors truncate">{{ $notification['title'] }}</p>
                                            <p class="text-[11px] text-gray-500 mt-1 font-medium line-clamp-2 leading-relaxed">{{ $notification['description'] }}</p>
                                            <span class="text-[9px] font-black text-gray-300 uppercase tracking-widest mt-3 block">{{ $notification['time']->diffForHumans() }}</span>
                                        </div>

                                        <button @click.prevent="deleteNotification('{{ $notification['id'] }}', $el.closest('a'))" 
                                                class="p-2 rounded-xl text-gray-200 hover:text-red-500 hover:bg-red-50 transition-all opacity-0 group-hover:opacity-100"
                                                title="Dismiss">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                </a>
                            @empty
                                <div class="py-16 px-8 text-center bg-white">
                                    <div class="w-20 h-20 bg-gray-50 rounded-[2rem] flex items-center justify-center mx-auto mb-6">
                                        <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    </div>
                                    <p class="text-sm font-black text-gray-900">Inbox Zero! ✨</p>
                                    <p class="text-xs text-gray-400 mt-2 font-medium">All notifications handled.</p>
                                </div>
                            @endforelse
                        </div>

                        @if(collect($adminNotifications)->count() > 0)
                        <div class="p-6 bg-white border-t border-gray-50">
                            <a href="{{ route('admin.notifications.index') }}" class="flex items-center justify-center h-12 bg-gray-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.1em] hover:bg-blue-600 transition-all shadow-xl shadow-gray-900/10 active:scale-98">View All Activity</a>
                        </div>
                        @endif
                    </div>
                </div>

                <script>
                    async function deleteNotification(id, element) {
                        if(!id) return;
                        element.style.transform = 'scale(0.95) translate(20px, 0)';
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
                            if (response.ok) {
                                setTimeout(() => { element.remove(); }, 300);
                            } else {
                                element.style.transform = 'none';
                                element.style.opacity = '1';
                            }
                        } catch (e) {
                            element.style.transform = 'none';
                            element.style.opacity = '1';
                        }
                    }
                </script>

                <!-- Profile -->
                <div class="flex items-center gap-3 pl-4 sm:pl-6 border-l border-gray-100">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-gray-900 text-white flex items-center justify-center font-black shadow-xl shadow-gray-900/20 ring-4 ring-gray-900/5 transition-transform hover:scale-105 cursor-pointer">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-4 sm:p-8 custom-scrollbar">
            <!-- Alert Component -->
            <div class="max-w-[1600px] mx-auto">
                <x-admin.alert />
                @yield('content')
            </div>
        </div>
    </main>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #d1d5db; }
    </style>
</body>
</html>
