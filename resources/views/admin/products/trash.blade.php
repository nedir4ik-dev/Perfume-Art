@extends('layouts.app')

<style>
    /* Zibil gutusyna mahsus dynamic animasiýalar we reňk sazlamalary */
    .trash-card {
        transition: all 0.3s ease;
        opacity: 0.85;
    }

    .trash-card:hover {
        opacity: 1;
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(220, 53, 69, 0.2) !important;
    }
</style>

@section('title', 'Zibil Gutusy - Perfume Art Collection')

@section('content')
<div class="admin-wrapper d-flex">
    @include('admin.partials.sidebar')

    <div class="main-content flex-grow-1"
        style="min-height: 100vh; background-color: rgba(31, 30, 30, 0.51); backdrop-filter: blur(5px);">

        <div class="container-xl p-5">

            <div class="d-flex justify-content-between align-items-center mb-4 pt-5">
                <h2 class="text-white fw-bold mb-0">Zibil Gutusy <span><i class="bi bi-trash3 text-danger"></i></span></h2>
                <a href="{{ route('admin.products.index') }}"
                    class="btn btn-outline-light rounded-4 px-3 py-2 fw-bold shadow-sm transition-all hover-lift">
                    <i class="bi bi-arrow-left"></i>
                </a>
            </div>

            @if($errors->any())
            <div class="alert alert-danger bg-danger bg-opacity-10 border-danger text-danger rounded-4 p-3 mb-4 d-flex align-items-start gap-2">
                <i class="bi bi-exclamation-triangle-fill mt-1"></i>
                <ul class="mb-0 small ps-2">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(session('success'))
            <div class="alert alert-success border-0 bg-success bg-opacity-25 text-success rounded-4 p-3 mb-4 d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            </div>
            @endif

            <div class="row g-4">
                @forelse($products as $product)
                <div class="col-xl-4 col-lg-12 col-md-6">
                    <div class="card h-100 border-0 shadow-sm overflow-hidden text-white trash-card"
                        style="background: rgba(255, 255, 255, 0.02); backdrop-filter: blur(15px); border: 1px solid rgba(220, 53, 69, 0.15) !important; border-radius: 28px;">

                        <div class="position-relative p-3">
                            <div class="rounded-4 overflow-hidden" style="height: 220px; filter: grayscale(40%);">
                                <img src="{{ asset('storage/' . $product->image) }}"
                                    class="w-100 h-100 object-fit-cover"
                                    alt="{{ $product->name }}">
                            </div>
                            <span class="position-absolute top-4 start-4 badge text-white rounded-pill px-3 py-2 fw-bold shadow-sm"
                                style="top: 25px; left: 25px; background: rgba(220, 53, 69, 0.25); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.08); border-radius: 28px;">
                                Pozulan güni: {{ $product->deleted_at->format('d.m.Y H:i') }}
                            </span>
                        </div>

                        <div class="card-body pt-0 px-4 pb-4 d-flex flex-column">
                            <h5 class="fw-bold mb-1 text-truncate text-white-50">{{ $product->name }}</h5>
                            <p class="text-muted small mb-3" style="display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ Str::limit($product->description, 65) }}
                            </p>

                            <div class="d-flex align-items-center justify-content-between mt-auto">
                                <div class="fs-5 fw-bold text-secondary">
                                    {{ number_format($product->price, 2) }}$
                                </div>

                                <div class="d-flex gap-2">
                                    <form action="{{ route('admin.products.restore', $product->id) }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-outline-success btn-sm rounded-3 d-flex align-items-center justify-content-center"
                                            title="Dükana yzyna getir"
                                            style="width: 38px; height: 38px; background: rgba(40, 167, 69, 0.1);">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.products.forceDelete', $product->id) }}"
                                        method="POST"
                                        class="m-0"
                                        onsubmit="return confirm('ÜNS BERIŇ! Bu atyr maglumat bazasyndan hemişelik öçüriler we yzyna getirip bolmaz. Dowam etmek isleýärsiňizmi?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-outline-danger btn-sm rounded-3 d-flex align-items-center justify-content-center"
                                            title="Hemişelik poz"
                                            style="width: 38px; height: 38px; background: rgba(220, 53, 69, 0.1);">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <div class="glass-card p-5 rounded-5" style="background: rgba(255,255,255,0.03);">
                        <i class="bi bi-trash text-white-50 display-1"></i>
                        <h3 class="text-white mt-4">Zibil gutusy boş</h3>
                        <p class="text-white-50">Bu ýerde öçürilen haryt ýok.</p>
                    </div>
                </div>
                @endforelse
            </div>

            <div class="mt-5 d-flex justify-content-center custom-pagination">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection