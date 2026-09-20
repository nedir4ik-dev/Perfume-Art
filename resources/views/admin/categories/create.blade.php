@extends('layouts.app')

@section('title', 'Create New Category - Perfume Art Collection')

@section('content')
<div class="admin-wrapper d-flex">
    @include('admin.partials.sidebar')

    {{-- Ana İçerik Alanı --}}
    <div class="main-content flex-grow-1 p-3 p-md-5" style="background-color: rgba(31, 30, 30, 0.51); backdrop-filter: blur(5px);">
        <div class="container-xl pt-4">

            {{-- RESPONSIVE BAŞLYK BÖLÜMI (Hemme sahypalarda birmeňzeş durnukly gurluş) --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-5 header-section pt-3 pt-xl-5">
                {{-- Çep tarap: Başlyk --}}
                <div class="pt-5 pt-md-2">
                    <h1 class="text-white fw-bold mb-1 text-nowrap">
                        {{ __('app.category-page-create-title1') }} <span class="text-info">{{ __('app.category-page-create-title1.1') }}</span>
                    </h1>
                </div>

                {{-- Sag tarap: Düwmeler --}}
                <div class="d-flex align-items-center gap-2 w-100 w-md-auto justify-content-between justify-content-md-end">
                    {{-- Go Back Düwmesi --}}
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-light flex-grow-1 flex-md-grow-0 rounded-pill px-3 shadow-xl d-flex align-items-center justify-content-center border-opacity-25" style="height: 42px; font-size: 13px;">
                        <i class="bi bi-arrow-left me-2"></i> {{ __('app.category-page-create-go-back-btn') }}
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

            {{-- ESASY FORM BÖLÜMI (Kompýuterde ortalanan owadan gurluş, telefonda doly giňlik) --}}
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card settings-card border-0 shadow-lg"
                        style="background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.08) !important; border-radius: 24px;">
                        <div class="card-body p-4 p-md-5 text-white">

                            <form action="{{ route('admin.categories.store') }}" method="POST">
                                @csrf

                                <div class="mb-4">
                                    <label class="text-white-50 small fw-bold text-uppercase mb-2 tracking-wide">
                                        {{ __('app.category-page-create-label-category-name') }}
                                    </label>
                                    <input type="text" name="name" class="form-control glass-input @error('name') is-invalid @enderror" placeholder="Mysal: Gündogar yslary" required autofocus>
                                    @error('name')
                                    <div class="invalid-feedback mt-2 font-monospace" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-info w-100 py-3 rounded-pill fw-bold text-dark shadow-lg border-0 transition-all hover-lift d-flex align-items-center justify-content-center gap-2" style="height: 50px; font-size: 15px;">
                                    <i class="bi bi-plus-circle-fill fs-5"></i> {{ __('app.category-page-create-add-category-btn') }}
                                </button>
                            </form>

                        </div>
                    </div>
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

    .hover-lift:hover {
        transform: translateY(-3px);
        opacity: 0.9;
    }
</style>
@endsection