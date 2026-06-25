@extends('layouts.app')

@section('title', 'Entrée de Stock')

@section('content')
<div class="mb-6">
    <a href="{{ route('products.index') }}" class="text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors">&larr; Retour aux produits</a>
</div>

<div class="max-w-xl mx-auto bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-200 bg-slate-50">
        <h3 class="text-lg font-semibold text-slate-900">Entrée de stock</h3>
        <p class="mt-1 text-sm text-slate-500">Ajoutez une quantité reçue pour un produit. Le stock sera mis à jour automatiquement.</p>
    </div>

    <form action="{{ route('stock.store') }}" method="POST" class="p-6 space-y-6">
        @csrf

        <!-- Product selector -->
        <div>
            <label for="product_id" class="block text-sm font-medium text-slate-700">Produit *</label>
            <select id="product_id" name="product_id" required
                class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border @error('product_id') border-red-500 @enderror">
                <option value="">-- Sélectionner un produit --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }} ({{ $product->category }}) — Stock actuel : {{ $product->stock_quantity }}
                    </option>
                @endforeach
            </select>
            @error('product_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Quantity -->
        <div>
            <label for="quantity" class="block text-sm font-medium text-slate-700">Quantité reçue *</label>
            <input type="number" min="1" id="quantity" name="quantity" value="{{ old('quantity') }}" required
                class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border @error('quantity') border-red-500 @enderror"
                placeholder="Ex: 50">
            @error('quantity')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-5 border-t border-slate-200 flex justify-end gap-3">
            <a href="{{ route('products.index') }}" class="inline-flex justify-center rounded-lg border border-slate-300 bg-white py-2 px-4 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 transition-colors">
                Annuler
            </a>
            <button type="submit" class="inline-flex justify-center rounded-lg border border-transparent py-2 px-4 text-sm font-medium text-white shadow-sm transition-colors" style="background-color:#4f46e5;">
                Enregistrer l'entrée
            </button>
        </div>
    </form>
</div>
@endsection
