@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
            <span>Aperçu</span>
            <span class="text-sm font-normal text-slate-400 font-arabic" dir="rtl">نظرة عامة</span>
        </h2>
    </div>
    <a href="{{ route('invoices.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        <span>Nouvelle Facture </span>
        <span class="text-xs font-normal text-indigo-200 ml-1.5 pl-1.5 border-l border-indigo-500/50 font-arabic" dir="rtl">فاتورة جديدة</span>
    </a>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
    <!-- Card 1: Chiffre du mois -->
    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-slate-200">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-50 rounded-md p-3">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-slate-500 flex flex-col">
                            <span>Chiffre du mois</span>
                            <span class="text-xs text-slate-400 font-arabic" dir="rtl">رقم المعاملات (الشهر)</span>
                        </dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-bold text-slate-900">{{ number_format($totalRevenue, 2) }} <span class="text-base font-medium text-slate-500">DH</span></div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Factures ce mois -->
    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-slate-200">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-emerald-50 rounded-md p-3">
                    <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-slate-500 flex flex-col">
                            <span>Factures ce mois</span>
                            <span class="text-xs text-slate-400 font-arabic" dir="rtl">فواتير هذا الشهر</span>
                        </dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-bold text-slate-900">{{ number_format($invoicesThisMonth) }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Total Clients -->
    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-slate-200">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-50 rounded-md p-3">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-slate-500 flex flex-col">
                            <span>Total Clients</span>
                            <span class="text-xs text-slate-400 font-arabic" dir="rtl">إجمالي الزبناء</span>
                        </dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-bold text-slate-900">{{ number_format($totalClients) }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Alertes Stock -->
    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-slate-200">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 @if($lowStockCount > 0) bg-red-50 @else bg-slate-50 @endif rounded-md p-3">
                    <svg class="h-6 w-6 @if($lowStockCount > 0) text-red-600 @else text-slate-600 @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-slate-500 flex flex-col">
                            <span>Alertes Stock</span>
                            <span class="text-xs text-slate-400 font-arabic" dir="rtl">تنبيهات المخزون</span>
                        </dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-bold text-slate-900">{{ number_format($lowStockCount) }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="space-y-8">
    <!-- Recent Invoices Panel -->
    <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200 flex justify-between items-center bg-slate-50/50">
            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                <span>Factures Récentes</span>
                <span class="text-sm font-normal text-slate-400 font-arabic" dir="rtl">الفواتير الأخيرة</span>
            </h3>
            <a href="{{ route('invoices.index') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition-colors flex items-center gap-1">
                <span>Tout voir</span>
                <span class="text-xs font-normal text-slate-400 font-arabic ml-1" dir="rtl">عرض الكل</span>
                <span>&rarr;</span>
            </a>
        </div>
        
        @if($recentInvoices->isEmpty())
            <div class="p-8 text-center">
                <p class="text-sm text-slate-500">Aucune facture récente.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                <div class="flex flex-col">
                                    <span>N° Facture</span>
                                    <span class="text-[10px] font-normal text-slate-400 font-arabic" dir="rtl">رقم الفاتورة</span>
                                </div>
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                <div class="flex flex-col">
                                    <span>Client</span>
                                    <span class="text-[10px] font-normal text-slate-400 font-arabic" dir="rtl">الزبون</span>
                                </div>
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                <div class="flex flex-col">
                                    <span>Date</span>
                                    <span class="text-[10px] font-normal text-slate-400 font-arabic" dir="rtl">التاريخ</span>
                                </div>
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">
                                <div class="flex flex-col">
                                    <span>Montant</span>
                                    <span class="text-[10px] font-normal text-slate-400 font-arabic" dir="rtl">المبلغ</span>
                                </div>
                            </th>
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
                                {{ $invoice->created_at->format('d/m/Y') }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-right font-medium text-slate-900">
                                {{ number_format($invoice->total, 2) }} DH
                            </td>
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

    <!-- Stock Alerts Panel -->
    <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200 flex justify-between items-center bg-slate-50/50">
            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                <span>Alertes de Stock</span>
                <span class="text-sm font-normal text-slate-400 font-arabic" dir="rtl">تنبيهات المخزون</span>
            </h3>
        </div>
        <div class="p-6">
            @if($lowStockProducts->isEmpty())
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h4 class="mt-2 text-sm font-bold text-slate-900 flex flex-col items-center">
                        <span>Tout est en ordre</span>
                        <span class="text-xs font-normal text-slate-400 font-arabic mt-0.5" dir="rtl">كل شيء على ما يرام</span>
                    </h4>
                    <p class="text-xs text-slate-400 mt-1 max-w-[200px] mx-auto flex flex-col items-center">
                        <span>Tous vos produits disposent d'un stock suffisant.</span>
                        <span class="text-[10px] text-slate-400 font-arabic mt-0.5" dir="rtl">جميع المنتجات لديها مخزون كافٍ.</span>
                    </p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($lowStockProducts as $product)
                        <div class="flex items-center justify-between p-3 rounded-lg border border-slate-100 bg-slate-50/50 hover:bg-slate-50 transition-colors">
                            <div class="min-w-0">
                                <h4 class="text-sm font-bold text-slate-900 truncate">{{ $product->name }}</h4>
                                <p class="text-xs text-slate-500 mt-0.5 flex flex-wrap gap-1 items-center">
                                    <span>Seuil min : {{ $product->min_stock }}</span>
                                    <span class="text-[10px] text-slate-400 font-arabic" dir="rtl">(الحد الأدنى: {{ $product->min_stock }})</span>
                                </p>
                            </div>
                            <div class="text-right flex flex-col items-end">
                                @if($product->stock_quantity == 0)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-700">Rupture (0) / نفذ</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-100 text-amber-700">Bas ({{ $product->stock_quantity }}) / منخفض</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 text-center">
            <a href="{{ route('products.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition-colors flex items-center justify-center gap-1.5">
                <span>Rapprovisionner le stock</span>
                <span class="text-[11px] font-normal text-indigo-400 font-arabic" dir="rtl">إعادة تموين المخزون</span>
                <span>&rarr;</span>
            </a>
        </div>
    </div>
</div>
@endsection
