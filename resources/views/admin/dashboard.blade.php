@extends('layouts.app')

@section('title', 'Admin Dashboard - Perfume Art Collection')

@section('content')

<style>
    @keyframes glass-entrance {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    :root {
        --glass-bg: rgba(31, 30, 30, 0.51);
        --glass-border: rgba(255, 255, 255, 0.08);
        --glass-blur: blur(15px) saturate(150%);
        --ios-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.4);
    }

    .custom-scroll-container {
        max-height: 380px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.1) transparent;
    }

    .custom-scroll-container::-webkit-scrollbar {
        width: 4px;
    }

    .custom-scroll-container::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scroll-container::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.15);
        border-radius: 10px;
    }

    .custom-scroll-container::-webkit-scrollbar-thumb:hover {
        background: rgba(13, 202, 240, 0.3);
    }

    .liquid-glass {
        animation: glass-entrance 0.6s ease-out forwards;
        background: var(--glass-bg) !important;
        backdrop-filter: var(--glass-blur) !important;
        -webkit-backdrop-filter: var(--glass-blur) !important;
        border: 1px solid var(--glass-border) !important;
        box-shadow: var(--ios-shadow);
        border-radius: 24px !important;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .liquid-glass:hover {
        transform: translateY(-5px);
        background: rgba(45, 45, 45, 0.6) !important;
        border-color: rgba(255, 255, 255, 0.15) !important;
    }

    .filter-btn {
        font-size: 10px;
        padding: 5px 12px;
        border-radius: 10px !important;
        transition: 0.3s;
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
        color: rgba(255, 255, 255, 0.4);
        background: rgba(255, 255, 255, 0.02);
    }

    .filter-btn.active {
        background: rgba(13, 202, 240, 0.15) !important;
        color: #0dcaf0 !important;
        border-color: rgba(13, 202, 240, 0.3) !important;
    }

    .icon-shape {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .custom-table thead th {
        background: rgba(255, 255, 255, 0.02);
        color: rgba(255, 255, 255, 0.4);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 10px;
        border: none;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .premium-badge {
        background: rgba(31, 30, 30, 0.6);
        border: 1px solid rgba(255, 215, 0, 0.15);
        border-radius: 15px;
        padding: 10px 20px;
        backdrop-filter: blur(10px);
    }

    .custom-table tbody tr {
        border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        transition: 0.3s;
    }

    .custom-table tbody tr:hover {
        background: rgba(255, 255, 255, 0.02);
    }

    @media (max-width: 991.98px) {
        .main-content {
            padding: 10px !important;
            margin-left: 0 !important;
            width: 100% !important;
        }

        .admin-header-flex {
            flex-direction: column;
            align-items: stretch !important;
            gap: 15px;
            padding: 20px 10px !important;
        }

        .admin-actions-gap {
            width: 100%;
            flex-direction: row;
            justify-content: space-between;
            gap: 10px;
        }

        .premium-badge {
            padding: 8px 12px;
            flex-grow: 1;
            justify-content: center;
        }

        .premium-badge span {
            font-size: 12px !important;
        }

        .container-xl.px-5 {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        .liquid-glass {
            padding: 15px !important;
            margin-bottom: 10px;
        }
    }
</style>

<div class="admin-wrapper d-flex">
    @include('admin.partials.sidebar')

    <div class="main-content flex-grow-1" style="background-color: rgba(31, 30, 30, 0.51); backdrop-filter: blur(5px); min-height: 100vh; overflow-x: hidden;">

        <div class="d-flex justify-content-between align-items-center p-5 pb-4 admin-header-flex">
            <div class="header-text mt-xl-5 mt-5">
                <h2 class="text-white fw-bold mb-1" style="letter-spacing: -1px;">{{ __('app.dashboard') }}</h2>
                <small class="text-white my-1 d-block">{{__('app.welcome')}}, {{ auth()->user()->name }}!</small>
                <h6 class="text-white small my-1">{{ __('app.admin-page-subtitle') }}</h6>
                <p class="text-white-50 small mb-0">{{ now()->format('l, d F Y') }}</p>
            </div>

            <div class="d-flex align-items-center gap-3 admin-actions-gap">
                <div class="premium-badge d-flex align-items-center shadow-sm">
                    <i class="bi bi-gem text-warning me-2"></i>
                    <span class="text-white-50 small me-2 d-none d-sm-inline">{{ __('app.admin-page-most-expensive') }}:</span>
                    <span class="text-warning fw-bold">${{ number_format(\App\Models\Product::max('price'), 0) }}</span>
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

        <div class="container-xl px-lg-5 px-3">

            <div class="row g-3 g-md-4 mb-5">
                <div class="col-12 col-md-4">
                    <div class="liquid-glass p-4 border-0 h-100 border-start border-info border-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-white-50 small mb-1"><span class="spinner-grow spinner-grow-sm text-info me-1" style="width: 10px; height: 10px;"></span> {{ __('app.admin-page-online-users') }}</p>
                                <h3 class="text-info fw-bold mb-0 h4">{{ $onlineUsers }}</h3>
                            </div>
                            <div class="icon-shape"><i class="bi bi-people text-info fs-4"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="liquid-glass p-4 border-0 h-100 border-start border-warning border-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-white-50 small mb-1">{{__('app.admin-page-conversion-rate')}}</p>
                                <h3 class="text-warning fw-bold mb-0 h4">{{ $conversionRate }}%</h3>
                            </div>
                            <div class="icon-shape"><i class="bi bi-pie-chart text-warning fs-4"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="liquid-glass p-4 border-0 h-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-white-50 small mb-1">{{ __('app.admin-page-total-products') }}</p>
                                <h3 class="text-white fw-bold mb-0 h4">{{ $productCount }}</h3>
                            </div>
                            <div class="icon-shape"><i class="bi bi-box-seam text-white-50 fs-4"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md">
                    <div class="liquid-glass p-4 border-0 h-100 border-start border-success border-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-white-50 small mb-1" id="traffic-label">{{ __('app.admin-page-traffic') }} (7G)</p>
                                <h3 class="text-success fw-bold mb-0 h4" id="live-traffic-count">{{ array_sum($trafficData) }}</h3>
                            </div>
                            <div class="icon-shape"><i class="bi bi-lightning-charge text-success fs-4"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md">
                    <div class="liquid-glass p-4 border-0 h-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-white-50 small mb-1">Maintenance Mode</p>
                                @if(app()->isDownForMaintenance())
                                <h3 class="text-danger fw-bold mb-0 h4 d-flex align-items-center gap-2">
                                    <span class="spinner-grow spinner-grow-sm text-danger" role="status"></span>
                                    Active
                                </h3>
                                @else
                                <h3 class="text-success fw-bold mb-0 h4">
                                    Disabled
                                </h3>
                                @endif
                            </div>
                            <div class="icon-shape">
                                <i class="bi {{ app()->isDownForMaintenance() ? 'bi-tools text-danger' : 'bi-shield-check text-success' }} fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md">
                    <div class="liquid-glass p-4 border-0 h-100 border-start {{ $isRecaptchaActive ? 'border-info' : 'border-danger' }} border-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-white-50 small mb-1">reCAPTCHA v3</p>
                                @if($isRecaptchaActive)
                                <h3 class="text-info fw-bold mb-0 h4">Active</h3>
                                <span style="font-size: 9px;" class="text-white-50 text-uppercase">Protected</span>
                                @else
                                <h3 class="text-danger fw-bold mb-0 h4">Disabled</h3>
                                <span style="font-size: 9px;" class="text-white-50 text-uppercase">Keys Missing</span>
                                @endif
                            </div>
                            <div class="icon-shape">
                                <i class="bi {{ $isRecaptchaActive ? 'bi-shield-lock text-info' : 'bi-shield-slash text-danger' }} fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-12 col-lg-8">
                    <div class="liquid-glass p-4 border-0 h-100">
                        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                            <h5 class="text-white fw-bold mb-0">{{ __('app.admin-page-activity-monitor') }} <span id="chart-status" class="text-info ms-2" style="font-size: 10px; font-weight: normal;">Live</span></h5>
                            <div class="d-flex gap-1 p-1 bg-black bg-opacity-20 rounded-3">
                                <button onclick="refreshChart('1hour', this)" class="btn btn-sm filter-btn" data-range="1S">1S</button>
                                <button onclick="refreshChart('24hours', this)" class="btn btn-sm filter-btn" data-range="24S">24S</button>
                                <button onclick="refreshChart('7days', this)" class="btn btn-sm filter-btn active" data-range="7G">7G</button>
                                <button onclick="refreshChart('1month', this)" class="btn btn-sm filter-btn" data-range="1A">1A</button>
                            </div>
                        </div>
                        <div style="height: 320px; position: relative;">
                            <canvas id="trafficChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="liquid-glass p-4 border-0 h-100">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="text-white fw-bold mb-0"><i class="bi bi-fire text-warning me-2"></i>{{ __('app.admin-page-top-selling') }}</h5>
                            <span class="badge bg-warning bg-opacity-10 text-warning" style="font-size: 9px;">{{ __('app.admin-page-top-selling-badge') }}</span>
                        </div>

                        <div class="top-selling-list">
                            @forelse($topSellingProducts as $item)
                            @if($item->product)
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="d-flex align-items-center flex-grow-1 overflow-hidden">
                                        <img src="{{ asset('storage/' . $item->product->image) }}" class="rounded-3 me-2 border border-white border-opacity-10" style="width: 35px; height: 35px; object-fit: cover;">
                                        <span class="text-white small fw-bold text-truncate">{{ $item->product->name }}</span>
                                    </div>
                                    <span class="text-info small fw-bold ms-2">{{ $item->total_qty }} <small class="text-white-50">{{ __('app.admin-page-top-selling-sold') }}</small></span>
                                </div>
                                <div class="progress bg-white bg-opacity-5" style="height: 4px;">
                                    <div class="progress-bar bg-info shadow-glow" style="width: {{ $maxQty > 0 ? ($item->total_qty / $maxQty) * 100 : 0 }}%; transition: 1.5s;"></div>
                                </div>
                            </div>
                            @endif
                            @empty
                            <p class="text-white-50 small text-center py-5">{{ __('app.admin-page-top-selling-no-sales') }}</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-12 col-lg-8">
                    <div class="liquid-glass p-4 border-0">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="text-white fw-bold mb-0"><i class="bi bi-cpu text-info me-2"></i>{{ __('app.admin-page-system-health') }}</h5>
                            <div id="health-status" class="small text-success"><span class="spinner-grow spinner-grow-sm me-1"></span> Live Monitoring</div>
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <div class="p-3 rounded-4 bg-black bg-opacity-20 border border-white border-opacity-5">
                                    <div class="d-flex justify-content-between mb-2">
                                        <small class="text-white-50 text-uppercase" style="font-size: 10px;">CPU Load</small>
                                        <small class="text-info fw-bold"><span id="val-cpu">{{ $cpuUsage }}</span>%</small>
                                    </div>
                                    <div class="progress bg-dark" style="height: 6px;">
                                        <div id="bar-cpu" class="progress-bar bg-info shadow-sm" style="width: {{ $cpuUsage }}%; transition: 1s;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="p-3 rounded-4 bg-black bg-opacity-20 border border-white border-opacity-5">
                                    <div class="d-flex justify-content-between mb-2">
                                        <small class="text-white-50 text-uppercase" style="font-size: 10px;">RAM Usage</small>
                                        <small class="text-warning fw-bold"><span id="val-ram">{{ $ramUsage }}</span>%</small>
                                    </div>
                                    <div class="progress bg-dark" style="height: 6px;">
                                        <div id="bar-ram" class="progress-bar bg-warning shadow-sm" style="width: {{ $ramUsage }}%; transition: 1s;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="p-3 rounded-4 bg-black bg-opacity-20 border border-white border-opacity-5">
                                    <div class="d-flex justify-content-between mb-2">
                                        <small class="text-white-50 text-uppercase" style="font-size: 10px;">Disk Space</small>
                                        <small class="text-danger fw-bold"><span id="val-disk">{{ $diskUsage }}</span>%</small>
                                    </div>
                                    <div class="progress bg-dark" style="height: 6px;">
                                        <div id="bar-disk" class="progress-bar bg-danger shadow-sm" style="width: {{ $diskUsage }}%; transition: 1s;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="p-3 rounded-4 bg-black bg-opacity-20 border border-white border-opacity-5">
                                    <div class="d-flex justify-content-between mb-2">
                                        <small class="text-white-50 text-uppercase" style="font-size: 10px;">DB Latency</small>
                                        <small class="text-success fw-bold"><span id="val-db">{{ $dbLatency }}</span>ms</small>
                                    </div>
                                    <div class="progress bg-dark" style="height: 6px;">
                                        <div id="bar-db" class="progress-bar bg-success shadow-sm" style="width: 100%; transition: 1s;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="liquid-glass p-4 border-0 h-100">
                        <h5 class="text-white fw-bold mb-4">{{ __('app.admin-page-fast-actions') }}</h5>
                        <div class="d-grid gap-3">
                            <a href="{{ route('admin.products.create') }}" class="btn btn-info py-3 rounded-4 fw-bold text-dark border-0">
                                <i class="bi bi-plus-lg me-2"></i> {{ __('app.admin-page-add-new-perfume-btn') }}
                            </a>
                            <a href="{{ route('admin.activities.index') }}" class="btn py-3 rounded-4 text-white border-white border-opacity-10 liquid-glass shadow-none m-0">
                                <i class="bi bi-activity me-2"></i> {{ __('app.admin-page-activity-monitor') }}
                            </a>
                            <a href="{{ route('admin.products.index') }}" class="btn py-3 rounded-4 text-white border-white border-opacity-10 liquid-glass shadow-none m-0">
                                <i class="bi bi-collection me-2"></i> {{ __('app.admin-page-all-products-btn') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="liquid-glass border-0 shadow-lg mb-5 overflow-hidden">
                <div class="d-flex justify-content-between align-items-center p-4">
                    <h5 class="text-white fw-bold mb-0"><i class="bi bi-exclamation-triangle text-warning me-2"></i> {{__('app.admin-page-low-stock-alert')}}</h5>
                    @if($criticalStockCount > 0)
                    <span class="badge bg-danger rounded-pill px-3">{{ $criticalStockCount }} {{__('app.admin-page-critical-count')}}</span>
                    @endif
                </div>

                <div class="custom-scroll-container">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover mb-0 custom-table">
                            <thead>
                                <tr class="text-white-50 small">
                                    <th class="ps-4 py-3">{{__('app.admin-page-table-head-1')}}</th>
                                    <th class="py-3">{{__('app.admin-page-table-head-4')}}</th>
                                    <th class="py-3">{{__('app.admin-page-table-head-5')}}</th>
                                    <th class="text-end pe-4 py-3">{{__('app.admin-page-table-status')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lowStockProducts as $lowProduct)
                                <tr class="align-middle">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/' . $lowProduct->image) }}" class="rounded-3 me-3 border border-white border-opacity-10" style="width: 40px; height: 40px; object-fit: cover;">
                                            <span class="text-white fw-medium text-nowrap">{{ $lowProduct->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-white-50 small">{{ $lowProduct->gender }}</td>
                                    <td>
                                        <span class="fw-bold {{ $lowProduct->stock_quantity <= 5 ? 'text-danger' : 'text-warning' }}">
                                            {{ $lowProduct->stock_quantity }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        @if($lowProduct->stock_quantity <= 5)
                                            <span class="badge bg-danger bg-opacity-10 border border-danger border-opacity-25 px-3"><a href="{{ route('admin.products.edit', $lowProduct->id) }}" class="text-danger text-decoration-none">Critical</a></span>
                                            @else
                                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3">Low</span>
                                            @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="liquid-glass p-4 border-0 mb-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="text-white fw-bold mb-0">{{ __('app.admin-page-recent-added') }}</h5>
                    <a href="{{ route('admin.products.index') }}" class="text-info text-decoration-none small">{{ __('app.admin-page-all-products-btn') }}<i class="bi bi-arrow-right-short ms-1"></i></a>
                </div>
                <div class="table-responsive">
                    <table class="table table-dark align-middle mb-0 custom-table">
                        <thead>
                            <tr>
                                <th class="py-3 ps-0">{{ __('app.admin-page-table-head-1') }}</th>
                                <th class="py-3">{{ __('app.admin-page-table-head-2') }}</th>
                                <th class="py-3">{{ __('app.admin-page-table-head-3') }}</th>
                                <th class="text-end pe-0">{{ __('app.admin-page-table-status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products->take(5) as $recent)
                            <tr>
                                <td class="ps-0 py-3">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $recent->image) }}" class="rounded-3 me-3 border border-white border-opacity-10" style="width: 44px; height: 44px; object-fit: cover;">
                                        <div>
                                            <span class="d-block fw-bold text-white mb-0 text-nowrap">{{ $recent->name }}</span>
                                            <span class="text-white-50" style="font-size: 11px;">{{ $recent->category->name ?? 'Perfume' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-info fw-bold">${{ number_format($recent->price, 2) }}</td>
                                <td class="text-white-50 small text-nowrap">{{ $recent->created_at->diffForHumans() }}</td>
                                <td class="text-end pe-0">
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill" style="font-size: 10px;">{{ __('app.admin-page-active-badge') }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function fetchHealth() {
        fetch("{{ route('admin.dashboard') }}?action=get_system_health", {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('val-cpu').innerText = data.cpuUsage;
                document.getElementById('val-ram').innerText = data.ramUsage;
                document.getElementById('val-disk').innerText = data.diskUsage;
                document.getElementById('val-db').innerText = data.dbLatency;

                document.getElementById('bar-cpu').style.width = data.cpuUsage + '%';
                document.getElementById('bar-ram').style.width = data.ramUsage + '%';
                document.getElementById('bar-disk').style.width = data.diskUsage + '%';
            })
            .catch(e => console.error("Health Check Error"));
    }
    setInterval(fetchHealth, 10000);
</script>

@endsection

@section('scripts')
<script src="{{ asset('js/chart.js') }}"></script>
<script>
    let trafficChart;

    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('trafficChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 320);
        gradient.addColorStop(0, 'rgba(13, 202, 240, 0.3)');
        gradient.addColorStop(1, 'rgba(13, 202, 240, 0)');

        trafficChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Girişler',
                    data: @json($trafficData),
                    borderColor: '#0dcaf0',
                    borderWidth: 2.5,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointHitRadius: 20,
                    pointBackgroundColor: '#0dcaf0',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 10,
                        titleColor: '#0dcaf0',
                        bodyColor: '#fff',
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Girişler: ' + context.raw;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255,255,255,0.03)'
                        },
                        ticks: {
                            color: 'rgba(255,255,255,0.3)',
                            font: {
                                size: 10
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: 'rgba(255,255,255,0.3)',
                            font: {
                                size: 10
                            }
                        }
                    }
                }
            }
        });
    });

    function refreshChart(range, btn) {
        const status = document.getElementById('chart-status');
        const trafficCount = document.getElementById('live-traffic-count');
        const trafficLabel = document.getElementById('traffic-label');

        status.innerText = "Loading...";
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        fetch(`{{ route('admin.dashboard') }}?range=${range}`, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            })
            .then(res => res.json())
            .then(json => {
                trafficChart.data.labels = json.labels;
                trafficChart.data.datasets[0].data = json.data;
                trafficChart.update();
                trafficCount.innerText = json.total;
                trafficLabel.innerText = `Trafik (${btn.getAttribute('data-range')})`;
                status.innerText = "Live";
            });
    }
</script>
@endsection