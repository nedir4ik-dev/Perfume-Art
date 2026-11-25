@extends('layouts.app')

@section('title', 'Edit Pages - Perfume Art Collection')

<style>
    /* Laraberg editoryny biziň gara dizaýnyňyza laýyklaşdyrmak */
    .laraberg-sidebar .components-panel__body {
        background: #252424 !important;
        color: #fff !important;
    }

    .editor-styles-wrapper {
        background-color: #1e1e1e !important;
        color: #fff !important;
    }

    .form-control:focus {
        border-color: #0dcaf0 !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 202, 240, 0.25) !important;
    }
</style>

@section('content')
<div class="admin-wrapper d-flex">
    {{-- Admin çep tarap menýu --}}
    @include('admin.partials.sidebar')

    {{-- Esasy Mazmun Meýdançasy --}}
    <div class="main-content flex-grow-1 min-vh-100"
        style="background-color: rgba(31, 30, 30, 0.51); backdrop-filter: blur(5px);">

        <div class="container-xl p-4 p-lg-5">
            <div class="card bg-transparent border-0">

                {{-- Ýokarky Başlyk --}}
                <div class="mb-4 mt-5 mt-xl-0">
                    <h4 class="text-white fw-bold mb-1">{{ __('app.cms-page-edit-title') }}</h4>
                    <p class="text-white-50 small mb-0">"{{ $page->title }}" {{ __('app.cms-page-edit-subtitle') }}</p>
                </div>

                {{-- Ýalňyşlyklar --}}
                @if($errors->any())
                <div class="alert alert-danger bg-danger bg-opacity-10 border-danger text-danger rounded-4 mb-4">
                    <ul class="mb-0 small">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Sahypa Täzeleme Formy (PUT Metody) --}}
                <form action="{{ route('admin.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data" id="page-form">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        {{-- Çep Tarap: Esasy Maglumatlar we Blok Editor --}}
                        <div class="col-xl-8">
                            <div class="p-4 rounded-4" style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.05);">

                                {{-- Sahypa Başlygy --}}
                                <div class="mb-4">
                                    <label class="form-label text-white-50 small text-uppercase fw-bold">{{ __('app.cms-page-edit-label-1') }}</label>
                                    <input type="text" name="title" class="form-control bg-dark border-secondary text-white rounded-3 py-2.5" value="{{ old('title', $page->title) }}" required>
                                </div>

                                {{-- Laraberg Görsel Blok Gurujy --}}
                                <div class="mb-3">
                                    <label class="form-label text-white-50 small text-uppercase fw-bold">{{ __('app.cms-page-edit-label-2') }}</label>
                                    {{-- Id hemişe "editor" galýar, Laraberg öňki mazmuny awtomatiki öwrüp açar --}}
                                    <textarea name="content" id="editor" hidden>{{ old('content', $page->content) }}</textarea>
                                </div>

                            </div>

                            {{-- SEO Sazlamalary Bölümi --}}
                            <div class="p-4 rounded-4 mt-4" style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.05);">
                                <h6 class="text-info fw-bold mb-3"><i class="bi bi-search me-2"></i>{{ __('app.cms-page-edit-seo-section') }}</h6>

                                <div class="mb-3">
                                    <label class="form-label text-white-50 small text-uppercase">{{ __('app.cms-page-edit-seo-section-label-1') }}</label>
                                    <input type="text" name="meta_title" class="form-control bg-dark border-secondary text-white rounded-3" value="{{ old('meta_title', $page->meta_title) }}">
                                </div>

                                <div>
                                    <label class="form-label text-white-50 small text-uppercase">{{ __('app.cms-page-edit-seo-section-label-2') }}</label>
                                    <textarea name="meta_description" class="form-control bg-dark border-secondary text-white rounded-3" rows="3">{{ old('meta_description', $page->meta_description) }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Sag Tarap: Sazlamalar --}}
                        <div class="col-xl-4">
                            <div class="p-4 rounded-4" style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.05);">

                                {{-- Sahypanyň Häzirki we Täze Suraty --}}
                                <div class="mb-4">
                                    <label class="form-label text-white-50 small text-uppercase fw-bold d-block">{{ __('app.cms-page-edit-photo-title') }}</label>

                                    @if($page->image)
                                    <div class="mb-3 position-relative">
                                        <p class="text-white-50 small mb-1">{{ __('app.cms-page-edit-current-photo') }}</p>
                                        <img src="{{ asset('storage/' . $page->image) }}" class="rounded-3 border border-white border-opacity-10 w-100" style="max-height: 160px; object-fit: cover;">
                                    </div>
                                    @endif

                                    <input type="file" name="image" class="form-control bg-dark border-secondary text-white rounded-3">
                                    <div class="form-text text-white-50 small mt-1">{{ __('app.cms-page-edit-photo-alert') }}</div>
                                </div>

                                {{-- Ýagdaýy --}}
                                <div class="mb-4">
                                    <label class="form-label text-white-50 small text-uppercase fw-bold d-block">{{ __('app.cms-page-edit-status-title') }}</label>
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input bg-secondary border-0" type="checkbox" name="is_active" id="isActiveSwitch" value="1" {{ $page->is_active ? 'checked' : '' }} style="cursor: pointer; width: 45px; height: 22px;">
                                        <label class="form-check-label text-white ms-2" for="isActiveSwitch" style="cursor: pointer;">{{ __('app.cms-page-edit-status-active') }}</label>
                                    </div>
                                </div>

                                <hr class="border-white border-opacity-10 my-4">

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-info rounded-pill fw-bold py-2.5">
                                        <i class="bi bi-arrow-clockwise me-2"></i>{{__('app.cms-page-edit-update-btn')}}
                                    </button>
                                    <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary rounded-pill fw-bold py-2.5 text-white">
                                        {{__('app.cms-page-edit-go-back-btn')}}
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof Laraberg !== 'undefined') {
            const initLaraberg = Laraberg.initialize || Laraberg.init;
            
            if (typeof initLaraberg === 'function') {
                initLaraberg('editor', {
                    sidebar: true,
                    laravelFilemanager: false
                });
                console.log("Laraberg Edit meýdançasynda kemsiz işe girizildi!");
            }
        } else {
            console.error("Laraberg tapylmady, master layout faýlyny barlaň.");
        }
    });
</script>
@endsection