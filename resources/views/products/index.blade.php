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
                <input type="text" id="searchInput" placeholder="Rechercher (nom, taille...)" class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg leading-5 bg-white placeholder-slate-500 focus:outline-none focus:placeholder-slate-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-150 ease-in-out">
            </div>
            
            <a href="{{ route('products.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors whitespace-nowrap">
                <svg class="w-5 h-5 mr-2 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nouveau
            </a>
        </div>
    </div>

    <!-- Category Tabs -->
    <div class="mb-8 flex flex-wrap gap-2" id="categoryTabs">
        @foreach(['Tous', 'Couscous', 'Semoule & Farine', 'Pâtes', 'Autre'] as $tab)
            <button class="filter-tab px-4 py-2 text-sm font-medium rounded-full border transition-all duration-200 {{ $loop->first ? 'bg-indigo-100 text-indigo-700 border-indigo-200 shadow-sm active-tab' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}"
                    data-tab="{{ $tab }}">
                {{ $tab }}
            </button>
        @endforeach
    </div>

    @php
        $groups = [
            'Couscous' => [],
            'Semoule & Farine' => [],
            'Pâtes' => [],
            'Autre' => []
        ];
        foreach($products as $p) {
            $cat = $p->category && array_key_exists($p->category, $groups) ? $p->category : 'Autre';
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
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Taille</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Prix</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                @foreach($items as $product)
                                    <tr class="product-row hover:bg-slate-50/80 transition-colors" 
                                        data-category="{{ $category }}" 
                                        data-name="{{ strtolower($product->name ?? '') }}" 
                                        data-size="{{ strtolower($product->size ?? '') }}">
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    @if($product->image)
                                                        <img class="h-10 w-10 rounded-lg object-cover border border-slate-200 shadow-sm" src="{{ asset('storage/' . $product->image) }}" alt="">
                                                    @else
                                                        <div class="h-10 w-10 rounded-lg bg-slate-100 flex items-center justify-center border border-slate-200 text-slate-400">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-semibold text-slate-900">{{ $product->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($product->size)
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 border border-slate-200 text-slate-700 shadow-sm">{{ $product->size }}</span>
                                            @else
                                                <span class="text-xs text-slate-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                            <span class="text-indigo-600 font-bold">{{ number_format($product->price, 2) }} DH</span>
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
        
        // Reset counts
        let groupCounts = {
            'Couscous': 0,
            'Semoule & Farine': 0,
            'Pâtes': 0,
            'Autre': 0
        };

        rows.forEach(row => {
            const cat = row.getAttribute('data-category');
            const name = row.getAttribute('data-name') || '';
            const size = row.getAttribute('data-size') || '';
            
            let matchCat = (activeCategory === 'Tous' || cat === activeCategory);
            let matchSearch = true;
            
            if (searchTerm !== '') {
                matchSearch = name.includes(searchTerm) || cat.toLowerCase().includes(searchTerm) || size.includes(searchTerm);
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
</script>
@endsection
