<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Products</h2>
    </x-slot>

    <div class="p-6">
        <a href="{{ route('products.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded">
            + Add Product
        </a>

        <table class="w-full mt-4 border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2">Barcode</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr class="border-t">
                    <td class="p-2 text-white">{{ $product->barcode }}</td>
                    <td class="p-2 text-white">{{ $product->name }}</td>
                    <td class="p-2 text-white">₱ {{ $product->price }}</td>
                    <td class="p-2 text-white">{{ $product->quantity }}</td>
                    <td class="space-x-2">
                        <a href="{{ route('products.edit', $product) }}"
                           class="text-white-600">Edit</a>

                        <form action="{{ route('products.destroy', $product) }}"
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600"
                                    onclick="return confirm('Delete product?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
