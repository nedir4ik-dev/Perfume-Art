@extends('layouts.app')

<style>
    .badge-sale {
        background: linear-gradient(45deg, #ff47568f, #ff6b8180) !important;
        color: white !important;
        padding: 5px 12px;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 800;
        box-shadow: 0 4px 15px rgba(255, 71, 86, 0.6);
        z-index: 50;
    }

    .product-fade-out {
        transition: all 0.5s ease;
        transform: scale(0.8);
        opacity: 0;
    }

    .custom-filter-input::placeholder {
        color: #6c757d !important;
        opacity: 1;
    }

    .custom-filter-input option {
        background-color: rgb(31, 30, 30, 0.95) !important;
        color: #ffffff !important;
    }
</style>

@section('title', 'Admin Products - Perfume Art Collection')

@section('content')
<div class="admin-wrapper d-flex">
    @include('admin.partials.sidebar')

    <div class="main-content flex-grow-1"
        style="min-height: 100vh; background-color: rgba(31, 30, 30, 0.51); backdrop-filter: blur(5px);">

        <div class="container-xl p-5 pt-4">
            <div class="d-flex justify-content-between align-items-center mb-4 pt-5">
                <h2 class="text-white fw-bold display-6 mb-0 d-flex align-items-center gap-2">
                    {{__('app.product-page-index-title')}} 
                    <span class="d-none d-xl-inline"><i class="bi bi-shop h3 text-info"></i></span>
                    <span class="badge bg-dark text-secondary fs-6 rounded-pill px-3 py-2 ms-2">
                        {{ $products->total() }}
                    </span>
                </h2>

                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.products.create') }}"
                        class="btn btn-info rounded-4 px-xl-4 py-xl-3 py-2 px-3 fw-bold shadow-lg border-0 transition-all hover-lift d-flex align-items-center justify-content-center"
                        style="height: 42px;">
                        <i class="bi bi-plus-lg me-xl-2 d-block d-xl-none"></i>
                        <span class="d-none d-xl-block">{{__('app.admin-page-add-new-perfume-btn')}}</span>
                    </a>

                    <a href="{{ route('admin.products.trash') }}"
                        class="btn btn-outline-danger rounded-4 d-flex align-items-center justify-content-center transition-all hover-lift shadow-lg"
                        style="width: 42px; height: 42px; background: rgba(220, 53, 69, 0.1); border: 1px solid rgba(220, 53, 69, 0.3);" title="Trash Page">
                        <i class="bi bi-trash-fill" style="font-size: 16px;"></i>
                    </a>

                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle border-0 px-3 py-2 rounded-pill shadow-xl d-flex align-items-center justify-content-center"
                            type="button" id="langDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                            style="background: rgba(255,255,255,0.1); height: 42px; min-width: 95px; font-size: 13px;">
                            <i class="bi bi-translate me-2 text-info" style="font-size: 15px;"></i>
                            <span class="text-uppercase fw-bold">{{ app()->getLocale() }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 p-1"
                            aria-labelledby="langDropdown"
                            style="background: rgba(31, 30, 30, 0.85); backdrop-filter: blur(10px); border-radius: 15px; min-width: 140px; z-index: 9999;">
                            <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'tm') }}">🇹🇲 Turkmen</a></li>
                            <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'ru') }}">🇷🇺 Русский</a></li>
                            <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'en') }}">🇺🇸 English</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="glass-card p-4 rounded-4 mb-4"
                style="background: rgba(93, 91, 91, 0.19); border: 1px solid rgba(255,255,255,0.08);">
                <form action="{{ route('admin.products.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="text-white-50 small mb-2">{{__('app.product-page-index-filter-label-1')}}</label>
                        <input type="text" name="search"
                            class="form-control bg-transparent text-white border border-secondary rounded-3 shadow-none custom-filter-input"
                            placeholder="{{__('app.product-page-index-filter-label-1-input')}}"
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="text-white-50 small mb-2">{{__('app.product-page-index-filter-label-2')}}</label>
                        <select name="category_id" class="form-select bg-transparent text-white border border-secondary rounded-3 shadow-none custom-filter-input">
                            <option value="">{{__('app.product-page-index-filter-label-2-option')}}</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="text-white-50 small mb-2">{{__('app.product-page-index-filter-label-3')}}</label>
                        <input type="number" name="min_price"
                            class="form-control bg-transparent text-white border border-secondary rounded-3 shadow-none custom-filter-input"
                            placeholder="0 - ∞" value="{{ request('min_price') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="text-white-50 small mb-2">{{__('app.product-page-index-filter-label-4')}}</label>
                        <input type="number" name="max_price"
                            class="form-control bg-transparent text-white border border-secondary rounded-3 shadow-none custom-filter-input"
                            placeholder="0 - ∞" value="{{ request('max_price') }}">
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-info w-100 rounded-3 text-dark fw-bold">{{__('app.product-page-index-filter-filter-btn')}}</button>
                        <a href="{{ route('admin.products.index') }}"
                            class="btn btn-outline-danger w-100 rounded-3 text-white">{{__('app.product-page-index-filter-reset-btn')}}</a>
                    </div>
                </form>
            </div>

            @if(request()->hasAny(['search', 'category_id', 'min_price', 'max_price']) && (request('search') || request('category_id') || request('min_price') || request('max_price')))
                <div class="mb-4 text-white-50 d-flex justify-content-end align-items-center gap-2">
                    <i class="bi bi-funnel text-info"></i>
                    <span>Jemi tapylan: <b class="text-white">{{ $products->total() }}</b></span>
                </div>
            @endif

            <div class="row g-4">
                @forelse($products as $product)
                <div class="col-xl-4 col-lg-12 col-md-6" id="product-card-{{ $product->id }}">
                    <div class="card h-100 border-0 shadow-sm overflow-hidden text-white"
                        style="background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.08) !important; border-radius: 28px;">

                        <div class="position-relative p-3">
                            <div class="rounded-4 overflow-hidden" style="height: 220px;">
                                <img src="{{ asset('storage/' . $product->image) }}"
                                    class="w-100 h-100 object-fit-cover transition-all img-hover"
                                    alt="{{ $product->name }}">
                            </div>
                            <span
                                class="position-absolute top-4 start-4 badge text-dark rounded-pill px-3 py-2 fw-bold shadow-sm"
                                style="top: 25px; left: 25px; background: rgba(255, 255, 255, 0.26); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.08) !important; border-radius: 28px;">
                                {{ $product->ml_size }} ml
                            </span>
                            @if($product->discount_percent > 0)
                            <div class="position-absolute top-0 end-0 mt-4 me-4 z-index-99">
                                <div class="badge-sale rounded-5">-{{ $product->discount_percent }}%</div>
                            </div>
                            @endif
                        </div>

                        <div class="card-body pt-0 px-4 pb-4">
                            <h5 class="fw-bold mb-1 text-truncate text-white">{{ $product->name }}</h5>
                            <p class="text-white-50 small mb-3" style="display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ Str::limit($product->description, 65) }}
                            </p>

                            <div class="d-flex align-items-center justify-content-between mt-auto">
                                <div class="fs-5 fw-bold text-success">
                                    {{ number_format($product->price, 2) }}$
                                </div>

                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                        class="btn btn-outline-info btn-sm rounded-3 d-flex align-items-center justify-content-center"
                                        style="width: 38px; height: 38px; background: rgba(13, 202, 240, 0.1);">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <button type="button"
                                        class="btn btn-outline-danger btn-sm rounded-3 d-flex align-items-center justify-content-center delete-product-btn"
                                        data-id="{{ $product->id }}"
                                        data-url="{{ route('admin.products.destroy', $product->id) }}"
                                        style="width: 38px; height: 38px; background: rgba(220, 53, 69, 0.1);">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <div class="glass-card p-5 rounded-5" style="background: rgba(255,255,255,0.03);">
                        <i class="bi bi-box2-heart display-1 text-white-50"></i>
                        <h3 class="text-white mt-4">Haryt tapylmady</h3>
                        <p class="text-white-50">Gözlegiňize gabat gelýän atyr tapylmady.</p>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.body.addEventListener('click', function(e) {
            let button = e.target.closest('.delete-product-btn');

            if (button) {
                e.preventDefault();

                let productId = button.getAttribute('data-id');
                let deleteUrl = button.getAttribute('data-url');

                Swal.fire({
                    title: 'Pozmalymy?',
                    text: "Bu atyr öçürilip, zibil gutusyna taşlanar!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0dcaf0',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: 'Hawa, poz!',
                    cancelButtonText: 'Ýatyr',
                    background: 'rgba(31, 30, 30, 0.86)',
                    color: '#fff'
                }).then((result) => {
                    if (result.isConfirmed) {

                        fetch(deleteUrl, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    _method: 'DELETE'
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        title: 'Pozuldy!',
                                        text: data.message,
                                        icon: 'success',
                                        background: 'rgba(31, 30, 30, 0.86)',
                                        color: '#fff'
                                    });

                                    let targetCard = document.getElementById(`product-card-${productId}`);
                                    if (targetCard) {
                                        targetCard.classList.add('product-fade-out');
                                        setTimeout(() => {
                                            targetCard.remove();
                                        }, 500);
                                    }
                                }
                            })
                            .catch(error => {
                                Swal.fire({
                                    title: 'Şowsuz boldy!',
                                    text: 'Näsazlyk ýüze çykdy.',
                                    icon: 'error',
                                    background: 'rgba(31, 30, 30, 0.86)',
                                    color: '#fff'
                                });
                            });

                    }
                });
            }
        });
    });
</script>
@endsection