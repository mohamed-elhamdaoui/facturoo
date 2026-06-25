@extends('layouts.app')

@section('title', 'Gestion des Clients')

@section('content')
<div x-data="{ openDeleteModal: false, deleteUrl: '' }">
    <!-- Header & Search -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-semibold text-slate-800">Clients</h2>
            <p class="text-sm text-slate-500 mt-1">Gérez votre carnet de clients.</p>
        </div>
        
        <div class="flex items-center gap-4 w-full sm:w-auto">
            <!-- Search Bar -->
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" id="searchInput" placeholder="Rechercher un client..." class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg leading-5 bg-white placeholder-slate-500 focus:outline-none focus:placeholder-slate-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-150 ease-in-out">
            </div>
            
            <a href="{{ route('clients.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors whitespace-nowrap">
                <svg class="w-5 h-5 mr-2 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nouveau Client
            </a>
        </div>
    </div>

    <!-- Clients Table -->
    <div class="bg-white shadow-sm border border-slate-200 rounded-xl overflow-hidden" id="clientsContainer">
        @if($clients->isEmpty())
            <div class="text-center py-16">
                <svg class="mx-auto h-16 w-16 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <h3 class="text-lg font-semibold text-slate-900">Aucun client</h3>
                <p class="mt-2 text-sm text-slate-500 max-w-sm mx-auto">Vous n'avez pas encore enregistré de clients. Commencez à ajouter des clients pour vos factures.</p>
                <div class="mt-6">
                    <a href="{{ route('clients.create') }}" class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition-colors">
                        <svg class="-ml-0.5 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Ajouter mon premier client
                    </a>
                </div>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Client</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Téléphone</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Factures</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @foreach($clients as $client)
                            <tr class="client-row hover:bg-slate-50/80 transition-colors" data-name="{{ strtolower($client->name) }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="h-9 w-9 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-sm flex-shrink-0">
                                            {{ strtoupper(substr($client->name, 0, 1)) }}
                                        </div>
                                        <div class="text-sm font-semibold text-slate-900">{{ $client->name }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-600">{{ $client->phone ?? '—' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                                        {{ $client->invoices_count }} facture(s)
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('clients.edit', $client) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 p-2.5 rounded-lg transition-colors border border-indigo-100" title="Modifier">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </a>
                                        <button type="button"
                                                x-on:click="deleteUrl = '{{ route('clients.destroy', $client) }}'; openDeleteModal = true"
                                                class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2.5 rounded-lg transition-colors border border-red-100"
                                                title="Supprimer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Empty Filter State -->
        <div id="emptyFilterState" style="display: none;" class="text-center py-12 border-t border-slate-100">
            <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <h3 class="mt-4 text-sm font-semibold text-slate-900">Aucun client trouvé</h3>
            <p class="mt-1 text-sm text-slate-500">Essayez de modifier vos termes de recherche.</p>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-cloak
         x-show="openDeleteModal"
         x-transition:enter="ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">

        <div x-show="openDeleteModal"
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             x-on:click.outside="openDeleteModal = false"
             class="relative w-full bg-white rounded-2xl p-6 shadow-2xl border border-slate-100" style="max-width: 540px;">

            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 bg-red-100 text-red-600 rounded-full p-2.5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Supprimer le client</h3>
                    <p class="text-sm text-slate-500 mt-1">Êtes-vous sûr de vouloir supprimer ce client ? Cette action est irréversible et impossible si des factures y sont associées.</p>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-3">
                <button type="button"
                        x-on:click="openDeleteModal = false"
                        class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">
                    Annuler
                </button>
                <form :action="deleteUrl" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            style="background-color:#dc2626;color:#ffffff;"
                            class="px-4 py-2 text-sm font-medium rounded-lg transition-colors hover:opacity-90">
                        Confirmer la suppression
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    const searchInput = document.getElementById('searchInput');
    const rows = document.querySelectorAll('.client-row');
    const emptyState = document.getElementById('emptyFilterState');

    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase().trim();
            let visibleCount = 0;

            rows.forEach(row => {
                const name = row.getAttribute('data-name') || '';
                if (name.includes(searchTerm)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (visibleCount === 0 && rows.length > 0) {
                emptyState.style.display = '';
            } else {
                emptyState.style.display = 'none';
            }
        });
    }

    const cleanup = function() {
        if (searchInput) searchInput.value = '';
        document.removeEventListener('turbo:before-cache', cleanup);
    };
    document.addEventListener('turbo:before-cache', cleanup);
})();
</script>
@endsection
