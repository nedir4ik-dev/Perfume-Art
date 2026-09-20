@extends('layouts.app')

@section('title', 'Admin Pages - Perfume Art Collection')

@section('content')
<div class="admin-wrapper d-flex">
    {{-- Admin çep tarap menýu --}}
    @include('admin.partials.sidebar')

    {{-- Esasy Mazmun Meýdançasy --}}
    <div class="main-content flex-grow-1 p-4 p-xl-5 min-vh-100"
        style="background-color: rgba(31, 30, 30, 0.51); backdrop-filter: blur(5px);">

        <div class="container-xl p-4 p-xl-5">
            <div class="card bg-transparent border-0">

                {{-- Ýokarky Başlyk we Täze Goş Düwmesi --}}
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 mt-4 gap-2">
                    <div>
                        <h1 class="text-white fw-bold mb-1">{{ __('app.cms-page-title') }}</h1>
                        <p class="text-white-50 small mb-0">{{ __('app.cms-page-subtitle') }}</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('admin.pages.create') }}" class="btn btn-info rounded-pill px-4 fw-bold">
                            <i class="bi bi-plus-lg me-2"></i>{{ __('app.cms-page-add-new-page-btn') }}
                        </a>
                        <div class="dropdown">
                            <button class="btn btn-outline-light dropdown-toggle border-0 px-3 py-2 rounded-pill shadow-xl d-flex align-items-center justify-content-center"
                                type="button" id="langDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                style="background: rgba(255,255,255,0.1); height: 42px; min-width: 95px; font-size: 13px;">
                                <i class="bi bi-translate me-2 text-info" style="font-size: 15px;"></i>
                                <span class="text-uppercase fw-bold">{{ app()->getLocale() }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 p-2" aria-labelledby="langDropdown" style="background: rgba(31, 30, 30, 0.51); backdrop-filter: blur(5px); border-radius: 15px; min-width: 140px; z-index: 9999;">
                                <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'tm') }}">🇹🇲 Turkmen</a></li>
                                <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'ru') }}">🇷🇺 Русский</a></li>
                                <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'en') }}">🇺🇸 English</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Sahypalar Jedweli --}}
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle border-secondary">
                        <thead class="text-secondary small text-uppercase">
                            <tr>
                                <th class="border-bottom border-secondary py-3" style="width: 15%">{{ __('app.cms-page-thead-1') }}</th>
                                <th class="border-bottom border-secondary py-3" style="width: 25%">{{ __('app.cms-page-thead-2') }}</th>
                                <th class="border-bottom border-secondary py-3" style="width: 30%">{{ __('app.cms-page-thead-3') }}</th>
                                <th class="border-bottom border-secondary py-3" style="width: 15%">{{ __('app.cms-page-thead-4') }}</th>
                                <th class="border-bottom border-secondary py-3 text-end" style="width: 15%">{{ __('app.cms-page-thead-5') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pages as $page)
                            <tr class="border-bottom border-white border-opacity-10">
                                <td class="py-3">
                                    @if($page->image)
                                    <img src="{{ asset('storage/' . $page->image) }}" class="rounded-3 border border-white border-opacity-10" style="width: 55px; height: 40px; object-fit: cover;">
                                    @else
                                    <span class="text-light small italic text-opacity-50">{{ __('app.cms-page-no-image') }}</span>
                                    @endif
                                </td>
                                <td class="py-3">
                                    <span class="text-white fw-bold">{{ $page->title }}</span>
                                </td>
                                <td class="py-3">
                                    <code class="bg-info bg-opacity-10 px-2 py-1 rounded" style="font-size: 0.85rem;"><a class="text-decoration-none text-info" href="/page/{{ $page->slug }}">/page/{{ $page->slug }}</a></code>
                                </td>
                                <td class="py-3">
                                    @if($page->is_active)
                                    <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success border-opacity-25 py-1.5 px-3">
                                        {{ __('app.cms-page-active') }}
                                    </span>
                                    @else
                                    <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 py-1.5 px-3">
                                        {{ __('app.cms-page-passive') }}
                                    </span>
                                    @endif
                                </td>
                                <td class="py-3 text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.pages.edit', $page->id) }}"
                                            class="btn btn-sm btn-outline-info px-2"
                                            title="Edit Page">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST"
                                            onsubmit="return confirm('{{ __('app.cms-page-sure-to-delete') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger px-2" title="Poz">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-white-50 italic">
                                    <i class="bi bi-folder-x display-6 d-block mb-2 text-secondary"></i>
                                    {{ __('app.cms-page-no-page') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection