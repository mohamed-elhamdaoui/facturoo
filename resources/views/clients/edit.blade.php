@extends('layouts.app')

@section('title', 'Modifier le Client')

@section('content')
<div class="mb-6">
    <a href="{{ route('clients.index') }}" class="text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors">&larr; Retour aux clients</a>
</div>

<div class="max-w-xl mx-auto bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-200 bg-slate-50">
        <h3 class="text-lg font-semibold text-slate-900">Modifier le client</h3>
        <p class="mt-1 text-sm text-slate-500">Mettez à jour les informations de {{ $client->name }}.</p>
    </div>
    
    <form action="{{ route('clients.update', $client) }}" method="POST" class="p-6 space-y-6">
        @csrf
        @method('PUT')
        
        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-slate-700">Nom complet *</label>
            <input type="text" id="name" name="name" value="{{ old('name', $client->name) }}" required 
                class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border @error('name') border-red-500 @enderror"
                placeholder="Ex: Boutique Al Amal, Ahmed Bensalah">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Phone -->
        <div>
            <label for="phone" class="block text-sm font-medium text-slate-700">Téléphone <span class="text-slate-400 font-normal">(Optionnel)</span></label>
            <input type="text" id="phone" name="phone" value="{{ old('phone', $client->phone) }}" 
                class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border @error('phone') border-red-500 @enderror"
                placeholder="Ex: 0661234567">
            @error('phone')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="pt-5 border-t border-slate-200 flex justify-end gap-3">
            <a href="{{ route('clients.index') }}" class="inline-flex justify-center rounded-lg border border-slate-300 bg-white py-2 px-4 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                Annuler
            </a>
            <button type="submit" class="inline-flex justify-center rounded-lg border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                Mettre à jour le client
            </button>
        </div>
    </form>
</div>
@endsection
