@extends('layouts.app')

@section('title', 'Invoice Details')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('invoices.index') }}" class="text-gray-500 hover:text-blue-600 flex items-center transition">
        &larr; Back to Invoices
    </a>
    <div class="space-x-3">
        <a href="{{ route('invoices.download', $invoice) }}" class="bg-blue-50 hover:bg-blue-100 text-blue-700 px-5 py-2.5 rounded-lg font-medium transition shadow-sm inline-flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Export PDF
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-10 max-w-4xl mx-auto">
    <!-- Invoice Header -->
    <div class="flex justify-between items-start border-b border-gray-100 pb-8 mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-800 tracking-tight">INVOICE</h2>
            <p class="text-gray-500 mt-1">#INV-{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</p>
        </div>
        <div class="text-right">
            <h3 class="text-xl font-bold text-blue-600 mb-1">Your Company Name</h3>
            <p class="text-gray-500 text-sm">123 Your Address Here</p>
            <p class="text-gray-500 text-sm">Your City, ZIP</p>
        </div>
    </div>

    <!-- Invoice Details -->
    <div class="flex justify-between mb-10">
        <div>
            <p class="text-sm text-gray-500 mb-1 uppercase tracking-wider font-semibold">Billed To:</p>
            <h4 class="text-lg font-medium text-gray-800">{{ $invoice->customer_name }}</h4>
        </div>
        <div class="text-right">
            <p class="text-sm text-gray-500 mb-1 uppercase tracking-wider font-semibold">Date of Issue:</p>
            <p class="text-gray-800 font-medium">{{ $invoice->created_at->format('F d, Y') }}</p>
        </div>
    </div>

    <!-- Items Table -->
    <table class="w-full text-left mb-8">
        <thead>
            <tr class="border-b-2 border-gray-800 text-sm text-gray-800 uppercase">
                <th class="py-3 font-semibold w-1/2">Description</th>
                <th class="py-3 font-semibold w-1/6 text-center">Unit Price</th>
                <th class="py-3 font-semibold w-1/6 text-center">Qty</th>
                <th class="py-3 font-semibold w-1/6 text-right">Amount</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($invoice->items as $item)
            <tr>
                <td class="py-4">
                    <p class="font-medium text-gray-800">{{ $item->product->name }}</p>
                </td>
                <td class="py-4 text-center text-gray-600">{{ number_format($item->unit_price, 2) }} DH</td>
                <td class="py-4 text-center text-gray-600">{{ $item->quantity }}</td>
                <td class="py-4 text-right font-medium text-gray-800">{{ number_format($item->subtotal, 2) }} DH</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Total -->
    <div class="flex justify-end pt-4 border-t-2 border-gray-800">
        <div class="w-1/3">
            <div class="flex justify-between items-center font-bold text-xl text-gray-800">
                <span>Total:</span>
                <span>{{ number_format($invoice->total, 2) }} DH</span>
            </div>
        </div>
    </div>
    
    <div class="mt-16 text-center text-gray-400 text-sm pt-8 border-t border-gray-100">
        <p>Thank you for your business!</p>
    </div>
</div>
@endsection
