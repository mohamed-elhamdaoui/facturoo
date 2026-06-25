<?php

namespace App\Http\Controllers;

use App\Models\Invoice;

class DashboardController extends Controller
{
    public function index()
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $totalInvoices = Invoice::count();
        $invoicesThisMonth = Invoice::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $totalRevenue = Invoice::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('total');
        
        $recentInvoices = Invoice::with(['client'])->withCount('items')->latest()->take(5)->get();

        // Premium Client & Stock Stats
        $totalClients = \App\Models\Client::count();
        
        // Count products currently below or at their min_stock threshold
        $lowStockCount = \App\Models\Product::whereRaw('stock_quantity <= min_stock')->count();
        
        // Get up to 5 products that need attention
        $lowStockProducts = \App\Models\Product::whereRaw('stock_quantity <= min_stock')
                                               ->orderBy('stock_quantity')
                                               ->take(5)
                                               ->get();

        return view('dashboard', compact(
            'totalInvoices', 
            'invoicesThisMonth', 
            'totalRevenue', 
            'recentInvoices',
            'totalClients',
            'lowStockCount',
            'lowStockProducts'
        ));
    }
}
