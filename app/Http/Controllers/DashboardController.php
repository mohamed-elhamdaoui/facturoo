<?php

namespace App\Http\Controllers;

use App\Models\Invoice;

class DashboardController extends Controller
{
    public function index()
    {
        $totalInvoices = Invoice::count();
        $invoicesThisMonth = Invoice::whereMonth('created_at', now()->month)
                                    ->whereYear('created_at', now()->year)
                                    ->count();
        $totalRevenue = Invoice::whereMonth('created_at', now()->month)
                               ->whereYear('created_at', now()->year)
                               ->sum('total');
        
        $recentInvoices = Invoice::withCount('items')->latest()->take(5)->get();

        return view('dashboard', compact('totalInvoices', 'invoicesThisMonth', 'totalRevenue', 'recentInvoices'));
    }
}
