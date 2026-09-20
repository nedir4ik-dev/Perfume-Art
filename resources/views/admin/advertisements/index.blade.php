@extends('layouts.app')

@section('title', 'Admin Advertisements - Perfume Art Collection')

@section('content')
<style>
    /* 1. Arka Plan we Umumy Tema (Modern Deep Dark) */
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

    /* 2. Liquid Glass Kart Gurluşy */
    .liquid-glass {
        background: rgba(255, 255, 255, 0.02) !important;
        backdrop-filter: blur(20px) saturate(160%);
        -webkit-backdrop-filter: blur(20px) saturate(160%);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 24px !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    }

    /* Tablisa Taslamasy */
    .table-responsive {
        border: none !important;
        background: transparent !important;
    }

    .table {
        --bs-table-bg: transparent !important;
        --bs-table-color: #ffffff !important;
        background-color: transparent !important;
        color: #ffffff !important;
        border-color: rgba(255, 255, 255, 0.05) !important;
        margin-bottom: 0 !important;
    }

    .table thead th {
        background: rgba(255, 255, 255, 0.02) !important;
        color: rgba(255, 255, 255, 0.5) !important;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 1.5px;
        font-weight: 600;
        border: none !important;
        padding: 16px 20px;
    }

    .table tbody td {
        padding: 20px;
        background: transparent !important;
        color: #ffffff !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.03) !important;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background: rgba(13, 202, 240, 0.03) !important;
    }

    @media (max-width: 767.98px) {
        .responsive-title {
            font-size: 20px !important;
        }

        .header-section {
            flex-direction: row !important;
            align-items: center !important;
            justify-content: space-between !important;
            margin-bottom: 25px !important;
        }

        .table thead {
            display: none !important;
        }

        .table tbody tr {
            display: block !important;
            padding: 15px 5px !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        }

        .table tbody td {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            padding: 10px 12px !important;
            border: none !important;
            text-align: right !important;
            font-size: 14px !important;
        }

        .table tbody td::before {
            content: attr(data-label);
            float: left;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.4);
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
        }

        .table tbody td .d-flex {
            justify-content: flex-end !important;
            width: auto !important;
        }

        .mobile-right {
            text-align: right !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: flex-end !important;
        }
    }
</style>

<div class="admin-wrapper d-flex">
    @include('admin.partials.sidebar')

    <div class="main-content flex-grow-1 p-3 p-md-5">
        <div class="container-xl pt-4">

            {{-- Sahypanyň Başlygy we Düwmeler --}}
            <div class="d-flex justify-content-between align-items-center gap-3 mb-5 header-section pt-5">
                <div>
                    <h1 class="text-white fw-bold mb-1 responsive-title text-nowrap">{{ __('app.ad-page-title') }}</h1>
                    <p class="text-white-50 small mb-0"><i class="bi bi-shield-check text-info me-1"></i> {{ __('app.ad-page-paragraph') }}</p>
                </div>

                <div class="d-flex align-items-center gap-2">
                    {{-- 🚀 MODAL DÜWMESI TÄZE AÝRATYN SAHYPA ACÝAN LINKA ÖWRÜLDI --}}
                    <a href="{{ route('admin.ads.create') }}" class="btn btn-info fw-bold shadow-sm rounded-pill px-3 px-sm-4 text-dark d-flex align-items-center justify-content-center text-decoration-none" style="height: 42px; font-size: 14px;">
                        <i class="bi bi-plus-lg me-1"></i> <span>{{ __('app.ad-page-add-new-add-btn') }}</span>
                    </a>

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

            @if(session('success'))
            <div class="alert alert-success border-0 text-white rounded-4 shadow-lg bg-opacity-10 d-flex align-items-center mb-4" style="background: rgba(25, 135, 84, 0.4); backdrop-filter: blur(10px);">
                <i class="bi bi-check-circle-fill me-3 text-success"></i>
                <div>{{ session('success') }}</div>
            </div>
            @endif

            {{-- Esasy Sanaw Tablisasy --}}
            <div class="liquid-glass overflow-hidden">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4" style="width: 100px;">{{ __('app.ad-page-thead-1') }}</th>
                                <th>{{ __('app.ad-page-thead-2') }}</th>
                                <th class="d-none d-md-table-cell">{{ __('app.ad-page-thead-3') }}</th>
                                <th>{{ __('app.ad-page-thead-4') }}</th>
                                <th class="pe-4 text-end" style="width: 150px;">{{ __('app.ad-page-thead-5') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($advertisements as $ad)
                            @php
                            $locale = app()->getLocale();
                            $titleField = 'title_' . $locale;
                            $badgeField = 'badge_' . $locale;
                            @endphp
                            <tr>
                                <td data-label="{{ __('app.ad-page-thead-1') }}" class="ps-md-4">
                                    @if($ad->image)
                                    <a href="{{ asset('storage/'.$ad->image) }}" data-fancybox="gallery">
                                        <img src="{{ asset('storage/' . $ad->image) }}" class="rounded-3 border border-white border-opacity-10" style="width: 50px; height: 50px; object-fit: cover; background: rgba(0,0,0,0.2);">
                                    </a>
                                    @else
                                    <div class="rounded-3 bg-secondary text-center d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-size: 10px; color:#ccc;">{{ __('app.ad-page-no-image') }}</div>
                                    @endif
                                </td>
                                <td data-label="{{ __('app.ad-page-thead-2') }}">
                                    <div class="mobile-right">
                                        <div class="fw-bold text-white">{{ $ad->$titleField ?: $ad->title_tm }}</div>
                                        @if($ad->$badgeField)
                                        <span class="badge bg-info text-dark text-uppercase font-monospace mt-1" style="font-size: 10px; font-weight: 700;">{{ $ad->$badgeField }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td data-label="{{ __('app.ad-page-thead-3') }}" class="text-info fw-bold">{{ $ad->seconds ?? 5 }} {{ __('app.ad-page-seconds') }}</td>
                                <td data-label="{{ __('app.ad-page-thead-4') }}">
                                    @if($ad->is_active)
                                    <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-20 px-3 py-1 rounded-pill small">{{ __('app.ad-page-ad-active') }}</span>
                                    @else
                                    <span class="badge bg-danger bg-opacity-25 text-danger border border-danger border-opacity-20 px-3 py-1 rounded-pill small">{{ __('app.ad-page-ad-none-active') }}</span>
                                    @endif
                                </td>
                                <td data-label="{{ __('app.ad-page-thead-5') }}" class="pe-md-4 text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ url('/admin/ads/'.$ad->id.'/edit') }}" class="btn btn-sm btn-outline-light border-0 rounded-pill px-3" style="background: rgba(255,255,255,0.05);">
                                            <i class="bi bi-pencil-square text-info"></i>
                                        </a>
                                        <form action="{{ url('/admin/ads/'.$ad->id) }}" method="POST" onsubmit="return confirm('{{ __('app.ad-page-confirm-delete') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-light border-0 rounded-pill px-3" style="background: rgba(255,255,255,0.05);">
                                                <i class="bi bi-trash3-fill text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-white-50 py-5">{{ __('app.ad-page-no-ads') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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