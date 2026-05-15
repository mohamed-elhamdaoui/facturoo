<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceRequest;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::withCount('items')->latest()->paginate(10);
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        return view('invoices.create', compact('products'));
    }

    public function store(StoreInvoiceRequest $request)
    {
        $data = $request->validated();
        
        $invoice = Invoice::create([
            'customer_name' => $data['customer_name'],
            'total' => 0
        ]);

        $grandTotal = 0;

        foreach ($data['items'] as $itemData) {
            $product = Product::find($itemData['product_id']);
            $subtotal = $product->price * $itemData['quantity'];
            
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'product_id' => $product->id,
                'quantity' => $itemData['quantity'],
                'unit_price' => $product->price,
                'subtotal' => $subtotal
            ]);

            $grandTotal += $subtotal;
        }

        $invoice->update(['total' => $grandTotal]);

        return redirect()->route('invoices.show', $invoice)
                         ->with('success', 'Invoice created successfully.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['items.product']);
        return view('invoices.show', compact('invoice'));
    }

    public function download(Invoice $invoice)
    {
        $invoice->load(['items.product']);
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
        return $pdf->download('invoice-' . str_pad($invoice->id, 5, '0', STR_PAD_LEFT) . '.pdf');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }
}
