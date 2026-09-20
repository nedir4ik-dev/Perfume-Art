@extends('layouts.app')

@section('title', 'Edit Advertisements - Perfume Art Collection')

@section('content')
<style>
    /* Umumy Deep Dark we Liquid Glass dizaýnlary */
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

    /* Premium Tab Dizaýnlary */
    .nav-tabs-premium {
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    .nav-tabs-premium .nav-link {
        color: rgba(255, 255, 255, 0.5) !important;
        border: none !important;
        border-bottom: 2px solid transparent !important;
        padding: 10px 20px !important;
        font-weight: 600 !important;
    }

    .nav-tabs-premium .nav-link.active {
        background: transparent !important;
        color: #0dcaf0 !important;
        border-bottom: 2px solid #0dcaf0 !important;
    }
</style>

<div class="admin-wrapper d-flex">
    @include('admin.partials.sidebar')

    <div class="main-content flex-grow-1">

        {{-- Başlyk we Yza Düwmesi + Dil Saýlama --}}
        <div class="d-flex justify-content-between align-items-center p-4 p-md-5 pb-0 header-section">
            <div class="mt-5">
                <h2 class="text-white fw-bold mb-1">
                    <i class="bi bi-pencil-square text-info me-2"></i>{{ __('app.ad-page-edit-title') }}
                </h2>
                <p class="text-white-50 small mb-0 d-none d-sm-block">
                    @if(app()->getLocale() == 'tm')
                    "#{{ $ad->id }}" {{ __('app.ad-page-edit-paragraph') }}
                    @else
                    {{ __('app.ad-page-edit-paragraph') }} #{{ $ad->id }}
                    @endif
                </p>
            </div>

            <div class="d-flex align-items-center gap-2 mt-5">
                {{-- Yza Gaýt Düwmesi --}}
                <a href="/admin/ads" class="btn btn-outline-light border-0 rounded-pill px-3 px-sm-4 shadow-sm d-flex align-items-center justify-content-center" style="background: rgba(255,255,255,0.05); height: 42px; font-size: 14px;">
                    <i class="bi bi-arrow-left me-1"></i> <span>{{ __('app.ad-page-edit-go-back-btn') }}</span>
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
                        <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'tm') }}">🇹🇲 Turkmen</a></li>
                        <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'ru') }}">🇷🇺 Русский</a></li>
                        <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'en') }}">🇺🇸 English</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container-xl p-3 p-md-5 pt-4">
            <div class="liquid-card p-4 p-md-5 shadow-lg">

                <form action="/admin/ads/{{ $ad->id }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Mahabat Statusy --}}
                    <div class="d-flex align-items-center justify-content-between mb-5 p-3 rounded-4" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                        <div>
                            <h6 class="text-white mb-1 fw-bold">{{ __('app.ad-page-edit-ad-status-title') }}</h6>
                            <p class="text-white-50 small mb-0">{{ __('app.ad-page-edit-ad-status-paragraph') }}</p>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input bg-info border-0" type="checkbox" name="is_active" id="isActive" {{ $ad->is_active ? 'checked' : '' }} style="cursor: pointer;">
                        </div>
                    </div>

                    <div class="row g-4">
                        {{-- ÇEP TARAP: KÖP DILLI INPUTLAR --}}
                        <div class="col-xl-7">

                            {{-- PREMIUM TABS FOR EDIT --}}
                            <ul class="nav nav-tabs nav-tabs-premium mb-4" id="editLangTabs" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link active" id="edit-tm-tab" data-bs-toggle="tab" data-bs-target="#edit-lang-tm" type="button">🇹🇲 Türkmençe</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="edit-ru-tab" data-bs-toggle="tab" data-bs-target="#edit-lang-ru" type="button">🇷🇺 Русский</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="edit-en-tab" data-bs-toggle="tab" data-bs-target="#edit-lang-en" type="button">🇺🇸 English</button>
                                </li>
                            </ul>

                            {{-- TABS CONTENT --}}
                            <div class="tab-content mb-4" id="editLangTabsContent">
                                {{-- TÜRKMENÇE DATA --}}
                                <div class="tab-pane fade show active" id="edit-lang-tm">
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label text-white-50 small fw-bold text-uppercase">Sözbasy (TM)</label>
                                            <input type="text" name="title_tm" class="form-control py-3 text-white shadow-none" required value="{{ $ad->title_tm }}" style="border-radius: 12px;">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label text-white-50 small fw-bold text-uppercase">Badge (TM)</label>
                                            <input type="text" name="badge_tm" class="form-control py-3 text-white shadow-none" value="{{ $ad->badge_tm }}" style="border-radius: 12px;">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label text-white-50 small fw-bold text-uppercase">Düşündiriş (TM)</label>
                                            <textarea name="description_tm" class="form-control text-white shadow-none" rows="4" style="border-radius: 12px;">{{ $ad->description_tm }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                {{-- RUSÇA DATA --}}
                                <div class="tab-pane fade" id="edit-lang-ru">
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label text-white-50 small fw-bold text-uppercase">Заголовок (RU)</label>
                                            <input type="text" name="title_ru" class="form-control py-3 text-white shadow-none" value="{{ $ad->title_ru }}" style="border-radius: 12px;">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label text-white-50 small fw-bold text-uppercase">Badge (RU)</label>
                                            <input type="text" name="badge_ru" class="form-control py-3 text-white shadow-none" value="{{ $ad->badge_ru }}" style="border-radius: 12px;">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label text-white-50 small fw-bold text-uppercase">Описание (RU)</label>
                                            <textarea name="description_ru" class="form-control text-white shadow-none" rows="4" style="border-radius: 12px;">{{ $ad->description_ru }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                {{-- IŇLISÇE DATA --}}
                                <div class="tab-pane fade" id="edit-lang-en">
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label text-white-50 small fw-bold text-uppercase">Title (EN)</label>
                                            <input type="text" name="title_en" class="form-control py-3 text-white shadow-none" value="{{ $ad->title_en }}" style="border-radius: 12px;">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label text-white-50 small fw-bold text-uppercase">Badge (EN)</label>
                                            <input type="text" name="badge_en" class="form-control py-3 text-white shadow-none" value="{{ $ad->badge_en }}" style="border-radius: 12px;">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label text-white-50 small fw-bold text-uppercase">Description (EN)</label>
                                            <textarea name="description_en" class="form-control text-white shadow-none" rows="4" style="border-radius: 12px;">{{ $ad->description_en }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr style="border-color: rgba(255,255,255,0.08);" class="my-4">

                            {{-- ORTAK MEÝDANÇALAR (LINK WE WAGT) --}}
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label text-white-50 small fw-bold text-uppercase">{{ __('app.ad-page-edit-input-link-label') }}</label>
                                    <input type="text" name="link" class="form-control py-3 text-white shadow-none" value="{{ $ad->link }}" style="border-radius: 12px;">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label text-white-50 small fw-bold text-uppercase">{{ __('app.ad-page-edit-input-time-label') }}</label>
                                    <input type="number" name="seconds" class="form-control py-3 text-center text-info fw-bold shadow-none" value="{{ $ad->seconds ?? 5 }}" style="border-radius: 12px;">
                                </div>
                            </div>
                        </div>

                        {{-- SAG TARAP: SURAT GÖRKEZMEK WE TÄZELEMEK --}}
                        <div class="col-xl-5">
                            <div class="p-4 rounded-4 h-100 d-flex flex-column justify-content-between" style="background: rgba(0,0,0,0.2); border: 1px dashed rgba(255,255,255,0.1); border-radius: 20px;">

                                <div class="text-center mb-4">
                                    <label class="form-label text-white-50 small fw-bold text-uppercase d-block mb-3">{{ __('app.ad-page-edit-current-image-label') }}</label>
                                    @if($ad->image)
                                    <a href="{{ asset('storage/'.$ad->image) }}" data-fancybox="gallery">
                                        <img src="{{ asset('storage/' . $ad->image) }}" class="img-fluid rounded-4 shadow-lg border border-white border-opacity-10" style="max-height: 250px; width: 100%; object-fit: contain; background: rgba(0,0,0,0.2);">
                                    </a>
                                    @else
                                    <div class="py-5 text-white-50 small">{{ __('app.ad-page-no-image') }}</div>
                                    @endif
                                </div>

                                <div>
                                    <label class="form-label text-white-50 small fw-bold text-uppercase">{{ __('app.ad-page-edit-input-new-image-label') }}</label>
                                    <input type="file" name="image" class="form-control py-3 text-white shadow-none" style="border-radius: 12px;">
                                    <div class="mt-2 text-white-50" style="font-size: 10px;">{{ __('app.ad-page-edit-alert-text') }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- ÝATDA SAKLAMAK DÜWMESI --}}
                        <div class="col-12 mt-5">
                            <button type="submit" class="btn btn-info w-100 fw-bold py-3 text-dark text-uppercase rounded-pill shadow-lg" style="letter-spacing: 2px; font-size: 1rem;">
                                <i class="bi bi-cloud-arrow-up-fill me-2"></i> {{ __('app.ad-page-edit-save-changes-btn') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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
</script>
@endsection