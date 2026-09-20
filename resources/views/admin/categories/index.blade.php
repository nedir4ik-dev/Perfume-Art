@extends('layouts.app')

@section('title', 'Admin Categories - Perfume Art Collection')

@section('content')
<div class="admin-wrapper d-flex">
    @include('admin.partials.sidebar')

    <div class="main-content flex-grow-1 p-4 p-xl-5 min-vh-100"
        style="background-color: rgba(31, 30, 30, 0.51); backdrop-filter: blur(5px); min-height: 100vh; overflow-x: hidden;">

        <div class="d-flex justify-content-between align-items-center mt-5 p-3 p-md-4 pt-5 pb-0 flex-wrap gap-3">
            <div class="flex-grow-1">
                <h1 class="text-white fw-bold mb-1">{{__('app.category-page-index-title')}}</h1>
                <p class="text-white-50 small mb-0">{{__('app.category-page-index-subtitle')}}</p>
            </div>

            <div class="d-flex align-items-center gap-1">
                <a href="{{ route('admin.categories.create') }}"
                    class="btn btn-info rounded-pill px-4 py-2 shadow-xl fw-bold transition-all">
                    <i class="bi bi-plus-circle-fill me-1"></i> {{__('app.category-page-index-add-category-btn')}}
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

        <div class="container-xl p-3 p-md-5 pt-3">

            <div class="glass-card rounded-4 border-0 shadow-lg overflow-hidden"
                style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05) !important;">
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0">
                        <thead style="background: rgba(255,255,255,0.02);">
                            <tr class="text-white-50 small" style="font-size: 11px;">
                                <th class="ps-4 py-3 border-0 text-uppercase fw-bold">ID</th>
                                <th class="py-3 border-0 text-uppercase fw-bold">{{__('app.category-page-index-table-head-1')}}</th>
                                <th class="py-3 border-0 text-uppercase fw-bold d-none d-md-table-cell">{{__('app.category-page-index-table-head-2')}}</th>
                                <th class="pe-4 py-3 border-0 text-end text-uppercase fw-bold">{{__('app.category-page-index-table-head-3')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $cat)
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                <td class="ps-4 py-3 border-0 text-white-50 small">#{{ $cat->id }}</td>
                                <td class="py-3 border-0">
                                    <div class="text-white fw-bold">{{ $cat->name }}</div>
                                    <div class="d-md-none text-info mt-1" style="font-size: 10px;">{{ $cat->slug }}</div>
                                </td>
                                <td class="py-3 border-0 d-none d-md-table-cell">
                                    <code class="text-info small bg-info bg-opacity-10 px-2 py-1 rounded">{{ $cat->slug }}</code>
                                </td>
                                <td class="pe-4 py-3 border-0 text-end">
                                    <div class="d-flex justify-content-end gap-2 flex-nowrap">
                                        <a href="{{ route('admin.categories.edit', $cat->id) }}"
                                            class="btn btn-sm btn-outline-warning rounded-pill px-2 px-md-3 transition-all"
                                            title="Edit">
                                            <i class="bi bi-pencil-square"></i> <span class="d-none d-md-inline">{{__('app.category-page-index-edit-btn')}}</span>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf @method('DELETE')
                                            <button
                                                class="btn btn-sm btn-outline-danger rounded-pill px-2 px-md-3 transition-all"
                                                onclick="return confirm('Are you sure?')">
                                                <i class="bi bi-trash3"></i> <span class="d-none d-md-inline">{{__('app.category-page-index-delete-btn')}}</span>
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