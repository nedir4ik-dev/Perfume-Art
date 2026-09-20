@extends('layouts.app')

@section('title', 'Create New Product - Perfume Art Collection')

@section('content')
<div class="admin-wrapper d-flex">
    {{-- Sidebar --}}
    @include('admin.partials.sidebar')

    {{-- Ana İçerik Alanı --}}
    <div class="main-content flex-grow-1 p-3 p-md-5"
        style="min-height: 100vh; background-color: rgba(31, 30, 30, 0.51); backdrop-filter: blur(5px);">

        <div class="container-xl pt-5">
            
            {{-- MOBILDE HEM OWADAN DURÝAN RESPONSIVE BAŞLYK BÖLÜMI --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-5 header-section pt-xl-4 pt-3">
                {{-- Çep tarap: Başlyk --}}
                <div class="pt-5 pt-md-2">
                    <h1 class="text-white fw-bold mb-1 responsive-title text-nowrap">
                        {{__('app.product-page-create-title1')}} <span class="text-info">{{__('app.product-page-create-title1.1')}} Perfume</span>
                    </h1>
                </div>

                {{-- Sag tarap: Düwmeler (Telefonda biri-birini gysmaz ýaly owadan aşak düşer) --}}
                <div class="d-flex align-items-center gap-2 w-100 w-md-auto justify-content-between justify-content-md-end">
                    {{-- Go Back Düwmesi --}}
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-light flex-grow-1 flex-md-grow-0 rounded-pill px-3 shadow-xl d-flex align-items-center justify-content-center border-opacity-25 text-white" style="height: 42px; font-size: 13px;">
                        <i class="bi bi-arrow-left me-2"></i> {{__('app.product-page-create-go-back-btn')}}
                    </a>

                    {{-- Dil Dropdown --}}
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle border-0 px-3 py-2 rounded-pill shadow-xl d-flex align-items-center justify-content-center"
                            type="button" id="langDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                            style="background: rgba(255,255,255,0.1); height: 42px; min-width: 95px; font-size: 13px;">
                            <i class="bi bi-translate me-2 text-info" style="font-size: 15px;"></i>
                            <span class="text-uppercase fw-bold text-white">{{ app()->getLocale() }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 p-2"
                            aria-labelledby="langDropdown"
                            style="background: rgba(31, 30, 30, 0.51); backdrop-filter: blur(5px); border-radius: 15px; min-width: 140px; z-index: 9999;">
                            <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'tm') }}">🇹🇲 Turkmen</a></li>
                            <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'ru') }}">🇷🇺 Русский</a></li>
                            <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'en') }}">🇺🇸 English</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Hata Mesajları --}}
            @if ($errors->any())
            <div class="alert alert-danger border-0 rounded-4 mb-4 shadow-sm" style="background: rgba(220, 53, 69, 0.15); backdrop-filter: blur(10px);">
                <ul class="mb-0 small fw-bold text-white">
                    @foreach ($errors->all() as $error)
                    <li><i class="bi bi-exclamation-circle me-2"></i>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Create Form Kartı --}}
            <div class="card border-0 shadow-lg"
                style="background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.08) !important; border-radius: 28px;">
                <div class="card-body p-4 p-lg-5">
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-4 text-white">
                            {{-- Sol Taraf: Temel Bilgiler --}}
                            <div class="col-lg-8">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="text-white-50 small fw-bold text-uppercase mb-2">{{__('app.product-page-create-label-product-name')}}</label>
                                        <input type="text" name="name" class="form-control glass-input" value="{{ old('name') }}" placeholder="{{__('app.product-page-create-label-product-placeholder')}}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="text-white-50 small fw-bold text-uppercase mb-2">{{__('app.product-page-create-label-product')}}</label>
                                        <select name="brand_id" class="form-select glass-input" required>
                                            <option value="" disabled selected>{{__('app.product-page-create-product-option')}}</option>
                                            @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="text-white-50 small fw-bold text-uppercase mb-2">{{__('app.product-page-create-label-product-category')}}</label>
                                        <select name="category_id" class="form-select glass-input" required>
                                            <option value="" disabled selected>{{__('app.product-page-create-product-category-option')}}</option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-white-50 small fw-bold text-uppercase mb-2">{{ __('app.product-page-create-label-product-gender') }}</label>
                                        <select name="gender" class="form-select glass-input">
                                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                            <option value="Unisex" {{ old('gender') == 'Unisex' ? 'selected' : '' }}>Unisex</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-white-50 small fw-bold text-uppercase mb-2">{{__('app.product-page-create-label-product-price')}} ($)</label>
                                        <input type="number" step="0.01" name="price" class="form-control glass-input" value="{{ old('price') }}" placeholder="150.00" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="text-white-50 small fw-bold text-uppercase mb-2">Size (ML)</label>
                                        <input type="number" name="ml_size" class="form-control glass-input" value="{{ old('ml_size') }}" placeholder="100" required>
                                    </div>

                                    {{-- Arzanlaşyk we Wagty --}}
                                    <div class="col-md-6">
                                        <label class="text-warning small fw-bold text-uppercase mb-2">
                                            <i class="bi bi-percent me-1"></i> Arzanlaşyk Göterimi (%)
                                        </label>
                                        <input type="number" name="discount_percent" id="discount_percent" class="form-control glass-input text-warning" value="{{ old('discount_percent', 0) }}" min="0" max="99" placeholder="Mysal: 15">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="text-warning small fw-bold text-uppercase mb-2">
                                            <i class="bi bi-calendar-event me-1"></i> Arzanlaşygyň Gutarjak Wagty
                                        </label>
                                        <input type="datetime-local" name="discount_expires_at" id="discount_expires_at" class="form-control glass-input text-warning" value="{{ old('discount_expires_at') }}">
                                        <small class="text-white-50 d-block mt-1" style="font-size: 11px;">Möhlet gutaranda asyl baha awtomatiki yzyna geler.</small>
                                    </div>

                                    <div class="col-12">
                                        <label class="text-white-50 small fw-bold text-uppercase mb-2">{{__('app.product-page-create-label-product-description')}}</label>
                                        <textarea name="description" rows="5" class="form-control glass-input" placeholder="{{__('app.product-page-create-label-product-description-placeholder')}}">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- Sağ Taraf: Ek Bilgiler ve Medya --}}
                            <div class="col-lg-4">
                                <div class="p-4 rounded-4 mb-4" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 16px;">
                                    <div class="mb-4">
                                        <label class="text-white-50 small fw-bold text-uppercase mb-2">{{__('app.product-page-create-label-product-stock-quantity')}}</label>
                                        <input type="number" name="stock_quantity" class="form-control glass-input" value="{{ old('stock_quantity', 0) }}" required>
                                    </div>

                                    <div class="mb-4">
                                        <label class="text-white-50 small fw-bold text-uppercase mb-2">{{__('app.product-page-create-label-product-photo')}}</label>
                                        <input type="file" name="image" class="form-control glass-input-file w-100" required>
                                        <div class="mt-2 text-white-50 small"><i class="bi bi-info-circle me-1"></i> High quality square image recommended.</div>
                                    </div>

                                    <div class="mb-2">
                                        <label class="text-white-50 small fw-bold text-uppercase mb-2">Scent Notes</label>
                                        <input type="text" name="scent_notes" class="form-control glass-input" value="{{ old('scent_notes') }}" placeholder="Rose, Vanilla...">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-info w-100 py-3 rounded-pill fw-bold text-dark shadow-lg border-0 transition-all hover-lift mt-2">
                                    <i class="bi bi-plus-circle-fill me-2 fs-5"></i> {{__('app.product-page-create-add-product-btn')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div> {{-- Container-fluid END --}}
    </div> {{-- Main-content END --}}
</div> {{-- Admin-wrapper END --}}

<style>
    .glass-input {
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: white !important;
        border-radius: 12px;
        padding: 12px 20px;
    }

    .glass-input:focus {
        border-color: #0dcaf0 !important;
        background: rgba(255, 255, 255, 0.08) !important;
        box-shadow: 0 0 10px rgba(13, 202, 240, 0.2) !important;
    }

    input[type="datetime-local"] {
        color-scheme: dark;
    }

    .glass-input-file {
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: rgba(255, 255, 255, 0.5) !important;
        border-radius: 12px;
        padding: 8px;
    }

    .form-select option {
        background: #1a1a1a;
        color: white;
    }

    .hover-lift:hover {
        transform: translateY(-3px);
        opacity: 0.9;
    }

    @media (max-width: 767.98px) {
        .responsive-title {
            font-size: 1.5rem !important;
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const datetimeInput = document.getElementById('discount_expires_at');
        if (datetimeInput) {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');

            const minDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
            datetimeInput.setAttribute('min', minDateTime);
        }
    });
</script>
@endsection