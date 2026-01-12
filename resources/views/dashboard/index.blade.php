<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Dashboard</h2>
    </x-slot>

    <div class="p-6 grid grid-cols-3 gap-6">
        <div class="bg-white p-4 rounded shadow">
            <h3>Total Products</h3>
            <p class="text-3xl font-bold">{{ $totalProducts }}</p>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <h3>Low Stock Items</h3>
            <p class="text-3xl font-bold text-red-600">{{ $lowStock }}</p>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <h3>Today’s Sales</h3>
            <p class="text-3xl font-bold">₱ {{ $todaySales }}</p>
        </div>
    </div>
</x-app-layout>
