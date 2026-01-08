@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Header Section -->
<div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl sm:text-4xl font-black text-gray-900 tracking-tight">Dashboard</h1>
        <p class="text-sm text-gray-400 font-bold mt-2 uppercase tracking-widest opacity-70">Commerce Overview</p>
    </div>
    <div class="flex items-center gap-3 bg-white p-1.5 pl-4 pr-3 rounded-2xl border border-gray-100 shadow-sm self-start md:self-auto">
        <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider">Today</span>
        <div class="h-8 w-[1px] bg-gray-100 mx-2"></div>
        <div class="text-xs font-black text-gray-900 italic">
            {{ now()->format('M d, Y') }}
        </div>
    </div>
</div>

<!-- Analytics Grid (Refined) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-12">
    <!-- Total Revenue -->
    <div class="bg-blue-600 rounded-[2rem] shadow-[0_20px_40px_rgba(37,99,235,0.15)] p-8 text-white relative overflow-hidden group">
        <div class="absolute -right-4 -bottom-4 opacity-10 transform group-hover:scale-110 transition-transform duration-500">
            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
        <div class="relative z-10">
            <p class="text-blue-100 text-[10px] font-black uppercase tracking-[0.2em] opacity-80">Total Revenue</p>
            <p class="text-3xl font-black mt-2 leading-none tracking-tight">{{ formatPrice($totalRevenue) }}</p>
            <div class="inline-flex items-center mt-6 text-[9px] font-black bg-white/20 px-2 py-1 rounded-lg uppercase tracking-wider">
                {{ $totalOrders }} Orders Total
            </div>
        </div>
    </div>

    <!-- Daily Earnings -->
    <div class="bg-gray-900 rounded-[2rem] shadow-xl p-8 text-white relative overflow-hidden group">
        <div class="absolute -right-4 -bottom-4 opacity-10 transform group-hover:scale-110 transition-transform duration-500">
            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
        </div>
        <div class="relative z-10">
            <p class="text-gray-400 text-[10px] font-black uppercase tracking-[0.2em]">Daily Earnings</p>
            <p class="text-3xl font-black mt-2 leading-none tracking-tight text-yellow-400">{{ formatPrice($todayRevenue) }}</p>
            <div class="inline-flex items-center mt-6 text-[9px] font-black {{ $revenueGrowth >= 0 ? 'text-green-400 bg-green-400/10' : 'text-red-400 bg-red-400/10' }} px-2 py-1 rounded-lg uppercase tracking-wider">
                <svg class="w-2.5 h-2.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="{{ $revenueGrowth >= 0 ? 'M5 10l7-7 7 7' : 'M19 14l-7 7-7-7' }}" /></svg>
                <span>{{ number_format(abs($revenueGrowth), 1) }}% Growth</span>
            </div>
        </div>
    </div>

    <!-- Total Products -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8 relative overflow-hidden group">
        <div class="absolute -right-4 -bottom-4 text-blue-600 opacity-[0.03] transform group-hover:scale-110 transition-transform duration-500">
            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
        </div>
        <div class="relative z-10">
            <p class="text-gray-400 text-[10px] font-black uppercase tracking-[0.2em]">Total Inventory</p>
            <p class="text-3xl font-black mt-2 leading-none tracking-tight text-gray-900">{{ number_format($totalProducts) }}</p>
            <p class="text-[9px] mt-6 font-black text-blue-600 uppercase tracking-wider opacity-80">Items in Shop</p>
        </div>
    </div>

    <!-- Happy Customers -->
    <div class="bg-yellow-400 rounded-[2rem] shadow-[0_20px_40px_rgba(250,204,21,0.15)] p-8 text-gray-900 relative overflow-hidden group">
        <div class="absolute -right-4 -bottom-4 opacity-10 transform group-hover:scale-110 transition-transform duration-500 text-gray-900">
            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
        </div>
        <div class="relative z-10">
            <p class="text-gray-900/60 text-[10px] font-black uppercase tracking-[0.2em]">Customers</p>
            <p class="text-3xl font-black mt-2 leading-none tracking-tight">{{ number_format($totalUsers) }}</p>
            <p class="text-[9px] mt-6 font-black text-gray-900/40 uppercase tracking-wider">Registered Clients</p>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mb-12">
    <div class="flex items-center gap-3 mb-8">
        <div class="w-1.5 h-6 bg-blue-600 rounded-full"></div>
        <h2 class="text-lg font-black text-gray-900 uppercase tracking-widest">Quick Actions</h2>
    </div>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <!-- Add Product -->
        <a href="{{ route('admin.products.create') }}" class="group bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm hover:shadow-2xl hover:border-blue-100 transition-all duration-300">
             <div class="w-12 h-12 sm:w-16 sm:h-16 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 mb-6 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
             </div>
             <h3 class="text-sm sm:text-base font-black text-gray-900 group-hover:text-blue-600 transition-colors">Add Product</h3>
             <p class="text-[10px] text-gray-400 mt-2 font-bold uppercase tracking-wider opacity-60">New Item</p>
        </a>

        <!-- Manage Orders -->
        <a href="{{ route('admin.orders.index') }}" class="group bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm hover:shadow-2xl hover:border-gray-900 transition-all duration-300">
             <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gray-50 rounded-2xl flex items-center justify-center text-gray-900 mb-6 group-hover:bg-gray-900 group-hover:text-white transition-all duration-300">
                <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
             </div>
             <h3 class="text-sm sm:text-base font-black text-gray-900 group-hover:text-gray-900 transition-colors">Orders</h3>
             <p class="text-[10px] text-gray-400 mt-2 font-bold uppercase tracking-wider opacity-60">Process Shipments</p>
        </a>

        <!-- Messages -->
        <a href="{{ route('admin.messages.index') }}" class="group bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm hover:shadow-2xl hover:border-yellow-200 transition-all duration-300">
             <div class="w-12 h-12 sm:w-16 sm:h-16 bg-yellow-50 rounded-2xl flex items-center justify-center text-yellow-600 mb-6 group-hover:bg-yellow-400 group-hover:text-gray-900 transition-all duration-300">
                <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
             </div>
             <h3 class="text-sm sm:text-base font-black text-gray-900 group-hover:text-yellow-600 transition-colors">Messages</h3>
             <p class="text-[10px] text-gray-400 mt-2 font-bold uppercase tracking-wider opacity-60">Customer Care</p>
        </a>

        <!-- Categories -->
        <a href="{{ route('admin.categories.create') }}" class="group bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm hover:shadow-2xl hover:border-blue-100 transition-all duration-300">
             <div class="w-12 h-12 sm:w-16 sm:h-16 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 mb-6 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
             </div>
             <h3 class="text-sm sm:text-base font-black text-gray-900 group-hover:text-blue-600 transition-colors">Categories</h3>
             <p class="text-[10px] text-gray-400 mt-2 font-bold uppercase tracking-wider opacity-60">Organize Shop</p>
        </a>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mb-8">
    <div class="bg-white p-6 sm:p-10 rounded-[3rem] shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Revenue Trend</h3>
                <p class="text-lg font-black text-gray-900 mt-1">7 Day Cycle</p>
            </div>
            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
            </div>
        </div>
        <div class="h-[300px]">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>
    
    <div class="bg-white p-6 sm:p-10 rounded-[3rem] shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Order Volume</h3>
                <p class="text-lg font-black text-gray-900 mt-1">7 Day Cycle</p>
            </div>
            <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-gray-900">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
            </div>
        </div>
        <div class="h-[300px]">
            <canvas id="ordersChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = {!! json_encode($chartLabels) !!};
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.font.weight = '600';
    
    // Revenue Chart
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($revenueData) !!},
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.05)',
                fill: true,
                tension: 0.4,
                pointRadius: 0,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#2563eb',
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 4,
                borderWidth: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { 
                    beginAtZero: true, 
                    grid: { color: '#f3f4f6', drawBorder: false },
                    ticks: { color: '#9ca3af', font: { size: 10 } }
                },
                x: { 
                    grid: { display: false },
                    ticks: { color: '#9ca3af', font: { size: 10 } }
                }
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
                backgroundColor: '#111827',
                borderRadius: 12,
                barThickness: 24,
                hoverBackgroundColor: '#2563eb'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { 
                    beginAtZero: true, 
                    grid: { color: '#f3f4f6', drawBorder: false },
                    ticks: { color: '#9ca3af', font: { size: 10 } }
                },
                x: { 
                    grid: { display: false },
                    ticks: { color: '#9ca3af', font: { size: 10 } }
                }
            }
        }
    });
</script>
@endsection
