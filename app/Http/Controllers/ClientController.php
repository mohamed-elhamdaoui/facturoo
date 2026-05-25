<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Client;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::withCount('invoices')->orderBy('name')->get();
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
        ]);

        $client = Client::create($validated);

        if ($request->expectsJson()) {
            return response()->json($client, 201);
        }

        return redirect()->route('clients.index')->with('success', 'Client créé avec succès.');
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
        ]);

        $client->update($validated);

        return redirect()->route('clients.index')->with('success', 'Client mis à jour avec succès.');
    }

    public function destroy(Client $client)
    {
        if ($client->invoices()->exists()) {
            return redirect()->route('clients.index')->with('error', 'Ce client ne peut pas être supprimé car il possède déjà des factures associées.');
        }

        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Client supprimé avec succès.');
    }

    public function search(Request $request)
    {
        $q = $request->query('q');

        $clients = Client::where('name', 'like', "%{$q}%")
            ->orWhere('phone', 'like', "%{$q}%")
            ->orderBy('name')
            ->limit(10)
            ->get();

        return response()->json($clients);
    }
}
