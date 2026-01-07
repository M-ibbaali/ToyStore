@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <h1 class="text-3xl font-extrabold text-gray-900">Dashboard Overview</h1>
    <div class="text-sm text-gray-500 bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-100 italic">
        Last updated: {{ now()->format('M d, Y - H:i') }}
    </div>
</div>

<!-- Analytics Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
    <!-- Total Revenue -->
    <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl shadow-xl p-6 text-white transform hover:scale-[1.02] transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-xs font-black uppercase tracking-widest opacity-80">Total Revenue</p>
                <p class="text-3xl font-black mt-1">{{ formatPrice($totalRevenue) }}</p>
                <div class="flex items-center mt-3 text-xs font-bold bg-white/20 w-fit px-2 py-1 rounded-lg">
                    <span>{{ $totalOrders }} Orders Total</span>
                </div>
            </div>
            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
        </div>
    </div>

    <!-- Daily Earnings -->
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-[1.02] transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-xs font-black uppercase tracking-widest opacity-80">Today's Earnings</p>
                <p class="text-3xl font-black mt-1">{{ formatPrice($todayRevenue) }}</p>
                <div class="flex items-center mt-3 text-xs font-bold {{ $revenueGrowth >= 0 ? 'bg-white/20' : 'bg-red-400/20' }} w-fit px-2 py-1 rounded-lg">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="{{ $revenueGrowth >= 0 ? 'M5 10l7-7 7 7' : 'M19 14l-7 7-7-7' }}" /></svg>
                    <span>{{ number_format(abs($revenueGrowth), 1) }}% vs yesterday</span>
                </div>
            </div>
            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
            </div>
        </div>
    </div>

    <!-- Total Products -->
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-[1.02] transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-xs font-black uppercase tracking-widest opacity-80">Total Inventory</p>
                <p class="text-3xl font-black mt-1">{{ number_format($totalProducts) }}</p>
                <p class="text-[10px] mt-3 font-bold opacity-80">Active Items in Shop</p>
            </div>
            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
            </div>
        </div>
    </div>

    <!-- Active Customers -->
    <div class="bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-2xl shadow-xl p-6 text-white transform hover:scale-[1.02] transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-yellow-100 text-xs font-black uppercase tracking-widest opacity-80">Happy Customers</p>
                <p class="text-3xl font-black mt-1">{{ number_format($totalUsers) }}</p>
                <p class="text-[10px] mt-3 font-bold opacity-80">Registered Clients</p>
            </div>
            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions Grid (Redesigned) -->
<h2 class="text-xl font-black text-gray-800 mb-6 flex items-center">
    <span class="bg-blue-600 w-2 h-8 rounded-full mr-3"></span>
    Quick Actions
</h2>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
    <!-- Add Product -->
    <a href="{{ route('admin.products.create') }}" class="group bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-2xl hover:border-yellow-200 transform hover:scale-[1.02] transition-all duration-300 relative overflow-hidden">
        <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity transform group-hover:scale-110">
            <svg class="w-24 h-24 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        </div>
        <div class="flex flex-col h-full justify-between relative z-10">
             <div class="w-14 h-14 bg-yellow-50 rounded-2xl flex items-center justify-center text-yellow-500 mb-4 group-hover:bg-yellow-500 group-hover:text-white transition-all duration-300 shadow-sm group-hover:shadow-lg group-hover:shadow-yellow-500/30 group-hover:rotate-6">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
             </div>
             <div>
                 <h3 class="text-lg font-black text-gray-800 group-hover:text-yellow-600 transition-colors tracking-tight">Add Product</h3>
                 <p class="text-xs text-gray-400 mt-2 font-bold group-hover:text-gray-500">Create new inventory item</p>
             </div>
        </div>
    </a>

    <!-- Manage Orders -->
    <a href="{{ route('admin.orders.index') }}" class="group bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-2xl hover:border-blue-200 transform hover:scale-[1.02] transition-all duration-300 relative overflow-hidden">
        <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity transform group-hover:scale-110">
             <svg class="w-24 h-24 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
        </div>
        <div class="flex flex-col h-full justify-between relative z-10">
             <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-500 mb-4 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 shadow-sm group-hover:shadow-lg group-hover:shadow-blue-500/30 group-hover:rotate-6">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
             </div>
             <div>
                 <h3 class="text-lg font-black text-gray-800 group-hover:text-blue-600 transition-colors tracking-tight">Manage Orders</h3>
                 <p class="text-xs text-gray-400 mt-2 font-bold group-hover:text-gray-500">View and process orders</p>
             </div>
        </div>
    </a>

    <!-- View Messages (NEW) -->
    <a href="{{ route('admin.messages.index') }}" class="group bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-2xl hover:border-pink-200 transform hover:scale-[1.02] transition-all duration-300 relative overflow-hidden">
        <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity transform group-hover:scale-110">
             <svg class="w-24 h-24 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        </div>
        <div class="flex flex-col h-full justify-between relative z-10">
             <div class="w-14 h-14 bg-pink-50 rounded-2xl flex items-center justify-center text-pink-500 mb-4 group-hover:bg-pink-500 group-hover:text-white transition-all duration-300 shadow-sm group-hover:shadow-lg group-hover:shadow-pink-500/30 group-hover:rotate-6">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
             </div>
             <div>
                 <h3 class="text-lg font-black text-gray-800 group-hover:text-pink-600 transition-colors tracking-tight">Messages</h3>
                 <p class="text-xs text-gray-400 mt-2 font-bold group-hover:text-gray-500">Read customer inquiries</p>
             </div>
        </div>
    </a>

     <!-- Add Category -->
     <a href="{{ route('admin.categories.create') }}" class="group bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-2xl hover:border-purple-200 transform hover:scale-[1.02] transition-all duration-300 relative overflow-hidden">
        <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity transform group-hover:scale-110">
           <svg class="w-24 h-24 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
        </div>
        <div class="flex flex-col h-full justify-between relative z-10">
             <div class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-500 mb-4 group-hover:bg-purple-600 group-hover:text-white transition-all duration-300 shadow-sm group-hover:shadow-lg group-hover:shadow-purple-500/30 group-hover:rotate-6">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
             </div>
             <div>
                 <h3 class="text-lg font-black text-gray-800 group-hover:text-purple-600 transition-colors tracking-tight">Add Category</h3>
                 <p class="text-xs text-gray-400 mt-2 font-bold group-hover:text-gray-500">Organize your shop</p>
             </div>
        </div>
    </a>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-lg font-black text-gray-800 uppercase tracking-wider">Revenue Trend (7 Days)</h3>
            <span class="text-xs font-bold text-gray-400">Values in DH</span>
        </div>
        <canvas id="revenueChart" height="250"></canvas>
    </div>
    
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-lg font-black text-gray-800 uppercase tracking-wider">Orders Volume (7 Days)</h3>
            <span class="text-xs font-bold text-gray-400">Total Count</span>
        </div>
        <canvas id="ordersChart" height="250"></canvas>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = {!! json_encode($chartLabels) !!};
    
    // Revenue Chart
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Revenue (DH)',
                data: {!! json_encode($revenueData) !!},
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 6,
                pointBackgroundColor: '#2563eb',
                borderWidth: 4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { display: false } },
                x: { grid: { display: false } }
            }
        }
    });

    // Orders Chart
    new Chart(document.getElementById('ordersChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Orders',
                data: {!! json_encode($ordersData) !!},
                backgroundColor: '#8b5cf6',
                borderRadius: 12,
                hoverBackgroundColor: '#7c3aed'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { display: false } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endsection
