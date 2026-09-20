@extends('layouts.app')

@section('og_title', $product->name . ' - ' . ($product->brand->name ?? 'Perfume Art'))
@section('og_description', Str::limit($product->description, 150))
@section('og_image', $product->image ? asset('storage/' . $product->image) : asset("images/default-perfume.jpg"))

@section('title', $product->name)

@section('content')
@php
$imagePath = $product->image ? asset('storage/' . $product->image) : asset("images/default-perfume.jpg");
@endphp

<div class="container mt-4">
    <nav class="mb-4" aria-label="breadcrumb">
        <ol class="breadcrumb d-flex align-items-center bg-dark bg-opacity-25 border border-white border-opacity-10 rounded-pill px-4 py-2 shadow-sm mb-0">

            <li class="breadcrumb-item d-flex align-items-center">
                <a href="{{ url()->previous() == url()->current() ? url('/') : url()->previous() }}"
                    class="text-white text-decoration-none small d-flex align-items-center">
                    <i class="bi bi-arrow-left me-2"></i> {{ __('app.show-page-breadcrumb-back') }}
                </a>
            </li>

            <li class="breadcrumb-item active text-white small d-flex align-items-center" aria-current="page">
                <span class="ms-1 border-start border-white border-opacity-25 ps-3">{{ $product->name }}</span>
            </li>

            <li class="ms-auto">
                <div class="dropdown">
                    <button class="btn btn-outline-light dropdown-toggle border-0 px-3 py-2 rounded-pill shadow-xl d-flex align-items-center justify-content-center"
                        type="button" id="langDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                        style="background: rgba(66, 65, 65, 0.57); height: 42px; min-width: 95px; font-size: 13px;">
                        <i class="bi bi-translate me-2 text-info" style="font-size: 15px;"></i>
                        <span class="text-uppercase fw-bold">{{ app()->getLocale() }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 p-2"
                        aria-labelledby="langDropdown"
                        style="background: rgba(31, 30, 30, 0.51); backdrop-filter: blur(5px); border-radius: 15px; min-width: 140px; z-index: 1000;">
                        <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'tm') }}">🇹🇲 Turkmen</a></li>
                        <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'ru') }}">🇷🇺 Русский</a></li>
                        <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'en') }}">🇺🇸 English</a></li>
                    </ul>
                </div>
            </li>
        </ol>
    </nav>

    <div class="row g-5 align-items-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-lg p-3 rounded-4 text-center justify-content-center align-items-center"
                style="background: rgba(31, 30, 30, 0.51) !important; backdrop-filter: blur(3px); border: 1px solid rgba(255,255,255,0.08) !important; min-height: 450px;">
                <a href="{{ $imagePath }}" data-fancybox="gallery" data-caption="{{ $product->name }}" class="w-100">
                    <img src="{{ $imagePath }}" class="img-fluid rounded-3" alt="{{ $product->name }}"
                        style="max-height: 430px; object-fit: contain; width: auto; filter: drop-shadow(0px 10px 20px rgba(0,0,0,0.3));">
                </a>
            </div>
        </div>

        <div class="col-lg-6 text-white">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-primary px-3 py-2 rounded-pill">{{ $product->gender }}</span>
                @if($product->discount_percent > 0)
                <span class="badge bg-danger px-3 py-2 rounded-pill">-{{ $product->discount_percent }}%</span>
                @endif
            </div>

            <h1 class="display-5 my-2 fw-bold">{{ $product->name }}</h1>
            <p class="text-white-50 small h5 mb-1">Brand: <span class="text-white fw-bold">{{ $product->brand->name ?? '-' }}</span></p>
            <p class="text-white-50 small h5 mb-4">Category: <span class="text-white fw-bold">{{ $product->category->name ?? '-' }}</span></p>

            <div class="col-12 rounded-5 mb-4">
                @if($product->discount_percent > 0)
                <span class="text-danger text-decoration-line-through small d-block mb-1">
                    {{ number_format($product->price, 2) }} $
                </span>
                <h2 class="fw-bold text-white mb-0">
                    {{ number_format($product->discounted_price, 2) }} $
                </h2>
                <h5 class="small text-white mt-1">
                    {{ number_format($product->discounted_price * $exchange_rate, 2) }} TMT
                </h5>
                @else
                <h2 class="fw-bold text-white mb-0">
                    {{ number_format($product->price, 2) }} $
                </h2>
                <u>
                    <h5 class="small text-white-50 mt-1">
                        {{ number_format($product->price * $exchange_rate, 2) }} TMT
                    </h5>
                </u>
                @endif
            </div>

            <div class="mb-4">
                <span class="badge border border-light rounded-pill px-3 py-2">{{ $product->ml_size }} ml</span>
            </div>

            <div class="description mb-5">
                <h6 class="text-uppercase fw-bold text-light small opacity-50">{{ __('app.show-page-description-subtitle') }}</h6>
                <p class="opacity-75 lead" style="font-size: 0.95rem;">{{ $product->description }}</p>
            </div>

            @if(!empty($product->scent_notes))
            <div class="scent-notes-box p-4 rounded-4 mb-4" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); backdrop-filter: blur(5px);">
                <h6 class="text-uppercase fw-bold text-info mb-3 d-flex align-items-center" style="letter-spacing: 1px; font-size: 0.85rem;">
                    <i class="bi bi-diagram-3 me-2"></i> Yslaryň Düzümi (Fragrance Pyramid)
                </h6>

                @php
                // Diňe ilkinji bölümi (Top Notes) alýarys
                $topNote = trim(explode('|', $product->scent_notes)[0] ?? '');
                @endphp

                @if($topNote)
                <div class="p-3 rounded-3" style="background: rgba(0, 0, 0, 0.2); border-left: 3px solid #0dcaf0;">
                    <span class="text-white-50 small d-block mb-1 fw-semibold">Top Notes</span>
                    <span class="text-white small fw-bold">{{ $topNote }}</span>
                </div>
                @endif
            </div>
            @endif

            <div class="d-flex align-items-center flex-wrap gap-3 gap-md-4">
                {{-- Add to Cart --}}
                <button class="btn btn-primary btn-lg rounded-pill px-4 px-md-5 shadow add-to-cart-btn flex-grow-1 flex-md-grow-0"
                    data-id="{{ $product->id }}"
                    data-name="{{ $product->name }}"
                    data-price="{{ $product->discount_percent > 0 ? $product->discounted_price : $product->price }}"
                    data-image="{{ $imagePath }}">
                    <i class="bi-cart4 me-1 me-md-2"></i> {{ __('app.show-page-add-to-card-btn') }}
                </button>

                {{-- Share Button --}}
                <div class="">
                    <button onclick="shareProduct()" class="btn btn-outline-light border-0 opacity-75 d-flex align-items-center gap-2 p-2 px-md-2 hover-white shadow-none">
                        <i class="bi bi-share-fill fs-5"></i>
                        <span class="small fw-bold text-uppercase tracking-wider d-none d-md-inline">Paýlaş</span>
                    </button>
                </div>

                <div class="stock-info ms-md-auto">
                    @if($product->stock_quantity > 0)
                    <small class="text-success d-block fw-bold">● {{ __('app.in_stock') }}</small>
                    <strong class="text-white small opacity-75">{{ $product->stock_quantity }} {{ __('app.pieces') }}</strong>
                    @else
                    <span class="text-danger fw-bold small text-uppercase">{{ __('app.out_of_stock') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- Meňzeş Harytlar Bölümi --}}
    @if($relatedProducts->count() > 0)
    <div class="related-products mt-5 pt-5 border-top border-white border-opacity-10">
        <h3 class="text-white fw-bold mb-4 d-flex align-items-center">
            <i class="bi bi-stars text-warning me-2"></i> {{ __('app.show-page-related-products-title') ?? 'Meňzeş harytlar' }}
        </h3>

        <div class="row row-cols-2 row-cols-md-2 row-cols-lg-4 g-4">
            @foreach($relatedProducts as $related)
            <div class="col">
                <div class="card h-100 border-0 bg-dark bg-opacity-50 rounded-4 overflow-hidden shadow-sm transition-hover">
                    <a href="{{ route('product.show', $related->slug) }}" class="text-decoration-none">
                        {{-- DÜZEDILEN BÖLÜM: Meňzeş harytlaryň hem surat fonlary utgaşdyryldy --}}
                        <div class="p-3 text-center rounded-4 m-2" style="background: rgba(31, 30, 30, 0.4) !important; border: 1px solid rgba(255,255,255,0.05);">
                            <img src="{{ $related->image ? asset('storage/' . $related->image) : asset('images/default-perfume.jpg') }}"
                                class="img-fluid rounded-3"
                                alt="{{ $related->name }}"
                                style="height: 160px; object-fit: contain; filter: drop-shadow(0px 5px 10px rgba(0,0,0,0.3));">
                        </div>
                        <div class="card-body p-3 text-center">
                            <h6 class="text-white text-truncate mb-1">{{ $related->name }}</h6>
                            <p class="text-secondary small mb-2">{{ $related->category->name ?? 'Designer' }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-2 px-1">
                                <span class="text-success fw-bold">{{ number_format($related->price, 2) }}$</span>
                                <span class="badge border border-secondary text-secondary rounded-pill" style="font-size: 0.7rem;">
                                    {{ $related->ml_size }} ml
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Fancybox !== 'undefined') {
            Fancybox.bind("[data-fancybox]", {
                infinite: false
            });
        }
    });

    function shareProduct() {
        const shareData = {
            title: "{{ $product->name }}",
            text: "🔥 {{ $product->brand->name ?? '' }} - {{ $product->name }}\n📏 Ölçegi: {{ $product->ml_size }} ml\n💰 Bahasy: {{ number_format($product->price, 2) }} $\n\nBu atyra Perfume-Art Collection-da seret:",
            url: window.location.href
        };

        if (navigator.share) {
            navigator.share(shareData)
                .then(() => console.log('Üstünlikli paýlaşyldy!'))
                .catch((error) => console.log('Paýlaşmakda säwlik:', error));
        } else {
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Salgysy göçürildi! (Mobil däl enjamlar üçin)');
            });
        }
    }
</script>
@endsection