@extends('layouts.app')

@section('title', 'Nouvelle Facture')

@section('content')
<div class="mb-6">
    <a href="{{ route('invoices.index') }}" class="text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors">&larr; Retour aux factures</a>
</div>

<form action="{{ route('invoices.store') }}" method="POST" id="invoice-form">
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
                    <button type="button" onclick="addInvoiceRow()" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 flex items-center transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Ajouter une ligne
                    </button>
                </div>
                
                <div class="p-6">
                    <div class="space-y-4" id="invoice-items-container">
                        <!-- JavaScript will inject rows here -->
                    </div>
                    
                    <div class="mt-8 pt-6 border-t border-slate-200 flex justify-end">
                        <div class="w-full sm:w-64 bg-slate-50 rounded-lg p-4 border border-slate-200">
                            <div class="flex justify-between items-center text-lg">
                                <span class="font-medium text-slate-500">Total TTC:</span>
                                <span class="font-bold text-indigo-600" id="grand-total-display">0.00 DH</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    const products = @json($products);
    let rowCount = 0;

    function buildProductOptions() {
        // Group products by category
        const groups = {};
        products.forEach(p => {
            const cat = p.category || 'Autre';
            if (!groups[cat]) groups[cat] = [];
            groups[cat].push(p);
        });

        let html = '<option value="">Sélectionnez un produit...</option>';
        Object.keys(groups).sort().forEach(cat => {
            html += `<optgroup label="${cat}">`;
            groups[cat].forEach(p => {
                const label = p.size ? `${p.name} — ${p.size}` : p.name;
                html += `<option value="${p.id}" data-price="${p.price}">${label}</option>`;
            });
            html += '</optgroup>';
        });
        return html;
    }

    function addInvoiceRow() {
        const container = document.getElementById('invoice-items-container');
        const index = rowCount++;
        
        const productOptions = buildProductOptions();

        const rowHtml = `
            <div class="flex flex-col sm:flex-row items-start gap-4 p-4 rounded-xl bg-slate-50/50 border border-slate-200 transition-colors hover:border-slate-300 invoice-row" id="row-${index}">
                <div class="flex-1 w-full">
                    <label class="block text-xs font-semibold tracking-wide text-slate-500 uppercase mb-1">Produit</label>
                    <select name="items[${index}][product_id]" onchange="updateRow(${index})" id="product-${index}" required
                        class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border bg-white">
                        ${productOptions}
                    </select>
                </div>
                
                <div class="w-full sm:w-24">
                    <label class="block text-xs font-semibold tracking-wide text-slate-500 uppercase mb-1">Prix U.</label>
                    <div class="block w-full rounded-lg border border-slate-200 bg-slate-100 sm:text-sm p-2.5 text-slate-500 text-right" id="price-${index}">0.00</div>
                </div>

                <div class="w-full sm:w-24">
                    <label class="block text-xs font-semibold tracking-wide text-slate-500 uppercase mb-1">Qté</label>
                    <input type="number" name="items[${index}][quantity]" id="qty-${index}" min="1" value="1" oninput="updateRow(${index})" required
                        class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border bg-white text-center">
                </div>
                
                <div class="w-full sm:w-32">
                    <label class="block text-xs font-semibold tracking-wide text-slate-500 uppercase mb-1">Total</label>
                    <div class="block w-full rounded-lg border border-transparent sm:text-sm py-2.5 font-bold text-slate-900 text-right subtotal-display" id="subtotal-${index}" data-value="0">0.00 DH</div>
                </div>

                <div class="pt-6 sm:pl-2">
                    <button type="button" onclick="removeRow(${index})" class="text-slate-400 hover:text-red-600 transition-colors delete-btn" title="Supprimer la ligne">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', rowHtml);
        updateDeleteButtons();
    }

    function removeRow(index) {
        const row = document.getElementById(`row-${index}`);
        if (row) {
            row.remove();
            updateGrandTotal();
            updateDeleteButtons();
        }
    }

    function updateRow(index) {
        const select = document.getElementById(`product-${index}`);
        const qtyInput = document.getElementById(`qty-${index}`);
        const priceDisplay = document.getElementById(`price-${index}`);
        const subtotalDisplay = document.getElementById(`subtotal-${index}`);

        if (!select || !qtyInput || !priceDisplay || !subtotalDisplay) return;

        const selectedOption = select.options[select.selectedIndex];
        let price = 0;
        
        if (selectedOption && selectedOption.value) {
            price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
        }

        const qty = parseInt(qtyInput.value) || 0;
        const subtotal = price * qty;

        priceDisplay.textContent = price.toFixed(2);
        subtotalDisplay.textContent = subtotal.toFixed(2) + ' DH';
        subtotalDisplay.setAttribute('data-value', subtotal);

        updateGrandTotal();
    }

    function updateGrandTotal() {
        let total = 0;
        document.querySelectorAll('.subtotal-display').forEach(el => {
            total += parseFloat(el.getAttribute('data-value')) || 0;
        });
        document.getElementById('grand-total-display').textContent = total.toFixed(2) + ' DH';
    }

    function updateDeleteButtons() {
        const rows = document.querySelectorAll('.invoice-row');
        const deleteBtns = document.querySelectorAll('.delete-btn');
        if (rows.length <= 1) {
            deleteBtns.forEach(btn => btn.style.display = 'none');
        } else {
            deleteBtns.forEach(btn => btn.style.display = 'block');
        }
    }

    // Use turbo:load instead of DOMContentLoaded so the form
    // initializes correctly after Turbo navigation (not just on first page load)
    document.addEventListener('turbo:load', () => {
        const container = document.getElementById('invoice-items-container');
        if (container && container.children.length === 0) {
            rowCount = 0;
            addInvoiceRow();
        }
    });
</script>
@endsection
