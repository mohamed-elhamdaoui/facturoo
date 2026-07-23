@extends('layouts.app')

@section('title', 'Détails de la Facture')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
    <a href="{{ route('invoices.index') }}" class="text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors inline-flex items-center">
        &larr; Retour aux factures
    </a>
    <div class="space-x-3">
        <a href="{{ route('invoices.download', $invoice) }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-indigo-700 bg-indigo-50 border border-transparent rounded-lg hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Télécharger PDF
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden max-w-4xl mx-auto">
    <!-- Top accent bar -->
    <div class="h-2 bg-indigo-600 w-full"></div>
    
    <div class="p-8 sm:p-12">
        <!-- Invoice Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start border-b border-slate-100 pb-8 mb-8 gap-6">
            <div>
                <h2 class="text-3xl font-bold text-slate-900 tracking-tight">FACTURE</h2>
                <p class="text-slate-500 mt-1 font-medium">#INV-{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div class="text-left sm:text-right">
                <img src="{{ asset('images/kenz_logo.svg') }}" alt="Kenz" class="h-16 w-auto ml-auto">
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="flex flex-col sm:flex-row justify-between mb-10 gap-6">
            <div>
                <p class="text-xs text-slate-400 mb-1 uppercase tracking-wider font-bold">Facturé à</p>
                @if($invoice->client)
                    <h4 class="text-lg font-semibold text-slate-900">{{ $invoice->client->name }}</h4>
                    @if($invoice->client->phone)
                        <p class="text-sm text-slate-500 mt-0.5">Tél : {{ $invoice->client->phone }}</p>
                    @endif
                @else
                    <h4 class="text-lg font-semibold text-slate-400">—</h4>
                @endif
            </div>
            <div class="text-left sm:text-right">
                <p class="text-xs text-slate-400 mb-1 uppercase tracking-wider font-bold">Date d'émission</p>
                <p class="text-slate-900 font-medium">{{ $invoice->created_at->format('d/m/Y') }}</p>
            </div>
        </div>

        <!-- Items Table -->
        <div class="overflow-hidden border border-slate-200 rounded-lg mb-8">
            <table class="min-w-full divide-y divide-slate-200 text-left">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Produit</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Qté</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Prix U.</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Remise</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Montant</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @foreach($invoice->items as $item)
                    <tr class="hover:bg-slate-50/50">
                        <td class="py-2.5 px-4">
                            <span class="text-sm font-semibold text-slate-900">{{ $item->product->name }}</span>
                        </td>
                        <td class="py-2.5 px-4 text-sm font-semibold text-slate-700 text-center">× {{ $item->quantity }}</td>
                        <td class="py-2.5 px-4 text-sm text-slate-600 text-right">{{ number_format($item->unit_price, 2) }} DH</td>
                        <td class="py-2.5 px-4 text-sm text-right {{ $item->discount_percentage > 0 ? 'text-red-600 font-semibold' : 'text-slate-400' }}">
                            {{ $item->discount_percentage > 0 ? $item->discount_percentage . '%' : '0%' }}
                        </td>
                        <td class="py-2.5 px-4 text-sm font-bold text-slate-900 text-right">{{ number_format($item->subtotal, 2) }} DH</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    @if($invoice->discount_amount > 0)
                    <tr class="border-t border-slate-200 text-slate-600">
                        <td class="py-2.5 px-4 font-medium" colspan="2">Total Brut</td>
                        <td class="py-2.5 px-4" colspan="2"></td>
                        <td class="py-2.5 px-4 text-right font-bold">{{ number_format($invoice->subtotal, 2) }} DH</td>
                    </tr>
                    <tr class="text-red-600">
                        <td class="py-2.5 px-4 font-medium" colspan="2">Remise</td>
                        <td class="py-2.5 px-4" colspan="2"></td>
                        <td class="py-2.5 px-4 text-right font-bold">-{{ number_format($invoice->discount_amount, 2) }} DH</td>
                    </tr>
                    @endif
                    <tr class="border-t-2 border-slate-900 font-bold text-slate-900 bg-slate-50/50">
                        <td class="py-4 px-4 text-base" colspan="2">Total TTC</td>
                        <td class="py-4 px-4 text-center text-sm text-slate-600" colspan="2">{{ $invoice->items->count() }} article(s)</td>
                        <td class="py-4 px-4 text-right text-lg text-indigo-700 font-extrabold">{{ number_format($invoice->total, 2) }} DH</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <!-- Footer -->
        <div class="mt-16 pt-8 border-t border-slate-100 text-center">
            <p class="text-slate-400 text-sm">Merci pour votre confiance !</p>
        </div>
    </div>
</div>
@endsection
