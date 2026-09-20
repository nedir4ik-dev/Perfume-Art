@extends('layouts.app')

@section('title', 'Edit Brand - Perfume Art Collection')

@section('content')
<div class="admin-wrapper d-flex">
    @include('admin.partials.sidebar')

    {{-- Ana İçerik Alanı --}}
    <div class="main-content flex-grow-1 p-3 p-md-5" style="background-color: rgba(31, 30, 30, 0.51); backdrop-filter: blur(5px);">
        <div class="container-xl pt-4">

            {{-- RESPONSIVE BAŞLYK BÖLÜMI (Beýleki sahypalar bilen doly bir meňzeş) --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-5 header-section pt-3 pt-xl-5">
                {{-- Çep tarap: Başlyk --}}
                <div class="pt-5 pt-md-2">
                    <h1 class="text-white fw-bold mb-1 text-nowrap">
                        {{ __('app.brand-page-edit-title1') }} <span class="text-info">{{ $brand->name }}</span>
                    </h1>
                </div>

                {{-- Sag tarap: Düwmeler --}}
                <div class="d-flex align-items-center gap-2 w-100 w-md-auto justify-content-between justify-content-md-end">
                    {{-- Go Back Düwmesi --}}
                    <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-light flex-grow-1 flex-md-grow-0 rounded-pill px-3 shadow-xl d-flex align-items-center justify-content-center border-opacity-25" style="height: 42px; font-size: 13px;">
                        <i class="bi bi-arrow-left me-2"></i> {{ __('app.brand-page-edit-go-back-btn') }}
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

            {{-- ESASY EDIT FORM KARTY --}}
            <div class="card settings-card border-0 shadow-lg"
                style="background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.08) !important; border-radius: 28px;">
                <div class="card-body p-4 p-lg-5">
                    <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-4 text-white">
                            {{-- Brand Name --}}
                            <div class="col-12">
                                <label class="text-white-50 small fw-bold text-uppercase mb-2 tracking-wide">{{ __('app.brand-page-edit-label-brand-name') }}</label>
                                <input type="text" name="name" value="{{ old('name', $brand->name) }}" class="form-control glass-input @error('name') is-invalid @enderror" required autofocus>
                                @error('name') <div class="invalid-feedback mt-2 font-monospace" style="font-size: 12px;">{{ $message }}</div> @enderror
                            </div>

                            {{-- Brand Logo we Täze Logo Ýüklemek --}}
                            <div class="col-12">
                                <label class="text-white-50 small fw-bold text-uppercase mb-2 tracking-wide d-block">{{ __('app.brand-page-edit-label-logo-text') }}</label>
                                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-4 p-3 rounded-4" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                                    @if($brand->logo_url)
                                    <div class="p-2 bg-white rounded-3 shadow-sm d-inline-block flex-shrink-0" style="line-height: 0;">
                                        <img src="{{ asset('storage/' . $brand->logo_url) }}" class="rounded-2" style="width: 70px; height: 70px; object-fit: contain;">
                                    </div>
                                    @endif
                                    <div class="flex-grow-1 w-100">
                                        <input type="file" name="logo_url" class="form-control glass-input-file w-100 @error('logo_url') is-invalid @enderror">
                                        <small class="text-white-50 mt-2 d-block" style="font-size: 12px;">
                                            <i class="bi bi-info-circle-fill text-info me-1"></i> {{ __('app.brand-page-edit-label-logo-subtext') }}
                                        </small>
                                        @error('logo_url') <div class="invalid-feedback mt-2 font-monospace" style="font-size: 12px;">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="col-12">
                                <label class="text-white-50 small fw-bold text-uppercase mb-2 tracking-wide">{{ __('app.brand-page-edit-label-description-text') }}</label>
                                <textarea name="description" rows="5" class="form-control glass-input @error('description') is-invalid @enderror" placeholder="Brend barada gysgaça maglumat...">{{ old('description', $brand->description) }}</textarea>
                                @error('description') <div class="invalid-feedback mt-2 font-monospace" style="font-size: 12px;">{{ $message }}</div> @enderror
                            </div>

                            {{-- Status Switch --}}
                            <div class="col-12 mb-2">
                                <div class="form-check form-switch custom-switch d-flex align-items-center p-0 m-0">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="isActive" {{ $brand->is_active ? 'checked' : '' }} style="margin-left: 0;">
                                    <label class="form-check-label ms-3 text-white-50 fw-bold small text-uppercase tracking-wide" for="isActive">
                                        {{ __('app.brand-page-edit-is-active') }}
                                    </label>
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-info w-100 py-3 rounded-pill fw-bold text-dark shadow-lg border-0 transition-all hover-lift d-flex align-items-center justify-content-center gap-2" style="height: 54px; font-size: 16px;">
                                    <i class="bi bi-save-fill fs-5"></i> {{ __('app.brand-page-edit-edit-brand-btn') }}
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

    .glass-input-file {
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: rgba(255, 255, 255, 0.5) !important;
        border-radius: 12px;
        padding: 8px;
    }

    .custom-switch .form-check-input {
        background-color: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.2);
        height: 24px;
        width: 44px;
        cursor: pointer;
    }

    .custom-switch .form-check-input:checked {
        background-color: #0dcaf0;
        border-color: #0dcaf0;
    }

    .hover-lift:hover {
        transform: translateY(-3px);
        opacity: 0.9;
    }
</style>
@endsection