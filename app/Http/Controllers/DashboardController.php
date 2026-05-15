<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $totalInvoices = Invoice::count();
        $totalRevenue = Invoice::sum('total');
        $totalProducts = Product::count();
        
        $recentInvoices = Invoice::withCount('items')->latest()->take(5)->get();

        return view('dashboard', compact('totalInvoices', 'totalRevenue', 'totalProducts', 'recentInvoices'));
    }
}
