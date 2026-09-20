<style>
    /* Magic Card Esasy Stil */
    .magic-card {
        background: rgba(31, 30, 30, 0.51) !important;
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 24px;
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        overflow: hidden;
        position: relative;
    }

    .magic-card:hover {
        transform: translateY(-10px);
        border-color: rgba(13, 202, 240, 0.4) !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
    }

    /* Gatlak barlaglary */
    .z-index-99 {
        z-index: 99 !important;
    }

    .z-index-2 {
        z-index: 2 !important;
    }

    /* DÜZELDILDI: CSS goşuldy */

    .magic-image-wrapper {
        position: relative;
        height: 280px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.02);
    }

    .magic-img {
        height: 100% !important;
        width: 100% !important;
        object-fit: cover;
        /* <--- INE BU: 'contain' deregine 'cover' bolmaly, şonda doly doldurýar */
        object-position: center;
        /* Suraty ortalaýar */
        display: block;
        backface-visibility: hidden;
        will-change: transform, opacity;
        transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.7s ease-in-out !important;
    }

    .magic-card:hover .magic-img {
        transform: scale(1.1) rotate(2deg);
    }

    .badge-magic {
        background: rgba(44, 43, 43, 0.6) !important;
        color: white !important;
        backdrop-filter: blur(10px);
        padding: 5px 14px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: bold;
        border: 1px solid rgba(255, 255, 255, 0.2);
        text-transform: uppercase;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .magic-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.4s ease;
        z-index: 10;
        backdrop-filter: blur(2px);
    }

    .magic-card:hover .magic-overlay {
        opacity: 1;
    }

    .btn-magic-view {
        padding: 12px 24px;
        background: white;
        color: black !important;
        border-radius: 50px;
        font-weight: bold;
        text-decoration: none;
        transition: 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .btn-magic-view:hover {
        transform: scale(1.05);
        background: #f8f9fa;
    }

    .text-gradient {
        background: linear-gradient(45deg, #0dcaf0, #00ff88);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .btn-wishlist {
        background: transparent;
        border: none;
        color: rgba(255, 255, 255, 0.5);
        font-size: 1.3rem;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        cursor: pointer;
        padding: 0;
        display: flex;
        align-items: center;
    }

    .btn-wishlist.active {
        color: #ff4757 !important;
    }

    .btn-wishlist:hover {
        color: #ff4757;
    }

    .badge-sale {
        background: linear-gradient(45deg, #ff47568f, #ff6b8180) !important;
        color: white !important;
        padding: 5px 12px;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 800;
        box-shadow: 0 4px 15px rgba(255, 71, 86, 0.6);
        z-index: 20;
    }

    .old-price {
        text-decoration: line-through;
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.85rem;
        display: block;
    }

    .dot {
        height: 8px;
        width: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
    }

    .pulse-green {
        background: #2ecc71;
        box-shadow: 0 0 0 0 rgba(46, 204, 113, 0.7);
        animation: pulse 2s infinite;
    }

    .pulse-red {
        background: #e74c3c;
    }

    @keyframes pulse {
        0% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(46, 204, 113, 0.7);
        }

        70% {
            transform: scale(1);
            box-shadow: 0 0 0 10px rgba(46, 204, 113, 0);
        }

        100% {
            transform: scale(0.95);
        }
    }
</style>

<div class="col-12 col-md-6 col-lg-4 product-item mb-4">
    <div class="card h-100 border-0 magic-card">

        {{-- Sale Badge - Eger arzanladyş bar bolsa --}}
        @if($product->discount_percent > 0)
        <div class="position-absolute top-0 end-0 m-3 z-index-99">
            <div class="badge-sale">-{{ $product->discount_percent }}%</div>
        </div>
        @endif

        <div class="magic-image-wrapper">
            {{-- Gender Badge --}}
            <div class="position-absolute top-0 start-0 m-3 z-index-2">
                <div class="badge-magic">{{ $product->gender }}</div>
            </div>

            @if($product->image)
            <img data-src="{{ asset('storage/' . $product->image) }}"
                src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 3'></svg>"
                class="magic-img main-img lazy-magic-img opacity-0"
                style="transition: opacity 0.7s ease-in-out;"
                alt="{{ $product->name }}"
                loading="lazy"
                decoding="async">

            <div class="magic-overlay">
                <a href="{{ route('product.show', $product->slug) }}" class="btn-magic-view">
                    <i class="bi bi-bag-plus me-2"></i> {{__('app.view-btn')}}
                </a>
            </div>
            @else
            <img src="{{ asset('images/default.jpg') }}" class="magic-img">
            @endif
        </div>

        <div class="card-body d-flex flex-column p-4 pt-4" style="background-color: rgba(31, 30, 30, 0.51); backdrop-filter: blur(1px);">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <h5 class="fw-bold mb-1 text-white magic-title">{{ Str::limit($product->name, 20 ) }}</h5>
                    <span class="text-info small fw-bold">{{ $product->ml_size }}ml</span>
                </div>

                {{-- Baha Bölümi --}}
                <div class="text-end">
                    @if($product->discount_percent > 0)
                    <span class="old-price">{{ number_format($product->price, 0) }} $</span>
                    <div class="h4 fw-bold mb-0 text-gradient">
                        {{ number_format($product->discounted_price, 0) }} $
                    </div>
                    <div class="text-white-50 x-small">
                        {{ number_format($product->discounted_price * $exchange_rate, 2) }} TMT
                    </div>
                    @else
                    <div class="h4 fw-bold mb-0 text-gradient">{{ number_format($product->price, 0) }} $</div>
                    <div class="text-white-50 x-small">
                        {{ number_format($product->price * $exchange_rate, 2) }} TMT
                    </div>
                    @endif
                </div>
            </div>

            <p class="text-white-50 mb-4 small flex-grow-1">
                {{ Str::limit($product->description, 65) }}
            </p>

            <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top border-white border-opacity-10">
                <div class="stock-indicator">
                    @if($product->stock_quantity > 0)
                    <span class="dot pulse-green"></span>
                    <span class="small opacity-75 text-white text-nowrap">{{ __('app.in_stock') }}: {{ $product->stock_quantity }}</span>
                    @else
                    <span class="dot pulse-red"></span>
                    <span class="small opacity-75 text-danger text-uppercase">{{ __('app.out_of_stock') }}</span>
                    @endif
                </div>

                <div class="d-flex align-items-center gap-2">
                    <span class="text-white-50 small fw-bold" id="like-count-{{ $product->id }}">
                        {{ $product->likes_count }}
                    </span>
                    <button class="btn-wishlist toggle-wishlist {{ Auth::check() && Auth::user()->wishlist->contains($product->id) ? 'active' : '' }}"
                        data-id="{{ $product->id }}">
                        <i class="bi {{ Auth::check() && Auth::user()->wishlist->contains($product->id) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // 1. LAZY LOAD STRATEGIÝASY (Intersection Observer)
    document.addEventListener("DOMContentLoaded", function() {
        const lazyImages = document.querySelectorAll('.lazy-magic-img');

        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const image = entry.target;

                    // Hakyky suraty ýükleýäris
                    image.src = image.dataset.src;

                    // Surat doly ýüklenip gutaranda opacity-0 klasyny aýyrýarys (Fade-in bolar)
                    image.onload = function() {
                        image.classList.remove('opacity-0');
                    };

                    // Bu surat üçin gözegçiligi bes edýäris
                    observer.unobserve(image);
                }
            });
        }, {
            rootMargin: "0px 0px 250px 0px" // Ulanyjy haryda ýetmezden 250px öň ýükläp başlar
        });

        lazyImages.forEach(image => {
            imageObserver.observe(image);
        });
    });

    // 2. SENIŇ ÖŇKI WISHLIST KODYŇ (Gatnaşylmady, adaty dur)
    $(document).on('click', '.toggle-wishlist', function(e) {
        e.preventDefault();
        let btn = $(this);
        let productId = btn.data('id');
        let countSpan = $('#like-count-' + productId);

        $.ajax({
            url: "{{ route('wishlist.toggle') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                product_id: productId
            },
            success: function(response) {
                if (response.status === 'added') {
                    btn.addClass('active');
                    btn.find('i').removeClass('bi-heart').addClass('bi-heart-fill');
                } else {
                    btn.removeClass('active');
                    btn.find('i').removeClass('bi-heart-fill').addClass('bi-heart');
                }
                countSpan.text(response.count);
            },
            error: function(xhr) {
                if (xhr.status === 401) window.location.href = "{{ route('login') }}";
            }
        });
    });
</script>
@endsection