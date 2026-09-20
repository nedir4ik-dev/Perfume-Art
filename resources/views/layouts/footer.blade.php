<div class="mt-5 bg-dark bg-opacity-10 pt-5 pb-4 border-top border-secondary border-opacity-25"
    style="backdrop-filter: blur(10px);">
    <div class="container-xl">

        {{-- SECTION 1: Ynam we Hyzmat Ikonkalary (Trust Badges) --}}
        <div class="row border-bottom justify-content-center border-secondary border-opacity-25 pb-4 mb-4 text-center text-md-start g-3">
            <div class="col-5 col-md-4 d-flex align-items-center justify-content-center justify-content-md-start gap-3">
                <i class="bi bi-truck fs-2 text-info"></i>
                <div>
                    <div class="fw-bold small text-white">{{__('app.footer-trust-badge-1-title')}}</div>
                    <div class="small text-white-50" style="font-size: 12px;">{{__('app.footer-trust-badge-1-subtitle')}}</div>
                </div>
            </div>
            <div class="col-5 col-md-4 d-flex align-items-center justify-content-center gap-3">
                <i class="bi bi-shield-check fs-2 text-success"></i>
                <div>
                    <div class="fw-bold small text-white">{{__('app.footer-trust-badge-2-title')}}</div>
                    <div class="small text-white-50" style="font-size: 12px;">{{__('app.footer-trust-badge-2-subtitle')}}</div>
                </div>
            </div>
            <div class="col-11 col-md-4 d-flex align-items-center justify-content-center justify-content-md-end gap-3">
                <i class="bi bi-headset fs-2 text-warning"></i>
                <div>
                    <div class="fw-bold small text-white">{{__('app.footer-trust-badge-3-title')}}</div>
                    <div class="small text-white-50" style="font-size: 12px;">{{__('app.footer-trust-badge-3-subtitle')}}</div>
                </div>
            </div>
        </div>

        {{-- SECTION 2: Tiz Linkler & Sütünler --}}
        <div class="row g-4 mb-4 text-center text-md-start">

            {{-- Sütün 1: Saýt barada gysgaça --}}
            <div class="col-12 col-md-4">
                <div class="d-flex align-items-center justify-content-center justify-content-md-start mb-3">
                    @if(get_setting('site_logo'))
                    <img src="{{ asset('storage/' . get_setting('site_logo')) }}" alt="{{ get_setting('site_name') }}" width="35" height="35" class="me-2 rounded shadow">
                    @else
                    <img src="{{ asset('images/favicon/parfum-art.png') }}" width="35" height="35" class="me-2">
                    @endif
                    <span class="fw-bold text-white fs-5">{{ get_setting('site_name', 'Perfume-Art') }}</span>
                </div>
                <p class="small text-white-50 lh-base mb-0">
                    {{__('app.footer-description')}}
                </p>
            </div>

            {{-- Sütün 2: Tiz Linkler --}}
            <div class="col-6 col-md-4">
                <h6 class="text-white fw-bold mb-3 text-uppercase small" style="letter-spacing: 1px;">{{__('app.footer-fast-actions-title')}}</h6>
                <ul class="list-unstyled small mb-0">
                    <li class="mb-2">
                        <a href="{{ route('home') }}" class="text-white-50 text-decoration-none transition-hover">
                            <i class="bi bi-chevron-right small me-1"></i> {{ __('app.nav-home') }}
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('about') }}" class="text-white-50 text-decoration-none transition-hover">
                            <i class="bi bi-chevron-right small me-1"></i> {{ __('app.nav-about-us') }}
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('contact') }}" class="text-white-50 text-decoration-none transition-hover">
                            <i class="bi bi-chevron-right small me-1"></i> {{ __('app.nav-contact') }}
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('orders.my') }}" class="text-white-50 text-decoration-none transition-hover">
                            <i class="bi bi-chevron-right small me-1"></i> {{ __('app.nav-my-orders') }}
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Sütün 3: Şertler we Hyzmatlar --}}
            <div class="col-6 col-md-4">
                <h6 class="text-white fw-bold mb-3 text-uppercase small" style="letter-spacing: 1px;">{{__('app.footer-terms-services-title')}}</h6>
                <ul class="list-unstyled small mb-0">
                    <li class="mb-2">
                        <a href="{{ route('privacy') }}" class="text-white-50 text-decoration-none transition-hover">
                            <i class="bi bi-shield-lock me-1"></i> {{__('app.footer-terms-services-link-1')}}
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('terms') }}" class="text-white-50 text-decoration-none transition-hover">
                            <i class="bi bi-file-earmark-text me-1"></i> {{__('app.footer-terms-services-link-2')}}
                        </a>
                    </li>
                    @if(get_setting('site_phone'))
                    <li class="mb-2">
                        <a href="tel:{{ get_setting('site_phone') }}" class="text-white-50 text-decoration-none transition-hover">
                            <i class="bi bi-telephone me-1"></i> {{ get_setting('site_phone') }}
                        </a>
                    </li>
                    @endif
                </ul>
            </div>

        </div>

        {{-- SECTION 3: Copyright we Sosial Torlar --}}
        <footer class="row align-items-center g-3 pt-3 border-top border-secondary border-opacity-25 text-center text-md-start">

            <div class="col-12 col-md-8 text-white">
                <span class="opacity-75 small text-nowrap">
                    {{ get_setting('site_copyright', '© 2025 - ' . date('Y') . ' ' . get_setting('site_name', 'Perfume-Art') . ' Shop, Inc.') }}
                </span>
            </div>

            <div class="col-12 col-md-4">
                <ul class="nav list-unstyled d-flex align-items-center justify-content-center justify-content-md-end mb-0 gap-3">

                    {{-- Mobil üçin Sargytlarym --}}
                    <li class="d-md-none">
                        <a class="text-light transition-hover h6 fs-5" href="{{ route('orders.my') }}" title="Sargytlarym">
                            <i class="bi bi-box-seam"></i>
                        </a>
                    </li>

                    {{-- WhatsApp --}}
                    @if(get_setting('social_whatsapp'))
                    <li>
                        <a class="text-success transition-hover h6 fs-5"
                            href="https://wa.me/{{ preg_replace('/[^0-9]/', '', get_setting('social_whatsapp')) }}" target="_blank">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </li>
                    @endif

                    {{-- TikTok --}}
                    @if(get_setting('social_tiktok'))
                    <li>
                        <a class="text-white opacity-75 h6 fs-5 transition-hover" href="{{ get_setting('social_tiktok') }}" target="_blank">
                            <i class="bi bi-tiktok"></i>
                        </a>
                    </li>
                    @endif

                    {{-- Instagram --}}
                    @if(get_setting('social_instagram'))
                    <li>
                        <a class="text-white opacity-75 h6 fs-5 transition-hover" href="{{ get_setting('social_instagram') }}" target="_blank">
                            <i class="bi bi-instagram"></i>
                        </a>
                    </li>
                    @endif

                    {{-- Telegram --}}
                    @if(get_setting('social_telegram'))
                    <li>
                        <a class="text-info opacity-75 h6 fs-5 transition-hover" href="{{ get_setting('social_telegram') }}" target="_blank">
                            <i class="bi bi-telegram"></i>
                        </a>
                    </li>
                    @endif

                    {{-- Admin Login --}}
                    <li>
                        <a class="text-white opacity-25 h6 fs-5 transition-hover" href="{{ route('login') }}">
                            <i class="bi bi-server"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </footer>

    </div>
</div>

{!! get_setting('custom_header_script') !!}

<style>
    .transition-hover {
        transition: all 0.3s ease;
    }

    .transition-hover:hover {
        opacity: 1 !important;
        color: #0dcaf0 !important;
        padding-left: 3px;
    }

    @media (max-width: 767.98px) {
        footer .col-12 {
            line-height: 1.8;
        }
    }
</style>