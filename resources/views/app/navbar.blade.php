<nav class="navbar navbar-expand-lg navbar-dark sticky-top"
    style="background-color: rgba(31, 30, 30, 0.6); -webkit-backdrop-filter: blur(30px); backdrop-filter: blur(5px); border-bottom: 1px solid rgba(255,255,255,0.05);">
    <div class="container-xl">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            @if(get_setting('site_logo'))
            <img src="{{ asset('storage/' . get_setting('site_logo')) }}"
                alt="{{ get_setting('site_name') }}"
                width="45" height="45" class="me-2 rounded shadow-xl">
            @else
            <img src="{{ asset('images/favicon/parfum-art.png') }}" width="45" height="45" class="me-2">
            @endif
            <span class="fw-bold small-on-mobile">{{ get_setting('site_name', 'Perfume-Art Shop') }}</span>
        </a>
        <div class="d-flex align-items-center d-lg-none gap-2">
            <a href="{{ route('orders.my') }}" title="My-Orders" class="btn btn-outline-light rounded-pill px-2 border-0">

                <i class="bi bi-box-seam fs-5"></i>
            </a>
            <button class="btn btn-light rounded-pill px-3 position-relative border-0" title="Cart" type="button"
                data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart">
                <i class="bi-cart4 h5"></i>
                <span id="cart-count-mobile" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">0</span>
            </button>
            <button class="navbar-toggler border-0 ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample11">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbarsExample11">
            <ul class="navbar-nav ms-auto me-4 gap-lg-3">
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('home') ? 'active fw-semibold' : '' }}" href="{{ route('home') }}" title="Home">
                        {{ __('app.nav-home') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('about') ? 'active fw-semibold' : '' }}" href="{{ route('about') }}" title="About-Us">
                        {{ __('app.nav-about-us') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('contact') ? 'active fw-semibold' : '' }}" href="{{ route('contact') }}" title="Contact Us">
                        {{ __('app.nav-contact') }}
                    </a>
                </li>
            </ul>

            <div class="d-none d-lg-flex align-items-center gap-3">
                <a href="{{ route('orders.my') }}"
                    class="btn btn-outline-light rounded-pill px-3 d-flex align-items-center gap-2 border-opacity-25"
                    title="Sargytlarym">
                    <i class="bi bi-box-seam"></i>
                    <span class="small fw-bold text-uppercase" style="font-size: 11px;">{{__('app.nav-my-orders')}}</span>
                </a>

                {{-- Sebet Düwmesi --}}
                <div class="d-flex align-items-center me-3">
                    <button class="btn btn-light shadow-lg rounded-pill px-3 position-relative border-0" type="button"
                        data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart">
                        <i class="bi-cart4 h5"></i>
                        <span id="cart-count"
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            style="display: inline-block;">0</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</nav>

<style>
    @media (max-width: 576px) {
        .small-on-mobile {
            font-size: 20px;
        }
    }

    .nav-link {
        transition: 0.3s;
    }

    .nav-link:hover {
        color: whitesmoke !important;
        font-weight: bolder;
    }
</style>