<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Sales Scanner
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow">

            <h3 class="text-lg font-semibold mb-4">Scan Barcode</h3>

            <input
                id="barcodeInput"
                type="text"
                class="w-full border rounded p-2 text-black"
                placeholder="Scan barcode here…"
                autofocus
            >

            <p id="scanMessage" class="mt-2 text-sm h-6"></p>

            <hr class="my-4">

            <h3 class="text-lg font-semibold mb-3">Current Cart</h3>

            <table class="min-w-full text-left text-sm text-gray-300">
                <thead>
                    <tr>
                        <th class="py-2">Item</th>
                        <th class="py-2">Qty</th>
                        <th class="py-2">Price</th>
                        <th class="py-2">Total</th>
                    </tr>
                </thead>
                <tbody id="cartTable"></tbody>
            </table>

            <h3 class="text-lg font-semibold mt-4">Total Items Sold Today:
                <span id="totalItemsSold">0</span>
            </h3>
        </div>
    </div>



<div id="qtyModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded shadow w-80">
        <h2 class="text-lg font-bold mb-2">Enter Quantity</h2>

        <input
            type="number"
            id="quantityInput"
            value="1"
            min="1"
            class="w-full border p-2 mb-4"
        />

        <div class="flex justify-end gap-2">
            <button onclick="closeQtyModal()" class="px-4 py-2 bg-gray-300 rounded">
                Cancel
            </button>
            <button onclick="confirmScan()" class="px-4 py-2 bg-blue-600 text-white rounded">
                Confirm
            </button>
        </div>
    </div>
</div>


  <script>
    const input = document.getElementById('barcodeInput');
    const message = document.getElementById('scanMessage');
    const cartTable = document.getElementById('cartTable');
    const totalItemsSoldDisplay = document.getElementById('totalItemsSold');

    let cart = [];
    let totalItemsSold = 0;
    let scannedBarcode = null;

    // 🔹 Handle manual typing OR scanner input
    input.addEventListener('keydown', e => {
        if (e.key === "Enter") {
            const barcode = e.target.value.trim();
            if (!barcode) return;

            handleScan(barcode);
            e.target.value = "";
        }
    });

    // 🔹 Open quantity popup
    function handleScan(barcode) {
        scannedBarcode = barcode;
        document.getElementById('quantityInput').value = 1;
        document.getElementById('qtyModal').classList.remove('hidden');
    }

    function closeQtyModal() {
        document.getElementById('qtyModal').classList.add('hidden');
    }

    // 🔹 Confirm quantity → send to backend
    function confirmScan() {
        const quantity = parseInt(document.getElementById('quantityInput').value);

        if (quantity <= 0) {
            alert("Quantity must be at least 1");
            return;
        }

        message.textContent = "Processing...";
        message.className = "mt-2 text-yellow-500";

        fetch("/scan", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                barcode: scannedBarcode,
                quantity: quantity
            })
        })
        .then(res => res.json())
        .then(data => {
            closeQtyModal();

            if (!data.success) {
                message.textContent = data.message;
                message.className = "mt-2 text-red-500";
                return;
            }

            message.textContent = data.message;
            message.className = "mt-2 text-green-500";

            totalItemsSold += quantity;
            totalItemsSoldDisplay.textContent = totalItemsSold;

            const p = data.product;
            let existing = cart.find(item => item.barcode === p.barcode);

            if (existing) {
                existing.qty += quantity;
                existing.total += p.price * quantity;
            } else {
                cart.push({
                    name: p.name,
                    barcode: p.barcode,
                    qty: quantity,
                    price: p.price,
                    total: p.price * quantity
                });
            }

            renderCart();
        });
    }

    function renderCart() {
        cartTable.innerHTML = "";
        cart.forEach(item => {
            cartTable.innerHTML += `
                <tr>
                    <td class="py-1">${item.name}</td>
                    <td>${item.qty}</td>
                    <td>${item.price}</td>
                    <td>${item.total}</td>
                </tr>
            `;
        });
    }
</script>

</x-app-layout>
