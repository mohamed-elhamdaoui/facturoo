@extends('layouts.app')

@section('title', 'Products Management')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <p class="text-gray-500">Manage your catalog of products.</p>
    <a href="{{ route('products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-medium transition shadow-sm">
        + Add New Product
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100 text-sm text-gray-500 uppercase tracking-wider">
                <th class="p-4 font-medium">Image</th>
                <th class="p-4 font-medium">Name</th>
                <th class="p-4 font-medium">Price</th>
                <th class="p-4 font-medium text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($products as $product)
            <tr class="hover:bg-gray-50 transition">
                <td class="p-4">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-12 h-12 rounded-lg object-cover border">
                    @else
                        <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 border border-gray-200">
                            No Img
                        </div>
                    @endif
                </td>
                <td class="p-4 font-medium text-gray-800">{{ $product->name }}</td>
                <td class="p-4 text-gray-600">{{ number_format($product->price, 2) }} DH</td>
                <td class="p-4 text-right space-x-2">
                    <a href="{{ route('products.edit', $product) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Edit</a>
                    
                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this product?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="p-8 text-center text-gray-400">
                    No products found. Start by adding one!
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $products->links() }}
</div>
@endsection
