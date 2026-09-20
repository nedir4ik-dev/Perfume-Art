@extends('layouts.app')

@section('content')
<div class="container py-5" style="min-height: 80vh;">
    <div class="d-flex justify-content-end pb-4">
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
    <div class="glass-card p-4 border-0 shadow-lg" style="background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(15px); border-radius: 25px; color: white;">
        <h3 class="fw-bold mb-4"><i class="bi bi-bag-check-fill text-info me-2"></i> Meniň Sargytlarym</h3>

        @if($orders->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-cart-x fs-1 opacity-25"></i>
            <p class="mt-3 opacity-50">Sizde heniz sargyt ýok.</p>
            <a href="{{ route('home') }}" class="btn btn-info rounded-pill px-4">Söwda Başla</a>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-dark table-hover custom-table">
                <thead>
                    <tr class="opacity-50 text-capitalize">
                        <th>Sargyt Kody</th>
                        <th>Sene</th>
                        <th>Jemi Baha</th>
                        <th>Ýagdaýy (Status)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td class="fw-bold">
                            <a href="{{ route('pages.success') }}?order_number={{ $order->order_number }}" class="text-info text-decoration-none hover-underline">
                                {{ $order->order_number }}
                            </a>
                        </td>
                        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                        <td class="fw-bold">{{ number_format($order->total_price, 2) }}TMT</td>
                        <td>
                            @php
                            $statusColors = [
                            'pending' => ['bg-warning', 'Garaşylýar'],
                            'accepted' => ['bg-primary', 'Kabul edildi'],
                            'shipped' => ['bg-info', 'Ýolda'],
                            'completed' => ['bg-success', 'Gowşuryldy'],
                            'cancelled' => ['bg-danger', 'Atkaz edildi'],
                            ];
                            $status = $statusColors[strtolower($order->status)] ?? ['bg-secondary', $order->status];
                            @endphp
                            <span class="badge {{ $status[0] }} bg-opacity-25 text-{{ str_replace('bg-', '', $status[0]) }} px-3 py-2 rounded-pill">
                                {{ $status[1] }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

<style>
    .custom-table {
        --bs-table-bg: transparent;
        border-color: rgba(255, 255, 255, 0.1);
    }

    .custom-table td {
        vertical-align: middle;
        padding: 20px 10px;
        color: #eee;
    }
</style>
@endsection