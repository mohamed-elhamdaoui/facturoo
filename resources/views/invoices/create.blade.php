@extends('layouts.app')

@section('title', 'Nouvelle Facture')

@section('content')
<div class="mb-6">
    <a href="{{ route('invoices.index') }}" class="text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors">&larr; Retour aux factures</a>
</div>

<form action="{{ route('invoices.store') }}" method="POST" x-data="{
    products: {{ $products->toJson() }},
    items: [{ product_id: '', quantity: 1, price: 0, subtotal: 0 }],
    
    get grandTotal() {
        return this.items.reduce((total, item) => total + (item.subtotal || 0), 0);
    },
    
    updateSubtotal(item) {
        if(!item.product_id) {
            item.price = 0;
            item.subtotal = 0;
            return;
        }
        let product = this.products.find(p => p.id == item.product_id);
        if(product) {
            item.price = parseFloat(product.price);
            item.subtotal = item.price * parseInt(item.quantity || 0);
        }
    },
    
    addItem() {
        this.items.push({ product_id: '', quantity: 1, price: 0, subtotal: 0 });
    },
    
    removeItem(index) {
        if(this.items.length > 1) {
            this.items.splice(index, 1);
        }
    }
}">
    @csrf
    <div class="flex flex-col lg:flex-row gap-6">
        
        <!-- Left Column: Client Info -->
        <div class="w-full lg:w-1/3">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden lg:sticky lg:top-6">
                <div class="px-6 py-5 border-b border-slate-200 bg-slate-50">
                    <h3 class="text-lg font-semibold text-slate-900">Informations Client</h3>
                </div>
                <div class="p-6">
                    <div>
                        <label for="customer_name" class="block text-sm font-medium text-slate-700 mb-1">Nom complet ou Entreprise *</label>
                        <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required
                            class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border @error('customer_name') border-red-500 @enderror" placeholder="Ex: Jean Dupont">
                        @error('customer_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mt-8 pt-6 border-t border-slate-200">
                        <button type="submit" class="w-full inline-flex justify-center items-center rounded-lg border border-transparent bg-indigo-600 py-3 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Valider et générer
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Products List -->
        <div class="w-full lg:w-2/3">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-slate-900">Lignes de la facture</h3>
                    <button type="button" @click="addItem()" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 flex items-center transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Ajouter une ligne
                    </button>
                </div>
                
                <div class="p-6">
                    <div class="space-y-4">
                        <template x-for="(item, index) in items" :key="index">
                            <div class="flex flex-col sm:flex-row items-start gap-4 p-4 rounded-xl bg-slate-50/50 border border-slate-200 transition-colors hover:border-slate-300">
                                <div class="flex-1 w-full">
                                    <label class="block text-xs font-semibold tracking-wide text-slate-500 uppercase mb-1">Produit</label>
                                    <select x-model="item.product_id" :name="'items['+index+'][product_id]'" @change="updateSubtotal(item)" required
                                        class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border bg-white">
                                        <option value="">Sélectionnez un produit...</option>
                                        <template x-for="product in products" :key="product.id">
                                            <option :value="product.id" x-text="product.name"></option>
                                        </template>
                                    </select>
                                </div>
                                
                                <div class="w-full sm:w-24">
                                    <label class="block text-xs font-semibold tracking-wide text-slate-500 uppercase mb-1">Prix U.</label>
                                    <div class="block w-full rounded-lg border border-slate-200 bg-slate-100 sm:text-sm p-2.5 text-slate-500 text-right" x-text="item.price.toFixed(2)"></div>
                                </div>

                                <div class="w-full sm:w-24">
                                    <label class="block text-xs font-semibold tracking-wide text-slate-500 uppercase mb-1">Qté</label>
                                    <input type="number" x-model.number="item.quantity" :name="'items['+index+'][quantity]'" min="1" @input="updateSubtotal(item)" required
                                        class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border bg-white text-center">
                                </div>
                                
                                <div class="w-full sm:w-32">
                                    <label class="block text-xs font-semibold tracking-wide text-slate-500 uppercase mb-1">Total</label>
                                    <div class="block w-full rounded-lg border border-transparent sm:text-sm py-2.5 font-bold text-slate-900 text-right" x-text="item.subtotal.toFixed(2) + ' DH'"></div>
                                </div>

                                <div class="pt-6 sm:pl-2">
                                    <button type="button" @click="removeItem(index)" x-show="items.length > 1" class="text-slate-400 hover:text-red-600 transition-colors" title="Supprimer la ligne">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                    
                    <div class="mt-8 pt-6 border-t border-slate-200 flex justify-end">
                        <div class="w-full sm:w-64 bg-slate-50 rounded-lg p-4 border border-slate-200">
                            <div class="flex justify-between items-center text-lg">
                                <span class="font-medium text-slate-500">Total TTC:</span>
                                <span class="font-bold text-indigo-600" x-text="grandTotal.toFixed(2) + ' DH'"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


@endsection
