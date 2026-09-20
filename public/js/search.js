document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('product-search');
    const container = document.getElementById('products-container');
    const pagination = document.querySelector('.pagination-wrapper');
    const backToTop = document.getElementById('back-to-top');
    let timeout = null;

    if (searchInput) {
        searchInput.addEventListener('input', function (e) {
            const term = e.target.value.trim();
            clearTimeout(timeout);

            if (term === "") {
                location.reload();
                return;
            }

            timeout = setTimeout(() => {
                fetch(`/api/search-products?term=${encodeURIComponent(term)}`)
                    .then(res => res.json())
                    .then(products => {
                        let html = '';
                        if (products.length === 0) {
                            html = '<div class="col-12 text-center text-white py-5"><h3>Item not found</h3></div>';
                        } else {
                            products.forEach(p => {
                                const imgPath = p.image ? `/storage/${p.image}` : 'storage/default.jpg';
                                const productUrl = `/product/${p.slug}`;
                                const shortDesc = p.description ? p.description.substring(0, 80) + '...' : '';
                                const stockClass = p.stock_quantity > 0 ? 'text-success' : 'text-danger';
                                const stockText = p.stock_quantity > 0 ? `Stokda bar: ${p.stock_quantity} sany` : 'Stokda ýok';

                                html += `
                                <div class="col-12 col-md-6 col-lg-4 product-item">
                                    <div class="card h-100 border-0 shadow-sm" style="background-color: rgba(31, 30, 30, 0.51); backdrop-filter: blur(5px); color: white; border: 1px solid rgba(255,255,255,0.1)">
                                        <div class="text-center p-3 position-relative">
                                            <div class="overflow-hidden">
                                                <a href="${imgPath}" data-fancybox="gallery" data-caption="${p.name}">
                                                    <img src="${imgPath}" class="img-fluid" alt="${p.name}" style="height: 250px; object-fit: contain;" onerror="this.onerror=null;this.src='/images/default.jpg';">
                                                </a>
                                            </div>
                                            <div class="position-absolute top-0 start-0 m-3">
                                                <div class="badge bg-light text-dark">${p.gender || 'Unisex'}</div>
                                            </div>
                                        </div>
                                        <div class="card-body d-flex flex-column p-4">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div class="h5 fw-bold mb-0 text-white">${p.name}</div>
                                                <div class="badge border border-light text-white rounded-5 fw-semibold">${p.ml_size}ml</div>
                                            </div>
                                            <div class="text-white-50 mb-4 small">${shortDesc}</div>
                                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                                <div class="h4 fw-bold mb-0 text-success">$${parseFloat(p.price).toFixed(2)}</div>
                                                <a href="${productUrl}" class="btn btn-outline-light rounded-pill px-2">
                                                    <i class="bi bi-eye me-1"></i> View
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-transparent border-0 text-center pb-3">
                                            <div class="${stockClass} small fw-bold">${stockText}</div>
                                        </div>
                                    </div>
                                </div>`;
                            });
                        }
                        container.innerHTML = html;
                        if (pagination) pagination.style.display = "none";
                        if (typeof Fancybox !== 'undefined') Fancybox.bind("[data-fancybox='gallery']", {});
                    });
            }, 300);
        });
    }

    if (backToTop) {
        window.addEventListener('scroll', () => {
            window.scrollY > 500 ? backToTop.classList.add('show') : backToTop.classList.remove('show');
        });
        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
});