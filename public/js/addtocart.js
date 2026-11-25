function loadCartData() {
    fetch("/cart/get-data")
        .then((res) => {
            if (!res.ok) throw new Error("Network response was not ok");
            return res.json();
        })
        .then((data) => {
            if (data) updateCartUI(data);
        })
        .catch((err) => console.error("Sebet maglumatyny alyp bolmady:", err));
}

function updateCartUI(cartData) {
    if (!cartData) return;

    const container = document.getElementById("cart-items-container");
    const countElement = document.getElementById("cart-count");
    const totalElement = document.getElementById("cart-total-price");
    const checkoutSection = document.getElementById("checkout-section");

    const cart = cartData.items || {};
    const total = cartData.total || 0;
    const count = cartData.count || 0;

    if (container) {
        container.innerHTML = "";
        const keys = Object.keys(cart);

        if (keys.length === 0) {
            container.innerHTML = `
                <div class="text-center mt-5">
                    <i class="bi bi-cart-x text-secondary" style="font-size: 3rem;"></i>
                    <p class="mt-3 text-secondary">Sebediňiz boş</p>
                </div>`;

            if (countElement) {
                countElement.innerText = "0";
                countElement.style.display = "none";
            }
            if (checkoutSection) {
                checkoutSection.style.setProperty(
                    "display",
                    "none",
                    "important",
                );
            }
        } else {
            keys.forEach((id) => {
                const item = cart[id];
                container.innerHTML += `
                    <div class="d-flex align-items-center mb-3 bg-dark bg-opacity-5 p-3 rounded-4 border border-white border-opacity-10 shadow-sm">
                        <img src="${item.image}" width="55" height="55" class="rounded-3 me-3" style="object-fit: cover;">
                        <div class="flex-grow-1">
                            <h6 class="mb-0 small fw-bold text-white text-truncate" style="max-width: 140px;">${item.name}</h6>
                            <small class="text-success fw-bold">${parseFloat(item.price).toFixed(2)} $</small>
                        </div>
                        <div class="d-flex align-items-center bg-dark rounded-pill p-1 border border-white border-opacity-10">
                            <button class="btn btn-sm text-white p-0 px-2" onclick="changeQty(${id}, -1)">
                                <i class="bi bi-dash"></i>
                            </button>
                            <span class="mx-1 small fw-bold text-white" style="min-width: 18px; text-align: center;">${item.quantity}</span>
                            <button class="btn btn-sm text-white p-0 px-2" onclick="changeQty(${id}, 1)">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </div>`;
            });

            if (countElement) {
                countElement.innerText = count;
                countElement.style.display = "inline-block";
            }
            if (checkoutSection) {
                checkoutSection.style.setProperty(
                    "display",
                    "block",
                    "important",
                );
            }
        }

        if (totalElement) {
            totalElement.innerText = parseFloat(total).toFixed(2) + " $";
        }
    }
}

document.addEventListener("click", function (e) {
    const btn = e.target.closest(".add-to-cart-btn");
    if (btn) {
        e.preventDefault();
        const id = btn.getAttribute("data-id");
        const tokenMeta = document.querySelector('meta[name="csrf-token"]');

        if (!tokenMeta) return;

        fetch(window.location.origin + "/cart/add", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": tokenMeta.content,
                Accept: "application/json",
            },
            body: JSON.stringify({ id: id }),
        })
            .then((res) => res.json())
            .then((data) => {
                updateCartUI(data);
                const offcanvasElement =
                    document.getElementById("offcanvasCart");
                if (offcanvasElement) {
                    bootstrap.Offcanvas.getOrCreateInstance(
                        offcanvasElement,
                    ).show();
                }
            })
            .catch((err) => console.error("Hata:", err));
    }
});

window.changeQty = function (id, delta) {
    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
    if (!tokenMeta) return;

    fetch(window.location.origin + "/cart/update", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": tokenMeta.content,
            Accept: "application/json",
        },
        body: JSON.stringify({ id: id, delta: delta }),
    })
        .then((res) => res.json())
        .then((data) => updateCartUI(data))
        .catch((err) => console.error("Mukdar üýtgetmekde hata:", err));
};

document.addEventListener("DOMContentLoaded", () => {
    const hasCart =
        document.getElementById("cart-items-container") ||
        document.getElementById("offcanvasCart");
    const isAdmin = window.location.pathname.startsWith("/admin");

    if (hasCart && !isAdmin) {
        loadCartData();
    }
});
