@extends('layouts.app')

@section('title', 'Admin Brands - Perfume Art Collection')

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
    .btn-action-edit {
        border-radius: 20px;
        transition: 0.2s;
        background: rgba(255, 193, 7, 0.05);
        border: 1px solid rgba(255, 193, 7, 0.2);
        color: #ffc107;
    }

    .btn-action-edit:hover {
        transform: translateY(-2px);
        background: #ffc107;
        color: #000;
    }

    .btn-action-delete {
        border-radius: 20px;
        transition: 0.2s;
        background: rgba(220, 53, 69, 0.05);
        border: 1px solid rgba(220, 53, 69, 0.2);
        color: #dc3545;
    }

    .btn-action-delete:hover {
        transform: translateY(-2px);
        background: #dc3545;
        color: #fff;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.02) !important;
    }
</style>

<div class="admin-wrapper d-flex">
    @include('admin.partials.sidebar')

    {{-- Arka plan dizaýny --}}
    <div class="main-content flex-grow-1 p-5 p-xl-5 min-vh-100" style="background-color: rgba(31, 30, 30, 0.51); backdrop-filter: blur(5px); overflow-x: hidden;">
        <div class="container-xl">

            <div class="row align-items-center g-3 mb-4 pt-4 mt-1 mt-xl-0">
                <div class="d-flex justify-content-between align-items-center mt-5 p-3 p-md-4 pt-5 pb-0 flex-wrap gap-3">
                    <div class="flex-grow-1">
                        <h1 class="text-white fw-bold mb-1">{{__('app.brand-page-index-title')}}</h1>
                        <p class="text-white-50 small mb-0">{{__('app.brand-page-index-subtitle')}}</p>
                    </div>

                    <div class="d-flex align-items-center gap-1">
                        <a href="{{ route('admin.brands.create') }}"
                            class="btn btn-info rounded-pill px-4 py-2 shadow-xl fw-bold transition-all">
                            <i class="bi bi-plus-circle-fill me-1"></i> {{__('app.brand-page-index-add-brand-btn')}}
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
                                style="background: rgba(31, 30, 30, 0.51); backdrop-filter: blur(5px); border-radius: 15px; min-width: 140px; z-index: 9999;">
                                <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'tm') }}">🇹🇲 Turkmen</a></li>
                                <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'ru') }}">🇷🇺 Русский</a></li>
                                <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'en') }}">🇺🇸 English</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Esasy Kart (Settings Card Garaňky Dizaýny) --}}
                <div class="card settings-card rounded-4 p-3 p-sm-4 text-white">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover align-middle border-secondary m-0" style="min-width: 800px;">
                            <thead class="text-secondary small text-uppercase">
                                <tr>
                                    <th class="border-bottom border-secondary py-3 ps-3" style="width: 100px;">{{ __('app.brand-page-index-table-head-1') }}</th>
                                    <th class="border-bottom border-secondary py-3">{{ __('app.brand-page-index-table-head-2') }}</th>
                                    <th class="border-bottom border-secondary py-3 text-center" style="width: 180px;">{{ __('app.brand-page-index-table-head-3') }}</th>
                                    <th class="border-bottom border-secondary py-3 text-end pe-3" style="width: 250px;">{{ __('app.brand-page-index-table-head-4') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($brands as $brand)
                                <tr class="border-bottom border-white border-opacity-10">
                                    {{-- Logo --}}
                                    <td class="py-3 ps-3">
                                        @if($brand->logo_url)
                                        <div class="p-1 bg-white rounded-3 d-inline-block shadow-sm" style="line-height: 0;">
                                            <img src="{{ asset('storage/' . $brand->logo_url) }}"
                                                class="rounded-2"
                                                style="width: 44px; height: 44px; object-fit: contain;">
                                        </div>
                                        @else
                                        <div class="bg-white bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center"
                                            style="width: 52px; height: 52px; border: 1px solid rgba(255,255,255,0.05);">
                                            <i class="bi bi-image text-white-50 fs-5"></i>
                                        </div>
                                        @endif
                                    </td>

                                    {{-- Name --}}
                                    <td class="py-3 text-nowrap">
                                        <span class="text-white fw-bold fs-6">{{ $brand->getName() }}</span>
                                        <div class="text-white-50 font-monospace" style="font-size: 11px;">ID: #{{ $brand->id }}</div>
                                    </td>

                                    {{-- Status --}}
                                    <td class="py-3 text-center">
                                        @if($brand->is_active)
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 border border-success border-opacity-25 small fw-bold">
                                            <i class="bi bi-check-circle-fill me-1"></i> {{__('app.brand-page-index-active')}}
                                        </span>
                                        @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2 border border-danger border-opacity-25 small fw-bold">
                                            <i class="bi bi-x-circle-fill me-1"></i> {{__('app.brand-page-index-passive')}}
                                        </span>
                                        @endif
                                    </td>

                                    {{-- Amallar --}}
                                    <td class="py-3 text-end pe-3">
                                        <div class="d-inline-flex gap-2 align-items-center justify-content-end">
                                            <a href="{{ route('admin.brands.edit', $brand->id) }}"
                                                class="btn btn-sm btn-action-edit px-3 py-1-5 small fw-bold d-flex align-items-center gap-1">
                                                <i class="bi bi-pencil-square"></i> {{ __('app.brand-page-index-edit-btn') }}
                                            </a>

                                            <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-action-delete px-3 py-1-5 small fw-bold d-flex align-items-center gap-1"
                                                    onclick="return confirm('{{ __('app.brand-page-index-confirm-alert') }}')">
                                                    <i class="bi bi-trash3"></i> {{ __('app.brand-page-index-delete-btn') }}
                                                </button>
                                            </form>
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