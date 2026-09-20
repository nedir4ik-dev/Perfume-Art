@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="card p-4 shadow-lg border-0"
        style="width: 450px; background: rgba(31,30,30,0.6); backdrop-filter: blur(10px); color: white; border-radius: 20px;">

        <h3 class="text-center fw-bold mb-4">Täze parol döretmek</h3>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label class="form-label small opacity-75">Email salgyňyz</label>
                <input type="email" name="email" class="form-control bg-dark border-secondary text-white @error('email') is-invalid @enderror"
                    value="{{ $email ?? old('email') }}" required readonly>
                @error('email')
                <span class="invalid-feedback text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label small opacity-75">Täze parol</label>
                <input type="password" name="password" class="form-control bg-dark border-secondary text-white @error('password') is-invalid @enderror" required autofocus>
                @error('password')
                <span class="invalid-feedback text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label small opacity-75">Paroly tassyklaň</label>
                <input type="password" name="password_confirmation" class="form-control bg-dark border-secondary text-white" required>
            </div>

            <button type="submit" class="btn btn-light w-100 rounded-pill py-2 fw-bold text-dark">
                Paroly täzele
            </button>
        </form>
    </div>
</div>
@endsection