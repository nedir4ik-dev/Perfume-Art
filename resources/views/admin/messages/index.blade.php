@extends('layouts.app')

@section('title', 'Admin Messages - Perfume Art Collection')

@section('content')
<style>
    body {
        background: #121212;
    }

    /* Esasy arka fon we dumanlygy */
    .main-content {
        background-color: rgba(31, 30, 30, 0.51) !important;
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
    }

    /* Kartoçka dizaýny */
    .glass-card {
        background: rgba(255, 255, 255, 0.03) !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 24px;
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
    }

    /* Tablisanyň dury dizaýny */
    .table,
    .table td,
    .table th,
    .table thead,
    .table tbody,
    .table tr {
        background-color: transparent !important;
        color: white !important;
        border-color: rgba(255, 255, 255, 0.05) !important;
    }

    .table th {
        font-size: 11px;
        letter-spacing: 1px;
    }

    /* Modal Dizaýny: Doly görner ýaly we Blur bolýan edildi */
    .modal-content {
        background: rgba(30, 30, 30, 0.95) !important;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 25px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
    }

    /* Uzyn hatlarda aşak süýşürip biler ýaly (Scroll) */
    .modal-dialog-scrollable .modal-content {
        max-height: 90vh;
    }

    /* Modal açylanda arkasyndaky dumanlygy sazlamak */
    .modal-backdrop {
        backdrop-filter: blur(5px) !important;
        -webkit-backdrop-filter: blur(5px) !important;
        background-color: rgba(0, 0, 0, 0.7) !important;
    }

    /* Modal içindäki inputlar */
    .modal .form-control {
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: white !important;
        transition: 0.3s;
    }

    .modal .form-control:focus {
        border-color: #0dcaf0 !important;
        box-shadow: 0 0 10px rgba(13, 202, 240, 0.2) !important;
    }

    /* "X" düwmesiniň has aýdyň bolmagy üçin */
    .btn-close-white {
        filter: invert(1) grayscale(100%) brightness(200%);
        opacity: 0.8;
    }

    /* Mobil ekran dizaýn optimizasiýasy */
    @media (max-width: 991.98px) {
        .main-content {
            padding: 15px !important;
        }
    }

    @media (max-width: 575.98px) {

        /* Telefon ekranynda kartoçkanyň gyra boşluklaryny sazlamak */
        .glass-card {
            padding: 15px 10px !important;
            border-radius: 16px !important;
        }

        /* Telefonlarda başlygyň şrifbini biraz kiçeltmek */
        .responsive-title {
            font-size: 30px !important;
        }
    }
</style>

<div class="admin-wrapper d-flex">
    @include('admin.partials.sidebar')

    <div class="main-content flex-grow-1 p-3 p-md-5 min-vh-100">
        <div class="container-xl pt-4">

            {{-- Sahypanyň Başlygy: Telefonlarda-da Gapdalma-Gapdal Durar Ýaly Edildi --}}
            <div class="d-flex justify-content-between align-items-center gap-2 mb-4 pt-5 pt-xl-2 position-relative">
                {{-- Çep tarap: Ady (Burger menýu düwmesine degmez ýaly ps-4 goşuldy) --}}
                <div class="ps-4 ps-sm-0">
                    <h2 class="text-white fw-bold mb-0 responsive-title text-nowrap">Gelen Habarlar</h2>
                    <small class="text-white-50">Müşderiler tarapyndan ugradylan hatlar</small>
                </div>

                {{-- Sag tarap: Dil Saýlama Dropdown --}}
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

            {{-- Tablisa --}}
            <div class="glass-card p-3 p-md-4 mt-4 shadow-lg">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr style="border-bottom: 2px solid rgba(255,255,255,0.1) !important;">
                                <th class="py-3 text-white-50 fw-bold text-uppercase">Status</th>
                                <th class="py-3 text-white-50 fw-bold text-uppercase">Ugradyjy</th>
                                <th class="py-3 text-white-50 fw-bold text-uppercase">Email</th>
                                <th class="py-3 text-white-50 fw-bold text-uppercase">Habar</th>
                                <th class="py-3 text-white-50 fw-bold text-uppercase text-end pe-4">Sazlamalar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($messages as $msg)
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                <td>
                                    @if(!$msg->is_read)
                                    <span class="badge bg-info text-dark rounded-pill px-3" style="font-size: 10px; font-weight: 800;">TÄZE</span>
                                    @else
                                    <span class="badge bg-white bg-opacity-10 text-white-50 rounded-pill px-3" style="font-size: 10px;"><i class="bi bi-check2-all"></i> OKALDY</span>
                                    @endif
                                </td>
                                <td class="fw-bold text-white">{{ $msg->name }}</td>
                                <td class="text-info opacity-75 small">{{ $msg->email }}</td>
                                <td style="max-width: 250px;">
                                    <div class="text-truncate small text-white-50">{{ $msg->message }}</div>
                                </td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-light rounded-pill px-3 shadow-sm border-0 fw-bold"
                                        data-bs-toggle="modal"
                                        data-bs-target="#msgModal{{ $msg->id }}"
                                        style="font-size: 12px;">
                                        <i class="bi bi-eye-fill me-1 text-dark"></i> Oka
                                    </button>
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

{{-- MODALLAR (Table-iň daşynda) --}}
@foreach($messages as $msg)
<div class="modal fade" id="msgModal{{ $msg->id }}" tabindex="-1" aria-labelledby="msgModalLabel{{ $msg->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="background-color: rgba(31, 30, 30, 0.51); backdrop-filter: blur(5px);">
        <div class="modal-content text-white">
            <div class="modal-header border-bottom border-white border-opacity-10 py-4 px-4">
                <h5 class="modal-title fw-bold" id="msgModalLabel{{ $msg->id }}">
                    <i class="bi bi-envelope-open me-2 text-info"></i> {{ $msg->name }} haty
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-4">
                    <label class="text-white-50 small text-uppercase fw-bold mb-1" style="letter-spacing: 1px; font-size: 10px;">E-mail Adresi:</label>
                    <p class="text-info mb-0">{{ $msg->email }}</p>
                </div>
                <div class="mb-4">
                    <label class="text-white-50 small text-uppercase fw-bold mb-1" style="letter-spacing: 1px; font-size: 10px;">Doly Habar:</label>
                    <p class="lh-base text-white-50" style="white-space: pre-line; font-size: 0.95rem;">{{ $msg->message }}</p>
                </div>

                <div class="mt-4 pt-4 border-top border-white border-opacity-10">
                    <label class="text-info small text-uppercase fw-bold mb-3" style="letter-spacing: 1px; font-size: 11px;">
                        <i class="bi bi-reply-fill"></i> Jogap ýazmak
                    </label>

                    <form action="{{ route('admin.messages.reply', $msg->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea name="reply_message" class="form-control p-3 shadow-none"
                                rows="3" placeholder="Müşderä näme diýmek isleýärsiňiz?..."
                                style="border-radius: 15px; font-size: 0.9rem;" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-info w-100 py-2.5 rounded-pill fw-bold text-dark">
                            <i class="bi bi-send-fill me-2"></i> Jogaby ugrat
                        </button>
                    </form>
                </div>

                <div class="mt-4 pt-2 text-white-50 small d-flex align-items-center" style="font-size: 11px; opacity: 0.6;">
                    <i class="bi bi-clock me-1"></i> {{ $msg->created_at->format('d.m.Y — H:i') }}
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0 flex-column gap-2">
                @if(!$msg->is_read)
                <form action="{{ route('admin.messages.read', $msg->id) }}" method="POST" class="w-100 m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-info w-100 py-2.5 rounded-pill fw-bold shadow-sm">
                        <i class="bi bi-check-circle-fill me-2"></i> Okaldy diýip belle
                    </button>
                </form>
                @endif
                <button type="button" class="btn btn-link text-white-50 text-decoration-none w-100 py-2 small" data-bs-dismiss="modal">Yza gaýt</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection