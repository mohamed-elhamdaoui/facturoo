@extends('layouts.app')

@section('title', 'Invoices History')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <p class="text-gray-500">View and manage all your generated invoices.</p>
    <a href="{{ route('invoices.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-medium transition shadow-sm">
        + Create Invoice
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100 text-sm text-gray-500 uppercase tracking-wider">
                <th class="p-4 font-medium">Invoice #</th>
                <th class="p-4 font-medium">Customer Name</th>
                <th class="p-4 font-medium">Items</th>
                <th class="p-4 font-medium">Date</th>
                <th class="p-4 font-medium">Total</th>
                <th class="p-4 font-medium text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($invoices as $invoice)
            <tr class="hover:bg-gray-50 transition">
                <td class="p-4 font-medium text-gray-800">INV-{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</td>
                <td class="p-4 text-gray-600">{{ $invoice->customer_name }}</td>
                <td class="p-4 text-gray-500">
                    <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-md text-xs">{{ $invoice->items_count }} items</span>
                </td>
                <td class="p-4 text-gray-500">{{ $invoice->created_at->format('M d, Y') }}</td>
                <td class="p-4 font-semibold text-gray-800">{{ number_format($invoice->total, 2) }} DH</td>
                <td class="p-4 text-right space-x-3">
                    <a href="{{ route('invoices.show', $invoice) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">View</a>
                    
                    <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this invoice forever?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="p-8 text-center text-gray-400">
                    No invoices found. Create your first one!
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $invoices->links() }}
</div>
@endsection
