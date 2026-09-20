@extends('layouts.app')

@section('title', 'Add New Advertisement - Perfume Art')

@section('content')
<style>
    body {
        background: #0a0a0a !important;
        color: #e0e0e0;
        font-family: 'Inter', sans-serif;
    }

    .main-content {
        background: radial-gradient(circle at top right, rgba(31, 30, 30, 0.51), transparent),
            radial-gradient(circle at bottom left, rgba(31, 30, 30, 0.51), transparent) !important;
        min-height: 100vh;
        backdrop-filter: blur(5px);
    }

    .liquid-card {
        background: rgba(255, 255, 255, 0.02) !important;
        backdrop-filter: blur(20px) saturate(160%);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 24px !important;
    }

    .form-control {
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: white !important;
    }

    .form-control:focus {
        border-color: #0dcaf0 !important;
        box-shadow: 0 0 10px rgba(13, 202, 240, 0.2) !important;
        background: rgba(255, 255, 255, 0.07) !important;
    }

    .nav-tabs-premium {
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    .nav-tabs-premium .nav-link {
        color: rgba(255, 255, 255, 0.5) !important;
        border: none !important;
        border-bottom: 2px solid transparent !important;
        font-weight: 600;
        padding: 10px 20px !important;
    }

    .nav-tabs-premium .nav-link.active {
        background: transparent !important;
        color: #0dcaf0 !important;
        border-bottom: 2px solid #0dcaf0 !important;
    }
</style>

<div class="admin-wrapper d-flex">
    @include('admin.partials.sidebar')

    <div class="main-content flex-grow-1 p-3 p-md-5">
        <div class="container-xl pt-4">

            {{-- Başlyk we Sag tarapdaky Düwmeler (Yza + Dil Dropdown) --}}
            <div class="d-flex justify-content-between align-items-center gap-3 mb-5 header-section pt-5">
                <div>
                    <h2 class="text-white fw-bold mb-1">{{ __('app.ad-page-create-title') }}</h2>
                    <p class="text-white-50 small mb-0"><i class="bi bi-plus-circle text-info me-1"></i> Create a new promotional slider entry</p>
                </div>

                {{-- 🟩 Düwmeler Toplumy (Seniň isleýşiň ýaly Sag Tarapda) --}}
                <div class="d-flex align-items-center gap-2">
                    {{-- Yza Düwmesi --}}
                    <a href="{{ url('/admin/ads') }}" class="btn btn-outline-light border-0 rounded-pill px-3 px-sm-4 shadow-sm d-flex align-items-center justify-content-center text-decoration-none" style="background: rgba(255,255,255,0.05); height: 42px; font-size: 14px;">
                        <i class="bi bi-arrow-left me-1"></i> <span class="d-none d-xl-block">{{ __('app.ad-page-edit-go-back-btn') }}</span>
                    </a>

                    {{-- Dil Saýlama Dropdown --}}
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle border-0 px-3 py-2 rounded-pill shadow-xl d-flex align-items-center justify-content-center"
                            type="button" id="langDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                            style="background: rgba(255,255,255,0.1); height: 42px; min-width: 95px; font-size: 13px;">
                            <i class="bi bi-translate me-2 text-info" style="font-size: 15px;"></i>
                            <span class="text-uppercase fw-bold">{{ app()->getLocale() }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 p-2" aria-labelledby="langDropdown" style="background: rgba(31, 30, 30, 0.51); backdrop-filter: blur(5px); border-radius: 15px; min-width: 140px; z-index: 9999;">
                            <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'tk') }}">🇹🇲 Turkmen</a></li>
                            <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'ru') }}">🇷🇺 Русский</a></li>
                            <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'en') }}">🇺🇸 English</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Forma Karty --}}
            <div class="liquid-card p-4 p-md-5 shadow-lg">
                <form action="{{ url('/admin/ads/store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Ad Status Switcher --}}
                    <div class="d-flex align-items-center justify-content-between mb-4 p-3 rounded-4" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                        <div>
                            <h6 class="text-white mb-1 fw-bold">{{ __('app.ad-page-create-ad-status-title') }}</h6>
                            <p class="text-white-50 small mb-0">{{ __('app.ad-page-create-ad-status-help') }}</p>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input bg-info border-0" type="checkbox" name="is_active" id="isActive" checked style="cursor: pointer; width: 45px; height: 24px;">
                        </div>
                    </div>

                    {{-- PREMIUM MULTI-LANGUAGE TABS --}}
                    <ul class="nav nav-tabs nav-tabs-premium mb-4" id="pageLangTabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="page-tm-tab" data-bs-toggle="tab" data-bs-target="#page-lang-tm" type="button">🇹🇲 Türkmençe</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="page-ru-tab" data-bs-toggle="tab" data-bs-target="#page-lang-ru" type="button">🇷🇺 Русский</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="page-en-tab" data-bs-toggle="tab" data-bs-target="#page-lang-en" type="button">🇺🇸 English</button>
                        </li>
                    </ul>

                    {{-- TABS CONTENT --}}
                    <div class="tab-content mb-4" id="pageLangTabsContent">
                        {{-- TÜRKMENÇE --}}
                        <div class="tab-pane fade show active" id="page-lang-tm">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label text-white-50 small fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Sözbasy (TM)</label>
                                    <input type="text" name="title_tm" class="form-control shadow-none py-3" required style="border-radius: 12px;">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label text-white-50 small fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Badge (TM) <small class="text-info">(Mysal: TÄZE GELEN)</small></label>
                                    <input type="text" name="badge_tm" class="form-control shadow-none py-3" style="border-radius: 12px;">
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-white-50 small fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Düşündiriş (TM)</label>
                                    <textarea name="description_tm" class="form-control shadow-none" rows="4" style="border-radius: 12px;"></textarea>
                                </div>
                            </div>
                        </div>

                        {{-- RUSSIAN --}}
                        <div class="tab-pane fade" id="page-lang-ru">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label text-white-50 small fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Заголовок (RU)</label>
                                    <input type="text" name="title_ru" class="form-control shadow-none py-3" style="border-radius: 12px;">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label text-white-50 small fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Badge (RU) <small class="text-info">(Пример: СКИДКА)</small></label>
                                    <input type="text" name="badge_ru" class="form-control shadow-none py-3" style="border-radius: 12px;">
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-white-50 small fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Описание (RU)</label>
                                    <textarea name="description_ru" class="form-control shadow-none" rows="4" style="border-radius: 12px;"></textarea>
                                </div>
                            </div>
                        </div>

                        {{-- ENGLISH --}}
                        <div class="tab-pane fade" id="page-lang-en">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label text-white-50 small fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Title (EN)</label>
                                    <input type="text" name="title_en" class="form-control shadow-none py-3" style="border-radius: 12px;">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label text-white-50 small fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Badge (EN) <small class="text-info">(Example: SALE)</small></label>
                                    <input type="text" name="badge_en" class="form-control shadow-none py-3" style="border-radius: 12px;">
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-white-50 small fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Description (EN)</label>
                                    <textarea name="description_en" class="form-control shadow-none" rows="4" style="border-radius: 12px;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr style="border-color: rgba(255,255,255,0.08);" class="my-4">

                    {{-- SHARED FIELDS (LINK, SLIDER TIME, IMAGE) --}}
                    <div class="row g-4 mb-5">
                        <div class="col-12 col-md-4">
                            <label class="form-label text-white-50 small fw-bold text-uppercase" style="font-size: 11px;">Ad Link</label>
                            <input type="text" name="link" class="form-control shadow-none py-3" placeholder="/shop/perfumes" style="border-radius: 12px;">
                        </div>
                        <div class="col-6 col-md-4">
                            <label class="form-label text-white-50 small fw-bold text-uppercase" style="font-size: 11px;">Slider Time (Sec.)</label>
                            <input type="number" name="seconds" class="form-control text-center text-info fw-bold shadow-none py-3" value="5" style="border-radius: 12px;">
                        </div>
                        <div class="col-6 col-md-4">
                            <label class="form-label text-white-50 small fw-bold text-uppercase" style="font-size: 11px;">Upload Image</label>
                            <input type="file" name="image" class="form-control shadow-none py-3" required style="border-radius: 12px;">
                        </div>
                    </div>

                    {{-- Form Submit Buttons --}}
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ url('/admin/ads') }}" class="btn btn-link text-white-50 text-decoration-none bg-light bg-opacity-10 rounded-pill px-4 me-auto">Cancel</a>
                        <button type="submit" class="btn btn-info rounded-pill px-5 fw-bold text-dark">Approve and Add</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection