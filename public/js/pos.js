document.addEventListener('DOMContentLoaded', () => {
    const scanInput = document.getElementById('barcodeInput');
    if (!scanInput) return;

    scanInput.addEventListener('keydown', (e) => {
        if (e.key !== 'Enter') return;

        e.preventDefault();

        const barcode = scanInput.value.trim();
        if (!barcode) return;

        let quantity = prompt('Enter quantity:', 1);

        if (quantity === null) {
            scanInput.value = '';
            return;
        }

        quantity = parseInt(quantity, 10);

        if (isNaN(quantity) || quantity <= 0) {
            alert('Invalid quantity');
            scanInput.value = '';
            return;
        }

        processScan(barcode, quantity);
        scanInput.value = '';
    });
});
