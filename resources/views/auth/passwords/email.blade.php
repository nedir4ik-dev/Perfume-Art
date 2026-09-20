@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="card p-4 shadow-lg border-0"
        style="width: 450px; background: rgba(31,30,30,0.6); backdrop-filter: blur(10px); color: white; border-radius: 20px;">

        <h3 class="text-center fw-bold mb-3">Paroly dikeltmek</h3>
        <p class="text-center small text-white-50 mb-4">Email salgyňyzy ýazyň, biz size paroly üýtgetmek üçin link ugradarys.</p>

        @if (session('status'))
        <div class="alert alert-success border-0 small text-center" style="background: rgba(40, 167, 69, 0.2); color: #2ecc71;">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-4">
                <label class="form-label small opacity-75">E-mail salgyňyz</label>
                {{-- Type 'email' bolmaly, name 'email' bolmaly --}}
                <input type="email" name="email" class="form-control bg-dark border-secondary text-white @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" required autofocus placeholder="mysal@mail.com">

                @error('email')
                <span class="invalid-feedback" role="alert" style="display: block;">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-outline-light w-100 rounded-pill py-2 fw-bold">
                Kod ugrat
            </button>
        </form>
    </div>
</div>
@endsection