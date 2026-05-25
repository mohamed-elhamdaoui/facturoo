@extends('layouts.app')

@section('title', 'Gestion des Produits')

@section('content')
<div>
    <!-- Header & Search -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-semibold text-slate-800">Produits</h2>
            <p class="text-sm text-slate-500 mt-1">Gérez votre catalogue de produits et services.</p>
        </div>
        
        <div class="flex items-center gap-4 w-full sm:w-auto">
            <!-- Search Bar -->
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" id="searchInput" placeholder="Rechercher (nom, catégorie...)" class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg leading-5 bg-white placeholder-slate-500 focus:outline-none focus:placeholder-slate-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-150 ease-in-out">
            </div>
            
            <a href="{{ route('products.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors whitespace-nowrap">
                <svg class="w-5 h-5 mr-2 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nouveau
            </a>
        </div>
    </div>

    <!-- Category Tabs -->
    <div class="mb-8 flex flex-wrap gap-2" id="categoryTabs">
        @foreach(['Tous', ...\App\Enums\ProductCategory::values()] as $tab)
            <button class="filter-tab flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-full border transition-all duration-200 {{ $loop->first ? 'bg-indigo-100 text-indigo-700 border-indigo-200 shadow-sm active-tab' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}"
                    data-tab="{{ $tab }}">
                <span>{{ $tab }}</span>
                @if($tab === 'Tous')
                    <span class="inline-flex items-center justify-center px-2 py-0.5 rounded-full text-xs font-bold bg-slate-900/10 opacity-80">{{ $products->count() }}</span>
                @endif
            </button>
        @endforeach
    </div>

    @php
        $groups = array_fill_keys(\App\Enums\ProductCategory::values(), []);
        foreach($products as $p) {
            $cat = $p->category && array_key_exists($p->category, $groups) ? $p->category : array_key_first($groups);
            $groups[$cat][] = $p;
        }
    @endphp

    <!-- Products Display -->
    <div class="space-y-8" id="productsContainer">
        @foreach($groups as $category => $items)
            <div class="category-group transition-opacity" data-group="{{ $category }}" {!! count($items) == 0 ? 'style="display: none;"' : '' !!}>
                <div class="flex items-center gap-3 mb-4">
                    <h3 class="text-lg font-semibold text-slate-900">{{ $category }}</h3>
                    <span class="category-count inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">{{ count($items) }}</span>
                </div>
                
                <div class="bg-white shadow-sm border border-slate-200 rounded-xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Produit</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Prix</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Stock</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider w-full">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                @foreach($items as $product)
                                    <tr class="product-row hover:bg-slate-50/80 transition-colors" 
                                        data-category="{{ $category }}" 
                                        data-name="{{ strtolower($product->name ?? '') }}">
                                        
                                        <td class="px-6 py-3 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-16 w-16 overflow-hidden rounded-lg border border-slate-200 shadow-sm bg-slate-50 relative group">
                                                    @if($product->image)
                                                        <img class="h-16 w-16 object-cover group-hover:scale-110 transition-transform duration-300 cursor-zoom-in" src="{{ $product->image_url }}" alt="" onclick="openImageModal('{{ $product->image_url }}', '{{ addslashes($product->name) }}')">
                                                        <div class="absolute inset-0 bg-slate-900/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center pointer-events-none">
                                                            <svg class="w-5 h-5 text-white drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"></path></svg>
                                                        </div>
                                                    @else
                                                        <div class="h-16 w-16 bg-slate-100 flex items-center justify-center border border-slate-200 text-slate-400">
                                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-semibold text-slate-900 leading-tight">{{ $product->name }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-left text-sm">
                                            <span class="text-indigo-600 font-bold">{{ number_format($product->price, 2) }} DH</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-left text-sm">
                                            @if($product->stock_status === 'out')
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold" style="background:#fee2e2;color:#b91c1c;">
                                                    <span style="width:7px;height:7px;border-radius:50%;background:#ef4444;display:inline-block;"></span>
                                                    Rupture (0)
                                                </span>
                                            @elseif($product->stock_status === 'low')
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold" style="background:#ffedd5;color:#c2410c;">
                                                    <span style="width:7px;height:7px;border-radius:50%;background:#f97316;display:inline-block;"></span>
                                                    Faible ({{ $product->stock_quantity }})
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold" style="background:#dcfce7;color:#15803d;">
                                                    <span style="width:7px;height:7px;border-radius:50%;background:#22c55e;display:inline-block;"></span>
                                                    {{ $product->stock_quantity }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 p-2 rounded-lg transition-colors border border-indigo-100" title="Modifier">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                </a>
                                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ? Cette action est irréversible.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors border border-red-100" title="Supprimer">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Empty State (When Filter yields 0 results) -->
        <div id="emptyFilterState" style="display: none;" class="text-center py-12 bg-white rounded-xl shadow-sm border border-slate-200">
            <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <h3 class="mt-4 text-sm font-semibold text-slate-900">Aucun produit trouvé</h3>
            <p class="mt-1 text-sm text-slate-500">Essayez de modifier vos termes de recherche ou de changer de catégorie.</p>
            <button id="resetFiltersBtn" class="mt-4 text-sm text-indigo-600 hover:text-indigo-800 font-medium">Réinitialiser les filtres</button>
        </div>
        
        <!-- Empty State (When DB is completely empty) -->
        @if($products->isEmpty())
        <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-slate-200">
            <svg class="mx-auto h-16 w-16 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            <h3 class="text-lg font-semibold text-slate-900">Catalogue vide</h3>
            <p class="mt-2 text-sm text-slate-500 max-w-sm mx-auto">Vous n'avez pas encore ajouté de produits. Commencez à créer votre catalogue pour générer vos premières factures.</p>
            <div class="mt-6">
                <a href="{{ route('products.create') }}" class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition-colors">
                    <svg class="-ml-0.5 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Ajouter mon premier produit
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Image Preview Modal -->
<div id="imagePreviewModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-300 opacity-0" onclick="closeImageModal()">
    <div class="relative max-w-2xl w-full bg-white rounded-2xl overflow-hidden shadow-2xl border border-slate-100 transform scale-95 transition-transform duration-300" onclick="event.stopPropagation()">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <h3 id="imageModalTitle" class="font-bold text-slate-800 text-lg">Prévisualisation de l'image</h3>
            <button onclick="closeImageModal()" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <!-- Body -->
        <div class="p-6 flex items-center justify-center bg-white">
            <img id="imageModalTarget" class="max-h-[60vh] max-w-full rounded-lg object-contain shadow-md border border-slate-200" src="" alt="">
        </div>
    </div>
</div>

<script>
document.addEventListener('turbo:load', function() {
    const searchInput = document.getElementById('searchInput');
    const tabs = document.querySelectorAll('.filter-tab');
    const rows = document.querySelectorAll('.product-row');
    const groups = document.querySelectorAll('.category-group');
    const emptyState = document.getElementById('emptyFilterState');
    
    let activeCategory = 'Tous';
    let searchTerm = '';

    function filterProducts() {
        let totalVisible = 0;
        
        // Reset counts dynamically from enum
        const categoryKeys = @json(\App\Enums\ProductCategory::values());
        let groupCounts = {};
        categoryKeys.forEach(k => groupCounts[k] = 0);

        rows.forEach(row => {
            const cat = row.getAttribute('data-category');
            const name = row.getAttribute('data-name') || '';
            
            let matchCat = (activeCategory === 'Tous' || cat === activeCategory);
            let matchSearch = true;
            
            if (searchTerm !== '') {
                matchSearch = name.includes(searchTerm) || cat.toLowerCase().includes(searchTerm);
            }
            
            if (matchCat && matchSearch) {
                row.style.display = '';
                if(groupCounts[cat] !== undefined) {
                    groupCounts[cat]++;
                }
                totalVisible++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update groups visibility and counts
        groups.forEach(group => {
            const cat = group.getAttribute('data-group');
            const count = groupCounts[cat] || 0;
            
            if (count > 0) {
                group.style.display = '';
                const countBadge = group.querySelector('.category-count');
                if(countBadge) countBadge.textContent = count;
            } else {
                group.style.display = 'none';
            }
        });

        // Toggle empty state if we have rows but none are visible
        if (totalVisible === 0 && rows.length > 0) {
            emptyState.style.display = '';
        } else {
            emptyState.style.display = 'none';
        }
    }

    if(searchInput) {
        searchInput.addEventListener('input', function(e) {
            searchTerm = e.target.value.toLowerCase().trim();
            filterProducts();
        });
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Update active styling
            tabs.forEach(t => {
                t.classList.remove('bg-indigo-100', 'text-indigo-700', 'border-indigo-200', 'shadow-sm', 'active-tab');
                t.classList.add('bg-white', 'text-slate-600', 'border-slate-200', 'hover:bg-slate-50');
            });
            
            this.classList.remove('bg-white', 'text-slate-600', 'border-slate-200', 'hover:bg-slate-50');
            this.classList.add('bg-indigo-100', 'text-indigo-700', 'border-indigo-200', 'shadow-sm', 'active-tab');
            
            activeCategory = this.getAttribute('data-tab');
            filterProducts();
        });
    });
    
    // Add reset functionality
    const resetBtn = document.getElementById('resetFiltersBtn');
    if(resetBtn) {
        resetBtn.addEventListener('click', function() {
            searchInput.value = '';
            searchTerm = '';
            const allTab = document.querySelector('.filter-tab[data-tab="Tous"]');
            if(allTab) allTab.click();
        });
    }
});

// Clean up event listeners when Turbo caches the page,
// preventing duplicate listeners on back-navigation
document.addEventListener('turbo:before-cache', function() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) searchInput.value = '';
});

function openImageModal(url, name) {
    const modal = document.getElementById('imagePreviewModal');
    const img = document.getElementById('imageModalTarget');
    const title = document.getElementById('imageModalTitle');
    
    if (!modal || !img) return;
    
    img.src = url;
    if (title) {
        title.textContent = name || "Prévisualisation de l'image";
    }
    
    modal.classList.remove('hidden');
    // Force reflow
    modal.offsetHeight;
    modal.classList.add('flex');
    modal.classList.remove('opacity-0');
    modal.classList.add('opacity-100');
    modal.querySelector('.transform').classList.remove('scale-95');
    modal.querySelector('.transform').classList.add('scale-100');
}

function closeImageModal() {
    const modal = document.getElementById('imagePreviewModal');
    if (!modal || modal.classList.contains('hidden')) return;
    
    modal.classList.remove('opacity-100');
    modal.classList.add('opacity-0');
    modal.querySelector('.transform').classList.remove('scale-100');
    modal.querySelector('.transform').classList.add('scale-95');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}
</script>
@endsection
