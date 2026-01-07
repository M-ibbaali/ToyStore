<div class="py-12 bg-[#FBFBFB] min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar -->
            <aside class="w-full lg:w-72 flex-shrink-0 hidden lg:block">
                <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100 sticky top-32">
                    <!-- User Profile Quick Info -->
                    <div class="flex items-center gap-4 mb-10 pb-8 border-b border-gray-50">
                        <div class="w-14 h-14 rounded-2xl overflow-hidden shadow-md ring-4 ring-primary/5 p-0.5">
                            <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover rounded-[0.9rem]">
                        </div>
                        <div class="overflow-hidden">
                            <h4 class="text-sm font-black text-toys-text truncate">{{ Auth::user()->name }}</h4>
                            <span class="text-[10px] font-bold text-gray-400 truncate block">{{ Auth::user()->email }}</span>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <nav class="space-y-1.5">
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center gap-4 px-5 py-4 rounded-2xl font-black text-sm transition-all duration-300 {{ Route::is('dashboard') ? 'bg-primary text-white shadow-xl shadow-primary/20 scale-[1.02]' : 'text-gray-400 hover:text-secondary hover:bg-gray-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Overview
                        </a>

                        <a href="{{ route('orders.index') }}" 
                           class="flex items-center gap-4 px-5 py-4 rounded-2xl font-black text-sm transition-all duration-300 {{ Route::is('orders.*') ? 'bg-primary text-white shadow-xl shadow-primary/20 scale-[1.02]' : 'text-gray-400 hover:text-secondary hover:bg-gray-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            My Orders
                        </a>

                        <a href="{{ route('profile.edit') }}" 
                           class="flex items-center gap-4 px-5 py-4 rounded-2xl font-black text-sm transition-all duration-300 {{ Route::is('profile.*') ? 'bg-primary text-white shadow-xl shadow-primary/20 scale-[1.02]' : 'text-gray-400 hover:text-secondary hover:bg-gray-50' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Profile Settings
                        </a>

                        <!-- Logout -->
                        <div class="pt-6 mt-6 border-t border-gray-50">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-4 px-5 py-4 w-full rounded-2xl font-black text-sm text-red-400 hover:bg-red-50 hover:text-red-500 transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </nav>
                </div>
            </aside>

            <!-- Main Content Area -->
            <main class="flex-1 min-w-0">
                <div class="bg-white rounded-[3rem] p-8 lg:p-12 shadow-sm border border-gray-100 min-h-[600px]">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</div>
