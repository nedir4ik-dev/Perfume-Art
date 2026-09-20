@extends('layouts.app')

@section('title', 'Admin Roles - Perfume Art Collection')

@section('content')
<style>
    /* 1. Arka Plan we Umumy Tema */
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

    /* 2. Liquid Glass Kart Taslamasy */
    .liquid-glass {
        background: rgba(255, 255, 255, 0.02) !important;
        backdrop-filter: blur(20px) saturate(160%);
        -webkit-backdrop-filter: blur(20px) saturate(160%);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 24px !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    }

    /* 3. Tablisa Sazlamalary */
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
        padding: 18px 20px;
    }

    .table tbody td {
        padding: 20px;
        background: transparent !important;
        color: #ffffff !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.03) !important;
        vertical-align: middle;
    }

    .table tbody tr {
        background: transparent !important;
        transition: background 0.2s ease-in-out;
    }

    .table tbody tr:hover {
        background: rgba(13, 202, 240, 0.02) !important;
    }

    /* Responsive Başlyk Düzedişi */
    @media (max-width: 767.98px) {
        .responsive-title {
            font-size: 22px !important;
        }

        .header-section {
            margin-bottom: 30px !important;
        }
    }
</style>

<div class="admin-wrapper d-flex">
    @include('admin.partials.sidebar')

    <div class="main-content flex-grow-1 p-3 p-xl-5">
        <div class="container-xl pt-5">

            {{-- Sahypa Başlygy, Dil we Düwme --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-xl-center gap-3 mb-5 header-section">

                {{-- Çep tarap: Başlyk (Sidebar-daky 'ESASY' ýazgysyna deňleşdirildi, font-size kiçeldildi) --}}
                <div class="mt-5">
                    <h2 class="text-white fw-bold mb-1 responsive-title text-nowrap" >
                        {{ __('app.roles-page-title') }}
                    </h2>
                    <p class="text-white-50 small mb-0">
                        {{ __('app.roles-page-paragraph') }}
                    </p>
                </div>

                {{-- Sag tarap: Düwmeler --}}
                <div class="d-flex align-items-center gap-2 w-100 w-md-auto justify-content-between justify-content-md-end mt-2">
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-info flex-grow-1 flex-md-grow-0 px-3 px-xl-4 rounded-pill fw-bold shadow-xl d-flex align-items-center justify-content-center text-dark" style="height: 42px; font-size: 14px;">
                        <i class="bi bi-plus-lg me-1" style="font-size: 15px;"></i> <span>{{ __('app.roles-page-create-btn') }}</span>
                    </a>

                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle border-0 px-3 py-2 rounded-pill shadow-xl d-flex align-items-center justify-content-center"
                            type="button" id="langDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                            style="background: rgba(255,255,255,0.1); height: 42px; min-width: 95px; font-size: 13px;">
                            <i class="bi bi-translate me-2 text-info" style="font-size: 15px;"></i>
                            <span class="text-uppercase fw-bold">{{ app()->getLocale() }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 p-2"
                            aria-labelledby="langDropdown"
                            style="background: rgba(31, 30, 30, 0.95); backdrop-filter: blur(15px); border-radius: 15px; min-width: 140px; z-index: 9999;">
                            <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'tm') }}">🇹🇲 Turkmen</a></li>
                            <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'ru') }}">🇷🇺 Русский</a></li>
                            <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'en') }}">🇺🇸 English</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Esasy Sanaw Tablisasy (Liquid Glass) --}}
            <div class="liquid-glass overflow-hidden">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4" style="width: 25%">{{ __('app.roles-page-table-th-name') }}</th>
                                <th style="width: 55%">{{ __('app.roles-page-table-th-permissions') }}</th>
                                <th class="pe-4 text-end" style="width: 20%">{{ __('app.roles-page-table-th-actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            <tr>
                                <td class="ps-4">
                                    <span class="text-white fw-bold font-monospace" style="letter-spacing: 0.5px;">{{ strtoupper($role->name) }}</span>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-2">
                                        @forelse($role->permissions as $perm)
                                        <span class="badge rounded-pill bg-info bg-opacity-10 text-info border border-info border-opacity-20 py-2 px-3 fw-normal" style="font-size: 12px; letter-spacing: 0.2px;">
                                            {{ $perm->label }}
                                        </span>
                                        @empty
                                        <span class="text-white-50 small opacity-50 italic">{{ __('app.roles-page-no-permissions') }}</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        {{-- Edit Düwmesi --}}
                                        <a href="{{ route('admin.roles.edit', $role->id) }}"
                                            class="btn btn-sm btn-outline-light border-0 rounded-pill px-3"
                                            style="background: rgba(255,255,255,0.05);"
                                            title="{{ __('app.edit') }}">
                                            <i class="bi bi-pencil-square text-info"></i>
                                        </a>

                                        {{-- Delete Düwmesi --}}
                                        @if(strtolower($role->name) !== 'admin')
                                        <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST"
                                            onsubmit="return confirm('{{ __('app.roles-page-delete-confirm') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-light border-0 rounded-pill px-3" style="background: rgba(255,255,255,0.05);" title="{{ __('app.delete') }}">
                                                <i class="bi bi-trash3-fill text-danger"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
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
@endsection