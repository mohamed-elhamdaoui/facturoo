@extends('layouts.app')

@section('title', 'Nouveau Produit')

@section('content')
<div class="mb-6">
    <a href="{{ route('products.index') }}" class="text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors">&larr; Retour aux produits</a>
</div>

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-200 bg-slate-50">
        <h3 class="text-lg font-semibold text-slate-900">Ajouter un produit</h3>
        <p class="mt-1 text-sm text-slate-500">Renseignez les informations de votre nouveau produit ou service.</p>
    </div>
    
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
        @csrf
        
        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-slate-700">Nom du produit *</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required 
                class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border @error('name') border-red-500 @enderror">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-slate-700">Description <span class="text-slate-400 font-normal">(Optionnel)</span></label>
            <textarea id="description" name="description" rows="3" 
                class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Price -->
        <div>
            <label for="price" class="block text-sm font-medium text-slate-700">Prix (DH) *</label>
            <div class="relative mt-1 rounded-md shadow-sm">
                <input type="number" step="0.01" id="price" name="price" value="{{ old('price') }}" required 
                    class="block w-full rounded-lg border-slate-300 pl-4 pr-12 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border @error('price') border-red-500 @enderror">
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4">
                    <span class="text-slate-500 sm:text-sm">DH</span>
                </div>
            </div>
            @error('price')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Image -->
        <div>
            <label for="image" class="block text-sm font-medium text-slate-700">Image du produit <span class="text-slate-400 font-normal">(Optionnel)</span></label>
            <input type="file" id="image" name="image" accept="image/*" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            @error('image')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="pt-5 mt-5 border-t border-slate-200 flex justify-end gap-3">
            <a href="{{ route('products.index') }}" class="inline-flex justify-center rounded-lg border border-slate-300 bg-white py-2 px-4 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                Annuler
            </a>
            <button type="submit" class="inline-flex justify-center rounded-lg border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                Enregistrer le produit
            </button>
        </div>
    </form>
</div>
@endsection
