document.addEventListener('DOMContentLoaded', function () {
    const rawData = localStorage.getItem('last_order_details');
    const container = document.getElementById('last-order-items');
    const totalEl = document.getElementById('last-order-total');
    const orderNoEl = document.getElementById('dynamic-order-no');

    let orderData = null;
    try {
        orderData = rawData ? JSON.parse(rawData) : null;
    } catch (e) {
        console.error("JSON parse hatasy:", e);
    }

    if (!orderData || !orderData.items) {
        if (container) {
            container.innerHTML = `<div class="text-center py-4 text-white-50 small">Sargyt maglumatlary tapylmady.</div>`;
        }
        return;
    }

    // Sargyt belgisini ýerleşdir
    if (orderNoEl) {
        orderNoEl.innerText = orderData.order_no || "#NED-XXXX";
    }

    // Harytlary görkez
    if (container) {
        container.innerHTML = '';
        const itemsArray = Array.isArray(orderData.items) ? orderData.items : Object.values(orderData.items);
        itemsArray.forEach(item => {
            const price = parseFloat(item.price) || 0;
            const quantity = parseInt(item.quantity) || 1;
            container.innerHTML += `
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom border-white border-opacity-5 pb-2 text-white small">
                    <span>${item.name} (x${quantity})</span>
                    <span class="fw-bold">$${(price * quantity).toFixed(2)}</span>
                </div>`;
        });
    }

    if (totalEl) {
        totalEl.innerText = `$${parseFloat(orderData.total).toFixed(2)}`;
    }

    // Iň soňunda: Maglumatlary görkezip bolanymyzdan SOŇ pozýarys
    localStorage.removeItem('last_order_details');
});