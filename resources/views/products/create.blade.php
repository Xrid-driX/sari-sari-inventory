<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold"> Add product </h2>
    </x-slot>

    <form method="POST" action="{{ route('products.store') }}" class="p-6 space-y-4">
        @csrf

        <input name="barcode" placeholder="Barcode" class="w-full border p-2">
        <input name="name" placeholder="Product Name" class="w-full border p-2">
        <input name="price" type="number" step="0.01" placeholder="Price" class="w-full border p-2">
        <input name="quantity" type="number" placeholder="Quantity" class="w-full border p-2">

        <button class="bg-green-600 text-white px-4 py-2 rounded">
            Save Product
        </button>
    </form>
</x-app-layout>
