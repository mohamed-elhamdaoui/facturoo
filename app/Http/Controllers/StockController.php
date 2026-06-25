<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function create()
    {
        $products = Product::orderBy('category')->orderBy('name')->get();
        return view('stock.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity'   => ['required', 'integer', 'min:1'],
        ]);

        DB::transaction(function () use ($validated) {
            $product = Product::lockForUpdate()->findOrFail($validated['product_id']);

            $product->increment('stock_quantity', $validated['quantity']);

            StockMovement::create([
                'product_id' => $product->id,
                'type'       => 'entrée',
                'quantity'   => $validated['quantity'],
                'reason'     => 'entrée manuelle',
            ]);
        });

        return redirect()->route('stock.create')->with('success', 'Stock mis à jour avec succès.');
    }
}
