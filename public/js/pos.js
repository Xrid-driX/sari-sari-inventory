document.addEventListener('DOMContentLoaded', () => {
    const scanInput = document.getElementById('barcodeInput');
    const cartTable = document.getElementById('cartTable');
    const totalItemsSoldDisplay = document.getElementById('totalItemsSold');
    const cartTotalPriceDisplay = document.getElementById('cartTotalPrice');
    const scanMessage = document.getElementById('scanMessage');

    if (!scanInput) return;

    // Maintain a local state for the current session's cart
    let sessionCart = [];
    let totalItemsCount = 0;

    scanInput.addEventListener('keydown', (e) => {
        if (e.key !== 'Enter') return;

        e.preventDefault();

        const barcode = scanInput.value.trim();
        if (!barcode) return;

        // Using prompt as per your original logic
        let quantity = prompt('Enter quantity:', 1);

        if (quantity === null) {
            scanInput.value = '';
            return;
        }

        quantity = parseInt(quantity, 10);

        if (isNaN(quantity) || quantity <= 0) {
            alert('Please enter a valid quantity (number greater than 0).');
            scanInput.value = '';
            return;
        }

        processScan(barcode, quantity);
        scanInput.value = '';
    });

    /**
     * Communicates with POSController@scan
     */
    function processScan(barcode, quantity) {
        if (scanMessage) {
            scanMessage.textContent = "Processing...";
            scanMessage.className = "mt-2 text-sm text-yellow-600 font-medium";
        }

        fetch('/pos/scan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                // This token is required by Laravel for security
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                barcode: barcode,
                quantity: quantity
            })
        })
        .then(async response => {
            const data = await response.json();

            if (!response.ok || !data.success) {
                throw new Error(data.message || 'Server error occurred');
            }
            return data;
        })
        .then(data => {
            // 1. Success Message
            if (scanMessage) {
                scanMessage.textContent = `Success: Added ${data.product.name}`;
                scanMessage.className = "mt-2 text-sm text-green-600 font-bold";
            }

            // 2. Update Local State
            const product = data.product;
            updateLocalCart(product, quantity);

            // 3. Update Total Count
            totalItemsCount += quantity;
            if (totalItemsSoldDisplay) {
                totalItemsSoldDisplay.textContent = totalItemsCount;
            }
        })
        .catch(error => {
            console.error('Scan Error:', error);
            if (scanMessage) {
                scanMessage.textContent = error.message;
                scanMessage.className = "mt-2 text-sm text-red-600 font-bold";
            }
            alert(error.message);
        });
    }

    /**
     * Updates the UI Table and totals
     */
    function updateLocalCart(product, quantity) {
        const price = parseFloat(product.price);
        const lineTotal = price * quantity;

        // Check if item already in the visible table for this session
        let existing = sessionCart.find(item => item.name === product.name);

        if (existing) {
            existing.qty += quantity;
            existing.total += lineTotal;
        } else {
            sessionCart.push({
                name: product.name,
                qty: quantity,
                price: price,
                total: lineTotal
            });
        }

        renderTable();
    }

    function renderTable() {
        if (!cartTable) return;

        cartTable.innerHTML = "";
        let grandTotal = 0;

        sessionCart.forEach(item => {
            grandTotal += item.total;
            const row = `
                <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900 transition">
                    <td class="py-3 px-4 font-medium text-gray-900 dark:text-white">${item.name}</td>
                    <td class="py-3 px-4">${item.qty}</td>
                    <td class="py-3 px-4">₱ ${item.price.toFixed(2)}</td>
                    <td class="py-3 px-4 text-right font-bold">₱ ${item.total.toFixed(2)}</td>
                </tr>
            `;
            cartTable.insertAdjacentHTML('beforeend', row);
        });

        if (cartTotalPriceDisplay) {
            cartTotalPriceDisplay.textContent = grandTotal.toFixed(2);
        }
    }
});
