<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        // Fetch all products for real-time frontend filtering
        $products = Product::orderBy('category')->orderBy('name')->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Produit créé avec succès.');
    }

    public function show(Product $product)
    {
        // Not used currently, redirecting to edit
        return redirect()->route('products.edit', $product);
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        
        // Defensive check: do not allow standard product edit form to modify stock fields
        unset($data['stock_quantity'], $data['min_stock']);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produit mis à jour avec succès.');
    }

    public function destroy(Product $product)
    {
        // Check if the product is used in any invoices
        if ($product->invoiceItems()->exists()) {
            return redirect()->route('products.index')->with('error', 'Ce produit ne peut pas être supprimé car il est déjà utilisé dans une ou plusieurs factures.');
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produit supprimé avec succès.');
    }

    public function addStock(\Illuminate\Http\Request $request, Product $product)
    {
        $data = $request->validate([
            'quantity' => 'required|integer|not_in:0',
        ], [
            'quantity.required' => 'La quantité est obligatoire.',
            'quantity.integer' => 'La quantité doit être un nombre entier.',
            'quantity.not_in' => 'La quantité ne peut pas être zéro.',
        ]);

        $quantity = (int)$data['quantity'];

        \Illuminate\Support\Facades\DB::transaction(function () use ($product, $quantity) {
            $product->increment('stock_quantity', $quantity);

            $product->stockMovements()->create([
                'type' => $quantity > 0 ? 'entrée' : 'sortie',
                'quantity' => abs($quantity),
                'reason' => 'ajustement manuel (correction)',
            ]);
        });

        return redirect()->route('products.index')->with('success', "Stock mis à jour avec succès (+{$quantity} pour {$product->name}).");
    }
}
