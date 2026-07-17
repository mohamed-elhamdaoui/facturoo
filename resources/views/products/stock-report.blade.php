<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport de Stock — {{ now()->format('d/m/Y') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #1f2937; font-size: 13px; background: #fff; }

        /* ── Header ── */
        .header { width: 100%; border-bottom: 3px solid #4f46e5; padding-bottom: 18px; margin-bottom: 24px; }
        .header td { vertical-align: middle; }
        .report-title { font-size: 26px; font-weight: 900; color: #1f2937; letter-spacing: -0.5px; }
        .report-sub  { font-size: 13px; color: #6b7280; margin-top: 4px; }
        .logo-cell   { text-align: right; }
        .logo-cell img { width: 110px; height: auto; }

        /* ── Meta Info ── */
        .meta-bar { width: 100%; margin-bottom: 24px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 14px; }
        .meta-bar td { font-size: 12px; color: #6b7280; padding: 0 6px; }
        .meta-bar td strong { color: #1f2937; font-size: 13px; }

        /* ── Alert Summary ── */
        .summary-cards { width: 100%; margin-bottom: 26px; border-collapse: separate; border-spacing: 8px; }
        .card { border-radius: 6px; padding: 10px 14px; text-align: center; }
        .card-ok  { background: #f0fdf4; border: 1px solid #86efac; }
        .card-low { background: #fffbeb; border: 1px solid #fcd34d; }
        .card-out { background: #fef2f2; border: 1px solid #fca5a5; }
        .card-num { font-size: 22px; font-weight: 900; margin-bottom: 2px; }
        .card-ok  .card-num { color: #16a34a; }
        .card-low .card-num { color: #d97706; }
        .card-out .card-num { color: #dc2626; }
        .card-label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; color: #6b7280; }

        /* ── Category Title ── */
        .category-header { background: #4f46e5; color: #fff; font-size: 12px; font-weight: 700; text-transform: uppercase;
                           letter-spacing: 1px; padding: 7px 12px; border-radius: 4px; margin-bottom: 6px; margin-top: 18px; }

        /* ── Products Table ── */
        .stock-table { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        .stock-table thead tr { background: #f1f5f9; }
        .stock-table th { padding: 8px 10px; font-size: 10px; font-weight: 700; text-transform: uppercase;
                          letter-spacing: 0.6px; color: #64748b; text-align: left; border-bottom: 2px solid #e2e8f0; }
        .stock-table th.text-right { text-align: right; }
        .stock-table th.text-center { text-align: center; }
        .stock-table td { padding: 8px 10px; border-bottom: 1px solid #f1f5f9; font-size: 12px; vertical-align: middle; }
        .stock-table td.text-right { text-align: right; }
        .stock-table td.text-center { text-align: center; }
        .stock-table tr:last-child td { border-bottom: none; }

        .product-name { font-weight: 600; color: #1f2937; }
        .product-size { font-size: 11px; color: #9ca3af; margin-top: 1px; }

        /* ── Status Badges ── */
        .badge { display: inline-block; padding: 2px 8px; border-radius: 999px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .badge-ok  { background: #dcfce7; color: #15803d; }
        .badge-low { background: #fef9c3; color: #a16207; }
        .badge-out { background: #fee2e2; color: #b91c1c; }

        /* Stock highlight */
        .qty-low { color: #d97706; font-weight: 700; }
        .qty-out { color: #dc2626; font-weight: 700; }
        .qty-ok  { color: #16a34a; font-weight: 700; }

        /* ── Row highlight for low/out ── */
        .row-low { background: #fffbeb !important; }
        .row-out { background: #fef2f2 !important; }

        /* ── Footer ── */
        .footer { margin-top: 36px; padding-top: 14px; border-top: 1px solid #e2e8f0;
                  text-align: center; color: #9ca3af; font-size: 11px; }
        .footer strong { color: #6b7280; }

        /* ── Totals Row ── */
        .totals-table { width: 100%; margin-top: 20px; }
        .totals-table td { padding: 6px 10px; font-size: 12px; }
        .totals-table .label { color: #6b7280; }
        .totals-table .value { font-weight: 700; color: #1f2937; text-align: right; }
        .grand-total { background: #f8fafc; border-top: 2px solid #4f46e5; }
        .grand-total td { font-size: 14px; padding: 10px 10px; }
        .grand-total .label { font-weight: 700; color: #4f46e5; }
        .grand-total .value { font-weight: 900; color: #4f46e5; }
    </style>
</head>
<body>

{{-- ── Header ── --}}
<table class="header">
    <tr>
        <td>
            <div class="report-title">RAPPORT DE STOCK</div>
            <div class="report-sub">État du stock au {{ now()->format('d/m/Y à H:i') }}</div>
        </td>
        <td class="logo-cell">
            <img src="{{ public_path('images/kenz_logo.svg') }}" alt="Logo">
        </td>
    </tr>
</table>

{{-- ── Meta bar ── --}}
<table class="meta-bar">
    <tr>
        <td>Date : <strong>{{ now()->format('d/m/Y') }}</strong></td>
        <td>Total produits : <strong>{{ $products->count() }}</strong></td>
        <td>Categories : <strong>{{ $products->pluck('category')->unique()->filter()->count() }}</strong></td>
        <td style="text-align:right;">Genere automatiquement par Facturo</td>
    </tr>
</table>

{{-- ── Summary Cards ── --}}
@php
    $okCount  = $products->filter(fn($p) => $p->stock_status === 'ok')->count();
    $lowCount = $products->filter(fn($p) => $p->stock_status === 'low')->count();
    $outCount = $products->filter(fn($p) => $p->stock_status === 'out')->count();
    $totalValue = $products->sum(fn($p) => $p->stock_quantity * $p->price);
@endphp
<table class="summary-cards">
    <tr>
        <td class="card card-ok">
            <div class="card-num">{{ $okCount }}</div>
            <div class="card-label">En stock</div>
        </td>
        <td class="card card-low">
            <div class="card-num">{{ $lowCount }}</div>
            <div class="card-label">Stock faible</div>
        </td>
        <td class="card card-out">
            <div class="card-num">{{ $outCount }}</div>
            <div class="card-label">Epuise</div>
        </td>
        <td style="background:#eef2ff; border:1px solid #c7d2fe; border-radius:6px; padding:10px 14px; text-align:center;">
            <div class="card-num" style="color:#4f46e5;">{{ number_format($totalValue, 2) }} DH</div>
            <div class="card-label" style="color:#4f46e5;">Valeur totale du stock</div>
        </td>
    </tr>
</table>

{{-- ── Products grouped by category ── --}}
@php
    $grouped = $products->groupBy('category')->sortKeys();
@endphp

@foreach($grouped as $category => $items)
    <div class="category-header">
        {{ $category ?: 'Sans catégorie' }}
        &nbsp;({{ $items->count() }} produit{{ $items->count() > 1 ? 's' : '' }})
    </div>

    <table class="stock-table">
        <thead>
            <tr>
                <th>Produit</th>
                <th class="text-center">Prix U.</th>
                <th class="text-center">Stock min.</th>
                <th class="text-center">Stock actuel</th>
                <th class="text-center">État</th>
                <th class="text-right">Valeur</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items->sortBy('name') as $product)
            @php
                $status = $product->stock_status;
                $rowClass = $status === 'out' ? 'row-out' : ($status === 'low' ? 'row-low' : '');
                $qtyClass = $status === 'out' ? 'qty-out' : ($status === 'low' ? 'qty-low' : 'qty-ok');
            @endphp
            <tr class="{{ $rowClass }}">
                <td>
                    <div class="product-name">{{ $product->name }}</div>
                    @if($product->size)
                        <div class="product-size">Taille : {{ $product->size }}</div>
                    @endif
                </td>
                <td class="text-center">{{ number_format($product->price, 2) }} DH</td>
                <td class="text-center" style="color:#6b7280;">{{ $product->min_stock }}</td>
                <td class="text-center {{ $qtyClass }}">{{ $product->stock_quantity }}</td>
                <td class="text-center">
                    @if($status === 'ok')
                        <span class="badge badge-ok">En stock</span>
                    @elseif($status === 'low')
                        <span class="badge badge-low">Faible</span>
                    @else
                        <span class="badge badge-out">Épuisé</span>
                    @endif
                </td>
                <td class="text-right">{{ number_format($product->stock_quantity * $product->price, 2) }} DH</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endforeach

{{-- ── Footer ── --}}
<div class="footer">
    <strong>Rapport genere le {{ now()->format('d/m/Y a H:i') }}</strong>
    &nbsp;&middot;&nbsp; Facturo - Systeme de gestion de facturation
    @if($lowCount > 0 || $outCount > 0)
        <br><br>
        <strong style="color: #dc2626;">ATTENTION : {{ $lowCount + $outCount }} produit(s) necessitent un reapprovisionnement urgent.</strong>
    @endif
</div>

</body>
</html>
