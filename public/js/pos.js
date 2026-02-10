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

    let quantity = parseInt(prompt('Enter quantity:', 1), 10);
    if (!quantity || quantity <= 0) return;

    addToLocalCart(barcode, quantity);
    scanInput.value = '';
    scanInput.focus();
});

    /**
     * Communicates with POSController@scan
     */

    function addToLocalCart(barcode, quantity) {
    const existing = sessionCart.find(item => item.barcode === barcode);

    if (existing) {
        existing.qty += quantity;
    } else {
        sessionCart.push({
            barcode,
            qty: quantity
        });
    }

    renderTable();
}



function renderTable() {
    if (!cartTable) return;

    cartTable.innerHTML = "";

    if (sessionCart.length === 0) {
        cartTable.innerHTML = `
            <tr>
                <td colspan="2" class="text-center text-gray-500 py-4">
                    No items scanned yet
                </td>
            </tr>
        `;
        return;
    }

    sessionCart.forEach(item => {
        const row = `
            <tr class="border-b">
                <td class="py-3 px-4 font-medium">${item.barcode}</td>
                <td class="py-3 px-4">${item.qty}</td>
            </tr>
        `;
        cartTable.insertAdjacentHTML('beforeend', row);
    });
}
});
