<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Edit Products </h2>
    </x-slot>

    <form method="POST" action="{{ route('products.update', $product) }}" class="p-6 space-y-4">
        @csrf
        @method('PUT')

        <input name="barcode" value="{{ $product->barcode }}" class="w-full border p-2">
        <input name="name" value="{{ $product->name }}" class="w-full border p-2">
        <input name="price" type="number" step="0.01" value="{{ $product->price }}" class="w-full border p-2">
        <input name="quantity" type="number" value="{{ $product->quantity }}" class="w-full border p-2">

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Update Product
        </button>
    </form>
</x-app-layout>
