@extends('layouts.app')

@section('title', 'Dashboard Overview')

@section('content')
<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Revenue -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
        <div class="p-4 bg-green-50 text-green-600 rounded-lg mr-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 mb-1">Total Revenue</p>
            <h4 class="text-2xl font-bold text-gray-800">${{ number_format($totalRevenue, 2) }}</h4>
        </div>
    </div>

    <!-- Invoices -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
        <div class="p-4 bg-blue-50 text-blue-600 rounded-lg mr-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 mb-1">Total Invoices</p>
            <h4 class="text-2xl font-bold text-gray-800">{{ number_format($totalInvoices) }}</h4>
        </div>
    </div>

    <!-- Products -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
        <div class="p-4 bg-purple-50 text-purple-600 rounded-lg mr-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 mb-1">Total Products</p>
            <h4 class="text-2xl font-bold text-gray-800">{{ number_format($totalProducts) }}</h4>
        </div>
    </div>
</div>

<!-- Recent Invoices -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-800">Recent Invoices</h3>
        <a href="{{ route('invoices.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View All &rarr;</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-sm text-gray-500 uppercase tracking-wider">
                    <th class="p-4 font-medium">Invoice #</th>
                    <th class="p-4 font-medium">Customer Name</th>
                    <th class="p-4 font-medium">Date</th>
                    <th class="p-4 font-medium text-right">Amount</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($recentInvoices as $invoice)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4 font-medium text-gray-800">
                        <a href="{{ route('invoices.show', $invoice) }}" class="text-blue-600 hover:underline">
                            INV-{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}
                        </a>
                    </td>
                    <td class="p-4 text-gray-600">{{ $invoice->customer_name }}</td>
                    <td class="p-4 text-gray-500">{{ $invoice->created_at->format('M d, Y') }}</td>
                    <td class="p-4 font-semibold text-gray-800 text-right">${{ number_format($invoice->total, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-8 text-center text-gray-400">
                        No invoices generated yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
