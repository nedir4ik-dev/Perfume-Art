@extends('layouts.app')

@section('title', 'Admin Popups - Perfume Art Collection')

@section('content')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(10px);
        border-radius: 25px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        transition: all 0.3s ease;
    }

    .glass-card:hover {
        border-color: rgba(13, 202, 240, 0.3);
    }

    .nav-tabs-premium {
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    .nav-tabs-premium .nav-link {
        color: rgba(255, 255, 255, 0.5) !important;
        border: none !important;
        border-bottom: 2px solid transparent !important;
        font-weight: 600;
        padding: 8px 16px !important;
        font-size: 13px;
    }

    .nav-tabs-premium .nav-link.active {
        background: transparent !important;
        color: #0dcaf0 !important;
        border-bottom: 2px solid #0dcaf0 !important;
    }

    .popup-preview-img {
        max-width: 70px;
        border-radius: 10px;
        object-fit: cover;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
</style>

<div class="admin-wrapper d-flex">
    @include('admin.partials.sidebar')

    <div class="main-content flex-grow-1" style="background-color: rgba(31,30,30,0.51); backdrop-filter: blur(5px); min-height: 100vh;">

        <div class="pt-5 px-xl-5 px-3">
            <div class="d-flex justify-content-between align-items-center pt-5">
                <div>
                    <h2 class="text-white fw-bold">{{__('app.popup-page-title')}}</h2>
                    <p class="text-white-50 small mb-0">{{__('app.popup-page-paragraph')}}</p>
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

        <div class="container-xl p-3 p-md-5 pt-4">
            @if(session('success'))
            <div class="alert alert-success bg-success bg-opacity-10 text-success border-success border-opacity-25 rounded-4 mb-4">
                {{ session('success') }}
            </div>
            @endif

            <div class="row g-4">
                {{-- TÄZE POPUP GOŞMAK --}}
                <div class="col-xl-5">
                    <div class="glass-card p-4 shadow-lg">
                        <h5 class="text-white mb-4 fw-bold">{{__('app.popup-page-add-popup-title')}}</h5>
                        <form action="{{ route('admin.popups.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- DIL TABS --}}
                            <ul class="nav nav-tabs nav-tabs-premium mb-3" id="popupTabs" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link active" id="popup-tm-tab" data-bs-toggle="tab" data-bs-target="#p-lang-tm" type="button">🇹🇲 TM</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="popup-ru-tab" data-bs-toggle="tab" data-bs-target="#p-lang-ru" type="button">🇷🇺 RU</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="popup-en-tab" data-bs-toggle="tab" data-bs-target="#p-lang-en" type="button">🇺🇸 EN</button>
                                </li>
                            </ul>

                            {{-- TABS MEÝDANÇALARY --}}
                            <div class="tab-content mb-3" id="popupTabsContent">
                                {{-- Turkmen --}}
                                <div class="tab-pane fade show active" id="p-lang-tm">
                                    <div class="mb-3">
                                        <label class="form-label text-white-50 small fw-bold">Sözbaşy (TM)</label>
                                        <input type="text" name="title_tm" class="form-control text-white bg-dark bg-opacity-50 border-secondary py-2 rounded-3" placeholder="Mysal: Uly Arzanladyş!">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-white-50 small fw-bold">Düşündiriş (TM)</label>
                                        <textarea name="description_tm" rows="3" class="form-control text-white bg-dark bg-opacity-50 border-secondary rounded-3" placeholder="Popup içindäki esasy tekst..."></textarea>
                                    </div>
                                </div>
                                {{-- Russian --}}
                                <div class="tab-pane fade" id="p-lang-ru">
                                    <div class="mb-3">
                                        <label class="form-label text-white-50 small fw-bold">Заголовок (RU)</label>
                                        <input type="text" name="title_ru" class="form-control text-white bg-dark bg-opacity-50 border-secondary py-2 rounded-3" placeholder="Пример: Мега Скидки!">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-white-50 small fw-bold">Описание (RU)</label>
                                        <textarea name="description_ru" rows="3" class="form-control text-white bg-dark bg-opacity-50 border-secondary rounded-3" placeholder="Основной текст по-русски..."></textarea>
                                    </div>
                                </div>
                                {{-- English --}}
                                <div class="tab-pane fade" id="p-lang-en">
                                    <div class="mb-3">
                                        <label class="form-label text-white-50 small fw-bold">Title (EN)</label>
                                        <input type="text" name="title_en" class="form-control text-white bg-dark bg-opacity-50 border-secondary py-2 rounded-3" placeholder="Example: Big Sale!">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-white-50 small fw-bold">Description (EN)</label>
                                        <textarea name="description_en" rows="3" class="form-control text-white bg-dark bg-opacity-50 border-secondary rounded-3" placeholder="Main description in English..."></textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- TEHNIKI SAZLAMALAR --}}
                            <div class="mb-3">
                                <label class="form-label text-capitalize text-white-50 small fw-bold">{{__('app.popup-page-add-popup-image-label')}} <span class="text-danger">*</span></label>
                                <input type="file" name="image" class="form-control bg-dark border-secondary text-white-50 rounded-3" required>
                                <div class="form-text text-white-50 small">{{ __('app.popup-page-add-popup-image-alert') }}</div>
                            </div>

                            <div class="row">
                                <div class="col-8 mb-3">
                                    <label class="form-label text-capitalize text-white-50 small fw-bold">{{__('app.popup-page-add-popup-link-label')}}</label>
                                    <input type="url" name="link" class="form-control text-white bg-dark bg-opacity-50 border-secondary rounded-3" placeholder="https://perfume-art.com/product/1">
                                </div>
                                <div class="col-4 mb-3">
                                    <label class="form-label text-capitalize text-white-50 small fw-bold">{{__('app.popup-page-add-popup-time-label')}}</label>
                                    <input type="number" name="seconds" value="15" min="1" max="30" class="form-control text-white bg-dark bg-opacity-50 border-secondary rounded-3" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-info w-100 fw-bold text-capitalize py-3 rounded-pill mt-3 shadow-sm text-uppercase">
                                <i class="bi bi-plus-lg me-2"></i>{{__('app.popup-page-add-popup-btn')}}
                            </button>
                        </form>
                    </div>
                </div>

                {{-- SANAW TABLISASY --}}
                <div class="col-xl-7">
                    <div class="glass-card p-4 shadow-lg h-100">
                        <h5 class="text-white mb-4 fw-bold">{{__('app.popup-page-created-popups-title')}}</h5>
                        <div class="table-responsive">
                            <table class="table table-dark table-hover align-middle border-0">
                                <thead class="text-white-50 small">
                                    <tr>
                                        <th>{{__('app.popup-page-created-popups-thead-1')}}</th>
                                        <th>{{__('app.popup-page-created-popups-thead-2')}}</th>
                                        <th>{{__('app.popup-page-created-popups-thead-3')}}</th>
                                        <th>{{__('app.popup-page-created-popups-thead-4')}}</th>
                                        <th class="text-end">{{__('app.popup-page-created-popups-thead-5')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($popups as $popup)
                                    <tr style="background: rgba(255,255,255,0.01);">
                                        <td>
                                            <img src="{{ asset('storage/' . $popup->image) }}" class="popup-preview-img" alt="Popup">
                                        </td>
                                        <td class="text-white fw-medium">
                                            {{ Str::limit($popup->title_tm ?? 'Sözbaşysyz Popup', 30) }}
                                        </td>
                                        <td class="text-info fw-bold">{{ $popup->seconds }} sek</td>
                                        <td>
                                            {{-- STATUS TOGGLE BUTTON --}}
                                            <form action="{{ route('admin.popups.toggle', $popup->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm rounded-pill px-2 fw-bold {{ $popup->is_active ? 'btn-outline-success' : 'btn-outline-secondary' }}">
                                                    {{ $popup->is_active ? 'Aktiw' : 'Passiw' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-end">
                                            <form action="{{ route('admin.popups.destroy', $popup->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger btn-sm rounded-pill px-3" onclick="return confirm('Do you want to delete this popup?')">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-white-50">{{__('app.popup-page-no-created-popup')}}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection