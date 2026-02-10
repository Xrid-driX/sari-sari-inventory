<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- BACK BUTTON -->
            <div class="mb-6">
                <a href="{{ route('products.index') }}" class="inline-flex items-center text-gray-600 hover:text-purple-600 dark:text-gray-400 dark:hover:text-purple-400 transition-colors duration-200">
                    <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
                    <span class="font-medium">Back to Inventory</span>
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-8 text-gray-900 dark:text-gray-100">

                    <div class="mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
                        <h3 class="text-2xl font-bold text-purple-700 dark:text-purple-400">Product Details</h3>
                        <p class="text-sm text-gray-500">Enter the information for the new item.</p>
                    </div>

                    <form action="{{ route('products.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Barcode Input -->
                        <div>
                            <x-input-label for="barcode" :value="__('Barcode')" />
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i data-lucide="scan-barcode" class="h-5 w-5 text-gray-400"></i>
                                </div>
                                <x-text-input id="barcode" name="barcode" type="text" class="block w-full pl-10 border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-lg shadow-sm" :value="old('barcode')" required autofocus placeholder="Scan or type barcode" />
                            </div>
                            <x-input-error :messages="$errors->get('barcode')" class="mt-2" />
                        </div>

                        <!-- Name Input -->
                        <div>
                            <x-input-label for="name" :value="__('Product Name')" />
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i data-lucide="package" class="h-5 w-5 text-gray-400"></i>
                                </div>
                                <x-text-input id="name" name="name" type="text" class="block w-full pl-10 border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-lg shadow-sm" :value="old('name')" required placeholder="e.g. Coca-Cola 1.5L" />
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Price Input -->
                            <div>
                                <x-input-label for="price" :value="__('Price (₱)')" />
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 font-bold">₱</span>
                                    </div>
                                    <x-text-input id="price" name="price" type="number" step="0.01" class="block w-full pl-8 border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-lg shadow-sm" :value="old('price')" required placeholder="0.00" />
                                </div>
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            <!-- Quantity Input -->
                            <div>
                                <x-input-label for="quantity" :value="__('Quantity (Stock)')" />
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i data-lucide="layers" class="h-5 w-5 text-gray-400"></i>
                                    </div>
                                    <x-text-input id="quantity" name="quantity" type="number" class="block w-full pl-10 border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-lg shadow-sm" :value="old('quantity')" required placeholder="0" />
                                </div>
                                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('products.index') }}" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 mr-4">
                                Cancel
                            </a>
                            <x-primary-button class="bg-purple-600 hover:bg-purple-700">
                                {{ __('Save Product') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Load Lucide Icons Script -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        // Initialize icons
        lucide.createIcons();
    </script>
</x-app-layout>
