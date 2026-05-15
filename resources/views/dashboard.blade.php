@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-xl font-medium text-slate-800">Aperçu</h2>
    <a href="{{ route('invoices.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Nouvelle Facture
    </a>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 gap-5 sm:grid-cols-3 mb-8">
    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-slate-200">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-indigo-50 rounded-md p-3">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-slate-500 truncate">Total Factures</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-bold text-slate-900">{{ number_format($totalInvoices) }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-slate-200">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-emerald-50 rounded-md p-3">
                    <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-slate-500 truncate">Factures ce mois</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-bold text-slate-900">{{ number_format($invoicesThisMonth) }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-slate-200">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-50 rounded-md p-3">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-slate-500 truncate">Chiffre du mois</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-bold text-slate-900">{{ number_format($totalRevenue, 2) }} <span class="text-base font-medium text-slate-500">DH</span></div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Invoices -->
<div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
        <h3 class="text-base font-semibold leading-6 text-slate-900">Factures Récentes</h3>
        <a href="{{ route('invoices.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors">Tout voir &rarr;</a>
    </div>
    
    @if($recentInvoices->isEmpty())
        <div class="p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <h3 class="mt-2 text-sm font-semibold text-slate-900">Aucune facture</h3>
            <p class="mt-1 text-sm text-slate-500">Commencez par créer votre première facture.</p>
            <div class="mt-6">
                <a href="{{ route('invoices.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Nouvelle Facture
                </a>
            </div>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead>
                    <tr>
                        <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">N° Facture</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Client</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-3 py-3.5 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Montant</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-6">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @foreach($recentInvoices as $invoice)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="whitespace-nowrap py-4 pl-6 pr-3 text-sm font-medium text-indigo-600">
                            <a href="{{ route('invoices.show', $invoice) }}" class="hover:underline">
                                INV-{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}
                            </a>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-600">{{ $invoice->customer_name }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ $invoice->created_at->format('d/m/Y') }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-right font-medium text-slate-900">{{ number_format($invoice->total, 2) }} DH</td>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-6 text-right text-sm font-medium">
                            <a href="{{ route('invoices.show', $invoice) }}" class="text-indigo-600 hover:text-indigo-900">Voir<span class="sr-only">, INV-{{ $invoice->id }}</span></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
