<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
    $siteName = get_setting('site_name', 'Perfume Art Collection');
    $seoTitle = get_setting('seo_title');
    $finalTitle = $seoTitle ?: $siteName;
    @endphp

    <title>@yield('title', $finalTitle)</title>

    <meta name="description" content="{{ get_setting('seo_description') }}">
    <meta name="keywords" content="{{ get_setting('seo_keywords') }}">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', $finalTitle)">
    <meta property="og:description" content="@yield('og_description', get_setting('seo_description'))">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:site_name" content="{{ $siteName }}">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('og_title', $finalTitle)">
    <meta property="twitter:description" content="@yield('og_description', get_setting('seo_description'))">
    <meta property="twitter:image" content="@yield('og_image', asset('images/og-default.jpg'))">

    <link class="favicon" rel="icon" type="image/png" href="{{ get_setting('site_logo') ? asset('storage/' . get_setting('site_logo')) : asset('images/favicon/parfum-art.png') }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fancybox.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/splide.min.css') }}">

    @if(Request::is('admin/pages*'))
    <link rel="stylesheet" href="{{ asset('vendor/laraberg/css/laraberg.css') }}">
    @endif

    <style>
        .promo-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 11000;
            display: none;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }

        .promo-content {
            position: relative;
            max-width: 420px;
            width: 85%;
            background: rgba(255, 255, 255, 0.05);
            padding: 10px;
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: premiumZoom 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .promo-text-overlay {
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9), transparent);
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 20px 15px 10px 15px;
            text-align: left;
            border-bottom-left-radius: 18px;
            border-bottom-right-radius: 18px;
        }

        .promo-title {
            color: #ffc107;
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .promo-desc {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.85rem;
            line-height: 1.3;
            margin-bottom: 0;
        }

        .promo-content img {
            width: 100%;
            display: block;
            border-radius: 18px;
            object-fit: cover;
        }

        .promo-close {
            position: absolute;
            top: -12px;
            right: -12px;
            background: #ffffff;
            color: #000;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            z-index: 11001;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .promo-progress-container {
            width: calc(100% - 20px);
            height: 4px;
            background: rgba(255, 255, 255, 0.1);
            margin: 12px auto 5px auto;
            border-radius: 10px;
            overflow: hidden;
        }

        #promoProgressBar {
            height: 100%;
            background: linear-gradient(90deg, #0dcaf0, #007bff);
            width: 100%;
            border-radius: 10px;
        }

        @keyframes premiumZoom {
            from {
                transform: scale(0.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* GLOBAL SCROLL TO TOP STILI */
        .global-scroll-top-btn {
            position: fixed !important;
            bottom: 30px !important;
            right: 30px !important;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(66, 65, 65, 0.57);
            color: #fff;
            font-size: 24px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 999999 !important;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 16px rgba(41, 42, 42, 0.4);
        }

        .global-scroll-top-btn.show {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translateY(0) !important;
        }

        .global-scroll-top-btn:hover {
            background: rgba(141, 138, 138, 0.63);
            color: black;
            transform: translateY(-4px) !important;
        }
    </style>
</head>

<body class="bg-dark">
    <div class="bg-image d-flex flex-column min-vh-100">
        @if(!Request::is('admin*'))
        @include('app.navbar')
        @endif

        <main class="flex-grow-1">
            @yield('content')
        </main>

        @if(!Request::is('admin*'))
        @include('layouts.footer')
        @endif
    </div>

    {{-- DINAMIK 3 DILLI POPUP BLOKY --}}
    @if(!Request::is('admin*'))
    @php
    $activePopup = \App\Models\Popup::where('is_active', true)->first();
    $currentLocale = app()->getLocale();
    $titleKey = 'title_' . $currentLocale;
    $descKey = 'description_' . $currentLocale;
    @endphp

    @if($activePopup)
    <div id="promoModal" class="promo-overlay">
        <div class="promo-content">
            <button class="promo-close" onclick="closePromo()">×</button>
            <a href="{{ $activePopup->link ?? '#' }}" onclick="closePromo('{{ $activePopup->id }}')" class="text-decoration-none position-relative d-block overflow-hidden rounded-4">
                <img src="{{ asset('storage/' . $activePopup->image) }}" alt="Popup Image">

                @if($activePopup->$titleKey || $activePopup->$descKey)
                <div class="promo-text-overlay">
                    @if($activePopup->$titleKey)
                    <div class="promo-title">{{ $activePopup->$titleKey }}</div>
                    @endif
                    @if($activePopup->$descKey)
                    <p class="promo-desc">{{ $activePopup->$descKey }}</p>
                    @endif
                </div>
                @endif
            </a>
            <div class="promo-progress-container">
                <div id="promoProgressBar"></div>
            </div>
        </div>
    </div>
    @endif
    @endif

    <div class="offcanvas offcanvas-end bg-dark bg-opacity-10 text-white border-start border-secondary" tabindex="-1" id="offcanvasCart" style="z-index: 1090;">
        <div class="offcanvas-header border-bottom border-secondary">
            <h5 class="offcanvas-title fw-bold">{{ __('app.nav-offcanva-title') }} <i class="bi bi-cart4 text-primary"></i></h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column">
            <div id="cart-items-container" class="flex-grow-1 overflow-auto pe-2"></div>

            <div id="checkout-section" style="display: none;" class="mt-auto pt-3 border-top border-secondary bg-dark bg-opacity-10">
                <div class="d-flex justify-content-between h5 mb-4 px-2">
                    <span class="text-white-50">{{__('app.total_price')}}</span>
                    <span id="cart-total-price" class="text-success fw-bold">0.00 $</span>
                </div>
                <a href="{{ route('checkout') }}" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-sm">
                    {{__('app.nav-offcanva-checkout-btn')}} <i class="bi bi-arrow-right ms-2"></i>
                </a>
                <div class="mt-3 text-center">
                    <a href="{{ route('orders.my') }}" class="text-white small text-decoration-none">
                        <i class="bi bi-clock-history me-1"></i> Öňki sargytlaryma seret
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Diňe baş sahypada bolsa görkez --}}
    @if(Request::is('/') || Request::is('tm') || Request::is('ru') || Request::is('en'))
    <button type="button" id="globalScrollTopBtn" class="global-scroll-top-btn" aria-label="Ýokary çyk">
        <i class="bi bi-arrow-up-short"></i>
    </button>
    @endif

    <div id="toast-container" class="position-fixed top-0 end-0 p-3" style="z-index: 1085;"></div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/fancybox.umd.js') }}"></script>
    <script src="{{ asset('js/addtocart.js') }}?v=1.1"></script>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/splide.min.js') }}"></script>

    @if(Request::is('admin/pages*'))
    <script src="{{ asset('js/react.production.min.js') }}"></script>
    <script src="{{ asset('js/react-dom.production.min.js') }}"></script>
    <script src="{{ asset('vendor/laraberg/js/laraberg.js') }}"></script>
    @endif

    {{-- POPUP JAVASCRIPT LOGIKASY --}}
    @if(isset($activePopup) && !Request::is('admin*'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const popupId = "{{ $activePopup->id }}";
            const durationMs = parseInt("{{ $activePopup->seconds ?? 5 }}") * 1000;

            const lastSeenId = localStorage.getItem('last_popup_seen_id');
            const lastSeenTime = localStorage.getItem('last_popup_seen_time');

            const now = new Date().getTime();
            const twoDaysInMs = 2 * 24 * 60 * 60 * 1000;

            const shouldShow = (lastSeenId !== popupId) || (!lastSeenTime) || (now - parseInt(lastSeenTime) > twoDaysInMs);

            if (shouldShow) {
                const modal = document.getElementById('promoModal');
                const bar = document.getElementById('promoProgressBar');

                if (modal) {
                    modal.style.display = 'flex';
                }

                if (bar) {
                    bar.style.transition = 'none';
                    bar.style.width = '100%';
                    setTimeout(() => {
                        bar.style.transition = `width ${durationMs}ms linear`;
                        bar.style.width = '0%';
                    }, 100);
                }

                setTimeout(() => {
                    closePromo(popupId);
                }, durationMs);
            }
        });

        function closePromo(id = null) {
            const modal = document.getElementById('promoModal');
            if (modal) {
                modal.style.display = 'none';
                const currentPopupId = id || "{{ $activePopup->id }}";
                const now = new Date().getTime();
                localStorage.setItem('last_popup_seen_id', currentPopupId);
                localStorage.setItem('last_popup_seen_time', now.toString());
            }
        }
    </script>
    @endif

    {{-- LIVE SEARCH WE SCROLL TOP GLOBAL JAVASCRIPT LOGIKASY --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- LIVE SEARCH LOGIKASY ---
            const searchInput = document.getElementById('product-search');
            const searchDropdown = document.getElementById('search-dropdown');
            let timeout = null;
            let controller = null;

            if (searchInput && searchDropdown) {
                searchInput.addEventListener('input', function(e) {
                    const term = e.target.value.trim();
                    clearTimeout(timeout);

                    if (controller) {
                        controller.abort();
                    }

                    if (term === "") {
                        searchDropdown.style.display = "none";
                        searchDropdown.innerHTML = "";
                        return;
                    }

                    timeout = setTimeout(() => {
                        controller = new AbortController();

                        fetch(`/search-products?term=${encodeURIComponent(term)}`, {
                                signal: controller.signal
                            })
                            .then(res => {
                                if (!res.ok) {
                                    throw new Error("Server hatasy");
                                }
                                return res.json();
                            })
                            .then(products => {
                                let html = '';

                                if (!Array.isArray(products) || products.length === 0) {
                                    html = `<div class="p-3 text-center text-white-50 small">
                                            <i class="bi bi-search me-1"></i> Hiç zat tapylmady
                                        </div>`;
                                } else {
                                    products.forEach(p => {
                                        const productUrl = `/product/${p.slug}`;
                                        html += `
                                        <a href="${productUrl}" class="search-dropdown-item">
                                            <i class="bi bi-search me-3"></i>
                                            <span class="fw-medium">${p.name}</span>
                                        </a>
                                    `;
                                    });
                                }

                                searchDropdown.innerHTML = html;
                                searchDropdown.style.display = "block";
                            })
                            .catch(err => {
                                if (err.name !== 'AbortError') {
                                    console.error("Gözleg hatasy:", err);
                                }
                            });
                    }, 200);
                });

                document.addEventListener('click', function(e) {
                    if (!searchInput.contains(e.target) && !searchDropdown.contains(e.target)) {
                        searchDropdown.style.display = "none";
                    }
                });

                searchInput.addEventListener('focus', function() {
                    if (searchInput.value.trim() !== "" && searchDropdown.children.length > 0) {
                        searchDropdown.style.display = "block";
                    }
                });
            }

            // --- GLOBAL SCROLL TO TOP LOGIKASY ---
            const scrollTopBtn = document.getElementById('globalScrollTopBtn');

            if (scrollTopBtn) {
                const checkScroll = function() {
                    const scrollPos = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
                    if (scrollPos > 150) {
                        scrollTopBtn.classList.add('show');
                    } else {
                        scrollTopBtn.classList.remove('show');
                    }
                };

                window.addEventListener('scroll', checkScroll, {
                    passive: true
                });
                document.addEventListener('scroll', checkScroll, {
                    passive: true
                });

                scrollTopBtn.addEventListener('click', function() {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            }
        });
    </script>

    @yield('scripts')
</body>

</html>