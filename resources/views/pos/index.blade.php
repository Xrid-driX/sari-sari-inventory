<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Point of Sale') }}
            </h2>
            <div class="text-sm text-gray-500 dark:text-gray-400">
                <i data-lucide="clock" class="inline w-4 h-4 mr-1"></i>
                <span id="clock-display">{{ now()->format('l, F j, Y h:i A') }}</span>
            </div>
        </div>
    </x-slot>

    <!-- Main Content -->
    <div class="py-6 h-[calc(100vh-65px)] overflow-hidden">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-full">
            <div class="flex flex-col lg:flex-row gap-6 h-full">

                <!-- LEFT COLUMN: Product Catalog -->
                <div class="w-full lg:w-2/3 flex flex-col gap-4 h-full">

                    <!-- Search / Barcode Input -->
                    <div
                        class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 shrink-0">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="scan-barcode" class="h-5 w-5 text-gray-400"></i>
                            </div>
                            <!-- Added ID for Logic -->
                            <input type="text" id="barcodeInput"
                                class="block w-full pl-10 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-purple-500 focus:ring-purple-500 rounded-lg shadow-sm py-3"
                                placeholder="Scan barcode or type product name (Press Enter)..." autofocus>

                            <!-- Loading/Status Indicator -->
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <span id="scanMessage" class="text-sm font-medium mr-2"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Categories Filter -->
                    <div class="flex gap-2 overflow-x-auto pb-2 shrink-0 no-scrollbar">
                        <button
                            class="px-4 py-2 bg-purple-600 text-white rounded-full text-sm font-semibold shadow-md whitespace-nowrap">All
                            Items</button>
                        <button
                            class="px-4 py-2 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 rounded-full text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700 whitespace-nowrap">Beverages</button>
                        <button
                            class="px-4 py-2 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 rounded-full text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700 whitespace-nowrap">Snacks</button>
                        <button
                            class="px-4 py-2 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 rounded-full text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700 whitespace-nowrap">Canned
                            Goods</button>
                    </div>

                    <!-- Product Grid -->
                    <div class="flex-1 overflow-y-auto pr-2 pb-20">
                        @if ($products->count() > 0)
                            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                                @foreach ($products as $product)
                                    <!-- MODIFIED: onclick triggers openQuantityModal instead of addToCart directly -->
                                    <div onclick="openQuantityModal('{{ $product->barcode }}', '{{ addslashes($product->name) }}', {{ $product->price }})"
                                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md hover:border-purple-200 transition-all duration-200 group cursor-pointer h-full flex flex-col relative active:scale-95">

                                        <div class="p-4 flex-1">
                                            <div
                                                class="h-24 bg-gray-50 dark:bg-gray-700 rounded-lg mb-3 flex items-center justify-center group-hover:bg-purple-50 dark:group-hover:bg-purple-900/20 transition-colors">
                                                <i data-lucide="package"
                                                    class="h-10 w-10 text-gray-300 group-hover:text-purple-400"></i>
                                            </div>
                                            <h3
                                                class="font-semibold text-gray-800 dark:text-gray-200 line-clamp-2 leading-tight">
                                                {{ $product->name }}</h3>
                                            <p class="text-xs text-gray-500 mt-1 font-mono">{{ $product->barcode }}</p>
                                        </div>
                                        <div class="p-4 pt-0 mt-auto flex justify-between items-center">
                                            <span
                                                class="font-bold text-lg text-purple-600 dark:text-purple-400">₱{{ number_format($product->price, 2) }}</span>
                                            <button
                                                class="bg-gray-100 dark:bg-gray-700 hover:bg-purple-600 hover:text-white text-gray-600 dark:text-gray-300 p-2 rounded-lg transition-colors">
                                                <i data-lucide="plus" class="h-5 w-5"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center h-64 text-center">
                                <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-full mb-4">
                                    <i data-lucide="box" class="h-8 w-8 text-gray-400"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">No products found</h3>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Add items to your inventory to start
                                    selling.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- RIGHT COLUMN: Cart / Checkout -->
                <div
                    class="w-full lg:w-1/3 h-full flex flex-col bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">

                    <!-- Cart Header -->
                    <div
                        class="p-5 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 flex justify-between items-center">
                        <h3 class="font-bold text-lg text-gray-800 dark:text-white flex items-center">
                            <i data-lucide="shopping-cart" class="w-5 h-5 mr-2 text-purple-600"></i> Current Order
                        </h3>
                        <span
                            class="bg-purple-100 text-purple-700 text-xs font-bold px-2 py-1 rounded-full dark:bg-purple-900 dark:text-purple-200">
                            Items: <span id="totalItemsCount">0</span>
                        </span>
                    </div>

                    <!-- Cart Items List (Dynamic Content) -->
                    <div id="cartItemsContainer" class="flex-1 overflow-y-auto p-4 space-y-3">
                        <!-- Empty State Default -->
                        <div class="flex flex-col items-center justify-center h-full text-gray-400">
                            <i data-lucide="shopping-bag" class="h-12 w-12 mb-2 opacity-50"></i>
                            <p class="text-sm">Cart is empty</p>
                        </div>
                    </div>

                    <!-- Cart Footer -->
                    <div class="p-5 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between text-sm text-gray-500">
                                <span>Subtotal</span>
                                <span id="cartSubtotal">₱0.00</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-500">
                                <span>Tax (0%)</span>
                                <span>₱0.00</span>
                            </div>
                            <div
                                class="flex justify-between text-xl font-extrabold text-gray-900 dark:text-white mt-2 pt-2 border-t border-gray-200 dark:border-gray-700">
                                <span>Total</span>
                                <span id="cartTotal" class="text-purple-600 dark:text-purple-400">₱0.00</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <button onclick="clearCart()"
                                class="flex items-center justify-center py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-red-50 hover:text-red-600 dark:hover:bg-gray-700 transition-colors">
                                <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i> Clear
                            </button>
                            <button
                                class="flex items-center justify-center py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <i data-lucide="pause" class="w-4 h-4 mr-2"></i> Hold
                            </button>
                        </div>

                        <button onclick="alert('Transaction Finalized!')"
                            class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg hover:shadow-purple-500/30 transition-all duration-200 flex items-center justify-center text-lg">
                            Pay Now <i data-lucide="arrow-right" class="w-5 h-5 ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- QUANTITY MODAL -->
    <div id="quantityModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm" aria-hidden="true"
                onclick="closeQuantityModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full border border-gray-100 dark:border-gray-700">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-purple-100 dark:bg-purple-900/30 sm:mx-0 sm:h-10 sm:w-10">
                            <i data-lucide="layers" class="h-6 w-6 text-purple-600 dark:text-purple-400"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-bold text-gray-900 dark:text-white" id="modal-title">
                                Add Quantity
                            </h3>
                            <div class="mt-2">
                                <p id="modalProductName"
                                    class="text-sm text-gray-500 dark:text-gray-400 mb-4 font-medium">
                                    Product Name
                                </p>
                                <label for="quantityInput"
                                    class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide mb-2">Quantity</label>
                                <input type="number" id="quantityInput"
                                    class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-purple-500 focus:ring-purple-500 rounded-lg shadow-sm text-2xl font-bold text-center py-3"
                                    value="1" min="1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                    <button type="button" onclick="confirmQuantity()"
                        class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:w-auto sm:text-sm">
                        Confirm
                    </button>
                    <button type="button" onclick="closeQuantityModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        // Initialize Icons
        lucide.createIcons();

        // ---------------------------------------------------------
        // LOGIC INTEGRATION
        // ---------------------------------------------------------

        const barcodeInput = document.getElementById('barcodeInput');
        const scanMessage = document.getElementById('scanMessage');
        const cartItemsContainer = document.getElementById('cartItemsContainer');
        const cartTotalDisplay = document.getElementById('cartTotal');
        const cartSubtotalDisplay = document.getElementById('cartSubtotal');
        const totalItemsCountDisplay = document.getElementById('totalItemsCount');

        // Modal Elements
        const quantityModal = document.getElementById('quantityModal');
        const quantityInput = document.getElementById('quantityInput');
        const modalProductName = document.getElementById('modalProductName');
        let pendingProduct = null;

        // Ensure CSRF token exists
        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

        // Capture the correct route URL using Blade
        const scanRoute = "{{ route('pos.scan') }}";

        // State variables
        let currentCart = [];
        let grandTotal = 0;

        /**
         * Open Quantity Modal
         */
        function openQuantityModal(barcode, name, price) {
            pendingProduct = {
                barcode,
                name,
                price
            };
            modalProductName.textContent = name;
            quantityInput.value = 1; // Default to 1
            quantityModal.classList.remove('hidden');

            // Focus the input so user can type immediately
            setTimeout(() => {
                quantityInput.focus();
                quantityInput.select();
            }, 100);
        }

        function closeQuantityModal() {
            quantityModal.classList.add('hidden');
            pendingProduct = null;
            barcodeInput.focus(); // Return focus to scanner
        }

        function confirmQuantity() {
            if (!pendingProduct) return;

            const qty = parseInt(quantityInput.value);
            if (qty > 0) {
                addToCart(pendingProduct.barcode, pendingProduct.name, pendingProduct.price, qty);
                closeQuantityModal();
            } else {
                alert('Please enter a valid quantity');
            }
        }

        // Modal Input Key Listener
        quantityInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') confirmQuantity();
            if (e.key === 'Escape') closeQuantityModal();
        });

        /**
         * Add Item to Cart
         */
        function addToCart(barcode, name = null, price = null, quantity = 1) {
            // Ensure quantity is a number
            quantity = parseInt(quantity);
            if (isNaN(quantity) || quantity <= 0) quantity = 1;

            // Check if item exists
            const existingItem = currentCart.find(item => item.barcode === barcode);

            if (existingItem) {
                existingItem.quantity += quantity;
                existingItem.total = existingItem.quantity * existingItem.unitPrice;
            } else {
                const productName = name || 'Item ' + barcode.substring(0, 4);
                const productPrice = price !== null ? parseFloat(price) : 25.00;

                currentCart.push({
                    barcode: barcode,
                    name: productName,
                    quantity: quantity,
                    unitPrice: productPrice,
                    total: productPrice * quantity // Calc total based on qty
                });
            }
            updateCartUI();
        }

        /**
         * Removes or Decrements an item
         */
        function updateItemQuantity(barcode, change) {
            const itemIndex = currentCart.findIndex(item => item.barcode === barcode);
            if (itemIndex > -1) {
                const item = currentCart[itemIndex];
                item.quantity += change;

                if (item.quantity <= 0) {
                    currentCart.splice(itemIndex, 1);
                } else {
                    item.total = item.quantity * item.unitPrice;
                }
                updateCartUI();
            }
        }

        function clearCart() {
            if (confirm('Are you sure you want to clear the cart?')) {
                currentCart = [];
                updateCartUI();
            }
        }

        /**
         * Updates the UI based on state
         */
        function updateCartUI() {
            cartItemsContainer.innerHTML = '';
            grandTotal = 0;
            let totalCount = 0;

            if (currentCart.length === 0) {
                cartItemsContainer.innerHTML = `
                    <div class="flex flex-col items-center justify-center h-full text-gray-400">
                        <i data-lucide="shopping-bag" class="h-12 w-12 mb-2 opacity-50"></i>
                        <p class="text-sm">Cart is empty</p>
                    </div>`;
                cartTotalDisplay.textContent = '₱0.00';
                cartSubtotalDisplay.textContent = '₱0.00';
                totalItemsCountDisplay.textContent = '0';
                lucide.createIcons();
                return;
            }

            currentCart.forEach(item => {
                const el = document.createElement('div');
                el.className =
                    'flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group border border-transparent hover:border-purple-100 dark:hover:border-gray-600';

                el.innerHTML = `
                    <div class="h-10 w-10 bg-purple-100 dark:bg-purple-900/30 rounded-md flex items-center justify-center shrink-0 text-purple-600 dark:text-purple-400">
                        <i data-lucide="package" class="h-5 w-5"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-medium text-gray-900 dark:text-white truncate text-sm">${item.name}</h4>
                        <div class="text-xs text-gray-500">₱${item.unitPrice.toFixed(2)} x ${item.quantity}</div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-gray-900 dark:text-white text-sm">₱${item.total.toFixed(2)}</div>
                        <div class="flex items-center gap-2 mt-1 justify-end">
                            <button onclick="updateItemQuantity('${item.barcode}', -1)" class="text-gray-400 hover:text-red-500 transition-colors p-1">
                                <i data-lucide="minus-circle" class="h-4 w-4"></i>
                            </button>
                            <button onclick="updateItemQuantity('${item.barcode}', 1)" class="text-gray-400 hover:text-green-500 transition-colors p-1">
                                <i data-lucide="plus-circle" class="h-4 w-4"></i>
                            </button>
                        </div>
                    </div>
                `;
                cartItemsContainer.appendChild(el);

                grandTotal += item.total;
                totalCount += item.quantity;
            });

            cartTotalDisplay.textContent = `₱${grandTotal.toFixed(2)}`;
            cartSubtotalDisplay.textContent = `₱${grandTotal.toFixed(2)}`;
            totalItemsCountDisplay.textContent = totalCount;

            // Re-init icons for new elements
            lucide.createIcons();
        }

        /**
         * Handle AJAX Scan
         */
        async function handleScan(barcode) {
            if (!barcode) return;

            scanMessage.textContent = 'Scanning...';
            scanMessage.className = 'text-sm font-medium mr-2 text-yellow-600';

            try {
                const response = await fetch(scanRoute, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    // FIXED: Added quantity field based on new controller method
                    body: JSON.stringify({
                        barcode: barcode
                    })
                });

                const data = await response.json();
                console.log('Scan Response:', data); // Debug log

                if (data.success) {
                    scanMessage.textContent = 'Product Found!';
                    scanMessage.className = 'text-sm font-medium mr-2 text-green-600';


                    // Store product data for modal
                    pendingProduct = {
                        barcode: data.product.barcode,
                        name: data.product.name,
                        price: data.product.price,
                        currentStock: data.product.quantity // Store current stock for validation
                    };

                    // Open quantity modal with product data
                    openQuantityModal(
                        data.product.barcode,
                        data.product.name,
                        data.product.price
                    );

                } else {
                    scanMessage.textContent = data.message || 'Product not found';
                    scanMessage.className = 'text-sm font-medium mr-2 text-red-600';
                }

            } catch (error) {
                console.error('Scan Error:', error);
                scanMessage.textContent = 'Error';
                scanMessage.className = 'text-sm font-medium mr-2 text-red-600';
            }

            // Clear message after 2s
            setTimeout(() => {
                scanMessage.textContent = '';
            }, 2000);
        }

        async function confirmQuantity() {
            if (!pendingProduct) return;

            const qty = parseInt(quantityInput.value);
            if (qty <= 0) {
                alert('Please enter a valid quantity');
                return;
            }

            if (pendingProduct.currentStock < qty) {
                alert(`Insufficient stock! Only ${pendingProduct.currentStock} available.`);
                return;
            }

            try {
                // Call the DEDUCT endpoint with user's quantity
                const response = await fetch("{{ route('pos.deduct') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        barcode: pendingProduct.barcode,
                        quantity: qty // User's entered quantity
                    })
                });

                const data = await response.json();
                console.log('Deduction Response:', data); // Debug log

                if (data.success) {
                    // Add to cart
                    addToCart(pendingProduct.barcode, pendingProduct.name, pendingProduct.price, qty);
                    closeQuantityModal();

                    // Show success message
                    scanMessage.textContent = `${qty} item(s) sold`;
                    scanMessage.className = 'text-sm font-medium mr-2 text-green-600';
                    setTimeout(() => {
                        scanMessage.textContent = '';
                    }, 2000);
                } else {
                    alert('Error: ' + data.message);
                }
            } catch (error) {
                console.error('Deduction Error:', error);
                alert('Error processing sale');
            }
        }


        // Listener for Barcode Input
        barcodeInput.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                event.preventDefault();
                const barcode = barcodeInput.value.trim();
                if (barcode) {
                    handleScan(barcode);
                    barcodeInput.value = '';
                }
            }
        });
    </script>
</x-app-layout>
