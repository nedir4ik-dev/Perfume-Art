@extends('layouts.app')

@section('title', 'Söwdaňyz üçin Sag boluň!')

@section('content')
<div class="container-xl pt-3">
    <div class="d-flex justify-content-end py-4">
        <div class="dropdown">
            <button class="btn btn-outline-light dropdown-toggle border-0 px-3 py-2 rounded-pill shadow-xl d-flex align-items-center justify-content-center"
                type="button" id="langDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                style="background: rgba(66, 65, 65, 0.57); height: 42px; min-width: 95px; font-size: 13px;">
                <i class="bi bi-translate me-2 text-info" style="font-size: 15px;"></i>
                <span class="text-uppercase fw-bold">{{ app()->getLocale() }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 p-2"
                aria-labelledby="langDropdown"
                style="background: rgba(31, 30, 30, 0.51); backdrop-filter: blur(5px); border-radius: 15px; min-width: 140px; z-index: 1000;">
                <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'tm') }}">🇹🇲 Turkmen</a></li>
                <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'ru') }}">🇷🇺 Русский</a></li>
                <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'en') }}">🇺🇸 English</a></li>
            </ul>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-7 text-center">

            @if($orderData)
            {{-- 1. HARSAWY (SUCCESS CARD) - HÄZIRKI TÄZE EDILEN SARGYT --}}
            <div class="card border-0 shadow-lg rounded-5 overflow-hidden"
                style="background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.1) !important;">

                <div class="card-body p-4 p-md-5">
                    <div class="display-1 text-success mb-4 animate__animated animate__bounceIn">
                        <i class="bi bi-check2-circle shadow-glow"></i>
                    </div>

                    <h1 class="display-5 fw-bold text-white mb-3">{{ __('app.success-page-title') }}</h1>
                    <p class="h5 text-white-50 mb-4 fw-light">
                        {{ __('app.success-page-subtitle') }}
                    </p>

                    <div class="bg-dark bg-opacity-25 rounded-4 mb-4 border border-white border-opacity-10 text-start overflow-hidden shadow-inner">

                        <div class="p-3 border-bottom border-white border-opacity-10 d-flex justify-content-between align-items-center bg-dark bg-opacity-10">
                            <div>
                                <span class="text-white-50 small text-uppercase d-block" style="font-size: 0.65rem;">
                                    {{ __('app.success-page-order-code') }}
                                </span>
                                <span class="text-info fw-bold font-monospace">
                                    {{ $orderData['order_number'] }}
                                </span>
                            </div>

                            {{-- DINAMIKI STATUS BADGE --}}
                            @php
                            $currentStatus = strtolower($orderData['status'] ?? 'pending');

                            $statusConfig = [
                            'pending' => ['bg-warning', 'text-warning', 'bi-clock-history', 'Taýýarlanýar'],
                            'accepted' => ['bg-primary', 'text-primary', 'bi-check-circle', 'Kabul edildi'],
                            'shipped' => ['bg-info', 'text-info', 'bi-truck', 'Ýolda'],
                            'completed' => ['bg-success', 'text-success', 'bi-check2-all', 'Gowşuryldy'],
                            'cancelled' => ['bg-danger', 'text-danger', 'bi-x-circle', 'Ýatyryldy (Atkaz)'],
                            ];

                            $st = $statusConfig[$currentStatus] ?? ['bg-secondary', 'text-secondary', 'bi-info-circle', strtoupper($currentStatus)];
                            @endphp

                            <span class="badge {{ $st[0] }} bg-opacity-25 {{ $st[1] }} rounded-pill px-3 py-2 border border-white border-opacity-10 small">
                                <i class="bi {{ $st[2] }} me-1"></i> {{ $st[3] }}
                            </span>
                        </div>

                        <div class="p-3" style="max-height: 250px; overflow-y: auto;">
                            @forelse($orderData['items'] ?? [] as $item)
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="text-white">
                                    <div class="fw-bold small">{{ $item['name'] ?? ($item['title'] ?? 'Önüm') }}</div>
                                    <div class="text-white-50" style="font-size: 0.75rem;">
                                        {{ $item['quantity'] }} sany × {{ number_format($item['price'], 2) }}$
                                    </div>
                                </div>
                                <div class="text-white fw-bold small">
                                    {{ number_format($item['price'] * $item['quantity'], 2) }}$
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-2 text-white-50 small italic">
                                Sargyt maglumatlary tapylmady.
                            </div>
                            @endforelse
                        </div>

                        <div class="p-3 bg-dark bg-opacity-20 d-flex justify-content-between align-items-center fw-bold border-top border-white border-opacity-10">
                            <span class="text-white-50 fw-normal">{{ __('app.success-page-total-payment') }}</span>
                            <span class="text-success h5 mb-0">
                                {{ number_format($orderData['total_price'] ?? 0, 2) }} TMT
                            </span>
                        </div>
                    </div>

                    <p class="text-white-50 small mb-5 px-md-5">
                        {{ __('app.success-page-description') }}
                    </p>

                    <div class="d-grid gap-3 col-md-10 mx-auto">
                        <a href="{{ route('orders.my') }}" class="btn btn-info rounded-pill py-3 fw-bold shadow-sm transition-hover text-dark border-0">
                            <i class="bi bi-box-seam-fill me-2"></i> Sargydymy Yzarla
                        </a>

                        <a href="{{ route('home') }}" class="btn btn-outline-light rounded-pill py-3 fw-bold opacity-75">
                            <i class="bi bi-house-door me-2"></i> {{ __('app.success-page-home-btn') }}
                        </a>
                    </div>
                </div>

                <div class="py-2 bg-success opacity-75"></div>
            </div>

            @else
            {{-- 2. SARGYT KODY BOLMASA ÝA-DA RELOAD BOLSA SIZIŇ SARGYTLARYŇYZ SANAWY --}}
            <div class="card border-0 shadow-lg rounded-5 overflow-hidden text-start p-4 p-md-5"
                style="background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.1) !important;">

                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-white border-opacity-10">
                    <div>
                        <h3 class="text-white fw-bold mb-1"><i class="bi bi-boxes text-info me-2"></i>Siziň Sargytlaryňyz</h3>
                        <p class="text-white-50 small mb-0">Öň eden sargytlaryňyzyň sanawy we ýagdaýy</p>
                    </div>
                    <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
                        <i class="bi bi-house me-1"></i> Baş sahypa
                    </a>
                </div>

                @if(isset($myOrders) && count($myOrders) > 0)
                <div class="d-flex flex-column gap-3">
                    @foreach($myOrders as $myOrder)
                    @php
                    $mStatus = strtolower($myOrder->status ?? 'pending');
                    $mConfig = [
                    'pending' => ['bg-warning', 'text-warning', 'bi-clock-history', 'Taýýarlanýar'],
                    'accepted' => ['bg-primary', 'text-primary', 'bi-check-circle', 'Kabul edildi'],
                    'shipped' => ['bg-info', 'text-info', 'bi-truck', 'Ýolda'],
                    'completed' => ['bg-success', 'text-success', 'bi-check2-all', 'Gowşuryldy'],
                    'cancelled' => ['bg-danger', 'text-danger', 'bi-x-circle', 'Ýatyryldy'],
                    ];
                    $mst = $mConfig[$mStatus] ?? ['bg-secondary', 'text-secondary', 'bi-info-circle', strtoupper($mStatus)];
                    @endphp
                    <div class="p-3 rounded-4 bg-dark bg-opacity-40 border border-white border-opacity-10 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
                        <div>
                            <span class="badge bg-info bg-opacity-25 text-info font-monospace mb-1">{{ $myOrder->order_number }}</span>
                            <div class="text-white-50 small">
                                <i class="bi bi-calendar3 me-1"></i> {{ $myOrder->created_at ? $myOrder->created_at->format('d.m.Y H:i') : '' }}
                            </div>
                        </div>
                        <div class="text-sm-end">
                            <div class="text-success fw-bold h6 mb-1">{{ number_format($myOrder->total_price, 2) }} TMT</div>
                            <span class="badge {{ $mst[0] }} bg-opacity-25 {{ $mst[1] }} rounded-pill px-2 py-1 small">
                                <i class="bi {{ $mst[2] }} me-1"></i> {{ $mst[3] }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-5">
                    <i class="bi bi-basket text-white-50 display-1 d-block mb-3 opacity-50"></i>
                    <h5 class="text-white fw-bold">Entek hiç hili sargyt etmediňiz</h5>
                    <p class="text-white-50 small mb-4">Saýtlarymyzdan harytlary saýlap ilkinji sargydyňyzy edip bilersiňiz.</p>
                    <a href="{{ route('home') }}" class="btn btn-info rounded-pill px-4 py-2 fw-bold text-dark">
                        Söwda Başla
                    </a>
                </div>
                @endif
            </div>
            @endif

        </div>
    </div>
</div>

<style>
    .shadow-glow {
        text-shadow: 0 0 20px rgba(25, 135, 84, 0.5);
    }

    .transition-hover:hover {
        transform: translateY(-3px);
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2) !important;
    }
</style>
@endsection