@extends('layouts.app')

@section('title', 'Admin Backup - Perfume Art Collection')

@section('content')
<style>
    /* 1. Arka Plan ve Genel Tema (Modern Deep Dark) */
    body {
        background: #0a0a0a !important;
        /* Daha derin bir siyah */
        color: #e0e0e0;
        font-family: 'Inter', sans-serif;
    }

    .main-content {
        background: radial-gradient(circle at top right, rgba(31, 30, 30, 0, 51), transparent),
            radial-gradient(circle at bottom left, rgba(31, 30, 30, 0, 51), transparent) !important;
        min-height: 100vh;
        backdrop-filter: blur(5px);
    }

    /* 2. Liquid Glass Kart Yapısı */
    .liquid-glass {
        background: rgba(255, 255, 255, 0.02) !important;
        backdrop-filter: blur(20px) saturate(160%);
        -webkit-backdrop-filter: blur(20px) saturate(160%);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 24px !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    }

    /* 3. İstatistik Kartları (İlk koddaki gibi ikon odaklı) */
    .stat-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        padding: 20px;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(13, 202, 240, 0.3);
    }

    .icon-shape {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: rgba(13, 202, 240, 0.1);
        border: 1px solid rgba(13, 202, 240, 0.1);
        margin-bottom: 15px;
    }

    /* 4. Tablo Tasarımı (İlk koddaki temizlik + Neon vurgu) */
    .table {
        --bs-table-bg: transparent !important;
        color: #ffffff !important;
        border-color: rgba(255, 255, 255, 0.05) !important;
    }

    .table thead th {
        background: rgba(255, 255, 255, 0.02) !important;
        color: rgba(255, 255, 255, 0.5) !important;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 1.5px;
        font-weight: 600;
        border: none !important;
        padding: 20px;
    }

    .table tbody td {
        padding: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.03) !important;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background: rgba(13, 202, 240, 0.03) !important;
    }

    /* 5. Butonlar ve Badge'ler */
    .btn-info-glass {
        background: rgba(63, 152, 170, 0.15);
        color: #0dcaf0;
        border: 1px solid rgba(13, 202, 240, 0.3);
        padding: 12px 25px;
        border-radius: 15px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-info-glass:hover {
        background: #0dcaf0;
        color: #000;
        box-shadow: 0 0 20px rgba(13, 202, 240, 0.4);
    }

    .badge-backup {
        background: rgba(255, 193, 7, 0.1);
        color: #ffc107;
        border: 1px solid rgba(255, 193, 7, 0.2);
        padding: 6px 12px;
        border-radius: 8px;
    }
</style>

<div class="admin-wrapper d-flex">
    @include('admin.partials.sidebar')

    <div class="main-content flex-grow-1 p-4 p-xl-5">
        <div class="container-xl pt-4">

            <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-5">
                <div>
                    <h2 class="text-white pt-5 fw-bold mb-1">{{ __("app.backup-page-title") }}</h2>
                    <p class="text-white-50 small mb-0"><i class="bi bi-shield-check text-info me-1"></i>{{__('app.backup-page-paragraph')}}</p>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-info-glass d-flex align-items-center justify-content-center" style="height: 48px;" data-bs-toggle="modal" data-bs-target="#backupConfirmModal">
                        <i class="bi bi-plus-lg me-2"></i> {{__('app.backup-page-create-btn')}}
                    </button>

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

            <!-- Success Message -->
            @if(session('success'))
            <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success rounded-4 mb-4">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            </div>
            @endif

            <!-- Error Message -->
            @if(session('error'))
            <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger rounded-4 mb-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            </div>
            @endif

            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="stat-card d-flex flex-column">
                        <div class="icon-shape">
                            <i class="bi bi-folder2-open text-info fs-4"></i>
                        </div>
                        <small class="text-white-50">{{__('app.backup-page-total-archive')}}</small>
                        <h3 class="text-white fw-bold mb-0">{{ count($backups) }} <span class="fs-6 fw-normal opacity-50">{{__('app.backup-page-total-archive-files')}}</span></h3>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="stat-card h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-shape me-3 mb-0" style="background: rgba(255, 193, 7, 0.1);">
                                <i class="bi bi-hdd-network text-warning fs-4"></i>
                            </div>
                            <div>
                                <small class="text-white-50 d-block">{{__('app.backup-page-latest-backup')}}</small>
                                <h5 class="text-warning fw-bold mb-0">
                                    @if(count($backups) > 0)
                                    {{ Str::limit($backups[0]['file_name'], 40) }}
                                    @else
                                    {{__('app.backup-page-no-backup')}}
                                    @endif
                                </h5>
                            </div>
                        </div>
                        @if(count($backups) > 0)
                        <div class="d-flex gap-2">
                            <span class="badge-backup text-uppercase small">{{ $backups[0]['file_size'] }}</span>
                            <span class="badge-backup text-uppercase small" style="color: #0dcaf0; border-color: rgba(13,202,240,0.2); background: rgba(13,202,240,0.05);">{{__('app.backup-page-verified-badge')}}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="liquid-glass overflow-hidden">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">{{__('app.backup-page-thead-1')}}</th>
                                <th>{{__('app.backup-page-thead-2')}}</th>
                                <th>{{__('app.backup-page-thead-3')}}</th>
                                <th class="pe-4 text-end">{{__('app.backup-page-thead-4')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($backups as $backup)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="p-2 rounded-3 bg-white bg-opacity-10 me-3">
                                            <i class="bi bi-file-earmark-zip text-info fs-5"></i>
                                        </div>
                                        <span class="text-white fw-medium">{{ $backup['file_name'] }}</span>
                                    </div>
                                </td>
                                <td><span class="text-info opacity-75 font-monospace">{{ $backup['file_size'] }}</span></td>
                                <td><span class="text-white-50 small text-uppercase">{{ $backup['last_modified'] }}</span></td>
                                <td class="pe-4 text-end">
                                    <a href="{{ route('admin.backup.download', ['file' => $backup['full_path']]) }}"
                                        class="btn btn-sm btn-outline-info px-4 rounded-pill border-opacity-25">
                                        <i class="bi bi-download me-1"></i> {{__('app.backup-page-download-btn')}}
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="opacity-25 py-5">
                                        <i class="bi bi-cloud-slash fs-1 d-block mb-3"></i>
                                        <span class="text-white">{{__('app.backup-page-no-data-archived')}}</span>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="backupConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content liquid-glass" style="background: rgba(15, 15, 15, 0.98) !important;">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="modal-title text-white fw-bold">{{__('app.backup-page-modal-title')}}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.backup.create') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <p class="text-white-50 small mb-3">{{__('app.backup-page-modal-paragraph')}}</p>
                    <input type="password" name="security_code" class="form-control bg-dark border-secondary text-info text-center py-3 fs-4" placeholder="••••" required autofocus>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-info-glass w-100 py-3">{{__('app.backup-page-modal-create-backup-btn')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection