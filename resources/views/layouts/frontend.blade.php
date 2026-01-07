@php
    $isHome = Route::is('home');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ToyStore') }} - @yield('title', 'Premium Toys')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=nunito:400,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    
    <style>
    
        .hero-slider {
            position: relative;
            overflow: hidden;
        }
        .hero-slide {
            display: none;
            animation: fadeIn 1s ease-in-out;
        }
        .hero-slide.active {
            display: block;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Hero Content Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 1s ease-out forwards;
            opacity: 0;
        }

        @keyframes bounceSubtle {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-3px); }
        }
        .animate-bounce-subtle {
            animation: bounceSubtle 2s infinite;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }

        .delay-100 {
            animation-delay: 0.2s;
        }

        .delay-200 {
            animation-delay: 0.4s;
        }

        /* Immediate Sticky Header */
        #main-header {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        #main-header.is-fixed {
            position: fixed !important;
            background-color: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            animation: headerFadeIn 0.3s ease-out;
        }

        .is-fixed #header-border {
            border-bottom-color: transparent !important;
        }

        .is-fixed #search-container {
            background-color: #f1f5f9 !important; /* slate-100 */
            border-color: #cbd5e1 !important; /* slate-300 */
        }

        @keyframes headerFadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Back to Top Button Styles */
        #back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 100;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px) scale(0.9);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #back-to-top.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }

        #back-to-top:hover {
            transform: translateY(-5px) scale(1.1);
        }

        #back-to-top:active {
            transform: translateY(0) scale(0.95);
        }

        /* Cart Transitions */
        .cart-item-fade-out {
            opacity: 0;
            transform: translateX(20px);
            transition: all 0.5s ease-out;
        }
        .cart-item-fade-in {
            animation: cartItemFadeIn 0.5s ease-out forwards;
        }
        @keyframes cartItemFadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Wishlist Bounce Animation */
        @keyframes bounce-scale {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.4); }
        }
        .animate-bounce-scale {
            animation: bounce-scale 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .shake {
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
        }
        @keyframes shake {
            10%, 90% { transform: translate3d(-1px, 0, 0); }
            20%, 80% { transform: translate3d(2px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
            40%, 60% { transform: translate3d(4px, 0, 0); }
        }
    </style>
</head>
<body class="font-sans antialiased bg-toys-bg text-toys-text {{ $isHome ? '' : 'pt-20 lg:pt-32' }}">
    <!-- Floating Home Button
    @if(!Route::is('home'))
    <a href="{{ route('home') }}" class="fixed top-6 left-6 z-[60] flex items-center gap-2 bg-white/80 backdrop-blur-md border border-white/50 px-4 py-2.5 rounded-2xl shadow-xl shadow-gray-200/50 group transition-all duration-300 hover:scale-105 hover:bg-white hover:shadow-2xl hover:border-primary/30">
        <div class="w-8 h-8 bg-primary/10 rounded-xl flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a2 2 0 002 2h2a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h2a2 2 0 002-2v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
            </svg>
        </div>
        <span class="text-sm font-black text-toys-text tracking-wide uppercase group-hover:text-primary transition-colors">Home</span>
    </a>
    @endif -->

    <!-- Header -->

    <header id="main-header" class="{{ $isHome ? 'absolute' : 'fixed' }} w-full top-0 z-50 transition-all duration-300 {{ $isHome ? 'bg-transparent text-toys-text' : 'bg-white text-toys-text shadow-sm' }}">
        <!-- Main Header -->
        <div id="header-border" class="border-b {{ $isHome ? 'border-transparent' : 'border-gray-200' }} transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="text-2xl font-black flex items-center transition-colors duration-300 group" id="header-logo">
                            <span class="text-3xl mr-2 transform group-hover:rotate-12 transition text-primary">🧸</span>
                            <span class="text-secondary drop-shadow-sm">ToyStore</span>
                        </a>
                    </div>

                    <!-- Search Bar (Desktop) -->
                    <!-- We might need to adjust search bar styling for transparent header -->
                    <div class="hidden md:flex flex-1 max-w-2xl mx-8 relative group">
                        <form action="{{ route('shop.index') }}" method="GET" class="w-full relative">
                            <!-- Input Wrapper -->
                            <div id="search-container" class="relative flex items-center w-full rounded-full overflow-hidden h-11 transition-all duration-300 {{ $isHome ? 'bg-white/80 border-2 border-primary text-toys-text' : 'bg-white border-2 border-secondary text-gray-700' }} shadow-sm">
                                <input 
                                    type="text" 
                                    name="search" 
                                    id="desktop-search-input"
                                    placeholder="Search Products..." 
                                    class="w-full px-4 text-sm outline-none border-none focus:ring-0 h-full bg-transparent placeholder-current transition-colors"
                                    autocomplete="off"
                                >
                                
                                <!-- Search Button -->
                                <button type="submit" class="px-4 h-full flex items-center justify-center transition-colors text-secondary hover:text-primary">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                        
                        <!-- Search Results Dropdown -->
                        <div id="search-results" class="absolute top-full left-0 right-0 bg-white border border-gray-200 rounded-b-lg shadow-xl z-50 hidden mt-1 divide-y divide-gray-100 max-h-[400px] overflow-y-auto">
                            <!-- Results will be injected here via JS -->
                        </div>
                    </div>

                    <!-- Right Menu (Desktop) -->
                    <div class="hidden md:flex items-center space-x-6">
                        <!-- Favorites -->
                        <div class="relative {{ !request()->routeIs('favorites.index') ? 'group/fav-nav' : '' }} items-center flex" id="favorites-wrapper">
                      <a href="{{ route('favorites.index') }}"
   class="relative transition-transform duration-300 hover:scale-110 flex items-center"
   id="header-favorites">

    <svg id="header-fav-icon"
         class="w-6 h-6"
         fill="{{ $wishlistCount > 0 ? '#ef4444' : 'none' }}"
         stroke="{{ $wishlistCount > 0 ? '#ef4444' : '#f92d2dff' }}"
         stroke-width="2"
         viewBox="0 0 24 24">
        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5
                 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09
                 C13.09 3.81 14.76 3 16.5 3
                 19.58 3 22 5.42 22 8.5
                 c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
    </svg>

    <span id="fav-badge"
          class="{{ $wishlistCount > 0 ? '' : 'hidden' }}
                 absolute -top-2 -right-2 bg-red-500 text-white
                 text-[10px] font-black rounded-full
                 w-4 h-4 flex items-center justify-center">
        {{ $wishlistCount }}
    </span>
</a>




                            <!-- Mini Wishlist Dropdown -->
                            <div id="fav-dropdown" class="absolute top-[120%] right-0 w-64 bg-white rounded-2xl shadow-2xl border border-gray-100 py-4 px-2 opacity-0 invisible group-hover/fav-nav:opacity-100 group-hover/fav-nav:visible group-hover/fav-nav:top-full transition-all duration-300 z-50 transform origin-top-right scale-95 group-hover/fav-nav:scale-100 overflow-visible">
                                <div id="fav-dropdown-content">
                                    @include('partials.mini-wishlist')
                                </div>
                            </div>
                        </div>

                        <!-- Cart -->
                        <div class="relative {{ !request()->routeIs('cart.index') ? 'group' : '' }}" id="mini-cart-wrapper">
                            <a href="{{ route('cart.index') }}" class="relative transition-colors duration-300 hover:opacity-75 flex items-center" id="header-cart">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <span id="cart-count-badge-desktop" class="cart-count-badge absolute -top-2 -right-2 bg-toys-btn text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center {{ $cartCount > 0 ? '' : 'hidden' }}">
                                    {{ $cartCount }}
                                </span>
                            </a>

                            <!-- Mini-Cart Dropdown -->
                            <div id="mini-cart-dropdown" class="absolute top-full right-0 mt-4 w-80 bg-white rounded-3xl shadow-2xl border-2 border-toy-bg p-6 opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-300 z-[100] transform origin-top-right">
                                @include('partials.mini-cart')
                            </div>
                        </div>
                        
                        @if(auth()->check() && auth()->user()->role !== 'admin')
                            <!-- User Profile -->
                            <div class="relative {{ !request()->routeIs(['dashboard', 'profile.*', 'orders.*', 'favorites.index']) ? 'group' : '' }}">
                                <button class="flex items-center space-x-2 transition-colors duration-300 hover:opacity-75" id="header-user">
                                @if(auth()->user()->avatar)
                                    <div class="w-8 h-8 rounded-lg overflow-hidden border border-gray-100 flex-shrink-0">
                                        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                @endif
                                <span class="text-sm font-medium">
                                    {{ auth()->user()->name }}
                                </span>
                                </button>
                                
                                @if(!request()->routeIs(['dashboard', 'profile.*', 'orders.*', 'favorites.index']))
                                    <!-- Dropdown -->
                                    <div class="absolute right-0 w-48 pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 ease-in-out z-50">
                                        <div class="bg-white rounded-xl shadow-lg border-2 border-primary overflow-hidden">
                                            <div class="px-4 py-3 border-b border-yellow-100 bg-yellow-50">
                                                <p class="text-sm leading-5 font-bold text-toys-text truncate">{{ Auth::user()->name }}</p>
                                                <p class="text-xs leading-4 text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                            </div>
                                            
                                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-toys-pink transition-colors">
                                                Dashboard
                                            </a>
                                            <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-toys-pink transition-colors">
                                                My Orders
                                            </a>
                                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-toys-pink transition-colors">
                                                My Profile
                                            </a>
                                            
                                            <!-- Authentication -->
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                                    Sign Out
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('login') }}" class="text-sm font-medium transition-colors duration-300 hover:opacity-75 text-black" id="header-login">Sign In</a>
                            <a href="{{ route('register') }}" class="text-sm font-medium transition-colors duration-300 hover:opacity-75 text-black" id="header-login">/ Register</a>
                        </div>
                        @endif
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="flex items-center gap-4 md:hidden">
                        <!-- Mobile Favorites -->
                         <a href="{{ route('favorites.index') }}" class="relative p-2 text-gray-500 hover:text-primary transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <span id="fav-badge-mobile" class="fav-badge {{ $wishlistCount > 0 ? '' : 'hidden' }} absolute top-1 right-1 bg-red-500 text-white text-[8px] font-black rounded-full w-3.5 h-3.5 flex items-center justify-center">
                                {{ $wishlistCount }}
                            </span>
                        </a>

                        <!-- Mobile Cart -->
                         <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-500 hover:text-primary transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span id="cart-count-badge-mobile" class="cart-count-badge {{ $cartCount > 0 ? '' : 'hidden' }} absolute top-1 right-1 bg-toys-btn text-white text-[8px] font-black rounded-full w-3.5 h-3.5 flex items-center justify-center">
                                {{ $cartCount }}
                            </span>
                        </a>

                        <button id="mobile-menu-btn" class="p-2 -mr-2 text-gray-700 hover:text-primary transition-colors focus:outline-none">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Navigation -->
        <!-- <nav id="header-nav" class="border-b transition-colors duration-300 {{ $isHome ? 'bg-secondary/10 border-transparent shadow-sm backdrop-blur-sm' : 'bg-white border-gray-200' }}">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex space-x-8 py-3 overflow-x-auto">
                    <a href="{{ route('shop.index') }}" class="text-sm font-bold text-toys-btn hover:text-primary transition whitespace-nowrap uppercase tracking-wider">All Toys</a>
                    @foreach($categories as $category)
                        <a href="{{ route('shop.index', ['category' => $category->id]) }}" 
                           class="text-sm font-bold transition-colors hover:text-toys-btn whitespace-nowrap {{ $isHome ? 'text-toys-text' : 'text-gray-700' }} nav-link">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </nav> -->
        <nav id="header-nav" class="hidden md:block border-b transition-colors duration-300 {{ $isHome ? 'bg-secondary/10 border-transparent shadow-sm backdrop-blur-sm' : 'bg-white border-gray-200' }}">
           <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-evenly py-5">

            {{-- Home --}}
            <a href="{{ route('home') }}"
               class="text-sm font-extrabold uppercase tracking-wider text-gray-900 hover:text-toys-btn transition">
                Home
            </a>

            {{-- Shop --}}
            <a href="{{ route('shop.index') }}"
               class="text-sm font-extrabold uppercase tracking-wider text-gray-900 hover:text-toys-btn transition">
                Shop
            </a>

            {{-- Categories (HOVER) --}}
            <div class="relative group">
                <span
                    class="flex items-center gap-1 text-sm font-extrabold uppercase tracking-wider
                           text-gray-900 hover:text-toys-btn transition cursor-pointer">
                    Categories
                    <svg class="w-4 h-4 transition-transform group-hover:rotate-180"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                </span>

                {{-- Dropdown --}}
                <div
                    class="absolute left-0 mt-3 w-56 bg-white border border-gray-200 rounded-xl shadow-lg
                           opacity-0 invisible translate-y-2
                           group-hover:opacity-100 group-hover:visible group-hover:translate-y-0
                           transition-all duration-200 z-50">

                    @foreach($categories as $category)
                        <div class="relative group/sub">
                            <a href="{{ route('shop.index', ['category' => $category->id]) }}"
                               class="flex items-center justify-between px-4 py-2 text-sm font-semibold
                                      text-gray-800 hover:bg-gray-100 hover:text-toys-btn transition">
                                {{ $category->name }}

                                @if($category->children->count() > 0)
                                    <svg class="w-4 h-4 -rotate-90" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 9l-7 7-7-7"/>
                                    </svg>
                                @endif
                            </a>

                            {{-- Subcategories --}}
                            @if($category->children->count() > 0)
                                <div
                                    class="absolute left-full top-0 ml-1 w-48 bg-white border border-gray-200
                                           rounded-xl shadow-lg opacity-0 invisible translate-x-2
                                           group-hover/sub:opacity-100 group-hover/sub:visible group-hover/sub:translate-x-0
                                           transition-all duration-200 z-50">
                                    @foreach($category->children as $child)
                                        <a href="{{ route('shop.index', ['category' => $child->id]) }}"
                                           class="block px-4 py-2 text-sm font-medium text-gray-800
                                                  hover:bg-gray-100 hover:text-toys-btn transition">
                                            {{ $child->name }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach

                </div>
            </div>

            {{-- About --}}
            <a href="{{ route('about') }}"
               class="text-sm font-extrabold uppercase tracking-wider text-gray-900 hover:text-toys-btn transition">
                About
            </a>

            {{-- Contact --}}
            <a href="{{ route('contact') }}"
               class="text-sm font-extrabold uppercase tracking-wider text-gray-900 hover:text-toys-btn transition">
                Contact
            </a>

        </div>
    </div>
        </nav>



      

    </header>

    <!-- Success/Error Alerts -->
    <!-- Toast Notifications -->

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16 font-sans">
        <!-- Top Features Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Feature 1 -->
                <div class="flex items-start space-x-3 group">
                    <div class="text-toys-btn">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm hover:text-toys-btn transition">High Quality Selection</h4>
                        <p class="text-xs text-gray-500 mt-1">Total product quality control for peace of mind</p>
                    </div>
                </div>
                <!-- Feature 2 -->
                <div class="flex items-start space-x-3 group">
                    <div class="text-toys-btn">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm hover:text-toys-btn transition">Affordable Prices</h4>
                        <p class="text-xs text-gray-500 mt-1">Factory direct prices for maximum savings</p>
                    </div>
                </div>
                <!-- Feature 3 -->
                <div class="flex items-start space-x-3 group">
                    <div class="text-toys-btn">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm hover:text-toys-btn transition">Express Shipping</h4>
                        <p class="text-xs text-gray-500 mt-1">Fast, reliable delivery from global warehouse</p>
                    </div>
                </div>
                <!-- Feature 4 -->
                <div class="flex items-start space-x-3 group">
                    <div class="text-toys-btn">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm hover:text-toys-btn transition">Worry Free</h4>
                        <p class="text-xs text-gray-500 mt-1">Instant access to professional support</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Footer Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Information -->
                <div>
                    <h5 class="font-bold text-gray-900 text-sm mb-4">Information</h5>
                    <ul class="space-y-3 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-toys-btn transition">About Us</a></li>
                        <li><a href="#" class="hover:text-toys-btn transition">Top Searches</a></li>
                        <li><a href="#" class="hover:text-toys-btn transition">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-toys-btn transition">Terms and Conditions</a></li>
                        <li><a href="#" class="hover:text-toys-btn transition">Testimonials</a></li>
                    </ul>
                </div>
                
                <!-- Customer Care -->
                <div>
                    <h5 class="font-bold text-gray-900 text-sm mb-4">Customer Care</h5>
                    <ul class="space-y-3 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-toys-btn transition">My Account</a></li>
                        <li><a href="#" class="hover:text-toys-btn transition">Track Order</a></li>
                        <li><a href="{{ route('shop.index') }}" class="hover:text-toys-btn transition">Shop</a></li>
                        <li><a href="#" class="hover:text-toys-btn transition">Wishlist</a></li>
                        <li><a href="#" class="hover:text-toys-btn transition">Returns/Exchange</a></li>
                    </ul>
                </div>

                <!-- Other Business -->
                <div>
                    <h5 class="font-bold text-gray-900 text-sm mb-4">Other Business</h5>
                    <ul class="space-y-3 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-toys-btn transition">Partnership Programs</a></li>
                        <li><a href="#" class="hover:text-toys-btn transition">Associate Program</a></li>
                        <li><a href="#" class="hover:text-toys-btn transition">Wholesale Socks</a></li>
                        <li><a href="#" class="hover:text-toys-btn transition">Wholesale Funny Socks</a></li>
                        <li><a href="#" class="hover:text-toys-btn transition">Others</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h5 class="font-bold text-gray-900 text-sm mb-4">Newsletter</h5>
                    <form class="flex items-center">
                        <div class="relative w-full">
                            <input type="email" placeholder="Enter your email" class="w-full px-4 py-2 text-sm border border-gray-300 rounded-full focus:outline-none focus:border-toys-btn focus:ring-1 focus:ring-toys-btn">
                            <button type="submit" class="absolute right-0 top-0 bottom-0 bg-toys-btn hover:bg-secondary text-white rounded-r-full px-4 transition duration-300 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>
                    </form>
                    <p class="text-xs text-gray-400 mt-2">Subscribe to our newsletter to get updates.</p>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="bg-gray-50 border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-xs text-gray-500">&copy; {{ date('Y') }} C-Digital. All rights reserved.</p>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-500">We using safe payment for:</span>
                        <img src="https://babymart.reactbd.com/_next/static/media/payment.682e08dd.webp" alt="Payment Methods" class="h-6 w-auto object-contain">
                    </div>
                </div>
            </div>
        </div>
    </footer>


<script>
    // Search Autocomplete Logic
    function initSearch(inputId, resultsId) {
        const searchInput = document.getElementById(inputId);
        const searchResults = document.getElementById(resultsId);
        let timeout = null;

        if (searchInput && searchResults) {
            // Function to fetch and render
            function performSearch(query = '') {
                fetch(`{{ route('search.suggestions') }}?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(products => {
                        searchResults.innerHTML = '';
                        
                        if (products.length > 0) {
                            searchResults.classList.remove('hidden');
                            
                            // Header
                            const header = document.createElement('div');
                            header.className = 'px-4 py-2 bg-gray-50 text-xs font-semibold text-gray-500 uppercase';
                            header.textContent = query.length < 2 ? 'Popular Products' : 'Search Results';
                            searchResults.appendChild(header);

                            products.forEach(product => {
                                const item = document.createElement('a');
                                // Navigate to shop page with filter
                                item.href = `{{ route('shop.index') }}?search=${encodeURIComponent(product.name)}`;
                                item.className = 'block px-4 py-2.5 hover:bg-gray-50 flex items-center gap-3 transition duration-150 group';
                                
                                item.innerHTML = `
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <span class="text-sm text-gray-700 font-medium group-hover:text-gray-900">${product.name}</span>
                                `;
                                searchResults.appendChild(item);
                            });

                        } else if (query.length >= 2) {
                            searchResults.classList.remove('hidden');
                            searchResults.innerHTML = `
                                <div class="px-4 py-6 text-center text-gray-500">
                                    <p class="text-sm">No toys found</p>
                                </div>
                            `;
                        } else {
                             searchResults.classList.add('hidden');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching search results:', error);
                    });
            }

            // On Input
            searchInput.addEventListener('input', function() {
                clearTimeout(timeout);
                const query = this.value;
                timeout = setTimeout(() => {
                    performSearch(query);
                }, 300);
            });

            // On Focus (Show default/popular if empty)
            searchInput.addEventListener('focus', function() {
                if (this.value.length === 0) {
                    performSearch(''); // Fetch defaults
                } else {
                    searchResults.classList.remove('hidden');
                }
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                    searchResults.classList.add('hidden');
                }
            });

            // Close mobile menu when a search result is clicked (only for mobile search)
            if (inputId === 'mobile-search-input') {
                searchResults.addEventListener('click', (e) => {
                    if (e.target.closest('a')) {
                        if (typeof closeMobileMenu === 'function') closeMobileMenu();
                    }
                });
            }
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        initSearch('desktop-search-input', 'search-results');
        initSearch('mobile-search-input', 'mobile-search-results');
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const header = document.getElementById('main-header');
        const headerNav = document.getElementById('header-nav');
        const headerBorder = document.getElementById('header-border');
        const headerLogo = document.getElementById('header-logo');
        const navLinks = document.querySelectorAll('.nav-link');
        const searchContainer = document.getElementById('search-container');
        
        // Right Menu Items
        const headerCart = document.getElementById('header-cart');
        const headerUser = document.getElementById('header-user');
        const headerLogin = document.getElementById('header-login');
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');

        const isHome = {{ json_encode(Route::is('home')) }};

        if (!header) return;

        // Scroll Header Logic for ALL pages
        function updateHeader() {
            const scrollY = window.scrollY;
            const heroHeight = window.innerHeight * 0.8;
            
            // Logic for Home Page (Transparent -> Pink)
            if (isHome) {
                 const scrolledPastHero = scrollY > heroHeight;
                 
                 // Position: Absolute initially, Fixed after hero
                 if (scrolledPastHero) {
                     header.classList.remove('absolute');
                     header.classList.add('fixed');
                 } else {
                     header.classList.remove('fixed');
                     header.classList.add('absolute');
                 }

                 // Appearance: Transparent -> White/Yellow
                 if (scrollY > 50) {
                     // Scrolled State
                     header.classList.remove('bg-transparent', 'text-toys-text');
                     header.classList.add('bg-white', 'text-toys-text', 'shadow-md', 'border-b', 'border-primary');
                     
                     if(headerBorder) {
                         headerBorder.classList.remove('border-transparent');
                         headerBorder.classList.add('border-primary');
                     }
                 } else {
                     // Top State
                     header.classList.add('bg-transparent', 'text-toys-text');
                     header.classList.remove('bg-white', 'text-toys-text', 'shadow-md', 'border-b', 'border-primary');

                     if(headerBorder) {
                         headerBorder.classList.add('border-transparent');
                         headerBorder.classList.remove('border-primary');
                     }
                 }
            } 
            // Logic for Other Pages
            // Fixed header logic handled by CSS classes (fixed top-0)

        }
        
        function updateHeaderColors(type) {
             // Simplified for Toy layout - always dark text
        }

        window.addEventListener('scroll', updateHeader);
        updateHeader();

        // Mobile Menu Event Listeners
        const closeMobileMenuBtn = document.getElementById('close-mobile-menu');
        const mobileMenuOverlay = document.getElementById('mobile-menu');

        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                openMobileMenu();
            });
        }

        if (closeMobileMenuBtn) {
            closeMobileMenuBtn.addEventListener('click', (e) => {
                e.preventDefault();
                closeMobileMenu();
            });
        }

        if (mobileMenuOverlay) {
            mobileMenuOverlay.addEventListener('click', (e) => {
                if (e.target === mobileMenuOverlay) {
                    closeMobileMenu();
                }
            });
        }
    });

    // Mobile Menu Functions (Global Scope for accessibility)
    function openMobileMenu() {
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileMenuPanel = document.getElementById('mobile-menu-panel');
        if (!mobileMenu || !mobileMenuPanel) return;

        // Ensure hidden class is removed if it was added by conflicting scripts
        mobileMenu.classList.remove('hidden');
        
        mobileMenu.classList.remove('invisible', 'opacity-0');
        mobileMenu.classList.add('opacity-100', 'visible');
        mobileMenuPanel.classList.remove('translate-x-full');
        document.body.style.overflow = 'hidden';
    }

    function closeMobileMenu() {
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileMenuPanel = document.getElementById('mobile-menu-panel');
        if (!mobileMenu || !mobileMenuPanel) return;

        mobileMenu.classList.remove('opacity-100', 'visible');
        mobileMenu.classList.add('opacity-0');
        mobileMenuPanel.classList.add('translate-x-full');
        document.body.style.overflow = '';
        
        // Wait for transition to finish before hiding container
        setTimeout(() => {
            if (mobileMenu.classList.contains('opacity-0')) {
                mobileMenu.classList.add('invisible');
            }
        }, 300);
    }


    // Add to Cart AJAX Logic
    function addToCart(productId, quantity = 1) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Find if button has loading state? (Optional polish)
        
        fetch('{{ route("cart.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update Mini Cart HTML
                const miniCartDropdown = document.getElementById('mini-cart-dropdown');
                if (miniCartDropdown) {
                    miniCartDropdown.innerHTML = data.html;
                }
                
                // Update Badges via Event
                window.dispatchEvent(new CustomEvent('cart:updated', { 
                    detail: { cartCount: data.cartCount } 
                }));
            } else {
                console.error(data.message || 'Error adding to cart');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function removeFromCart(itemId) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const itemElement = document.getElementById(`cart-item-${itemId}`);
        
        if (itemElement) {
            itemElement.classList.add('cart-item-fade-out');
        }

        setTimeout(() => {
            fetch(`/cart/${itemId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const miniCartDropdown = document.getElementById('mini-cart-dropdown');
                    if (miniCartDropdown) {
                        miniCartDropdown.innerHTML = data.html;
                    }
                    window.dispatchEvent(new CustomEvent('cart:updated', { 
                        detail: { cartCount: data.cartCount } 
                    }));
                } else {
                    console.error('Error removing item');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }, 300); // Wait for animation
    }

    function updateCartCount(count) {
        document.querySelectorAll('.cart-count-badge').forEach(badge => {
            badge.textContent = count;
            count > 0 ? badge.classList.remove('hidden') : badge.classList.add('hidden');
        });
    }

    function updateWishlistCount(count) {
        document.querySelectorAll('.fav-badge, #fav-badge-mobile').forEach(badge => {
            badge.textContent = count;
            count > 0 ? badge.classList.remove('hidden') : badge.classList.add('hidden');
        });
        
        // Update header icon state (Desktop)
        const headerFavIcon = document.getElementById('header-fav-icon');
        if (headerFavIcon) {
            if (count > 0) {
                headerFavIcon.setAttribute('fill', '#ef4444');
                headerFavIcon.setAttribute('stroke', '#ef4444');
            } else {
                headerFavIcon.setAttribute('fill', 'none');
                headerFavIcon.setAttribute('stroke', '#f92d2dff');
            }
        }
    }

    // Listen for Cart Updates
    window.addEventListener('cart:updated', (e) => {
        updateCartCount(e.detail.cartCount);
    });

    // Listen for Wishlist Updates
    window.addEventListener('wishlist:updated', (e) => {
        updateWishlistCount(e.detail.count);
    });

    // Global Wishlist Logic
    async function toggleFavorite(productId) {
        @if(!auth()->check())
            window.location.href = "{{ route('login') }}";
            return;
        @endif

        const icons = document.querySelectorAll(`.fav-icon-${productId}`);
        const dropdownContent = document.getElementById('fav-dropdown-content');

        try {
            const response = await fetch(`/favorites/toggle/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                
                // 1. Update Favorite Icons on Cards
                icons.forEach(icon => {
                    if (data.favorited) {
                        icon.setAttribute('fill', 'currentColor');
                        icon.classList.remove('text-gray-400');
                        icon.classList.add('text-red-500');
                    } else {
                        icon.setAttribute('fill', 'none');
                        icon.classList.remove('text-red-500');
                        icon.classList.add('text-gray-400');
                    }
                });

                // 2. Update All Badges via Event
                window.dispatchEvent(new CustomEvent('wishlist:updated', { 
                    detail: { count: data.count } 
                }));

                // 3. Update Dropdown Partial
                if (dropdownContent && data.html) {
                    dropdownContent.innerHTML = data.html;
                }

                // 4. Handle Favorites Page Specifically
                if (typeof removeFromWishlistGrid === 'function' && !data.favorited) {
                    removeFromWishlistGrid(productId, data.count);
                }
            }
        } catch (error) {
            console.error('Error toggling favorite:', error);
        }
    }

    // Immediate Sticky Header Logic
    document.addEventListener('DOMContentLoaded', () => {
        const header = document.getElementById('main-header');
        const backToTop = document.getElementById('back-to-top');
        
        const handleScrollEffects = () => {
            const scrollPos = window.scrollY;

            // Header Logic
            if (scrollPos > 0) {
                header.classList.add('is-fixed');
            } else {
                header.classList.remove('is-fixed');
            }

            // Back to Top Logic
            if (scrollPos > 400) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        };

        window.addEventListener('scroll', () => {
            requestAnimationFrame(handleScrollEffects);
        }, { passive: true });
        
        // Initial check
        handleScrollEffects();

        // Smooth Scroll to Top
        backToTop.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });
</script>

<!-- <script>
document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('categoriesBtn');
    const dropdown = document.getElementById('categoriesDropdown');
    const arrow = document.getElementById('catArrow');

    btn.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdown.classList.toggle('opacity-0');
        dropdown.classList.toggle('invisible');
        dropdown.classList.toggle('translate-y-2');
        arrow.classList.toggle('rotate-180');
    });

    document.addEventListener('click', () => {
        dropdown.classList.add('opacity-0', 'invisible', 'translate-y-2');
        arrow.classList.remove('rotate-180');
    });
});
</script> -->


<!-- Back to Top Button -->
<button id="back-to-top" class="bg-primary text-white p-4 rounded-2xl shadow-2xl shadow-primary/40 hover:bg-secondary transition-all flex items-center justify-center group" aria-label="Back to Top">
    <svg class="w-6 h-6 transform group-hover:-translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18" />
    </svg>
</button>

<!-- Add to Cart Success Modal -->
<div id="cart-success-modal" class="fixed inset-0 z-[300] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('cart-success-modal').classList.add('hidden')"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Product Added Successfully!
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                The item has been added to your shopping cart.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                <a href="{{ route('cart.index') }}" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-toys-btn text-base font-medium text-white hover:bg-secondary focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                    View Cart
                </a>
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="document.getElementById('cart-success-modal').classList.add('hidden')">
                    Continue Shopping
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    // Search Autocomplete Logic (existing)
    // ... (rest of the search script)
    
    // Global Wishlist Logic

</script>
    <!-- Mobile Menu (Full Screen Overlay) Moved to Root for proper overflow -->
    <div id="mobile-menu" class="fixed inset-0 z-[200] invisible bg-black/60 backdrop-blur-sm transition-all duration-300 opacity-0 md:hidden overflow-hidden">
        <!-- Off-canvas Panel -->
        <div id="mobile-menu-panel" class="absolute inset-y-0 right-0 w-[85%] max-w-sm bg-white shadow-2xl transform translate-x-full transition-transform duration-300 ease-out flex flex-col">
            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-100">
                <a href="{{ route('home') }}" class="text-xl font-black flex items-center gap-2">
                    <span class="text-2xl transform hover:rotate-12 transition text-primary">🧸</span>
                    <span class="text-secondary tracking-tight">ToyStore</span>
                </a>
                <button id="close-mobile-menu" class="p-2 text-gray-400 hover:text-gray-900 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto px-6 py-8">
                <!-- Mobile Search Bar -->
                <div class="mb-8 relative group">
                    <form action="{{ route('shop.index') }}" method="GET" class="w-full relative">
                        <div class="relative flex items-center w-full rounded-2xl overflow-hidden h-12 bg-gray-50 border-2 border-gray-100 focus-within:border-secondary transition-all">
                            <input 
                                type="text" 
                                name="search" 
                                id="mobile-search-input"
                                placeholder="Search for toys..." 
                                class="w-full px-4 text-sm font-bold outline-none border-none focus:ring-0 h-full bg-transparent placeholder-gray-300"
                                autocomplete="off"
                            >
                            <button type="submit" class="px-4 h-full flex items-center justify-center text-secondary hover:text-primary transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>
                    </form>
                    <!-- Mobile Search Results -->
                    <div id="mobile-search-results" class="absolute top-full left-0 right-0 bg-white border border-gray-200 rounded-b-xl shadow-xl z-50 hidden mt-1 divide-y divide-gray-100 max-h-[300px] overflow-y-auto"></div>
                </div>

                <!-- Nav Links -->
                <div class="space-y-6 mb-12">
                    <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Navigation</h3>
                    <nav class="space-y-2">
                        <a href="{{ route('home') }}" class="flex items-center gap-4 p-4 rounded-2xl font-black text-sm {{ Route::is('home') ? 'bg-primary text-white' : 'text-gray-500 hover:bg-gray-50 hover:text-secondary' }} transition-all">
                            <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Home
                        </a>
                        <a href="{{ route('shop.index') }}" class="flex items-center gap-4 p-4 rounded-2xl font-black text-sm {{ Route::is('shop.*') ? 'bg-primary text-white' : 'text-gray-500 hover:bg-gray-50 hover:text-secondary' }} transition-all">
                            <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            Shop All
                        </a>

                        <!-- Custom Category Selector (Alpine.js) -->
                        <div x-data="{ open: false }" class="relative">
                            <button 
                                @click="open = !open"
                                class="w-full flex items-center justify-between p-4 rounded-2xl font-black text-sm transition-all duration-300"
                                :class="open ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-gray-500 bg-gray-50 border-2 border-gray-100 hover:bg-white hover:border-primary/30 hover:text-secondary'"
                            >
                                <div class="flex items-center gap-4">
                                    <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/>
                                    </svg>
                                    <span>Categories</span>
                                </div>
                                <svg 
                                    class="w-4 h-4 transition-transform duration-300" 
                                    :class="open ? 'rotate-180' : ''"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <!-- Dropdown Panel -->
                            <div 
                                x-show="open" 
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 -translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 -translate-y-2"
                                @click.away="open = false"
                                class="mt-2 bg-white border-2 border-gray-50 rounded-2xl shadow-xl overflow-hidden z-30"
                            >
                                <div class="max-h-60 overflow-y-auto py-2 custom-scrollbar">
                                    @foreach($categories as $category)
                                        <a 
                                            href="{{ route('shop.index', ['category' => $category->id]) }}"
                                            class="flex items-center gap-3 px-6 py-3 text-sm font-bold text-gray-600 hover:bg-gray-50 hover:text-primary transition-colors border-b border-gray-50 last:border-0"
                                        >
                                            <span class="w-1.5 h-1.5 rounded-full bg-primary/20 group-hover:bg-primary transition-colors"></span>
                                            {{ $category->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('about') }}" class="flex items-center gap-4 p-4 rounded-2xl font-black text-sm {{ Route::is('about') ? 'bg-primary text-white' : 'text-gray-500 hover:bg-gray-50 hover:text-secondary' }} transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            About Us
                        </a>
                        <a href="{{ route('contact') }}" class="flex items-center gap-4 p-4 rounded-2xl font-black text-sm {{ Route::is('contact') ? 'bg-primary text-white' : 'text-gray-500 hover:bg-gray-50 hover:text-secondary' }} transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            Contact
                        </a>
                    </nav>
                </div>



                <!-- User Actions -->
                <div class="space-y-4 pt-8 border-t border-gray-100">
                    @auth
                        <div class="p-4 bg-gray-50 rounded-[2rem] border-2 border-white shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl border-2 border-white overflow-hidden shadow-md">
                                <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-black text-toys-text truncate">{{ auth()->user()->name }}</p>
                                <a href="{{ route('profile.edit') }}" class="text-[10px] font-bold text-primary hover:text-secondary transition-colors uppercase tracking-widest underline underline-offset-4">Edit Profile</a>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mt-4">
                            <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center p-4 bg-white border-2 border-gray-50 rounded-2xl hover:border-primary/20 transition-all group">
                                <span class="text-xs font-black text-gray-900">Dashboard</span>
                            </a>
                            <a href="{{ route('orders.index') }}" class="flex flex-col items-center justify-center p-4 bg-white border-2 border-gray-50 rounded-2xl hover:border-primary/20 transition-all group">
                                <span class="text-xs font-black text-gray-900">Orders</span>
                            </a>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="mt-4">
                            @csrf
                            <button type="submit" class="w-full py-4 bg-red-50 text-red-500 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-red-500 hover:text-white transition-all active:scale-95">
                                Sign Out
                            </button>
                        </form>
                    @else
                        <div class="grid grid-cols-1 gap-4 text-center">
                            <a href="{{ route('login') }}" class="py-4 bg-white border-2 border-secondary text-secondary rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-secondary hover:text-white transition-all">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="py-4 bg-primary text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-primary/20 hover:bg-secondary transition-all active:scale-95">
                                Create Account
                            </a>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Footer -->
            <div class="p-6 bg-gray-50 border-t border-gray-100 italic text-center text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                Happy Shopping! ✨
            </div>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
```
