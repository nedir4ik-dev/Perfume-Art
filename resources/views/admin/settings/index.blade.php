@extends('layouts.app')

@section('title', 'Admin Settings - Perfume Art Collection')

@section('content')
<style>
    body {
        background: #0a0a0a !important;
        color: #e0e0e0;
        font-family: 'Inter', sans-serif;
    }

    .main-content {
        background: radial-gradient(circle at top right, rgba(31, 30, 30, 0.51), transparent),
            radial-gradient(circle at bottom left, rgba(31, 30, 30, 0.51), transparent) !important;
        min-height: 100vh;
        backdrop-filter: blur(5px);
    }

    .settings-card {
        background: rgba(255, 255, 255, 0.02) !important;
        backdrop-filter: blur(20px) saturate(160%);
        -webkit-backdrop-filter: blur(20px) saturate(160%);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 25px;
    }

    .nav-pills .nav-link {
        color: rgba(255, 255, 255, 0.6);
        border-radius: 12px;
        padding: 12px 20px;
        transition: all 0.3s;
    }

    .nav-pills .nav-link.active {
        background: rgba(13, 202, 240, 0.2);
        color: #0dcaf0;
        border: 1px solid rgba(13, 202, 240, 0.3);
    }

    .glass-input {
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: white !important;
    }

    .glass-input:focus {
        border-color: #0dcaf0 !important;
        box-shadow: 0 0 10px rgba(13, 202, 240, 0.2) !important;
    }

    .custom-switch .form-check-input {
        cursor: pointer;
        width: 3em;
        height: 1.5em;
    }
</style>

<div class="admin-wrapper d-flex">
    @include('admin.partials.sidebar')

    <div class="main-content flex-grow-1 p-3 p-md-5">
        <div class="container-xl pt-4">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-5 header-section pt-3 pt-xl-0">
                <div class="pt-5">
                    <h1 class="text-white fw-bold mb-1 responsive-title text-nowrap">{{__('app.settings-page-title')}}</h1>
                    <p class="text-white-50 sm mb-0"><i class="bi bi-gear-fill text-info me-1"></i> {{__('app.settings-page-paragraph')}}</p>
                </div>

                <div class="d-flex align-items-center gap-2 w-100 w-md-auto justify-content-between justify-content-md-end ">
                    <button form="settings-form" type="submit" class="btn btn-info flex-grow-1 flex-md-grow-0 px-3 px-xl-4 rounded-pill fw-bold shadow-xl d-flex align-items-center justify-content-center text-dark" style="height: 42px; font-size: 14px;">
                        <i class="bi bi-cloud-check-fill me-1" style="font-size: 16px;"></i> <span>{{__('app.settings-page-save-btn')}}</span>
                    </button>

                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle border-0 px-3 py-2 rounded-pill shadow-xl d-flex align-items-center justify-content-center"
                            type="button" id="langDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                            style="background: rgba(255,255,255,0.1); height: 42px; min-width: 95px; font-size: 13px;">
                            <i class="bi bi-translate me-2 text-info" style="font-size: 15px;"></i>
                            <span class="text-uppercase fw-bold">{{ app()->getLocale() }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 p-2"
                            aria-labelledby="langDropdown"
                            style="background: rgba(31, 30, 30, 0.51); backdrop-filter: blur(5px); border-radius: 15px; min-width: 140px; z-index: 9999;">
                            <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'tm') }}">🇹🇲 Turkmen</a></li>
                            <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'ru') }}">🇷🇺 Русский</a></li>
                            <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'en') }}">🇺🇸 English</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            @if(session('success'))
            <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success rounded-4 mb-4">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('admin.settings.update') }}" method="POST" id="settings-form" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <div class="col-xl-3">
                        <div class="settings-card p-3 shadow-lg">
                            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <button class="nav-link active mb-2 text-start" id="v-pills-general-tab" data-bs-toggle="pill" data-bs-target="#v-pills-general" type="button" role="tab">
                                    <i class="bi bi-info-circle me-2"></i>{{__('app.settings-page-sidebar-tab-1')}}
                                </button>
                                <button class="nav-link mb-2 text-start" id="v-pills-commerce-tab" data-bs-toggle="pill" data-bs-target="#v-pills-commerce" type="button" role="tab">
                                    <i class="bi bi-cart-check me-2"></i> {{__('app.settings-page-sidebar-tab-2')}}
                                </button>
                                <button class="nav-link mb-2 text-start" id="v-pills-security-tab" data-bs-toggle="pill" data-bs-target="#v-pills-security" type="button" role="tab">
                                    <i class="bi bi-shield-lock me-2"></i> {{__('app.settings-page-sidebar-tab-3')}}
                                </button>
                                <button class="nav-link mb-2 text-start" id="v-pills-seo-tab" data-bs-toggle="pill" data-bs-target="#v-pills-seo" type="button" role="tab">
                                    <i class="bi bi-search me-2"></i> {{__('app.settings-page-sidebar-tab-4')}}
                                </button>
                                <button class="nav-link mb-2 text-start" id="v-pills-branding-tab" data-bs-toggle="pill" data-bs-target="#v-pills-branding" type="button" role="tab">
                                    <i class="bi bi-patch-check-fill me-2"></i> {{__('app.settings-page-sidebar-tab-5')}}
                                </button>
                                <button class="nav-link mb-2 text-start" id="v-pills-social-tab" data-bs-toggle="pill" data-bs-target="#v-pills-social" type="button" role="tab">
                                    <i class="bi bi-share me-2"></i> {{__('app.settings-page-sidebar-tab-6')}}
                                </button>
                                <button class="nav-link mb-2 text-start" id="v-pills-layout-tab" data-bs-toggle="pill" data-bs-target="#v-pills-layout" type="button" role="tab">
                                    <i class="bi bi-layout-text-window-reverse me-2"></i> {{__('app.settings-page-sidebar-tab-7')}}
                                </button>
                            </div>
                        </div>

                        <div class="settings-card p-3 mt-4 border-danger border-opacity-25 shadow-xl" title="perfume-safe">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-white sm text-uppercase fw-bold"><i class="bi bi-cone-striped text-danger me-2"></i> {{__('app.settings-page-maintanance-mode-title')}}</span>
                                <div class="form-check form-switch custom-switch">
                                    <input class="form-check-input bg-danger border-0 shadow-none" type="checkbox" name="maintenance_mode" {{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-9">
                        <div class="settings-card p-4 p-md-5 shadow-lg">
                            <div class="tab-content" id="v-pills-tabContent">

                                <div class="tab-pane fade show active" id="v-pills-general" role="tabpanel">
                                    <h4 class="text-white fw-bold mb-4">{{__('app.settings-page-general-tab-title')}}</h4>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="text-white-50 sm mb-1">{{__('app.settings-page-general-tab-site-name')}}</label>
                                            <input type="text" name="site_name" class="form-control glass-input p-3" value="{{ $settings['site_name'] ?? '' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="text-white-50 sm mb-1">{{__('app.settings-page-general-tab-phone-number')}}</label>
                                            <input type="text" name="site_phone" class="form-control glass-input p-3" value="{{ $settings['site_phone'] ?? '' }}">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="text-white-50 sm mb-1">{{__('app.settings-page-general-tab-address')}}</label>
                                            <textarea name="site_address" class="form-control glass-input p-3" rows="2">{{ $settings['site_address'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="v-pills-commerce" role="tabpanel">
                                    <h4 class="text-white fw-bold mb-4">{{__('app.settings-page-commerce-tab-title')}}</h4>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="p-3 rounded-4 bg-dark bg-opacity-5 border border-info border-opacity-10 shadow-xl">
                                                <label class="text-info sm fw-bold mb-2 text-uppercase">{{__('app.settings-page-commerce-tab-exchange-rate')}} (1$ = ? TMT)</label>
                                                <input type="number" step="0.1" name="exchange_rate" class="form-control glass-input p-3 shadow-none" value="{{ $settings['exchange_rate'] ?? 20 }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="p-3 rounded-4 bg-dark bg-opacity-5">
                                                <label class="text-white-50 sm mb-1">{{__('app.settings-page-commerce-tab-delivery-price')}}</label>
                                                <input type="number" name="delivery_standard" class="form-control glass-input p-3 shadow-none" value="{{ $settings['delivery_standard'] ?? 50 }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="p-3 rounded-4 bg-dark bg-opacity-5">
                                                <label class="text-white-50 sm mb-1">{{__('app.settings-page-commerce-tab-free-delivery-limit')}}</label>
                                                <input type="number" name="delivery_free_limit" class="form-control glass-input p-3 shadow-none" value="{{ $settings['delivery_free_limit'] ?? 250 }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="v-pills-security" role="tabpanel">
                                    <h4 class="text-white fw-bold mb-2">{{__('app.settings-page-security-tab-title')}}</h4>
                                    <p class="text-white-50 sm mb-4">{{__('app.settings-page-security-tab-paragraph')}}</p>

                                    <div class="p-4 rounded-4 bg-dark bg-opacity-5 border border-info border-opacity-10 mb-4 shadow-xl">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div>
                                                <h6 class="text-white mb-1">{{__('app.settings-page-security-tab-security-type')}}</h6>
                                                <p class="text-white-50 sm mb-0">{{__('app.settings-page-security-tab-description')}}</p>
                                            </div>
                                            <div class="form-check form-switch custom-switch">
                                                <input class="form-check-input bg-info border-0 shadow-none" type="checkbox" name="recaptcha_enabled" id="rec_switch" {{ ($settings['recaptcha_enabled'] ?? '0') == '1' ? 'checked' : '' }}>
                                            </div>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="text-white-50 sm mb-1 fw-bold">SITE KEY</label>
                                                <input type="text" name="recaptcha_site_key" class="form-control glass-input p-3 shadow-none" value="{{ $settings['recaptcha_site_key'] ?? '' }}" placeholder="6Lcy...">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="text-white-50 sm mb-1 fw-bold">SECRET KEY</label>
                                                <input type="password" name="recaptcha_secret_key" class="form-control glass-input p-3 shadow-none" value="{{ $settings['recaptcha_secret_key'] ?? '' }}" placeholder="••••••••">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="alert alert-info bg-info bg-opacity-10 border-0 text-info sm rounded-4">
                                        <a href="https://www.google.com/recaptcha/admin" class="text-decoration-none text-info"><i class="bi bi-info-circle-fill me-2"></i></a> {{__('app.settings-page-security-tab-alert')}}
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="v-pills-seo" role="tabpanel">
                                    <h4 class="text-white fw-bold mb-4">{{__('app.settings-page-seo-tab-title')}}</h4>
                                    <div class="mb-3">
                                        <label class="text-white-50 sm mb-1">{{__('app.settings-page-seo-tab-meta-title')}}</label>
                                        <input type="text" name="seo_title" class="form-control glass-input p-3 shadow-none" value="{{ $settings['seo_title'] ?? '' }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="text-white-50 sm mb-1">{{__('app.settings-page-seo-tab-meta-description')}}</label>
                                        <textarea name="seo_description" class="form-control glass-input p-3 shadow-none" rows="3">{{ $settings['seo_description'] ?? '' }}</textarea>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="v-pills-branding" role="tabpanel">
                                    <h4 class="text-white fw-bold mb-4">{{__('app.settings-page-brending-tab-title')}}</h4>
                                    <div class="d-flex align-items-center p-4 rounded-4 bg-dark bg-opacity-5 shadow-xl border border-white border-opacity-5">
                                        <div class="me-4 border border-white border-opacity-10 p-2 rounded bg-dark">
                                            @if(isset($settings['site_logo']))
                                            <img src="{{ asset('storage/' . $settings['site_logo']) }}" style="height: 80px; width: auto; object-fit: contain;">
                                            @else
                                            <div class="text-white-50 sm">{{__('app.settings-page-brending-tab-no-logo')}}</div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <input type="file" name="site_logo" class="form-control glass-input mb-2 shadow-none">
                                            <span class="text-white-50 sm">{{__('app.settings-page-brending-tab-advice')}}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="v-pills-social" role="tabpanel">
                                    <h4 class="text-white fw-bold mb-4">{{__('app.settings-page-social-tab-title')}}</h4>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="text-white-50 sm mb-1"><i class="bi bi-whatsapp me-1"></i>{{__('app.settings-page-social-tab-whatsapp-num')}}</label>
                                            <input type="text" name="social_whatsapp" class="form-control glass-input p-3 shadow-none" value="{{ $settings['social_whatsapp'] ?? '' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="text-white-50 sm mb-1"><i class="bi bi-instagram me-1"></i> {{__('app.settings-page-social-tab-instagram')}}</label>
                                            <input type="text" name="social_instagram" class="form-control glass-input p-3 shadow-none" value="{{ $settings['social_instagram'] ?? '' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="text-white-50 sm mb-1"><i class="bi bi-tiktok me-1"></i> {{__('app.settings-page-social-tab-tiktok')}}</label>
                                            <input type="text" name="social_tiktok" class="form-control glass-input p-3 shadow-none" value="{{ $settings['social_tiktok'] ?? '' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="text-white-50 sm mb-1"><i class="bi bi-telegram me-1"></i> {{__('app.settings-page-social-tab-telegram')}}</label>
                                            <input type="text" name="social_telegram" class="form-control glass-input p-3 shadow-none" value="{{ $settings['social_telegram'] ?? '' }}">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="text-white-50 sm mb-1"><i class="bi bi-envelope me-1"></i>{{__('app.settings-page-social-tab-email')}}</label>
                                            <input type="text" name="site_email" class="form-control glass-input p-3 shadow-none" value="{{ $settings['site_email'] ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="v-pills-layout" role="tabpanel">
                                    <h4 class="text-white fw-bold mb-4">{{ __('app.settings-page-layout-tab-title') }}</h4>
                                    <div class="mb-4">
                                        <label class="text-white-50 sm mb-1">{{__('app.settings-page-layout-tab-google-map-iframe')}}</label>
                                        <textarea name="site_map_iframe" class="form-control glass-input p-3 shadow-none" rows="3" placeholder="<iframe src='...'></iframe>">{{ $settings['site_map_iframe'] ?? '' }}</textarea>
                                        <sm class="text-info opacity-75">{{__('app.settings-page-layout-tab-google-map-notice')}}</sm>
                                    </div>
                                    <div class="mb-4">
                                        <label class="text-white-50 sm mb-1">{{__('app.settings-page-layout-tab-footer-copyright')}}</label>
                                        <input type="text" name="site_copyright" class="form-control glass-input p-3 shadow-none" value="{{ $settings['site_copyright'] ?? '© 2026 Ähli hukuklar goralan.' }}">
                                    </div>
                                    <div class="p-3 rounded-4 bg-danger bg-opacity-10 border border-danger border-opacity-20 mb-4">
                                        <h6 class="text-danger fw-bold mb-2 sm text-uppercase">{{__('app.settings-page-layout-tab-custom-script')}}</h6>
                                        <textarea name="custom_header_script" class="form-control glass-input p-3 shadow-none" rows="3" placeholder="<script> ... </script>">{{ $settings['custom_header_script'] ?? '' }}</textarea>
                                        <sm class="text-white-50" style="font-size: 10px;">{{__('app.settings-page-layout-tab-custom-script-notice')}}</sm>
                                    </div>

                                    <div class="p-4 rounded-4 bg-dark bg-opacity-25 border border-info border-opacity-10 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                                        <div>
                                            <h6 class="text-info fw-bold mb-1 text-uppercase"><i class="bi bi-lightning-charge-fill me-1"></i> Ulgam Keşini Arassalamak</h6>
                                            <p class="text-white-50 sm mb-0">Sahypada edilen üýtgeşmeler görünmedik ýagdaýynda brauzer we sistema keşlerini şu ýerden durlap bilersiňiz.</p>
                                        </div>
                                        <div>
                                            <button type="button" onclick="document.getElementById('clear-cache-form').submit();" class="btn btn-outline-info rounded-pill px-4 fw-bold shadow-sm text-nowrap">
                                                <i class="bi bi-trash3 me-1"></i> Keşi Arassala
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<form id="clear-cache-form" action="{{ route('admin.settings.clearCache') }}" method="POST" style="display: none;">
    @csrf
</form>

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let activeTabHash = window.location.hash || localStorage.getItem('admin_active_tab');

        if (activeTabHash) {
            let activeTabBtn = document.querySelector(`button[data-bs-target="${activeTabHash}"]`);
            if (activeTabBtn) {
                let tab = new bootstrap.Tab(activeTabBtn);
                tab.show();
            }
        }

        let tabButtons = document.querySelectorAll('button[data-bs-toggle="pill"]');
        tabButtons.forEach(button => {
            button.addEventListener('shown.bs.tab', function(e) {
                let targetHash = e.target.getAttribute('data-bs-target');
                localStorage.setItem('admin_active_tab', targetHash);
                history.replaceState(null, null, targetHash);
            });
        });
    });
</script>
@endsection
@endsection