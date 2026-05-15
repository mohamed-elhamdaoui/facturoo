@extends('layouts.app')

@section('title', 'Create New Invoice')

@section('content')
<div class="max-w-4xl bg-white rounded-xl shadow-sm border border-gray-100 p-8" x-data="invoiceForm()">
    <form action="{{ route('invoices.store') }}" method="POST">
        @csrf

        <!-- Customer Information -->
        <div class="mb-8 pb-6 border-b border-gray-100">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Customer Details</h3>
            <div>
                <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Customer Name *</label>
                <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required
                    class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition @error('customer_name') border-red-500 @enderror">
                @error('customer_name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Invoice Items -->
        <div class="mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-800">Products</h3>
                <button type="button" @click="addItem()" class="text-sm text-blue-600 hover:text-blue-800 font-medium">+ Add Row</button>
            </div>

            <div class="bg-gray-50 rounded-lg border border-gray-200 overflow-hidden">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-gray-200 text-sm text-gray-500">
                            <th class="p-3 font-medium w-1/2">Product</th>
                            <th class="p-3 font-medium w-1/6">Price</th>
                            <th class="p-3 font-medium w-1/6">Qty</th>
                            <th class="p-3 font-medium w-1/6 text-right">Subtotal</th>
                            <th class="p-3 w-10"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <template x-for="(item, index) in items" :key="index">
                            <tr>
                                <td class="p-3">
                                    <select x-model="item.product_id" :name="'items['+index+'][product_id]'" @change="updateSubtotal(item)" required
                                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                                        <option value="">Select a product...</option>
                                        <template x-for="product in products" :key="product.id">
                                            <option :value="product.id" x-text="product.name"></option>
                                        </template>
                                    </select>
                                </td>
                                <td class="p-3 text-gray-600" x-text="'$' + item.price.toFixed(2)"></td>
                                <td class="p-3">
                                    <input type="number" x-model.number="item.quantity" :name="'items['+index+'][quantity]'" min="1" @input="updateSubtotal(item)" required
                                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                                </td>
                                <td class="p-3 text-right font-medium text-gray-800" x-text="'$' + item.subtotal.toFixed(2)"></td>
                                <td class="p-3 text-center">
                                    <button type="button" @click="removeItem(index)" x-show="items.length > 1" class="text-red-500 hover:text-red-700" title="Remove">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                          <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Grand Total -->
            <div class="mt-4 flex justify-end">
                <div class="w-1/3 bg-gray-50 rounded-lg border border-gray-200 p-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 font-medium">Grand Total:</span>
                        <span class="text-2xl font-bold text-gray-800" x-text="'$' + grandTotal.toFixed(2)"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center space-x-4 pt-6 border-t border-gray-100">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-medium transition shadow-sm w-full md:w-auto">
                Generate Invoice
            </button>
            <a href="{{ route('invoices.index') }}" class="text-gray-500 hover:text-gray-700 font-medium">Cancel</a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('invoiceForm', () => ({
            products: @json($products),
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
        }));
    });
</script>
@endsection
