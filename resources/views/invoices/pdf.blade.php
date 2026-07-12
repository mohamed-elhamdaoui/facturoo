<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture #INV-{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; font-size: 14px; }
        .header { width: 100%; margin-bottom: 40px; border-bottom: 2px solid #eee; padding-bottom: 20px; }
        .header td { vertical-align: middle; }
        .title { font-size: 28px; font-weight: bold; color: #1f2937; margin: 0; }
        .invoice-id { color: #6b7280; font-size: 16px; margin-top: 5px; }
        .logo-cell { text-align: right; vertical-align: middle; }
        .info-table { width: 100%; margin-bottom: 40px; }
        .info-table td { vertical-align: top; width: 50%; }
        .info-label { font-size: 12px; color: #6b7280; text-transform: uppercase; font-weight: bold; margin-bottom: 5px; }
        .info-value { font-size: 16px; font-weight: bold; margin: 0; }
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .items-table th { padding: 10px 12px; background-color: #f8fafc; border-bottom: 2px solid #1f2937; text-align: left; font-size: 11px; text-transform: uppercase; }
        .items-table td { padding: 8px 12px; border-bottom: 1px solid #f3f4f6; font-size: 13px; }
        .product-name { font-weight: bold; color: #1f2937; }
        .text-center { text-align: center !important; }
        .text-right { text-align: right !important; }
        .items-table tfoot .total-row td {
            padding: 15px 12px;
            border-top: 2px solid #1f2937;
            font-size: 16px;
            font-weight: bold;
        }
        .items-table tfoot .total-row .total-label {
            text-align: left;
            color: #1f2937;
        }
        .items-table tfoot .total-row .total-amount {
            text-align: right;
            color: #1f2937;
        }
        .footer { text-align: center; margin-top: 80px; padding-top: 20px; border-top: 1px solid #eee; color: #9ca3af; font-size: 12px; }
    </style>
</head>
<body>

    <table class="header">
        <tr>
            <td>
                <h1 class="title">FACTURE</h1>
                <div class="invoice-id">#INV-{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</div>
            </td>
            <td class="logo-cell">
                <img src="{{ public_path('images/kenz_logo.svg') }}" alt="Kenz" style="width: 120px; height: 90px; display: inline-block;">
            </td>
        </tr>
    </table>

    <table class="info-table">
        <tr>
            <td>
                <div class="info-label">Facturé à :</div>
                <div class="info-value">
                    @if($invoice->client)
                        {{ $invoice->client->name }}
                        @if($invoice->client->phone)
                            <div style="font-size: 13px; font-weight: normal; color: #4b5563; margin-top: 3px;">Tél : {{ $invoice->client->phone }}</div>
                        @endif
                    @else
                        —
                    @endif
                </div>
            </td>
            <td class="text-right">
                <div class="info-label">Date d'émission :</div>
                <div class="info-value">{{ $invoice->created_at->format('d/m/Y') }}</div>
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th>Description</th>
                <th class="text-center">Qté</th>
                <th class="text-center">Prix U.</th>
                <th class="text-right">Montant</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
            <tr>
                <td>
                    <span class="product-name">{{ $item->product->name }}</span>
                </td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-center">{{ number_format($item->unit_price, 2) }} DH</td>
                <td class="text-right"><strong>{{ number_format($item->subtotal, 2) }} DH</strong></td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td class="total-label">Total TTC</td>
                <td class="text-center" style="font-size: 13px; color: #6b7280; font-weight: normal;">{{ $invoice->items->count() }} article(s)</td>
                <td></td>
                <td class="total-amount">{{ number_format($invoice->total, 2) }} DH</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Merci pour votre confiance !
    </div>

</body>
</html>
