@extends('layouts.app')

@section('title', 'Admin Tickers - Perfume Art Collection')

@section('content')
<style>
    /* Janly Preview Effekti */
    .preview-box {
        background: #111;
        border-radius: 15px;
        overflow: hidden;
        position: relative;
        height: 50px;
        display: flex;
        align-items: center;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .preview-content {
        white-space: nowrap;
        display: inline-block;
        padding-left: 100%;
        animation: ticker-move 20s linear infinite;
    }

    @keyframes ticker-move {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-100%);
        }
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(10px);
        border-radius: 25px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        transition: all 0.3s ease;
    }

    .glass-card:hover {
        border-color: rgba(13, 202, 240, 0.3);
    }

    .custom-switch {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .custom-switch:checked {
        filter: drop-shadow(0 0 8px rgba(13, 202, 240, 0.8));
    }

    .hover-lift:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13, 202, 240, 0.3) !important;
    }

    .nav-tabs-premium {
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    .nav-tabs-premium .nav-link {
        color: rgba(255, 255, 255, 0.5) !important;
        border: none !important;
        border-bottom: 2px solid transparent !important;
        font-weight: 600;
        padding: 8px 16px !important;
        font-size: 13px;
    }

    .nav-tabs-premium .nav-link.active {
        background: transparent !important;
        color: #0dcaf0 !important;
        border-bottom: 2px solid #0dcaf0 !important;
    }

    @media (max-width: 767.98px) {
        .btn-info {
            width: 100%;
            margin-top: 10px;
        }

        .d-md-contents {
            background: rgba(255, 255, 255, 0.03);
            flex-direction: row;
            padding: 15px !important;
        }
    }
</style>

<div class="admin-wrapper d-flex">
    @include('admin.partials.sidebar')

    <div class="main-content flex-grow-1" style="background-color: rgba(31,30,30,0.51); backdrop-filter: blur(5px); min-height: 100vh;">

        <div class="p-5 pb-0">
            <div class="d-flex justify-content-between align-items-center pt-5">
                <div>
                    <h2 class="text-white fw-bold fs-2">{{ __('app.ticker-page-title') }}</h2>
                    <p class="text-white-50 mb-0">{{ __('app.ticker-page-paragraph') }}</p>
                </div>
                <div class="dropdown">
                    <button class="btn btn-outline-light dropdown-toggle border-0 px-3 py-2 rounded-pill shadow-xl d-flex align-items-center justify-content-center"
                        type="button" id="langDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                        style="background: rgba(255,255,255,0.1); height: 42px; min-width: 95px; font-size: 13px;">
                        <i class="bi bi-translate me-2 text-info" style="font-size: 15px;"></i>
                        <span class="text-uppercase fw-bold">{{ app()->getLocale() }}</span>
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

        <div class="container-xl p-3 p-md-5 pt-4">

            {{-- GLOBAL TOGGLE SYSTEM --}}
            <div class="row mb-4">
                <div class="col-12">
                    <form action="{{ route('admin.tickers.toggle-global') }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="0">
                        <div class="glass-card p-4 border-info border-opacity-25 shadow-lg">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="d-flex align-items-center gap-3 mb-2">
                                            <h5 class="text-white mb-0 fw-bold">{{ __('app.ticker-page-status-title') }}</h5>

                                            @if($tickerStatus == '1')
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2 py-1 fw-bold d-inline-flex align-items-center">
                                                <i class="bi bi-power text-success"></i>
                                            </span>
                                            @else
                                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-2 py-1 fw-bold d-inline-flex align-items-center">
                                                <i class="bi bi-power text-danger"></i>
                                            </span>
                                            @endif
                                        </div>
                                        <p class="text-white-50 small mb-0 pe-md-4">{{ __('app.ticker-page-status-status-help') }}</p>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between justify-content-md-end p-3 p-md-0 rounded-4 d-md-contents">
                                    <div class="form-check form-switch me-4">
                                        <input class="form-check-input bg-info border-info custom-switch"
                                            type="checkbox" name="status" id="statusSwitch" value="1"
                                            {{ $tickerStatus == '1' ? 'checked' : '' }}
                                            style="width: 3.5rem; height: 1.75rem; cursor: pointer;">
                                    </div>
                                    <button type="submit" class="btn btn-info rounded-pill px-3 fw-bold shadow-lg transition-all hover-lift">
                                        SUBMIT
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- LIVE PREVIEW SECTION --}}
            <div class="row mb-4">
                <div class="col-12">
                    <div class="glass-card p-3">
                        <label class="text-white-50 small fw-bold mb-2 ms-2 text-uppercase">{{ __('app.ticker-page-live-preview') }}</label>
                        <div class="preview-box">
                            <div id="live-preview-container" class="preview-content d-flex align-items-center">
                                @php $currentLocale = app()->getLocale(); $contentField = 'content_' . $currentLocale; @endphp
                                @forelse($tickers as $ticker)
                                <span class="mx-4 text-white fw-bold">
                                    <i class="bi {{ $ticker->icon }} {{ $ticker->color }} me-2"></i>
                                    {{ $ticker->$contentField ?? $ticker->content_tm }}
                                </span>
                                @empty
                                <span id="placeholder-text" class="mx-4 text-white-50 fw-bold">
                                    <i class="bi bi-stars text-warning me-2"></i> {{ __('app.ticker-page-no-live-preview') }}
                                </span>
                                @endforelse

                                <span id="current-input-preview" class="mx-4 text-info fw-bold d-none">
                                    <i id="preview-icon-live" class="bi bi-stars me-2"></i>
                                    <span id="preview-text-live"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                {{-- MULTI-LANGUAGE FORM --}}
                <div class="col-xl-5">
                    <div class="glass-card p-4 shadow-lg h-100">
                        <h5 class="text-white mb-4 fw-bold">{{ __('app.ticker-page-add-ticker-title') }}</h5>
                        <form action="{{ route('admin.tickers.store') }}" method="POST">
                            @csrf

                            {{-- FORM TABS --}}
                            <ul class="nav nav-tabs nav-tabs-premium mb-3" id="tickerFormTabs" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link active" id="tm-tab" data-bs-toggle="tab" data-bs-target="#lang-tm" type="button">🇹🇲 TM</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="ru-tab" data-bs-toggle="tab" data-bs-target="#lang-ru" type="button">🇷🇺 RU</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="en-tab" data-bs-toggle="tab" data-bs-target="#lang-en" type="button">🇺🇸 EN</button>
                                </li>
                            </ul>

                            {{-- TABS CONTENT --}}
                            <div class="tab-content mb-4" id="tickerFormTabsContent">
                                {{-- Turkmen --}}
                                <div class="tab-pane fade show active" id="lang-tm">
                                    <label class="form-label text-white-50 text-capitalize small fw-bold">Mahabat tеksti (TM) <span class="text-danger">*</span></label>
                                    <input type="text" name="content_tm" id="input-text-tm" class="form-control py-3 text-white ticker-input"
                                        placeholder="Arzanladyş başlady!" autofocus="" required data-lang="tm"
                                        style="background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px;">
                                </div>
                                {{-- Russian --}}
                                <div class="tab-pane fade" id="lang-ru">
                                    <label class="form-label text-white-50 text-capitalize small fw-bold">Текст Рекламы (RU)</label>
                                    <input type="text" name="content_ru" id="input-text-ru" class="form-control py-3 text-white ticker-input"
                                        placeholder="Скидки начались!" data-lang="ru"
                                        style="background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px;">
                                </div>
                                {{-- English --}}
                                <div class="tab-pane fade" id="lang-en">
                                    <label class="form-label text-white-50 text-capitalize small fw-bold">Advertisement Text (EN)</label>
                                    <input type="text" name="content_en" id="input-text-en" class="form-control py-3 text-white ticker-input"
                                        placeholder="Discounts have started!" data-lang="en"
                                        style="background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px;">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label text-white-50 small fw-bold">{{ __('app.ticker-page-add-ticker-select-icon') }}</label>
                                    <select name="icon" id="input-icon" class="form-select py-2 bg-dark text-white border-secondary" style="border-radius: 10px;">
                                        <option value="bi-fire">🔥 {{ __('app.ticker-page-add-ticker-icon-option-1') }}</option>
                                        <option value="bi-stars">✨ {{ __('app.ticker-page-add-ticker-icon-option-2') }}</option>
                                        <option value="bi-lightning-charge-fill">⚡ {{ __('app.ticker-page-add-ticker-icon-option-3') }}</option>
                                        <option value="bi-percent">% {{ __('app.ticker-page-add-ticker-icon-option-4') }}</option>
                                        <option value="bi-truck">🚚 {{ __('app.ticker-page-add-ticker-icon-option-5') }}</option>
                                        <option value="bi-megaphone-fill">📢 {{ __('app.ticker-page-add-ticker-icon-option-6') }}</option>
                                    </select>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label text-white-50 small fw-bold">{{ __('app.ticker-page-add-ticker-select-color') }}</label>
                                    <select name="color" id="input-color" class="form-select py-2 bg-dark text-white border-secondary" style="border-radius: 10px;">
                                        <option value="text-warning">🟡 {{ __('app.ticker-page-add-ticker-color-option-1') }}</option>
                                        <option value="text-info">🔵 {{ __('app.ticker-page-add-ticker-color-option-2') }}</option>
                                        <option value="text-success">🟢 {{ __('app.ticker-page-add-ticker-color-option-3') }}</option>
                                        <option value="text-danger">🔴 {{ __('app.ticker-page-add-ticker-color-option-4') }}</option>
                                        <option value="text-white">⚪️ {{ __('app.ticker-page-add-ticker-color-option-5') }}</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-info w-100 fw-bold py-3 rounded-pill mt-3 shadow-sm text-uppercase">
                                <i class="bi bi-plus-lg me-2"></i>{{ __('app.ticker-page-add-ticker-btn') }}
                            </button>
                        </form>
                    </div>
                </div>

                {{-- TABLE SECTION --}}
                <div class="col-xl-7">
                    <div class="glass-card p-4 shadow-lg h-100">
                        <h5 class="text-white mb-4 fw-bold">{{__('app.ticker-page-active-tickers-title')}}</h5>
                        <div class="table-responsive">
                            <table class="table table-dark table-hover align-middle border-0">
                                <thead class="text-white-50 small">
                                    <tr>
                                        <th>{{__('app.ticker-page-active-tickers-thead-1')}}</th>
                                        <th>{{__('app.ticker-page-active-tickers-thead-1')}}</th>
                                        <th class="text-end">{{__('app.ticker-page-active-tickers-thead-1')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tickers as $ticker)
                                    <tr style="background: rgba(255,255,255,0.01);">
                                        <td>
                                            <div class="bg-dark p-2 d-inline-block rounded-3 border border-secondary border-opacity-25">
                                                <i class="bi {{ $ticker->icon }} {{ $ticker->color }} fs-4"></i>
                                            </div>
                                        </td>
                                        {{-- Dinamik sütün görkezilýär --}}
                                        <td class="text-white fw-medium">
                                            {{ $ticker->$contentField ?? $ticker->content_tm }}
                                        </td>
                                        <td class="text-end">
                                            <form action="{{ route('admin.tickers.destroy', $ticker->id) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-outline-danger btn-sm rounded-pill px-3" onclick="return confirm('Do you want to delete: ({{ $ticker->id }}. {{ $ticker->$contentField }}) ticker')">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-5 text-white-50">{{__('app.ticker-page-no-active-tickers')}}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const inputIcon = document.getElementById('input-icon');
    const inputColor = document.getElementById('input-color');
    let activeLang = 'tm';

    document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
        tab.addEventListener('shown.bs-tab', function(e) {
            const targetId = e.target.id;
            activeLang = targetId.split('-')[0];
            updatePreview();
        });
    });

    function updatePreview() {
        const inputEl = document.getElementById(`input-text-${activeLang}`);
        const text = inputEl ? inputEl.value.trim() : '';
        const icon = inputIcon.value;
        const colorClass = inputColor.value;

        const currentSpan = document.getElementById('current-input-preview');
        const previewTextLive = document.getElementById('preview-text-live');
        const previewIconLive = document.getElementById('preview-icon-live');
        const placeholder = document.getElementById('placeholder-text');

        if (text.length > 0) {
            currentSpan.classList.remove('d-none');
            if (placeholder) placeholder.classList.add('d-none');

            previewTextLive.innerText = text;
            previewIconLive.className = `bi ${icon} ${colorClass} me-2`;
            currentSpan.className = `mx-4 fw-bold ${colorClass}`;
        } else {
            currentSpan.classList.add('d-none');
            if (placeholder) placeholder.classList.remove('d-none');
        }
    }

    document.querySelectorAll('.ticker-input').forEach(input => {
        input.addEventListener('input', updatePreview);
    });
    inputIcon.addEventListener('change', updatePreview);
    inputColor.addEventListener('change', updatePreview);
</script>
@endsection