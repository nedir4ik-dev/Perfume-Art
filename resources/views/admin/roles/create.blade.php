@extends('layouts.app')

@section('title', 'Create New Role - Perfume Art Collection')

@push('styles')
<style>
    body {
        background: #0a0a0a !important;
        color: #e0e0e0;
        font-family: 'Inter', sans-serif;
    }

    /* Glass Card Taslamasy */
    .liquid-glass {
        background: rgba(255, 255, 255, 0.02) !important;
        backdrop-filter: blur(20px) saturate(160%);
        -webkit-backdrop-filter: blur(20px) saturate(160%);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 24px !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    }

    /* Input Sazlamalary */
    .glass-input {
        background: rgba(255, 255, 255, 0.04) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: white !important;
        border-radius: 12px;
        padding: 12px 16px;
    }

    .glass-input:focus {
        background: rgba(255, 255, 255, 0.73) !important;
        border-color: #0dcaf0 !important;
        box-shadow: 0 0 15px rgba(13, 202, 240, 0.15) !important;
    }

    /* Permission kartlary üçin dury garaňky arka fon */
    .glass-perm-card {
        background: rgba(255, 255, 255, 0.03) !important;
        border: 1px solid rgba(255, 255, 255, 0.06) !important;
        transition: all 0.2s ease-in-out;
    }

    .glass-perm-card:hover {
        background: rgba(13, 202, 240, 0.06) !important;
        border-color: rgba(13, 202, 240, 0.3) !important;
    }

    ::placeholder {
        color: rgba(255, 255, 255, 0.3) !important;
    }
</style>
@endpush

@section('content')
<div class="admin-wrapper d-flex">
    @include('admin.partials.sidebar')

    <div class="main-content flex-grow-1 min-vh-100 p-3 p-md-5" style="background: radial-gradient(circle at top right, rgba(31, 30, 30, 0.51), transparent), radial-gradient(circle at bottom left, rgba(31, 30, 30, 0.51), transparent) !important; backdrop-filter: blur(5px);">
        <div class="container-xl pt-5">

            {{-- Validation Ýalňyşlyk Habarlary --}}
            @if ($errors->any())
            <div class="alert alert-danger bg-danger bg-opacity-10 border-danger text-danger rounded-4 mb-4 p-3">
                <ul class="mb-0 small ps-3">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Döretmek Karty (Liquid Glass) --}}
            <div class="liquid-glass p-5">

                {{-- Ýokarky Başlyk we Navigasiýa Bölümi --}}
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 pb-3 border-bottom border-white border-opacity-10">

                    {{-- ÇEP TARAP: Title we Subtitle --}}
                    <div>
                        <h2 class="text-white fw-bold mb-1" style="font-size: 32px;">{{ __('app.roles-page-create-title') }}</h2>
                        <p class="text-white-50 small mb-0">{{ __('app.roles-page-create-paragraph') }}</p>
                    </div>

                    {{-- SAG TARAP: Go Back & Dil Dropdown --}}
                    <div class="d-flex align-items-center gap-2">
                        {{-- Yza Ýöneliji Düwme --}}
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-light border-0 rounded-pill px-3 py-2 small d-flex align-items-center" style="background: rgba(255,255,255,0.05);">
                            <i class="bi bi-arrow-left me-2"></i> {{ __('app.roles-page-create-back-btn') }}
                        </a>

                        {{-- Dil Çalşyryjy Dropdown --}}
                        <div class="dropdown">
                            <button class="btn btn-outline-light dropdown-toggle border-0 px-3 py-2 rounded-pill shadow-xl d-flex align-items-center justify-content-center"
                                type="button" id="langDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                style="background: rgba(255,255,255,0.1); height: 38px; min-width: 90px; font-size: 13px;">
                                <i class="bi bi-translate me-2 text-info" style="font-size: 15px;"></i>
                                <span class="text-uppercase fw-bold">{{ app()->getLocale() }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 p-2"
                                aria-labelledby="langDropdown"
                                style="background: rgba(31, 30, 30, 0.95); backdrop-filter: blur(15px); border-radius: 15px; min-width: 140px; z-index: 9999;">
                                <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'tm') }}">🇹🇲 Turkmen</a></li>
                                <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'ru') }}">🇷🇺 Русский</a></li>
                                <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'en') }}">🇺🇸 English</a></li>
                            </ul>
                        </div>
                    </div>

                </div>

                {{-- Form Bölümi --}}
                <form action="{{ route('admin.roles.store') }}" method="POST">
                    @csrf

                    <div class="row g-4">
                        {{-- Roluň sistemadaky ady --}}
                        <div class="col-md-6">
                            <label class="form-label text-info small fw-bold text-uppercase" style="letter-spacing: 0.5px;">{{ __('app.roles-page-create-name-label') }}</label>
                            <input type="text" name="name"
                                value="{{ old('name') }}"
                                class="form-control glass-input shadow-none"
                                placeholder="Meselem: moderator" required>
                            <div class="form-text text-white-50 small opacity-75 mt-1">{{ __('app.roles-page-create-name-help') }}</div>
                        </div>

                        {{-- Roluň görünýän ady --}}
                        <div class="col-md-6">
                            <label class="form-label text-info small fw-bold text-uppercase" style="letter-spacing: 0.5px;">{{ __('app.roles-page-create-label-label') }}</label>
                            <input type="text" name="label"
                                value="{{ old('label') }}"
                                class="form-control glass-input shadow-none"
                                placeholder="Meselem: Sargyt Dolandyryjy" required>
                            <div class="form-text text-white-50 small opacity-75 mt-1">{{ __('app.roles-page-create-label-help') }}</div>
                        </div>

                        {{-- Rugsatlar bölümi --}}
                        <div class="col-12 mt-5">
                            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom border-white border-opacity-10 pb-2">
                                <label class="text-white fw-bold d-flex align-items-center">
                                    <i class="bi bi-shield-lock text-info me-2"></i> {{ __('app.roles-page-create-permissions-title') }}
                                </label>
                                <div class="form-check">
                                    <input class="form-check-input shadow-none" type="checkbox" id="selectAll" style="cursor:pointer;">
                                    <label class="form-check-label text-white-50 small" for="selectAll" style="cursor:pointer;">
                                        {{ __('app.roles-page-create-select-all') }}
                                    </label>
                                </div>
                            </div>

                            <div class="row g-3">
                                @foreach($permissions as $permission)
                                <div class="col-md-6 col-xl-4">
                                    <div class="p-3 rounded-3 glass-perm-card h-100 d-flex align-items-center">
                                        <div class="form-check form-switch custom-switch m-0">
                                            <input class="form-check-input shadow-none" type="checkbox"
                                                name="permissions[]"
                                                value="{{ $permission->id }}"
                                                id="perm{{ $permission->id }}"
                                                style="cursor:pointer;">
                                            <label class="form-check-label text-white ms-2 small" for="perm{{ $permission->id }}" style="cursor:pointer;">
                                                {{ $permission->label }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Düwmeler --}}
                    <div class="d-flex flex-column-reverse flex-md-row justify-content-between align-items-center mt-5 gap-3 pt-3 border-top border-white border-opacity-25">
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-link text-white-50 text-decoration-none px-0 text-center text-md-start small">
                            <i class="bi bi-x-circle me-2"></i>{{ __('app.roles-page-create-cancel-btn') }}
                        </a>
                        <button type="submit" class="btn btn-info rounded-pill px-4 py-2 fw-bold shadow d-flex align-items-center justify-content-center text-dark">
                            <i class="bi bi-check-lg me-2 fs-6"></i>{{ __('app.roles-page-create-save-btn') }}
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAll');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                let checkboxes = document.querySelectorAll('input[name="permissions[]"]');
                checkboxes.forEach(checkbox => checkbox.checked = this.checked);
            });
        }
    });
</script>
@endsection