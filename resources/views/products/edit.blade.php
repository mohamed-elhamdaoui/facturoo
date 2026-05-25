@extends('layouts.app')

@section('title', 'Modifier le Produit')

@section('content')
<div class="mb-6">
    <a href="{{ route('products.index') }}" class="text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors">&larr; Retour aux produits</a>
</div>

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-200 bg-slate-50">
        <h3 class="text-lg font-semibold text-slate-900">Modifier le produit</h3>
        <p class="mt-1 text-sm text-slate-500">Mettez à jour les informations de {{ $product->name }}.</p>
    </div>
    
    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
        @csrf
        @method('PUT')
        
        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-slate-700">Nom du produit *</label>
            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required 
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
                    @foreach(\App\Enums\ProductCategory::values() as $cat)
                        <option value="{{ $cat }}" {{ old('category', $product->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                @error('category')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            

        </div>
        
        <!-- Price -->
        <div>
            <label for="price" class="block text-sm font-medium text-slate-700">Prix (DH) *</label>
            <div class="relative mt-1 rounded-md shadow-sm">
                <input type="number" step="0.01" id="price" name="price" value="{{ old('price', $product->price) }}" required 
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
            
            <div class="mt-2 mb-3">
                <p class="text-xs text-slate-500 mb-1.5">Image actuelle / sélectionnée :</p>
                <div class="relative inline-block" id="imageWrapper">
                    @if($product->image)
                        <img id="imagePreviewTarget" src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-24 w-24 object-cover rounded-lg border border-slate-200 shadow-sm">
                    @else
                        <div id="imagePlaceholder" class="h-24 w-24 rounded-lg bg-slate-100 flex items-center justify-center border border-slate-200 text-slate-400">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    <button type="button" id="clearImageBtn" onclick="clearImageSelection()" class="absolute -top-2 -right-2 bg-red-100 hover:bg-red-200 text-red-700 hover:text-red-900 rounded-full p-1 border border-red-200 shadow transition-colors hidden" title="Annuler la nouvelle image">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>

            <input type="file" id="image" name="image" accept="image/*" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            <p class="mt-1.5 text-xs text-slate-400">Formats acceptés : JPEG, PNG, JPG, WEBP. Taille maximale autorisée : 2 Mo.</p>
            @error('image')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Stock -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="stock_quantity" class="block text-sm font-medium text-slate-700">Quantité en stock</label>
                <input type="number" min="0" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}"
                    class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border @error('stock_quantity') border-red-500 @enderror">
                <p class="mt-1 text-xs text-slate-400">Pour modifier le stock, utilisez la page <a href="{{ route('stock.create') }}" class="text-indigo-600 hover:underline">Entrée de stock</a>.</p>
                @error('stock_quantity')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="min_stock" class="block text-sm font-medium text-slate-700">Seuil d'alerte (min)</label>
                <input type="number" min="0" id="min_stock" name="min_stock" value="{{ old('min_stock', $product->min_stock) }}"
                    class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border @error('min_stock') border-red-500 @enderror">
                <p class="mt-1 text-xs text-slate-400">Alerte orange en dessous de ce seuil.</p>
                @error('min_stock')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="pt-5 mt-5 border-t border-slate-200 flex justify-end gap-3">
            <a href="{{ route('products.index') }}" class="inline-flex justify-center rounded-lg border border-slate-300 bg-white py-2 px-4 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                Annuler
            </a>
            <button type="submit" class="inline-flex justify-center rounded-lg border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                Mettre à jour
            </button>
        </div>
    </form>
</div>

<!-- Stock History -->
<div class="max-w-2xl mx-auto mt-8 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
        <div>
            <h3 class="text-base font-semibold text-slate-900">Historique des mouvements de stock</h3>
            <p class="mt-0.5 text-xs text-slate-500">Toutes les entrées et sorties de stock pour ce produit.</p>
        </div>
        <a href="{{ route('stock.create') }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white rounded-lg transition-colors" style="background-color:#4f46e5;">
            + Entrée de stock
        </a>
    </div>

    @if($product->stockMovements->isEmpty())
        <div class="text-center py-10">
            <svg class="mx-auto h-10 w-10 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <p class="text-sm text-slate-500">Aucun mouvement de stock enregistré.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Quantité</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Raison</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @foreach($product->stockMovements as $movement)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-3 text-sm text-slate-600 whitespace-nowrap">{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-3 whitespace-nowrap">
                                @if($movement->type === 'entrée')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold" style="background:#dcfce7;color:#15803d;">↑ Entrée</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold" style="background:#fee2e2;color:#b91c1c;">↓ Sortie</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-sm font-semibold text-slate-900 whitespace-nowrap">{{ $movement->quantity }}</td>
                            <td class="px-6 py-3 text-sm text-slate-500">{{ $movement->reason ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<script>
document.addEventListener('turbo:load', function() {
    const imageInput = document.getElementById('image');
    const previewTarget = document.getElementById('imagePreviewTarget');
    const imagePlaceholder = document.getElementById('imagePlaceholder');
    const clearBtn = document.getElementById('clearImageBtn');
    
    // Store initial source/placeholder state
    const hasInitialImage = @json($product->image ? true : false);
    const initialSrc = hasInitialImage && previewTarget ? previewTarget.src : '';
    
    if (imageInput) {
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                // Check max size (2048 KB = 2 MB)
                if (file.size > 2048 * 1024) {
                    alert("Attention : Ce fichier dépasse la taille maximale autorisée de 2 Mo.");
                    this.value = '';
                    resetToInitial();
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    let targetImg = document.getElementById('imagePreviewTarget');
                    if (targetImg) {
                        targetImg.src = e.target.result;
                        targetImg.classList.remove('hidden');
                    } else if (imagePlaceholder) {
                        // Create preview element dynamically
                        imagePlaceholder.classList.add('hidden');
                        const wrapper = document.getElementById('imageWrapper');
                        const img = document.createElement('img');
                        img.id = 'imagePreviewTarget';
                        img.className = 'h-24 w-24 object-cover rounded-lg border border-slate-200 shadow-sm';
                        img.src = e.target.result;
                        wrapper.insertBefore(img, clearBtn);
                    }
                    if (clearBtn) clearBtn.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            } else {
                resetToInitial();
            }
        });
    }

    function resetToInitial() {
        const dynamicImg = document.getElementById('imagePreviewTarget');
        if (hasInitialImage) {
            if (dynamicImg) {
                dynamicImg.src = initialSrc;
                dynamicImg.classList.remove('hidden');
            }
        } else {
            if (dynamicImg) dynamicImg.remove();
            if (imagePlaceholder) imagePlaceholder.classList.remove('hidden');
        }
        if (clearBtn) clearBtn.classList.add('hidden');
    }
});

function clearImageSelection() {
    const imageInput = document.getElementById('image');
    if (imageInput) {
        imageInput.value = '';
        // Trigger change event to trigger preview reset
        const event = new Event('change');
        imageInput.dispatchEvent(event);
    }
}
</script>
@endsection
