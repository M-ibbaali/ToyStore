@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <h1 class="text-3xl font-extrabold text-gray-900">Dashboard Overview</h1>
    <div class="text-sm text-gray-500">
        Today: {{ now()->format('M d, Y') }}
    </div>
</div>

<!-- Analytics Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Users -->
    <div class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-pink-100 text-sm font-semibold uppercase tracking-wider">Total Users</p>
                <p class="text-4xl font-bold mt-2">{{ $totalUsers }}</p>
            </div>
            <div class="bg-white/20 p-3 rounded-lg backdrop-blur-sm">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Total Orders -->
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm font-semibold uppercase tracking-wider">Total Orders</p>
                <p class="text-4xl font-bold mt-2">{{ $totalOrders }}</p>
            </div>
            <div class="bg-white/20 p-3 rounded-lg backdrop-blur-sm">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Total Sales -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-semibold uppercase tracking-wider">Total Earnings</p>
                <p class="text-4xl font-bold mt-2">${{ number_format($totalSales, 2) }}</p>
            </div>
            <div class="bg-white/20 p-3 rounded-lg backdrop-blur-sm">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Pending -->
    <div class="bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-yellow-100 text-sm font-semibold uppercase tracking-wider">Pending Orders</p>
                <p class="text-4xl font-bold mt-2">{{ $pendingOrders }}</p>
            </div>
            <div class="bg-white/20 p-3 rounded-lg backdrop-blur-sm">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-md p-6 lg:col-span-1 border border-gray-100">
        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
            <svg class="w-5 h-5 mr-2 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            Quick Actions
        </h2>
        <div class="space-y-4">
            <a href="{{ route('admin.products.create') }}" class="group flex items-center p-4 bg-gray-50 rounded-lg hover:bg-pink-50 transition border border-gray-200 hover:border-pink-200">
                <div class="p-2 bg-white rounded-full shadow-sm text-pink-500 group-hover:bg-pink-500 group-hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                </div>
                <span class="ml-4 font-semibold text-gray-700 group-hover:text-pink-700">Add New Product</span>
            </a>
            
            <a href="{{ route('admin.categories.create') }}" class="group flex items-center p-4 bg-gray-50 rounded-lg hover:bg-purple-50 transition border border-gray-200 hover:border-purple-200">
                <div class="p-2 bg-white rounded-full shadow-sm text-purple-500 group-hover:bg-purple-500 group-hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                </div>
                <span class="ml-4 font-semibold text-gray-700 group-hover:text-purple-700">Add Category</span>
            </a>
            
            <a href="{{ route('admin.orders.index') }}" class="group flex items-center p-4 bg-gray-50 rounded-lg hover:bg-blue-50 transition border border-gray-200 hover:border-blue-200">
                <div class="p-2 bg-white rounded-full shadow-sm text-blue-500 group-hover:bg-blue-500 group-hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <span class="ml-4 font-semibold text-gray-700 group-hover:text-blue-700">Manage Orders</span>
            </a>
        </div>
    </div>

    <!-- Analytics / Chart Placeholder (or Recent Activity) -->
    <div class="bg-white rounded-xl shadow-md p-6 lg:col-span-2 border border-gray-100">
        <h2 class="text-xl font-bold text-gray-800 mb-6">System Status</h2>
        <div class="bg-gray-50 p-6 rounded-lg text-center border-2 border-dashed border-gray-200">
             <p class="text-gray-500 mb-2">Detailed Analytics & Reports module coming soon.</p>
             <div class="flex justify-center space-x-4 mt-4">
                 <span class="px-3 py-1 bg-green-100 text-green-700 text-xs rounded-full font-medium">Database: Healthy</span>
                 <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs rounded-full font-medium">System: Online</span>
             </div>
        </div>
    </div>
</div>
@endsection
