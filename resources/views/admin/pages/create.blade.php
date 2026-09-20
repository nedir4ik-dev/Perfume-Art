@extends('layouts.app')

@section('title', 'Create New Page - Perfume Art Collection')

<style>
    /* Laraberg editoryny siziň gara dizaýnyňyza laýyklaşdyrmak */
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
                    <h4 class="text-white fw-bold mb-1">{{__('app.cms-page-create-title')}}</h4>
                    <p class="text-white-50 small mb-0">{{__('app.cms-page-create-subtitle')}}</p>
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

                {{-- Sahypa Goşma Formasy --}}
                <form action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data" id="page-form">
                    @csrf

                    <div class="row g-4">
                        {{-- Çep Tarap: Esasy Maglumatlar we Blok Redaktory --}}
                        <div class="col-xl-8">
                            <div class="p-4 rounded-4" style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.05);">

                                {{-- Sahypa Başlygy --}}
                                <div class="mb-4">
                                    <label class="form-label text-white-50 small text-uppercase fw-bold">{{__('app.cms-page-create-label-1')}}</label>
                                    <input type="text" name="title" class="form-control bg-dark border-secondary text-white rounded-3 py-2.5" placeholder="Mysal üçin: Biz barada" value="{{ old('title') }}" required>
                                </div>

                                {{-- Keşpli Blok Gurujy --}}
                                <div class="mb-3">
                                    <label class="form-label text-white-50 small text-uppercase fw-bold">{{__('app.cms-page-create-label-2')}}</label>
                                    {{-- Hökman id="editor" bolmaly, Laraberg munuň içini keşpli gurşawa öwürer --}}
                                    <textarea name="content" id="editor" hidden>{{ old('content') }}</textarea>
                                </div>

                            </div>

                            {{-- SEO Sazlamalary Bölümi --}}
                            <div class="p-4 rounded-4 mt-4" style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.05);">
                                <h6 class="text-info fw-bold mb-3"><i class="bi bi-search me-2"></i>{{__('app.cms-page-create-seo-section')}}</h6>

                                <div class="mb-3">
                                    <label class="form-label text-white-50 small text-uppercase">{{__('app.cms-page-create-seo-section-label-1')}}</label>
                                    <input type="text" name="meta_title" class="form-control bg-dark border-secondary text-white rounded-3" placeholder="Google-da görünjek ady" value="{{ old('meta_title') }}">
                                </div>

                                <div>
                                    <label class="form-label text-white-50 small text-uppercase">{{__('app.cms-page-create-seo-section-label-2')}}</label>
                                    <textarea name="meta_description" class="form-control bg-dark border-secondary text-white rounded-3" rows="3" placeholder="Sahypa barada gysgajyk jemleýji sözler...">{{ old('meta_description') }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Sag Tarap: Sazlamalar --}}
                        <div class="col-xl-4">
                            <div class="p-4 rounded-4" style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.05);">

                                {{-- Sahypanyň Uly Suraty --}}
                                <div class="mb-4">
                                    <label class="form-label text-white-50 small text-uppercase fw-bold">{{__('app.cms-page-create-photo-title')}}</label>
                                    <input type="file" name="image" class="form-control bg-dark border-secondary text-white rounded-3">
                                </div>

                                {{-- Ýagdaýy --}}
                                <div class="mb-4">
                                    <label class="form-label text-white-50 small text-uppercase fw-bold d-block">{{__('app.cms-page-create-status-title')}}</label>
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input bg-success border-0" type="checkbox" name="is_active" id="isActiveSwitch" value="1" checked style="cursor: pointer; width: 45px; height: 22px;">
                                        <label class="form-check-label text-white ms-2" for="isActiveSwitch" style="cursor: pointer;">{{__('app.cms-page-create-status-active')}}</label>
                                    </div>
                                </div>

                                <hr class="border-white border-opacity-10 my-4">

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-info rounded-pill fw-bold py-2.5">
                                        <i class="bi bi-check-lg me-2"></i>{{__('app.cms-page-create-create-btn')}}
                                    </button>
                                    <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary rounded-pill fw-bold py-2.5 text-white">
                                        {{__('app.cms-page-create-go-back-btn')}}
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
        // Laraberg obýektiniň barlygyny barlaýarys
        if (typeof Laraberg !== 'undefined') {

            // Täze wersiýalarda init ýa-da initialize funksiýasyny awtomatiki saýlaýar
            const initLaraberg = Laraberg.initialize || Laraberg.init;

            if (typeof initLaraberg === 'function') {
                initLaraberg('editor', {
                    sidebar: true,
                    laravelFilemanager: false // Häzirlikçe munuň ýalňyşlyk bermezligi üçin false edeliň
                });
                console.log("Laraberg kemsiz işe girizildi!");
            } else {
                // Eger obýekt bar bolup, initialize funksiýasy başgaça bolsa, bütin obýekti konsola çykaralyň
                console.error("Laraberg bar, ýöne init funksiýasy tapylmady. Obýektiň wezipeleri:", Laraberg);
            }

        } else {
            console.error("Laraberg JS faýly sahypa düýbünden ýüklenmändir! layouts/app.blade.php faýlyny barlaň.");
        }
    });
</script>
@endsection