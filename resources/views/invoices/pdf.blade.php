<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #INV-{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; font-size: 14px; }
        .header { width: 100%; margin-bottom: 40px; border-bottom: 2px solid #eee; padding-bottom: 20px; }
        .header td { vertical-align: top; }
        .title { font-size: 28px; font-weight: bold; color: #1f2937; margin: 0; }
        .invoice-id { color: #6b7280; font-size: 16px; margin-top: 5px; }
        .company-details { text-align: right; }
        .company-name { font-size: 18px; font-weight: bold; color: #2563eb; margin: 0; }
        .info-table { width: 100%; margin-bottom: 40px; }
        .info-table td { vertical-align: top; width: 50%; }
        .info-label { font-size: 12px; color: #6b7280; text-transform: uppercase; font-weight: bold; margin-bottom: 5px; }
        .info-value { font-size: 16px; font-weight: bold; margin: 0; }
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .items-table th { padding: 12px; background-color: #f8fafc; border-bottom: 2px solid #1f2937; text-align: left; font-size: 12px; text-transform: uppercase; }
        .items-table td { padding: 15px 12px; border-bottom: 1px solid #f3f4f6; }
        .text-center { text-align: center !important; }
        .text-right { text-align: right !important; }
        .total-container { width: 100%; text-align: right; }
        .total-box { display: inline-block; width: 300px; padding-top: 15px; border-top: 2px solid #1f2937; }
        .total-label { font-size: 18px; font-weight: bold; display: inline-block; width: 40%; text-align: left; }
        .total-amount { font-size: 20px; font-weight: bold; display: inline-block; width: 55%; text-align: right; }
        .footer { text-align: center; margin-top: 80px; padding-top: 20px; border-top: 1px solid #eee; color: #9ca3af; font-size: 12px; }
    </style>
</head>
<body>

    <table class="header">
        <tr>
            <td>
                <h1 class="title">INVOICE</h1>
                <div class="invoice-id">#INV-{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</div>
            </td>
            <td class="company-details">
                <h2 class="company-name">Facturo Inc.</h2>
                <div>123 Business Road</div>
                <div>Tech City, TX 75001</div>
            </td>
        </tr>
    </table>

    <table class="info-table">
        <tr>
            <td>
                <div class="info-label">Billed To:</div>
                <div class="info-value">{{ $invoice->customer_name }}</div>
            </td>
            <td class="text-right">
                <div class="info-label">Date of Issue:</div>
                <div class="info-value">{{ $invoice->created_at->format('F d, Y') }}</div>
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th>Description</th>
                <th class="text-center">Unit Price</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
            <tr>
                <td><strong>{{ $item->product->name }}</strong></td>
                <td class="text-center">${{ number_format($item->unit_price, 2) }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right"><strong>${{ number_format($item->subtotal, 2) }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-container">
        <div class="total-box">
            <div class="total-label">Total:</div>
            <div class="total-amount">${{ number_format($invoice->total, 2) }}</div>
        </div>
    </div>

    <div class="footer">
        Thank you for your business!
    </div>

</body>
</html>
