@extends('layouts.app')

@section('title', 'Login' . '- Perfume Art')

@section('content')
<div class="container-xl">
    {{-- Language Selector şol durşuna galýar --}}
    <div class="d-flex justify-content-end pt-5">
        {{-- ... seniň dropdown kodyň ... --}}
    </div>
</div>

<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="card p-4 shadow-lg border-0"
        style="width: 400px; background: rgba(31,30,30,0.6); backdrop-filter: blur(10px); color: white;">
        <h3 class="text-center fw-bold mb-4">{{__('app.login-page-title')}}</h3>

        <form action="{{ route('login') }}" method="POST" id="loginForm">
            @csrf

            {{-- Honeypot --}}
            <div style="display: none;">
                <input type="text" name="honeypot" value="">
            </div>

            <div class="mb-3">
                <label class="form-label">{{__('app.login-page-input-name-subtitle')}}</label>
                <input type="text" name="username" class="form-control bg-dark border-secondary text-white"
                    required autofocus>
            </div>
            <div class="mb-4">
                <label class="form-label">{{__('app.login-page-input-password-subtitle')}}</label>
                <input type="password" name="password" class="form-control bg-dark border-secondary text-white" required>

                <div class="text-end mt-2">
                    <a href="{{ route('password.request') }}" class="text-info small text-decoration-none opacity-75">
                        {{ __('app.login-page-forgot-password-link') ?? 'Paroly unutdyňyzmy?' }}
                    </a>
                </div>
            </div>

            @if($errors->any())
            <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger rounded-4 mb-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $errors->first() }}
            </div>
            @endif

            {{-- Hidden Input for reCAPTCHA --}}
            <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

            <button type="submit" class="btn my-2 btn-outline-light w-100 rounded-pill" id="submitBtn">
                {{__('app.login-page-login-btn')}}
            </button>

            <a href="{{ route('home') }}" class="btn btn-outline-light w-100 rounded-pill mt-2">
                <i class="bi bi-house-door-fill"></i> Go to Home Page
            </a>
        </form>
    </div>
</div>
@endsection

@section('scripts')
{{-- API Key-ni dogry almak üçin config-den ýa-da env-den çekýäris --}}
<script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>
<script>
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const btn = document.getElementById('submitBtn');

        // Düwmäni bloklaýarys, gaýta-gaýta basmazlygy üçin
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Garaşyň...';

        grecaptcha.ready(function() {
            grecaptcha.execute("{{ env('RECAPTCHA_SITE_KEY') }}", {
                action: 'login'
            }).then(function(token) {
                if (token) {
                    document.getElementById('g-recaptcha-response').value = token;
                    form.submit();
                } else {
                    alert('Captcha ýüklenmedi. Sahypany täzeläp görüň.');
                    btn.disabled = false;
                    btn.innerHTML = "{{__('app.login-page-login-btn')}}";
                }
            });
        });
    });
</script>
@endsection