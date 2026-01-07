<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Basic Stats
        $totalUsers = User::where('role', 'client')->count();
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total');
        $pendingOrders = Order::where('status', 'pending')->count();

        // Revenue Stats
        $todayRevenue = Order::whereDate('created_at', now())->where('status', '!=', 'cancelled')->sum('total');
        $yesterdayRevenue = Order::whereDate('created_at', now()->subDay())->where('status', '!=', 'cancelled')->sum('total');
        
        // Growth Percent (Today vs Yesterday)
        $revenueGrowth = 0;
        if ($yesterdayRevenue > 0) {
            $revenueGrowth = (($todayRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100;
        }

        // Charts Data (Last 7 Days)
        $chartLabels = [];
        $revenueData = [];
        $ordersData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->format('M d');
            
            $revenueData[] = Order::whereDate('created_at', $date)
                ->where('status', '!=', 'cancelled')
                ->sum('total');
                
            $ordersData[] = Order::whereDate('created_at', $date)
                ->count();
        }

        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalOrders', 
            'totalProducts',
            'totalRevenue', 
            'pendingOrders',
            'todayRevenue',
            'revenueGrowth',
            'chartLabels',
            'revenueData',
            'ordersData'
        ));
    }
}
