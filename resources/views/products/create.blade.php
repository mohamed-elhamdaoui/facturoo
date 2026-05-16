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
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-medium text-slate-700">Catégorie</label>
                <select id="category" name="category" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border @error('category') border-red-500 @enderror">
                    <option value="Couscous" {{ old('category') == 'Couscous' ? 'selected' : '' }}>Couscous</option>
                    <option value="Farine" {{ old('category') == 'Farine' ? 'selected' : '' }}>Farine</option>
                    <option value="Cheveux d'Ange" {{ old('category') == "Cheveux d'Ange" ? 'selected' : '' }}>Cheveux d'Ange</option>
                    <option value="Semoule" {{ old('category') == 'Semoule' ? 'selected' : '' }}>Semoule</option>
                    <option value="Pâtes vrac" {{ old('category') == 'Pâtes vrac' ? 'selected' : '' }}>Pâtes vrac</option>
                    <option value="Pâtes ptc" {{ old('category') == 'Pâtes ptc' ? 'selected' : '' }}>Pâtes ptc</option>
                </select>
                @error('category')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Size -->
            <div>
                <label for="size" class="block text-sm font-medium text-slate-700">Taille / Poids</label>
                <select id="size" name="size" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border @error('size') border-red-500 @enderror">
                    <option value="" {{ old('size') == '' ? 'selected' : '' }}>Sélectionner une taille...</option>
                    <option value="500g" {{ old('size') == '500g' ? 'selected' : '' }}>500g</option>
                    <option value="750g" {{ old('size') == '750g' ? 'selected' : '' }}>750g</option>
                    <option value="1kg" {{ old('size') == '1kg' ? 'selected' : '' }}>1kg</option>
                    <option value="5kg" {{ old('size') == '5kg' ? 'selected' : '' }}>5kg</option>
                    <option value="10kg" {{ old('size') == '10kg' ? 'selected' : '' }}>10kg</option>
                    <option value="25kg" {{ old('size') == '25kg' ? 'selected' : '' }}>25kg</option>
                </select>
                @error('size')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
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
