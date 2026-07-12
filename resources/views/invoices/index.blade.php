@extends('layouts.app')

@section('title', 'Factures')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h2 class="text-xl font-semibold text-slate-800">Factures</h2>
        <p class="text-sm text-slate-500 mt-1">Consultez et gérez toutes vos factures émises.</p>
    </div>
    <a href="{{ route('invoices.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Nouvelle Facture
    </a>
</div>

{{-- Filter Bar --}}
<div class="mb-4 flex flex-col sm:flex-row gap-3 items-start sm:items-center">
    <form method="GET" action="{{ route('invoices.index') }}" class="flex items-center gap-2 w-full sm:w-auto">
        <label for="client_filter" class="text-sm font-medium text-slate-600 whitespace-nowrap">Client :</label>
        <select id="client_filter" name="client_id" onchange="this.form.submit()"
            class="w-full sm:w-56 py-2 px-3 text-sm border border-slate-300 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
            <option value="">Tous les clients</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                    {{ $client->name }}
                </option>
            @endforeach
        </select>
    </form>

    @if($selectedClient)
        <div class="flex items-center gap-2 px-3 py-1.5 bg-indigo-50 border border-indigo-200 rounded-full text-sm text-indigo-700 font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/></svg>
            {{ $selectedClient->name }}
            <a href="{{ route('invoices.index') }}" class="ml-1 text-indigo-400 hover:text-indigo-700 transition-colors" title="Effacer le filtre">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </a>
        </div>
        <span class="text-sm text-slate-500">{{ $invoices->total() }} facture(s) trouvée(s)</span>
    @endif
</div>

<div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
    @if($invoices->isEmpty())
        <div class="p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <h3 class="mt-2 text-sm font-semibold text-slate-900">Aucune facture{{ $selectedClient ? ' pour ' . $selectedClient->name : '' }}</h3>
            <p class="mt-1 text-sm text-slate-500">{{ $selectedClient ? 'Ce client n\'a pas encore de factures.' : 'Commencez par créer votre première facture.' }}</p>
            @if($selectedClient)
                <div class="mt-4">
                    <a href="{{ route('invoices.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">← Voir toutes les factures</a>
                </div>
            @else
                <div class="mt-6">
                    <a href="{{ route('invoices.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                        <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Nouvelle Facture
                    </a>
                </div>
            @endif
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead>
                    <tr class="bg-slate-50">
                        <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">N° Facture</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Client</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Articles</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-3 py-3.5 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Total</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-6 text-right">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @foreach($invoices as $invoice)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="whitespace-nowrap py-4 pl-6 pr-3 text-sm font-medium text-indigo-600">
                            <a href="{{ route('invoices.show', $invoice) }}" class="hover:underline">
                                INV-{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}
                            </a>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-600 font-medium">
                            @if($invoice->client)
                                <a href="{{ route('clients.show', $invoice->client) }}" class="hover:underline text-slate-800 font-semibold">
                                    {{ $invoice->client->name }}
                                </a>
                            @else
                                <span class="text-slate-400">—</span>
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">
                            <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600 ring-1 ring-inset ring-slate-500/10">{{ $invoice->items_count }} articles</span>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ $invoice->created_at->format('d M Y') }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-right font-bold text-slate-900">{{ number_format($invoice->total, 2) }} DH</td>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-6 text-right text-sm font-medium flex justify-end gap-3 items-center">
                            <a href="{{ route('invoices.show', $invoice) }}" class="text-indigo-600 hover:text-indigo-900">Voir</a>
                            <a href="{{ route('invoices.download', $invoice) }}" class="text-slate-600 hover:text-slate-900" title="Télécharger PDF">PDF</a>
                            <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline-block m-0 p-0 h-full" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette facture ? Cette action est définitive.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 bg-transparent border-none p-0 cursor-pointer">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<div class="mt-4">
    {{ $invoices->links() }}
</div>
@endsection
