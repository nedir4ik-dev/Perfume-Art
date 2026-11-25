@extends('layouts.app')

@section('title', 'Admin Activities - Perfume Art Collection')

@section('content')
@php
$nextCleanupDate = $cleanupDate ?? \Carbon\Carbon::parse('first day of next month midnight');
@endphp

<style>
    body {
        background: #121212;
    }

    .main-content {
        background-color: rgba(31, 30, 30, 0.51) !important;
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 20px;
    }

    .cleanup-box {
        overflow: visible !important;
        position: relative;
        z-index: 10;
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.1) 0%, rgba(255, 193, 7, 0.02) 100%);
        border: 1px solid rgba(255, 193, 7, 0.15) !important;
    }

    .dropdown-menu {
        z-index: 9999 !important;
        background: rgba(31, 30, 30, 0.95) !important;
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        margin-top: 5px !important;
    }

    .table-responsive {
        overflow: visible !important;
    }

    .table {
        --bs-table-bg: transparent;
        color: #e0e0e0;
        border-color: rgba(255, 255, 255, 0.05);
    }

    .table thead th {
        background: rgba(255, 255, 255, 0.02);
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 1px;
        color: rgba(255, 255, 255, 0.5);
        padding: 20px 15px;
    }

    .icon-shape {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: rgba(13, 202, 240, 0.1);
    }

    .btn-load-more {
        background: rgba(13, 202, 240, 0.1);
        color: #68abb8;
        border: 1px solid rgba(13, 202, 240, 0.2);
        padding: 12px 40px;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .btn-load-more:hover {
        background: #116c7e94;
        color: #ffffff;
    }

    .status-dot-pulse {
        width: 8px;
        height: 8px;
        background: #0dfaf0;
        border-radius: 50%;
        box-shadow: 0 0 0 rgba(13, 202, 240, 0.4);
        animation: pulse-animation 2s infinite;
    }

    @keyframes pulse-animation {
        0% {
            box-shadow: 0 0 0 0 rgba(13, 202, 240, 0.7);
        }

        70% {
            box-shadow: 0 0 0 6px rgba(13, 202, 240, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(13, 202, 240, 0);
        }
    }
</style>

<div class="admin-wrapper d-flex">
    @include('admin.partials.sidebar')

    <div class="main-content flex-grow-1 p-4 p-xl-5">
        <div class="container-xl">

            {{-- Sahypanyň Başlygy --}}
            <div class="row align-items-center g-2 mb-4 pt-4 mt-1 mt-xl-0">
                <div class="col-6 text-start">
                    <h1 class="text-white fw-bold mb-3 pt-5 d-flex align-items-center gap-2">
                        <span class="status-dot-pulse d-inline-block"></span> Activities
                    </h1>
                </div>
                <div class="col-6 d-flex justify-content-end align-items-center">
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle border-0 px-3 py-2 rounded-pill shadow-xl d-flex align-items-center justify-content-center"
                            type="button" id="langDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                            style="background: rgba(255,255,255,0.1); height: 42px; min-width: 95px; font-size: 13px;">
                            <i class="bi bi-translate me-2 text-info" style="font-size: 15px;"></i>
                            <span class="text-uppercase fw-bold">{{ app()->getLocale() }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 p-2"
                            aria-labelledby="langDropdown">
                            <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'tm') }}">🇹🇲 Turkmen</a></li>
                            <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'ru') }}">🇷🇺 Русский</a></li>
                            <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'en') }}">🇺🇸 English</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Statistika we Log Arassalamak --}}
            <div class="row g-3 mb-5">
                <div class="col-12 col-md-4">
                    <div class="glass-card p-4 d-flex align-items-center h-100">
                        <div class="icon-shape flex-shrink-0 me-3">
                            <i class="bi bi-eye text-info"></i>
                        </div>
                        <div>
                            <small class="text-white-50 d-block text-uppercase tracking-wider" style="font-size: 11px;">Jemi Görülişler</small>
                            <h3 class="text-white fw-bold mb-0 mt-1">{{ $activities->total() }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-8">
                    <div class="glass-card cleanup-box p-4 h-100">
                        <div class="row align-items-center h-100 g-3">
                            <div class="col-12 col-sm-6 d-flex align-items-center">
                                <div class="icon-shape flex-shrink-0 me-3">
                                    <i class="bi bi-trash3 text-info"></i>
                                </div>
                                <div>
                                    <small class="text-white-50 d-block text-uppercase tracking-wider" style="font-size: 11px;">Indiki Arassalaýyş (Her aýyň 1-i)</small>
                                    <h4 id="cleanup-countdown" class="text-info fw-bold mb-0 mt-1">Hasaplanýar...</h4>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 text-start text-sm-end d-flex flex-column align-items-start align-items-sm-end justify-content-center">
                                <div class="dropdown w-100 w-sm-auto">
                                    <button class="btn btn-outline-info rounded-pill px-4 dropdown-toggle shadow-sm fw-bold w-100 w-sm-auto btn-sm"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false" style="min-width: 180px;">
                                        <i class="bi bi-trash3 me-2"></i> LOGLARY POZ
                                    </button>

                                    {{-- FORM BARKALY HOWPSUZ POZMAK LOGIKASY --}}
                                    <ul class="dropdown-menu dropdown-menu-dark border-secondary shadow-lg p-2 dropdown-menu-end">
                                        <li>
                                            <h6 class="dropdown-header text-white-50 small">WAGT ARALYGY SAÝLA</h6>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.logs.clear') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="range" value="1hour">
                                                <button type="submit" class="dropdown-item rounded-3 py-2 text-white"><i class="bi bi-clock me-2 text-warning"></i> Soňky 1 sagat</button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.logs.clear') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="range" value="3days">
                                                <button type="submit" class="dropdown-item rounded-3 py-2 text-danger"><i class="bi bi-calendar-event me-2"></i> 3 günden köne</button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.logs.clear') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="range" value="7days">
                                                <button type="submit" class="dropdown-item rounded-3 py-2 text-danger"><i class="bi bi-calendar-range me-2"></i> 7 günden köne</button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.logs.clear') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="range" value="30days">
                                                <button type="submit" class="dropdown-item rounded-3 py-2 text-danger"><i class="bi bi-calendar3 me-2"></i> 1 aýdan köne</button>
                                            </form>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider border-secondary">
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.logs.clear') }}" method="POST" onsubmit="return confirm('Ähli loglary pozmak isleýärsiňizmi?')">
                                                @csrf
                                                <input type="hidden" name="range" value="all">
                                                <button type="submit" class="dropdown-item rounded-3 py-2 fw-bold text-danger text-uppercase">
                                                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Ählisini Arassala
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                                <span class="badge text-info rounded-pill mt-2 px-3 py-1" style="background: rgba(255,255,255,0.05); font-size: 10px;">Awtomatik ulgam</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <div class="d-flex align-items-center gap-2 flex-wrap" id="status-filter-group">
                    <button type="button" class="btn btn-sm btn-outline-light active rounded-pill px-3 filter-btn" data-status="all">
                        <i class="bi bi-layers-half me-1"></i> Ählisi
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 filter-btn" data-status="success">
                        <i class="bi bi-check-circle-fill me-1"></i> OK (200-299)
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-warning rounded-pill px-3 filter-btn" data-status="warning">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i> Warning (400-499)
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 filter-btn" data-status="danger">
                        <i class="bi bi-bug-fill me-1"></i> Error (500+)
                    </button>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-end mb-3 px-1">
                <h4 class="text-white fw-bold mb-0">Live Activity Monitor</h4>
                <span class="text-white-50 small" style="font-size: 12px;"><i class="bi bi-broadcast text-info me-1"></i> Live updates active</span>
            </div>

            <div class="glass-card overflow-hidden">
                <div class="table-responsive">
                    <table class="table align-middle mb-0" style="min-width: 850px;">
                        <thead>
                            <tr class="text-white-50 small border-bottom border-white border-opacity-10" style="font-size: 11px; letter-spacing: 0.5px;">
                                <th class="ps-4 text-center" style="width: 50px;">#</th>
                                <th class="text-start" style="min-width: 160px;">ULANYJY / IP</th>
                                <th class="text-center" style="width: 70px;">OS</th>
                                <th class="text-center" style="width: 80px;">ENJAM</th>
                                <th class="text-center" style="width: 80px;">BRAUZER</th>
                                <th class="text-start" style="min-width: 220px;">GIREN SAHPASY</th>
                                <th class="pe-4 text-end" style="min-width: 110px;">WAGTY</th>
                            </tr>
                        </thead>
                        <tbody id="activity-tbody">
                            @include('admin.activities.partials._activity_rows')
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="load-more-section" class="text-center mt-5 mb-5">
                @if($activities->hasMorePages())
                <button id="load-more-btn" class="btn btn-load-more" data-next-page="{{ $activities->currentPage() + 1 }}">
                    <i class="bi bi-arrow-down-short me-1"></i> Has köp görkez
                </button>
                @endif
            </div>

        </div>
    </div>
</div>

<input type="hidden" id="cleanup-date" value="{{ \Carbon\Carbon::parse($nextCleanupDate)->toIso8601String() }}">

<script>
    function initCleanupCountdown() {
        const dateInput = document.getElementById("cleanup-date");
        if (!dateInput || !dateInput.value) return;
        const cleanupTime = new Date(dateInput.value).getTime();
        const countdownElement = document.getElementById("cleanup-countdown");

        setInterval(function() {
            const now = new Date().getTime();
            const distance = cleanupTime - now;
            if (distance < 0) {
                countdownElement.innerHTML = "Arassalanmaga garaşylýar...";
                return;
            }
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            countdownElement.innerHTML = `${days}g ${hours}s ${minutes}m ${seconds}s`;
        }, 1000);
    }

    let currentStatusFilter = 'all';

    function initLiveFilters() {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const tbody = document.getElementById('activity-tbody');

        filterButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                filterButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                currentStatusFilter = this.getAttribute('data-status');
                fetchFilteredLogs();
            });
        });

        function fetchFilteredLogs() {
            tbody.style.opacity = '0.3';

            const url = new URL(`{{ route('admin.activities.index') }}`, window.location.origin);
            if (currentStatusFilter !== 'all') {
                url.searchParams.set('status', currentStatusFilter);
            }

            fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    tbody.style.opacity = '1';
                    if (html.trim().length > 0) {
                        tbody.innerHTML = html;

                        const loadMoreSection = document.getElementById('load-more-section');
                        loadMoreSection.innerHTML = `
                        <button id="load-more-btn" class="btn btn-load-more" data-next-page="2">
                            <i class="bi bi-arrow-down-short me-1"></i> Has köp görkez
                        </button>
                    `;
                        initLoadMore();
                    } else {
                        tbody.innerHTML = `
                        <tr>
                            <td colspan="7" class="text-center py-5 text-white-50">
                                <i class="bi bi-inbox fs-2 d-block mb-2 text-info"></i>
                                Bu süzgüçe degişli log tapylmady.
                            </td>
                        </tr>
                    `;
                        document.getElementById('load-more-section').innerHTML = '';
                    }
                })
                .catch(() => {
                    tbody.style.opacity = '1';
                });
        }
    }

    function initLoadMore() {
        const btn = document.getElementById('load-more-btn');
        if (!btn) return;

        const newBtn = btn.cloneNode(true);
        btn.parentNode.replaceChild(newBtn, btn);

        newBtn.addEventListener('click', function() {
            const nextPage = newBtn.getAttribute('data-next-page');
            const tbody = document.getElementById('activity-tbody');

            newBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Ýüklenýär...';
            newBtn.disabled = true;

            const url = new URL(`{{ route('admin.activities.index') }}`, window.location.origin);
            url.searchParams.set('page', nextPage);
            if (currentStatusFilter !== 'all') {
                url.searchParams.set('status', currentStatusFilter);
            }

            fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    if (html.trim().length > 0 && !html.includes('Bu süzgüçe degişli log tapylmady')) {
                        const tempDiv = document.createElement('tbody');
                        tempDiv.innerHTML = html;

                        Array.from(tempDiv.children).forEach(row => {
                            tbody.appendChild(row);
                        });

                        newBtn.setAttribute('data-next-page', parseInt(nextPage) + 1);
                        newBtn.innerHTML = '<i class="bi bi-arrow-down-short me-1"></i> Has köp görkez';
                        newBtn.disabled = false;
                    } else {
                        document.getElementById('load-more-section').innerHTML = '<span class="text-white-50 small">Ähli maglumatlar ýüklendi</span>';
                    }
                })
                .catch(() => {
                    newBtn.innerHTML = '<i class="bi bi-exclamation-circle text-danger me-1"></i> Ýalňyşlyk boldy';
                    newBtn.disabled = false;
                });
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        initCleanupCountdown();
        initLiveFilters();
        initLoadMore();
    });
</script>
@endsection