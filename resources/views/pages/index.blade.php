@extends('layouts.app')

@section('content')
@php
    $locale = app()->getLocale();
@endphp

<style>
    /* Continuous Marquee Ticker */
    .marquee-container {
        width: 100%;
        overflow: hidden;
        background: var(--bg-surface);
        border-top: 1px solid var(--border-color);
        border-bottom: 1px solid var(--border-color);
        padding: 12px 0;
        white-space: nowrap;
        position: relative;
        z-index: 5;
    }

    .marquee-content {
        display: inline-flex;
        gap: 60px;
        animation: scroll-marquee 30s linear infinite;
        will-change: transform;
    }

    .marquee-container:hover .marquee-content {
        animation-play-state: paused;
    }

    .marquee-item {
        color: var(--text-secondary);
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 12px;
        letter-spacing: 0.5px;
    }

    @keyframes scroll-marquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }

    .carousel-item {
        transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1) !important;
    }

    .carousel-indicators [data-bs-target] {
        background-color: var(--text-secondary);
        transition: all 0.3s ease;
    }

    .carousel-indicators .active {
        background-color: var(--accent-color) !important;
        width: 35px !important;
    }

    .hero-card-wrapper {
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        box-shadow: var(--card-shadow);
    }

    .custom-row-height {
        min-height: auto;
    }

    .hero-main-img {
        max-height: 240px;
        width: 100%;
        object-fit: contain;
        filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.5));
    }

    .hero-desc-text {
        font-size: 0.95rem;
    }

    .style-badge {
        font-size: 0.75rem;
        letter-spacing: 1px;
    }

    @media (min-width: 992px) {
        .custom-row-height { min-height: 520px; }
        .hero-main-img { max-height: 420px !important; }
        .hero-desc-text { font-size: 1.25rem !important; }
        .hero-main-title { font-size: 3.8rem !important; }
        .style-badge { font-size: 0.85rem; }
        .hero-btn { font-size: 1rem !important; }
        .border-end-lg { border-right: 1px solid var(--border-color) !important; }
    }

    @media (max-width: 768px) {
        .marquee-container { padding: 10px 0; }
        .marquee-item { font-size: 13px; }
        .marquee-content { animation-duration: 25s; }
    }

    /* Live Search Popover */
    .search-wrapper {
        position: relative;
    }

    .search-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        z-index: 9999;
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: 14px;
        box-shadow: var(--card-shadow);
        margin-top: 8px;
        max-height: 350px;
        overflow-y: auto;
        display: none;
    }

    .search-dropdown-item {
        display: flex;
        align-items: center;
        padding: 12px 18px;
        color: var(--text-primary);
        text-decoration: none;
        font-size: 14px;
        transition: all 0.2s ease;
        border-bottom: 1px solid var(--border-color);
    }

    .search-dropdown-item:last-child {
        border-bottom: none;
    }

    .search-dropdown-item:hover {
        background: rgba(255, 255, 255, 0.05);
        color: var(--accent-color);
        padding-left: 22px;
    }

    .search-dropdown-item i {
        font-size: 14px;
        opacity: 0.6;
    }

    /* Full-Width Infinite Brands Marquee */
    .brands-marquee-fullwidth {
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
        overflow: hidden;
        background: var(--bg-surface);
        border-top: 1px solid var(--border-color);
        border-bottom: 1px solid var(--border-color);
        padding: 22px 0;
        white-space: nowrap;

        mask-image: linear-gradient(to right, transparent 0%, black 12%, black 88%, transparent 100%);
        -webkit-mask-image: linear-gradient(to right, transparent 0%, black 12%, black 88%, transparent 100%);
    }

    .brands-marquee-track {
        display: inline-flex;
        align-items: center;
        animation: scroll-brands-seamless 20s linear infinite;
        will-change: transform;
    }

    .brands-marquee-fullwidth:hover .brands-marquee-track {
        animation-play-state: paused;
    }

    .brand-marquee-item {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 45px;
        opacity: 0.85;
        transition: all 0.3s ease;
    }

    .brand-marquee-item:hover {
        opacity: 1;
        transform: scale(1.12);
    }

    .brand-img {
        height: 38px !important;
        width: auto !important;
        max-width: 130px !important;
        object-fit: contain !important;
        display: block !important;
        filter: none !important;
    }

    @keyframes scroll-brands-seamless {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
</style>

<div class="container-xl">
    <div class="d-flex justify-content-end pt-4">
        <div class="dropdown">
            <button class="btn btn-outline-light dropdown-toggle border-0 px-3 py-2 rounded-pill shadow-xl d-flex align-items-center justify-content-center"
                type="button" id="langDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                style="background: var(--bg-surface); height: 42px; min-width: 95px; font-size: 13px; border: 1px solid var(--border-color);">
                <i class="bi bi-translate me-2 text-info" style="font-size: 15px;"></i>
                <span class="text-uppercase fw-bold">{{ $locale }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 p-2"
                aria-labelledby="langDropdown"
                style="background: var(--bg-surface); border: 1px solid var(--border-color); border-radius: 15px; min-width: 140px; z-index: 1000;">
                <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'tm') }}">🇹🇲 Turkmen</a></li>
                <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'ru') }}">🇷🇺 Русский</a></li>
                <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'en') }}">🇺🇸 English</a></li>
            </ul>
        </div>
    </div>
</div>

@if(!empty($advertisements) && $advertisements->count() > 0)
<div class="container-xl my-3 my-xl-3">
    <div id="mainHeroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4500">

        <div class="carousel-indicators mb-2 mb-xl-3" style="z-index: 15;">
            @foreach($advertisements as $index => $heroAd)
            <button type="button" data-bs-target="#mainHeroCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}" style="width: 25px; height: 4px; border-radius: 2px;"></button>
            @endforeach
        </div>

        <div class="carousel-inner rounded-4 hero-card-wrapper text-white">
            @foreach($advertisements as $index => $heroAd)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }} px-3 px-xl-5 py-4 py-lg-5">
                <div class="row flex-column-reverse flex-lg-row align-items-center g-4 custom-row-height">

                    <div class="col-lg-7 text-center text-lg-start position-relative py-2" style="z-index: 20;">

                        @php
                            $badge = $heroAd->{'badge_' . $locale} ?? null;
                            $title = $heroAd->{'title_' . $locale} ?? '';
                            $desc  = $heroAd->{'description_' . $locale} ?? null;
                        @endphp

                        @if($badge)
                        <span class="badge bg-dark text-light text-uppercase mb-3 px-3 py-2 rounded-pill fw-bold style-badge" style="border: 1px solid var(--border-color);">
                            {{ $badge }}
                        </span>
                        @endif

                        <h1 class="display-4 display-lg-2 fw-bold text-white mb-3 hero-main-title" style="line-height: 1.1;">
                            {{ $title }}
                        </h1>

                        @if($desc)
                        <p class="lead mb-4 mb-lg-5 text-white-50 hero-desc-text" style="line-height: 1.6;">
                            {{ $desc }}
                        </p>
                        @endif

                        <div class="d-flex justify-content-center justify-content-lg-start gap-3 mb-5 position-relative" style="z-index: 30;">
                            <a href="#products-container" class="btn btn-light rounded-pill px-4 px-xl-5 py-2 py-xl-3 fw-bold shadow hero-btn">
                                {{ __('app.search-now-btn') ?? 'Häzir Gözle' }}
                            </a>
                            @if($heroAd->link)
                            <a href="{{ $heroAd->link }}" class="btn btn-outline-light rounded-pill px-4 px-xl-5 py-2 py-xl-3 border-white border-opacity-50 hero-btn">
                                {{ __('app.view-more-btn') ?? 'Doly Gör' }}
                            </a>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-5 text-center position-relative" style="z-index: 10;">
                        @if($heroAd->image)
                        <div class="p-2 p-xl-3 mx-auto hero-img-box">
                            <a href="{{ $heroAd->link }}" class="text-decoration-none">
                                <img src="{{ asset('storage/' . $heroAd->image) }}" class="img-fluid rounded-4 hero-main-img" alt="Advertisement" loading="lazy" decoding="async">
                            </a>
                        </div>
                        @endif
                    </div>

                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>
@endif

@if(!empty($tickers) && $tickers->count() > 0)
<div class="marquee-container">
    <div class="marquee-content">
        @php $contentField = 'content_' . $locale; @endphp
        @foreach($tickers->concat($tickers) as $item)
        <span class="marquee-item">
            <i class="bi {{ $item->icon }} {{ $item->color }}"></i>
            {{ $item->$contentField ?? $item->content }}
        </span>
        @endforeach
    </div>
</div>
@endif

<div class="container-xl mt-5 pb-5 position-relative" style="z-index: 2;">
    <div class="row mb-5 text-center">
        <div class="col-12">
            <div class="display-4 fw-bold text-white">{{ get_setting('site_name') ?? '' }}</div>
            <div class="text-white-50 mt-2">{{ __('app.main-p-tag') }}</div>
        </div>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-md-7 col-lg-5">
            <div class="search-wrapper position-relative">
                <input type="text" id="product-search"
                    class="form-control text-white px-4 py-2 shadow-none"
                    placeholder="{{ __('app.search') }}"
                    autocomplete="off"
                    style="background-color: var(--bg-surface); color: white; border: 1px solid var(--border-color);">
                <i class="bi bi-search position-absolute end-0 top-50 translate-middle-y me-3 text-white-50"></i>

                <div id="search-dropdown" class="search-dropdown"></div>
            </div>
        </div>
    </div>

    <div class="row g-4" id="products-container">
        @forelse($products as $product)
        @include('partials.product_card', ['product' => $product])
        @empty
        <div class="col-12 text-center py-5">
            <h3 class="text-white-50 text-center">Gözlegiňize görä hiç hili haryt tapylmady.</h3>
        </div>
        @endforelse
    </div>

    <div class="mt-5 d-flex justify-content-end custom-pagination">
        {{ $products->links() }}
    </div>
</div>

{{-- Full-Width Brands Marquee --}}
<div class="brands-marquee-fullwidth mt-5">
    <div class="brands-marquee-track">
        @php
        $brandLogos = ['chanel.png', 'dior.png', 'tomford.png', 'creed.png', 'versace.png'];
        @endphp

        @for ($i = 0; $i < 2; $i++)
            @foreach($brandLogos as $logo)
            <div class="brand-marquee-item">
                <img src="{{ asset('images/brands/' . $logo) }}" alt="Brand" class="brand-img" loading="lazy" decoding="async">
            </div>
            @endforeach
        @endfor
    </div>
</div>
@endsection

@section('scripts')
<script>
    if (typeof Fancybox !== 'undefined') {
        Fancybox.bind("[data-fancybox='gallery']", {
            Images: {
                zoom: true
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const marqueeContainer = document.querySelector('.marquee-container');
        const marqueeContent = document.querySelector('.marquee-content');

        if (marqueeContainer && marqueeContent) {
            marqueeContainer.addEventListener('touchstart', () => {
                marqueeContent.style.animationPlayState = 'paused';
            }, { passive: true });

            marqueeContainer.addEventListener('touchend', () => {
                marqueeContent.style.animationPlayState = 'running';
            }, { passive: true });
        }
    });
</script>
@endsection
