@extends('layouts.app')

@section('title', $client->name . ' — Détail Client')

@section('content')
{{-- Header --}}
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div class="flex items-center gap-4">
        <a href="{{ route('clients.index') }}" class="text-slate-400 hover:text-indigo-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-lg flex-shrink-0">
            {{ strtoupper(substr($client->name, 0, 1)) }}
        </div>
        <div>
            <h2 class="text-xl font-semibold text-slate-800">{{ $client->name }}</h2>
            <p class="text-sm text-slate-500 mt-0.5">{{ $client->phone ?? 'Aucun téléphone' }}</p>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('clients.edit', $client) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 border border-indigo-200 rounded-lg hover:bg-indigo-100 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
            Modifier
        </a>
        <a href="{{ route('invoices.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg shadow-sm hover:bg-indigo-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nouvelle Facture
        </a>
    </div>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Total Factures</p>
        <p class="mt-2 text-3xl font-bold text-slate-900">{{ $client->invoices_count }}</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Chiffre d'affaires</p>
        <p class="mt-2 text-3xl font-bold text-indigo-600">{{ number_format($totalRevenue, 2) }} DH</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Panier Moyen</p>
        <p class="mt-2 text-3xl font-bold text-slate-900">
            {{ $client->invoices_count > 0 ? number_format($totalRevenue / $client->invoices_count, 2) : '0.00' }} DH
        </p>
    </div>
</div>

{{-- Invoices Table --}}
<div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h3 class="text-base font-semibold text-slate-900">Historique des factures</h3>
    </div>

    @if($client->invoices->isEmpty())
        <div class="p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <h3 class="mt-2 text-sm font-semibold text-slate-900">Aucune facture pour ce client</h3>
            <p class="mt-1 text-sm text-slate-500">Créez la première facture pour {{ $client->name }}.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead>
                    <tr class="bg-slate-50">
                        <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">N° Facture</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Articles</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-3 py-3.5 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Total</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-6 text-right"><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @foreach($client->invoices as $invoice)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="whitespace-nowrap py-4 pl-6 pr-3 text-sm font-medium text-indigo-600">
                            <a href="{{ route('invoices.show', $invoice) }}" class="hover:underline">
                                INV-{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}
                            </a>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">
                            <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600 ring-1 ring-inset ring-slate-500/10">{{ $invoice->items_count }} articles</span>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ $invoice->created_at->format('d M Y') }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-right font-bold text-slate-900">{{ number_format($invoice->total, 2) }} DH</td>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-6 text-right text-sm font-medium">
                            <div class="flex justify-end items-center gap-3">
                                <a href="{{ route('invoices.show', $invoice) }}" class="text-indigo-600 hover:text-indigo-900">Voir</a>
                                <a href="{{ route('invoices.download', $invoice) }}" class="text-slate-600 hover:text-slate-900">PDF</a>
                                <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline-block" onsubmit="return confirm('Supprimer cette facture ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 bg-transparent border-none p-0 cursor-pointer">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
