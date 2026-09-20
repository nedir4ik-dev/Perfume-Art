@extends('layouts.app')

@section('title', 'Admin Orders - Perfume Art Collection')

@section('content')
<style>
    /* Premium Gara Sazlamalar Dizaýn Elementleri */
    .settings-card {
        background: rgba(255, 255, 255, 0.02) !important;
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    /* Action Buttons */
    .btn-square {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: 0.2s;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: white;
        padding: 0;
    }

    .btn-square:hover {
        transform: translateY(-2px);
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }

    /* Status Pill-ler */
    .status-pill {
        padding: 5px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 10px;
        text-transform: uppercase;
        border: 1px solid rgba(255, 255, 255, 0.1);
        display: inline-block;
    }

    .status-pending {
        background: rgba(255, 193, 7, 0.15);
        color: #ffc107;
    }

    .status-accepted {
        background: rgba(13, 202, 240, 0.15);
        color: #0dcaf0;
    }

    .status-shipped {
        background: rgba(13, 110, 253, 0.15);
        color: #0d6efd;
    }

    .status-completed {
        background: rgba(25, 135, 84, 0.2);
        color: #198754;
    }

    .status-cancelled {
        background: rgba(220, 53, 69, 0.15);
        color: #dc3545;
    }
</style>

<div class="admin-wrapper d-flex">
    @include('admin.partials.sidebar')

    <div class="main-content flex-grow-1 min-vh-100" style="background-color: rgba(31, 30, 30, 0.51); backdrop-filter: blur(5px);">
        <div class="container-xl p-3 p-sm-5 p-lg-5">

            <div class="row align-items-center g-3 mb-5 mt-5 pt-2 mt-xl-0">
                <div class="col-6 col-sm-6 text-start">
                    <h1 class="text-white fw-bold mb-1">
                        {{ __('app.orders-page-title') }}
                    </h1>
                    <p class="text-white-50 small mb-0">{{ __('app.orders-page-subtitle') }}</p>
                </div>
                <div class="col-6 col-sm-6 d-flex justify-content-end align-items-center gap-2">

                    {{-- SARGYTLARY POZMAK / ARASSALAMAK DÜWMESI --}}
                    <div class="dropdown">
                        <button class="btn btn-outline-danger border-0 px-3 py-2 rounded-pill shadow-xl d-flex align-items-center justify-content-center"
                            type="button" id="clearOrdersDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                            style="background: rgba(220, 53, 69, 0.15); height: 42px; font-size: 13px;">
                            <i class="bi bi-trash me-2 text-danger"></i>
                            <span class="fw-bold text-danger">Arassala</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 p-2"
                            aria-labelledby="clearOrdersDropdown"
                            style="background: rgba(31, 30, 30, 0.95); backdrop-filter: blur(10px); border-radius: 15px; min-width: 220px; z-index: 9999;">
                            <li>
                                <form action="{{ route('admin.orders.clearOld') }}" method="POST" onsubmit="return confirm('3 gün öňki sargytlary pozmak isleýärsiňizmi?');">
                                    @csrf
                                    <input type="hidden" name="days" value="3">
                                    <button type="submit" class="dropdown-item rounded-3 text-warning py-2 small">
                                        <i class="bi bi-clock-history me-2"></i>3 gün öňki sargytlary poz
                                    </button>
                                </form>
                            </li>
                            <li>
                                <form action="{{ route('admin.orders.clearOld') }}" method="POST" onsubmit="return confirm('7 gün öňki sargytlary pozmak isleýärsiňizmi?');">
                                    @csrf
                                    <input type="hidden" name="days" value="7">
                                    <button type="submit" class="dropdown-item rounded-3 text-warning py-2 small">
                                        <i class="bi bi-clock-history me-2"></i>7 gün öňki sargytlary poz
                                    </button>
                                </form>
                            </li>
                            <li>
                                <form action="{{ route('admin.orders.clearOld') }}" method="POST" onsubmit="return confirm('30 gün öňki sargytlary pozmak isleýärsiňizmi?');">
                                    @csrf
                                    <input type="hidden" name="days" value="30">
                                    <button type="submit" class="dropdown-item rounded-3 text-danger py-2 small">
                                        <i class="bi bi-clock-history me-2"></i>30 gün öňki sargytlary poz
                                    </button>
                                </form>
                            </li>
                            <li>
                                <hr class="dropdown-divider border-secondary opacity-25">
                            </li>
                            <li>
                                <form action="{{ route('admin.orders.clearOld') }}" method="POST" onsubmit="return confirm('ÜNS BERIŇ! Ähli sargytlar arassalanar. Razymy?');">
                                    @csrf
                                    <input type="hidden" name="days" value="all">
                                    <button type="submit" class="dropdown-item rounded-3 text-danger fw-bold py-2 small">
                                        <i class="bi bi-trash-fill me-2"></i>Ähli sargytlary poz
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>

                    {{-- DIL SEÇMEK DÜWMESI --}}
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

            <div class="card settings-card rounded-4 p-3 p-sm-4 text-white">
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle border-secondary m-0" style="min-width: 900px;">
                        <thead class="text-secondary small text-uppercase">
                            <tr>
                                <th class="border-bottom border-secondary py-3 ps-3">№</th>
                                <th class="border-bottom border-secondary py-3">{{ __('app.orders-page-thead-1') }}</th>
                                <th class="border-bottom border-secondary py-3">{{ __('app.orders-page-thead-2') }}</th>
                                <th class="border-bottom border-secondary py-3 text-center">{{ __('app.orders-page-thead-3') }}</th>
                                <th class="border-bottom border-secondary py-3 text-center">{{ __('app.orders-page-thead-4') }}</th>
                                <th class="border-bottom border-secondary py-3 text-center">{{ __('app.orders-page-thead-5') }}</th>
                                <th class="border-bottom border-secondary py-3 text-end pe-3">{{ __('app.orders-page-thead-6') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr class="border-bottom border-white border-opacity-10">
                                <td class="py-3 ps-3 fw-bold text-info font-monospace">#{{ $order->order_number }}</td>

                                <td class="py-3 text-nowrap">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-info bg-opacity-10 p-2 me-3 border border-info border-opacity-10 flex-shrink-0" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-person text-info"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold small text-white">{{ $order->customer_name }}</div>
                                            <div class="text-white-50" style="font-size: 11px;">{{ $order->customer_phone }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="d-flex flex-wrap gap-1" style="max-width: 280px;">
                                        @if($order->items && is_array($order->items))
                                        @foreach($order->items as $item)
                                        <span class="badge bg-white bg-opacity-10 text-white-50 border border-white border-opacity-10 fw-normal">
                                            {{ $item['name'] ?? __('app.orders-page-thead-2') }} <b class="text-info">x{{ $item['quantity'] ?? 1 }}</b>
                                        </span>
                                        @endforeach
                                        @endif
                                    </div>
                                </td>

                                <td class="text-center">
                                    <span class="text-warning fw-bold">{{ number_format($order->total_price, 2) }} TMT</span>
                                </td>

                                <td class="text-center">
                                    @php
                                    $statusMap = [
                                    'pending' => ['class' => 'status-pending', 'label' => 'PENDING'],
                                    'accepted' => ['class' => 'status-accepted', 'label' => 'ACCEPTED'],
                                    'shipped' => ['class' => 'status-shipped', 'label' => 'SHIPPED'],
                                    'completed' => ['class' => 'status-completed', 'label' => 'COMPLETED'],
                                    'cancelled' => ['class' => 'status-cancelled', 'label' => 'CANCELED']
                                    ];
                                    $st = $statusMap[strtolower($order->status)] ?? ['class' => 'status-pending', 'label' => strtoupper($order->status)];
                                    @endphp
                                    <span class="status-pill {{ $st['class'] }}">{{ $st['label'] }}</span>
                                </td>

                                <td class="text-center text-nowrap">
                                    <div class="fw-bold small">{{ $order->created_at->timezone('Asia/Ashgabat')->format('H:i') }}</div>
                                    <div class="text-white-50" style="font-size: 10px;">{{ $order->created_at->format('d.m.Y') }}</div>
                                </td>

                                <td class="text-end pe-3">
                                    <div class="d-inline-flex gap-2 align-items-center justify-content-end">
                                        @php $currentStatus = strtolower($order->status); @endphp

                                        @if($currentStatus == 'pending')
                                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="m-0">
                                            @csrf
                                            <input type="hidden" name="status" value="accepted">
                                            <button type="submit" class="btn-square text-success border-0" title="{{ __('app.orders-page-action-accept') }}">
                                                <i class="bi bi-check2 fs-5"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" onsubmit="return confirm('{{ __('app.orders-page-confirm-cancel') }}')" class="m-0">
                                            @csrf
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="btn-square text-danger border-0" title="{{ __('app.orders-page-action-cancel') }}">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                        @endif

                                        @if($currentStatus == 'accepted')
                                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="m-0">
                                            @csrf
                                            <input type="hidden" name="status" value="shipped">
                                            <button type="submit" class="btn btn-info btn-sm rounded-pill px-3 py-1 fw-bold text-dark shadow-sm border-0" style="white-space: nowrap;">
                                                <i class="bi bi-truck me-1"></i> {{ __('app.orders-page-btn-ship') }}
                                            </button>
                                        </form>
                                        @endif

                                        @if($currentStatus == 'shipped')
                                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="m-0">
                                            @csrf
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="btn btn-success btn-sm rounded-pill px-3 py-1 fw-bold shadow-sm border-0" style="white-space: nowrap;">
                                                <i class="bi bi-check-all me-1"></i> {{ __('app.orders-page-btn-complete') }}
                                            </button>
                                        </form>
                                        @endif

                                        @if(in_array($currentStatus, ['completed', 'cancelled']))
                                        <span class="badge bg-white bg-opacity-10 text-white-50 px-3 py-2 rounded-pill small border border-white border-opacity-10" style="white-space: nowrap;">
                                            <i class="bi bi-lock-fill me-1"></i> {{ __('app.orders-page-archive') }}
                                        </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="p-4 d-flex justify-content-center border-top border-white border-opacity-5 mt-3" style="background: rgba(0,0,0,0.1); border-radius: 0 0 16px 16px;">
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* Pagination Fix */
    .pagination .page-link {
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: rgba(255, 255, 255, 0.7) !important;
    }

    .pagination .page-item.active .page-link {
        background: #0dcaf0 !important;
        color: #000 !important;
        font-weight: bold;
        border-color: #0dcaf0 !important;
    }
</style>
@endsection