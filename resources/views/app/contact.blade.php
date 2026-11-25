@extends('layouts.app')

@section('content')
<style>
    /* Iframe kartasynyň owadan we doly sypar ýaly dizaýny */
    .map-wrapper iframe {
        width: 100% !important;
        height: 400px !important;
        border: 0 !important;
        border-radius: 20px;
        filter: grayscale(20%) contrast(100%);
    }

    /* Liquid Glass Working Hours Accordion Styling */
    .working-hours-toggler {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        color: #fff;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .working-hours-toggler:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.25);
    }

    .working-hours-list {
        background: rgba(83, 82, 82, 0.36);
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(5px);
        border-radius: 24px;
    }

    .working-day-item {
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        padding: 8px 12px;
        font-size: 0.88rem;
    }

    .working-day-item:last-child {
        border-bottom: none;
    }

    .working-day-item.today {
        background: rgba(13, 240, 21, 0.15);
        border-radius: 8px;
        color: #198754;
        font-weight: 600;
    }
</style>

<div class="container mt-4">
    <div class="d-flex justify-content-end mb-4">
        <div class="dropdown">
            <button class="btn btn-outline-light dropdown-toggle border-0 px-3 py-2 rounded-pill shadow-xl d-flex align-items-center justify-content-center"
                type="button" id="langDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                style="background: rgba(66, 65, 65, 0.57); height: 42px; min-width: 95px; font-size: 13px;">
                <i class="bi bi-translate me-2 text-info" style="font-size: 15px;"></i>
                <span class="text-uppercase fw-bold">{{ app()->getLocale() }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 p-2"
                aria-labelledby="langDropdown"
                style="background: rgba(31, 30, 30, 0.51); backdrop-filter: blur(5px); border-radius: 15px; min-width: 140px; z-index: 1000;">
                <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'tm') }}">🇹🇲 Turkmen</a></li>
                <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'ru') }}">🇷🇺 Русский</a></li>
                <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'en') }}">🇺🇸 English</a></li>
            </ul>
        </div>
    </div>

    <div class="text-center mb-5 mt-2">
        <div class="display-4 fw-bold text-white mb-2">{{__('app.contact-page-title')}}</div>
        <div class="text-white fs-5">{{__('app.contact-page-subtitle')}}</div>
    </div>

    <div class="row justify-content-center pb-5">
        <div class="col-12 col-xl-10">
            @if(session('success'))
            <div class="alert alert-success border-0 bg-success bg-opacity-25 text-success rounded-4 mb-4">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger border-0 bg-danger bg-opacity-25 text-danger rounded-4 mb-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger rounded-4 mb-4">
                <div class="fw-bold mb-2"><i class="bi bi-exclamation-octagon-fill me-2"></i> Düzedilmeli näsazlyklar bar:</div>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="bg-dark bg-opacity-10 border border-white border-opacity-25 rounded-4 p-4 h-100 shadow-lg"
                        style="background-color: rgba(31, 30, 30, 0.51); backdrop-filter: blur(10px); color: white;">

                        <div class="mb-4">
                            <div class="text-white-50 small fw-bold text-uppercase mb-2" style="letter-spacing: 1px;">
                                {{__('app.contact-page-address-title')}}
                            </div>
                            <div class="text-white fw-medium lh-base">
                                {{ get_setting('site_address') ?? __('app.contact-page-address') }}
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="text-white-50 small fw-bold text-uppercase mb-2" style="letter-spacing: 1px;">
                                {{__('app.contact-page-phone-num-title')}}
                            </div>
                            <a href="tel:{{ get_setting('site_phone') }}" class="text-white fw-bold fs-5 text-decoration-none">
                                {{ get_setting('site_phone', '+993 12 555550') }}
                            </a>
                        </div>

                        <div class="mb-4">
                            <div class="text-white-50 small fw-bold text-uppercase mb-2" style="letter-spacing: 1px;">
                                {{ __('app.contact-page-email-title') }}
                            </div>
                            <a href="mailto:{{ get_setting('site_email') }}" class="text-white fw-medium text-decoration-none">
                                {{ get_setting('site_email', 'info@perfumeart.com') }}
                            </a>
                        </div>

                        @php
                        $now = \Carbon\Carbon::now();
                        $dayOfWeek = $now->dayOfWeek; // 0 = Ýekşenbe, 1 = Duşenbe ...
                        $currentTime = $now->format('H:i');

                        $openTime = "08:35";
                        $closeTime = "21:25";

                        // Ýekşenbe güni ýapyk (0 = Sunday)
                        $isOpen = ($dayOfWeek !== 0) && ($currentTime >= $openTime && $currentTime <= $closeTime);
                            @endphp

                            <div class="mt-4 pt-3 border-top border-white border-opacity-10">
                            <div class="text-white-50 small fw-bold text-uppercase mb-2" style="letter-spacing: 1px;">
                                {{__('app.contact-page-working-hours-title')}}
                            </div>

                            <div class="working-hours-wrapper">
                                <div class="working-hours-toggler rounded-3 p-2 px-3 d-flex align-items-center justify-content-between"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#workingHoursCollapse"
                                    aria-expanded="false">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-clock-history fs-5 {{ $isOpen ? 'text-success' : 'text-danger' }}"></i>
                                        <div>
                                            @if($isOpen)
                                            <span class="text-success fw-bold">{{__('app.contact-page-working-hours-open')}}</span>
                                            <span class="text-white-50 small">· {{ $closeTime }} {{ __('app.contact-page-working-hours-closing') }}</span>
                                            @else
                                            <span class="text-danger fw-bold">{{__('app.contact-page-working-hours-close')}}</span>
                                            <span class="text-white-50 small">· {{__('app.contact-page-working-hours-opening')}} {{ $openTime }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <i class="bi bi-chevron-down text-white-50 small"></i>
                                </div>

                                <div class="collapse mt-2" id="workingHoursCollapse">
                                    <div class="working-hours-list p-2">
                                        <div class="working-day-item d-flex justify-content-between align-items-center {{ $dayOfWeek == 1 ? 'today' : '' }}">
                                            <span>{{__('app.contact-page-working-hours-monday')}}</span>
                                            <span class="text-white-50">08:35–21:25</span>
                                        </div>
                                        <div class="working-day-item d-flex justify-content-between align-items-center {{ $dayOfWeek == 2 ? 'today' : '' }}">
                                            <span>{{__('app.contact-page-working-hours-tuesday')}}</span>
                                            <span class="text-white-50">08:35–21:25</span>
                                        </div>
                                        <div class="working-day-item d-flex justify-content-between align-items-center {{ $dayOfWeek == 3 ? 'today' : '' }}">
                                            <span>{{__('app.contact-page-working-hours-wednesday')}}</span>
                                            <span class="text-white-50">08:35–21:25</span>
                                        </div>
                                        <div class="working-day-item d-flex justify-content-between align-items-center {{ $dayOfWeek == 4 ? 'today' : '' }}">
                                            <span>{{__('app.contact-page-working-hours-thursday')}}</span>
                                            <span class="text-white-50">08:35–21:25</span>
                                        </div>
                                        <div class="working-day-item d-flex justify-content-between align-items-center {{ $dayOfWeek == 5 ? 'today' : '' }}">
                                            <span>{{__('app.contact-page-working-hours-friday')}}</span>
                                            <span class="text-white-50">08:35–21:25</span>
                                        </div>
                                        <div class="working-day-item d-flex justify-content-between align-items-center {{ $dayOfWeek == 6 ? 'today' : '' }}">
                                            <span>{{__('app.contact-page-working-hours-saturday')}}</span>
                                            <span class="text-white-50">08:35–21:25</span>
                                        </div>
                                        <div class="working-day-item d-flex justify-content-between align-items-center {{ $dayOfWeek == 0 ? 'today' : '' }}">
                                            <span>{{__('app.contact-page-working-hours-sunday')}}</span>
                                            <span class="text-danger fw-bold">{{__('app.contact-page-working-hours-close')}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>

                </div>
            </div>

            <div class="col-md-8">
                <div class="bg-dark bg-opacity-10 border border-white border-opacity-25 rounded-4 p-4 p-lg-5 shadow-lg"
                    style="background-color: rgba(31, 30, 30, 0.51); backdrop-filter: blur(10px); color: white;">
                    <div class="h3 text-white fw-bold mb-4">{{ __('app.contact-page-input-send-title') }}</div>

                    <form id="contact-form" action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <div class="text-white-50 small mb-2 fw-bold">{{__('app.contact-page-input-name-subtitle')}}</div>
                                    <input type="text" name="name" class="form-control bg-white bg-opacity-10 border-white border-opacity-25 text-white py-2 shadow-none" placeholder="{{__('app.contact-page-input-name-placeholder')}}" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <div class="text-white-50 small mb-2 fw-bold">{{__('app.contact-page-input-email-subtitle')}}</div>
                                    <input type="email" name="email" class="form-control bg-white bg-opacity-10 border-white border-opacity-25 text-white py-2 shadow-none" placeholder="example@mail.com" required>

                                    <div class="alert alert-warning mt-2 border-0 shadow-sm" style="background: rgba(255, 193, 7, 0.15); color: #ffc107; border-radius: 12px; font-size: 0.85rem;">
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                        <b>{{__('app.contact-page-email-alert-bold')}}</b> {{__('app.contact-page-email-alert')}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <div class="text-white-50 small mb-2 fw-bold">{{__('app.contact-page-input-description-subtitle')}}</div>
                                    <textarea name="message" class="form-control border-white border-opacity-25 bg-white bg-opacity-10 text-white px-3 shadow-none" rows="5" placeholder="{{__('app.contact-page-input-description-placeholder')}}" required style="background-color: transparent;"></textarea>
                                </div>
                            </div>

                            <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-light w-100 py-3 rounded-pill fw-bold fs-5 shadow-sm border-0">
                                    {{ __('app.contact-page-send-btn') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if(get_setting('site_map_iframe') || get_setting('map_iframe'))
        <div class="row mt-5">
            <div class="col-12">
                <div class="bg-dark bg-opacity-10 border border-white border-opacity-25 rounded-4 p-3 shadow-lg position-relative"
                    style="background-color: rgba(31, 30, 30, 0.51); backdrop-filter: blur(10px); min-height: 400px;">

                    <div id="map-offline-fallback" class="position-absolute top-50 start-50 translate-middle text-center text-white-50 w-100 px-3" style="z-index: 1;">
                        <i class="bi bi-wifi-off display-4 text-danger mb-2 d-block"></i>
                        <div class="fw-bold text-white fs-5">{{ __('app.contact-page-map-offline-feedback-title') }}</div>
                        <div class="small mb-3">{{ __('app.contact-page-map-offline-feedback-description') }}</div>
                        <button type="button" onclick="window.location.reload()" class="btn btn-outline-light btn-sm rounded-pill px-4">
                            <i class="bi bi-arrow-clockwise me-1"></i> {{ __('app.contact-page-map-offline-feedback-reload') }}
                        </button>
                    </div>

                    <div class="map-wrapper rounded-4 overflow-hidden position-relative" style="z-index: 2;">
                        {!! get_setting('site_map_iframe') ?? get_setting('map_iframe') !!}
                    </div>

                </div>
            </div>
        </div>
        @endif

    </div>
</div>
</div>
@endsection

@section('scripts')
@if(get_setting('recaptcha_enabled') == '1')
<script src="https://www.google.com/recaptcha/api.js?render={{ get_setting('recaptcha_site_key') }}"></script>
@endif

<script>
    document.getElementById('contact-form').addEventListener('submit', function(e) {
        const form = this;
        const btn = form.querySelector('button[type="submit"]');

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Garaşyň...';

        if ("{{ get_setting('recaptcha_enabled') }}" === "1") {
            e.preventDefault();

            grecaptcha.ready(function() {
                grecaptcha.execute("{{ get_setting('recaptcha_site_key') }}", {
                        action: 'contact'
                    })
                    .then(function(token) {
                        if (token) {
                            document.getElementById('g-recaptcha-response').value = token;
                            form.submit();
                        } else {
                            btn.disabled = false;
                            btn.innerHTML = 'Ugrat';
                        }
                    }).catch(function(err) {
                        console.error('reCAPTCHA Hata:', err);
                        btn.disabled = false;
                        btn.innerHTML = 'Ugrat';
                    });
            });
        }
    });
</script>
@endsection