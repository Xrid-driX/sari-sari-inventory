<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Sales Report</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">

            <div class="mb-4 grid grid-cols-2 gap-4">
                <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded">
                    <h3 class="text-sm">Total Items Sold</h3>
                    <p class="text-2xl font-bold">{{ $totalItemsSold }}</p>
                </div>

                <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded">
                    <h3 class="text-sm">Total Revenue</h3>
                    <p class="text-2xl font-bold">₱{{ number_format($totalRevenue, 2) }}</p>
                </div>
            </div>

            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="text-left p-2">Product</th>
                        <th class="text-left p-2">Qty</th>
                        <th class="text-left p-2">Total</th>
                        <th class="text-left p-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales as $sale)
                        <tr class="border-b">
                            <td class="p-2">{{ $sale->product->name ?? 'Deleted Product' }}</td>
                            <td class="p-2">{{ $sale->quantity }}</td>
                            <td class="p-2">₱{{ number_format($sale->total, 2) }}</td>
                            <td class="p-2">{{ $sale->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>
