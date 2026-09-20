@extends('layouts.app')

@section('title', $page->title)

@section('content')
<div class="container py-5 text-white" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            {{-- Sahypa Başlygy --}}
            <h1 class="fw-bold mb-4">{{ $page->title }}</h1>

            {{-- Ýüklenen Surat Bar Bolsa Görkezýäris --}}
            @if($page->image)
            <div class="mb-4 card border-0 p-2" style="background: rgba(31, 30, 30, 0.51); backdrop-filter: blur(3px); border: 1px solid rgba(255,255,255,0.08) !important;">
                <img src="{{ asset('storage/' . $page->image) }}" class="img-fluid rounded-3 w-100" alt="{{ $page->title }}">
            </div>
            @endif

            {{-- CKEditor-dan gelýän owadan HTML tekst mazmuny --}}
            <div class="page-content lh-lg opacity-75" style="font-size: 1rem;">
                {!! $page->content !!}
            </div>

        </div>
    </div>
</div>
@endsection