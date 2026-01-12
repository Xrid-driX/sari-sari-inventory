<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sari-Sari Store POS</title>
    @vite('resources/css/app.css')

    <!-- CSRF Token for security in AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-purple-100 min-h-screen antialiased">

    <div class="container mx-auto p-4 md:p-8">
        <h1 class="text-4xl font-extrabold text-indigo-700 text-center mb-10 tracking-tight">
            Sari-Sari Store Point of Sale
        </h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Left Panel: Scanning and Current Sale -->
            <div class="lg:col-span-2 space-y-8">

                <!-- Barcode Scanner Input -->
                <div class="bg-white p-6 rounded-xl shadow-lg border-t-4 border-indigo-500">
                    <h2 class="text-2xl font-semibold mb-4 text-gray-800">Scan Product</h2>
                    <input
                        type="text"
                        id="barcodeInput"
                        placeholder="Scan barcode here..."
                        class="w-full p-4 text-xl border-2 border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-150"
                        autofocus
                    >
                    <p id="scanMessage" class="mt-3 text-lg font-medium h-6"></p>
                </div>

                <!-- Current Transaction / Cart Display -->
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <h2 class="text-2xl font-semibold mb-4 text-gray-800">Current Sale</h2>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-indigo-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            </tr>
                        </thead>
                        <tbody id="cartItems" class="bg-white divide-y divide-gray-200">
                            <!-- Cart items will be inserted here by JavaScript -->
                            <tr class="text-gray-500">
                                <td colspan="3" class="p-6 text-center">No items scanned yet.</td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-right text-lg font-bold text-gray-900">Total:</td>
                                <td id="cartTotal" class="px-6 py-4 text-left text-xl font-extrabold text-indigo-600">₱ 0.00</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Right Panel: Summary/Actions -->
            <div class="space-y-8">
                <div class="bg-white p-6 rounded-xl shadow-lg h-full flex flex-col justify-between">
                    <h2 class="text-2xl font-semibold mb-4 text-gray-800">Sales Summary</h2>
                    <p class="text-gray-600 mb-4">Total items sold in this session:</p>
                    <p id="totalItemsSold" class="text-5xl font-extrabold text-center text-green-600">0</p>
                    <p class="text-gray-600 mt-6 mb-4">You can add more features here like item lookup!</p>
                    <button class="w-full py-3 bg-green-500 text-white font-bold rounded-lg hover:bg-green-600 transition duration-200 shadow-md focus:outline-none focus:ring-4 focus:ring-green-300">
                        Finalize Transaction
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- JavaScript for Barcode Scanning Logic -->
    <script>
        const barcodeInput = document.getElementById('barcodeInput');
        const scanMessage = document.getElementById('scanMessage');
        const cartItemsBody = document.getElementById('cartItems');
        const cartTotalDisplay = document.getElementById('cartTotal');
        const totalItemsSoldDisplay = document.getElementById('totalItemsSold');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // State variables to track the current transaction
        let currentCart = [];
        let grandTotal = 0;
        let totalItemsSold = 0;

        /**
         * Updates the UI (Cart table and Total) based on the currentCart state.
         */
        function updateCartUI() {
            cartItemsBody.innerHTML = '';
            grandTotal = 0;
            let totalItemsInCart = 0;

            if (currentCart.length === 0) {
                cartItemsBody.innerHTML = '<tr class="text-gray-500"><td colspan="3" class="p-6 text-center">No items scanned yet.</td></tr>';
                cartTotalDisplay.textContent = '₱ 0.00';
                return;
            }

            currentCart.forEach(item => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-indigo-50 transition duration-100';
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${item.name}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${item.quantity}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-indigo-500">₱ ${item.total.toFixed(2)}</td>
                `;
                cartItemsBody.appendChild(row);

                grandTotal += item.total;
                totalItemsInCart += item.quantity;
            });

            cartTotalDisplay.textContent = `₱ ${grandTotal.toFixed(2)}`;
            totalItemsSoldDisplay.textContent = totalItemsSold; // Update the session total
        }

        /**
         * Clears the message display after a short delay.
         */
        function clearMessage() {
            setTimeout(() => {
                scanMessage.textContent = '';
                scanMessage.className = 'mt-3 text-lg font-medium h-6'; // Reset classes
            }, 3000);
        }

        /**
         * Handles the AJAX call to the Laravel controller when a barcode is scanned.
         * @param {string} barcode
         */
        async function handleScan(barcode) {
            if (!barcode) return;

            // Display a loading message
            scanMessage.textContent = 'Processing...';
            scanMessage.className = 'mt-3 text-lg font-medium h-6 text-yellow-600';

            try {
                const response = await fetch('/scan', { // Assuming your route is /scan
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken, // Mandatory for Laravel POST requests
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ barcode: barcode })
                });

                const data = await response.json();

                if (data.success) {
                    scanMessage.textContent = data.message;
                    scanMessage.className = 'mt-3 text-lg font-medium h-6 text-green-600';
                    totalItemsSold++; // Increment the session counter

                    // --- Simulate adding the product details to the cart ---
                    // Since your PHP response is minimal, we'll simulate the product data.
                    // In a real app, you'd return the product name/price in the JSON response.

                    const simulatedProductName = 'Item ' + barcode.substring(0, 4); // Dummy name
                    const simulatedProductPrice = 25.50; // Dummy price

                    const existingItem = currentCart.find(item => item.barcode === barcode);

                    if (existingItem) {
                        existingItem.quantity += 1;
                        existingItem.total += simulatedProductPrice;
                    } else {
                        currentCart.push({
                            barcode: barcode,
                            name: simulatedProductName,
                            quantity: 1,
                            unitPrice: simulatedProductPrice,
                            total: simulatedProductPrice,
                        });
                    }

                } else {
                    scanMessage.textContent = data.message;
                    scanMessage.className = 'mt-3 text-lg font-medium h-6 text-red-600';
                }
            } catch (error) {
                console.error('Error during scan:', error);
                scanMessage.textContent = 'An network error occurred.';
                scanMessage.className = 'mt-3 text-lg font-medium h-6 text-red-600';
            }

            // Always update UI after processing, and clear message
            updateCartUI();
            clearMessage();
        }

        // Event listener for Enter key press on the barcode input
        // barcodeInput.addEventListener('keydown', (event) => {
        //     // Check if the key pressed is 'Enter' (key code 13)
        //     if (event.key === 'Enter') {
        //         event.preventDefault(); // Prevent form submission
        //         const barcode = barcodeInput.value.trim();
        //         if (barcode) {
        //             handleScan(barcode);
        //             barcodeInput.value = ''; // Clear the input after processing
        //         }
        //     }
        // });

        // Initial UI render
        // updateCartUI();


    </script>

<script src="{{ asset('js/pos.js') }}"></script>
</body>
</html>
