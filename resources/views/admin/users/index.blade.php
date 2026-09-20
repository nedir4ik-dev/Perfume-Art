@extends('layouts.app')

@section('title', 'Admin Users' . ' - Perfume Art Collection')

<style>
    .form-control:focus,
    .form-select:focus {
        border-color: #0dcaf0 !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 202, 240, 0.20) !important;
    }

    .dark-select option {
        background-color: #1e1e1e !important;
        color: #fff !important;
    }

    .modal-backdrop {
        background-color: #000000 !important;
        backdrop-filter: blur(8px) !important;
        -webkit-backdrop-filter: blur(8px) !important;
    }

    body.modal-open {
        overflow: hidden !important;
        padding-right: 0px !important;
    }

    .modal {
        background: rgba(0, 0, 0, 0.4);
    }

    /* Hover edilende bökmezlik üçin böküş we transformasiýa aýryldy */
    .table-row-no-jump {
        transition: background-color 0.15s ease-in-out;
    }

    /* Placeholder reňkini ak reňke öwürmek üçin browser prefiksleri */
    ::placeholder {
        color: #ffffffac !important;
        opacity: 1 !important;
    }

    ::-webkit-input-placeholder {
        color: #ffffffac !important;
        opacity: 1 !important;
    }

    :-ms-input-placeholder {
        color: #ffffffac !important;
        opacity: 1 !important;
    }

    ::-ms-input-placeholder {
        color: #ffffffac !important;
        opacity: 1 !important;
    }

    ::-moz-placeholder {
        color: #ffffffac !important;
        opacity: 1 !important;
    }

    :-moz-placeholder {
        color: #ffffffac !important;
        opacity: 1 !important;
    }

    .table-row-no-jump:hover {
        background-color: rgba(255, 255, 255, 0.03) !important;
    }

    @media (max-width: 576px) {
        .responsive-form-gap {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 6px !important;
        }

        .responsive-form-gap select {
            max-width: 100% !important;
            width: 100% !important;
        }
    }
</style>

@section('content')
<div class="admin-wrapper d-flex">
    @include('admin.partials.sidebar')

    <div class="main-content flex-grow-1 min-vh-100" style="background-color: rgba(31, 30, 30, 0.51); backdrop-filter: blur(5px);">
        <div class="container-xl p-5 mt-5">

            {{-- Üstünlik habary --}}
            @if(session('success'))
            <div class="alert alert-success bg-success bg-opacity-10 border-success text-success rounded-3 mb-4 p-3 d-flex align-items-center shadow-sm">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <span class="small fw-bold">{{ session('success') }}</span>
            </div>
            @endif

            {{-- Ýalňyşlyk habary --}}
            @if(session('error'))
            <div class="alert alert-danger bg-danger bg-opacity-10 border-danger text-danger rounded-4 mb-4 p-3 d-flex align-items-center shadow-sm">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <span class="small fw-bold">{{ session('error') }}</span>
            </div>
            @endif

            {{-- Sahypanyň Ýönekeý Başlygy (Card Dizaýnsyz) --}}
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4 pb-3 border-bottom border-white border-opacity-10">
                <div>
                    <h3 class="text-white fw-bold m-0 d-flex align-items-center">
                        {{ __('app.users-page-header-title') }}
                    </h3>
                    <p class="text-white-50 small mb-0 mt-1">{{ __('app.users-page-header-subtitle') }}</p>
                </div>

                <div class="d-flex align-items-center gap-2 w-100 w-sm-auto justify-content-end">
                    <button type="button" class="btn btn-info rounded-pill px-4 py-2 fw-bold shadow-sm small d-inline-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#createAdminModal" style="white-space: nowrap;">
                        <i class="bi bi-person-plus-fill me-2"></i> {{ __('app.users-page-add-admin-btn') }}
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
                            style="background: rgba(31, 30, 30, 0.95); backdrop-filter: blur(15px); border-radius: 15px; min-width: 140px; z-index: 9999;">
                            <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'tm') }}">🇹🇲 Turkmen</a></li>
                            <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'ru') }}">🇷🇺 Русский</a></li>
                            <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'en') }}">🇺🇸 English</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- SEARCH & FILTER BÖLEGI --}}
            <form action="{{ route('admin.users.index') }}" method="GET" class="row g-2 mb-4">
                <div class="col-12 col-md-6 col-lg-5">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control bg-transparent border-secondary text-white border-end-0" placeholder="Ady, email ýa-da username..." value="{{ request('search') }}" style="border-radius: 10px 0 0 10px;">
                        <span class="input-group-text bg-transparent border-secondary text-white-50 border-start-0" style="border-radius: 0 10px 10px 0;">
                            <i class="bi bi-search"></i>
                        </span>
                    </div>
                </div>

                <div class="col-12 col-md-4 col-lg-3">
                    <select name="role_id" class="form-select bg-transparent border-secondary text-white" style="border-radius: 10px;">
                        <option value="">Ähli rollar</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                            {{ $role->label }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-2 col-xl-2 d-flex gap-2">
                    <button type="submit" class="btn btn-info rounded-3 p-2 px-3 fw-bold" style="border-radius: 10px !important;">
                        <i class="bi bi-search"></i>
                    </button>
                    @if(request('search') || request('role_id'))
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary rounded-3 px-3" title="Süzgüçleri arassala" style="border-radius: 10px !important;">
                        <i class="bi bi-x-lg"></i>
                    </a>
                    @endif
                </div>
            </form>

            {{-- ADMIN TABLISASY (Card-syz, göni sahypanyň üstünde) --}}
            <div class="table-responsive">
                <table class="table table-dark align-middle border-0 m-0 bg-transparent" style="min-width: 600px;">
                    <thead>
                        <tr class="text-white-50 small text-uppercase border-bottom border-white border-opacity-10">
                            <th class="border-0 px-2 py-3">{{ __('app.users-page-table-user') }}</th>
                            <th class="border-0 px-2 py-3">{{ __('app.users-page-table-current-role') }}</th>
                            <th class="border-0 px-2 py-3">{{ __('app.users-page-table-change-role') }}</th>
                            <th class="border-0 text-end px-2 py-3">{{ __('app.users-page-table-actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr class="border-bottom border-white border-opacity-5 table-row-no-jump">
                            <td class="py-3 border-0 px-2">
                                <div class="d-flex align-items-center">
                                    <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold flex-shrink-0" style="width: 40px; height: 40px;">
                                        {{ mb_substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-white fw-bold small">{{ $user->name }}</div>
                                        <div class="text-white-50" style="font-size: 11px;">{{ $user->username }} @if($user->email) &bull; {{ $user->email }} @endif</div>
                                    </div>
                                </div>
                            </td>
                            <td class="border-0 px-2">
                                <span class="badge bg-info bg-opacity-10 text-info fw-normal p-2 px-3 rounded-pill small">
                                    {{ $user->role->label ?? __('app.users-page-no-role') }}
                                </span>
                            </td>
                            <td class="border-0 px-2">
                                <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST" class="d-flex align-items-center responsive-form-gap m-0">
                                    @csrf
                                    <select name="role_id" class="form-select form-select-sm bg-dark border-secondary text-white dark-select" style="border-radius: 8px; max-width: 180px; height: 34px;">
                                        @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                            {{ $role->label }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-info rounded-3 px-3 fw-bold ms-1" style="height: 34px;">{{ __('app.users-page-update-btn') }}</button>
                                </form>
                            </td>
                            <td class="border-0 text-end px-2">
                                <div class="d-flex justify-content-end gap-1">
                                    <button class="btn btn-sm btn-outline-info border-0 rounded-3 p-2" data-bs-toggle="modal" data-bs-target="#editAdminModal{{ $user->id }}" title="{{ __('app.users-page-btn-edit') }}">
                                        <i class="bi bi-pencil-square fs-6"></i>
                                    </button>

                                    @if(auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('{{ __('app.users-page-delete-confirm') }}')" class="m-0">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger border-0 rounded-3 p-2" title="{{ __('app.users-page-btn-delete') }}">
                                            <i class="bi bi-trash3 fs-6"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-white-50">
                                <i class="bi bi-people fs-2 d-block mb-2 text-info"></i>
                                Ulanyjy tapylmady.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

{{-- CREATE ADMIN MODAL --}}
<div class="modal fade" id="createAdminModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="background: rgba(30, 30, 30, 0.85); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border-radius: 24px; border: 1px solid rgba(255, 255, 255, 0.08);">
            <div class="modal-header border-white border-opacity-10 px-4">
                <h5 class="modal-title text-white fw-bold">
                    <i class="bi bi-person-plus text-info me-2"></i>{{ __('app.users-page-create-modal-title') }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4 text-white">
                    <div class="mb-3">
                        <label class="text-white-50 small fw-bold mb-2 text-uppercase">{{ __('app.users-page-create-modal-form-name') }}</label>
                        <input type="text" name="name" class="form-control bg-dark border-secondary text-white p-2" placeholder="Meselem: Aman Amanow" required style="border-radius: 12px;">
                    </div>
                    <div class="mb-3">
                        <label class="text-white-50 small fw-bold mb-2 text-uppercase">{{ __('app.users-page-create-modal-form-username') }}</label>
                        <input type="text" name="username" class="form-control bg-dark border-secondary text-white p-2" placeholder="username" required style="border-radius: 12px;">
                    </div>
                    <div class="mb-3">
                        <label class="text-white-50 small fw-bold mb-2 text-uppercase">{{ __('app.users-page-create-modal-form-email') }}</label>
                        <input type="email" name="email" class="form-control bg-dark border-secondary text-white p-2" placeholder="mysal@mail.com" style="border-radius: 12px;">
                    </div>
                    <div class="mb-3">
                        <label class="text-white-50 small fw-bold mb-2 text-uppercase">{{ __('app.users-page-create-modal-form-password') }}</label>
                        <input type="password" name="password" class="form-control bg-dark border-secondary text-white p-2" required style="border-radius: 12px;">
                    </div>
                    <div class="mb-3">
                        <label class="text-white-50 small fw-bold mb-2 text-uppercase">{{ __('app.users-page-create-modal-form-role') }}</label>
                        <select name="role_id" class="form-select bg-dark border-secondary text-white p-2 dark-select" required style="border-radius: 12px;">
                            <option value="" disabled selected class="text-white-50">{{ __('app.users-page-create-modal-form-role-select') }}</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-white border-opacity-10 px-4">
                    <button type="button" class="btn btn-link text-white-50 text-decoration-none fw-bold small" data-bs-dismiss="modal">
                        {{ __('app.users-page-btn-cancel') }}
                    </button>
                    <button type="submit" class="btn btn-info px-4 rounded-pill fw-bold shadow-sm">
                        {{ __('app.users-page-btn-create') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- EDIT MODALS FOR EACH USER --}}
@foreach($users as $user)
@include('admin.partials.edit_admin_modal', ['user' => $user, 'roles' => $roles])
@endforeach

@endsection