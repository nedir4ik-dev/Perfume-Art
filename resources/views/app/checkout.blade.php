@extends('layouts.app')

@section('content')
<div class="container-xl">
    <div class="d-flex justify-content-end pt-4">
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
</div>

<div class="container mt-5 pt-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="p-4 p-md-5 rounded-5 border border-white border-opacity-10 shadow-2xl"
                style="background: rgba(25, 25, 25, 0.47); backdrop-filter: blur(5px);">

                <h2 class="text-white fw-bold mb-5 text-center">{{__('app.checkout-title')}}</h2>

                <div class="row g-4">
                    <div class="col-md-7">
                        <div class="row g-3 text-white">
                            <div class="col-12">
                                <label class="small opacity-75 ms-2 mb-1">{{__('app.checkout-input-name-subtitle')}} <span class="text-danger">*</span></label>
                                <input type="text" id="customer-name"
                                    class="form-control bg-dark bg-opacity-75 text-white border-secondary rounded-pill px-4 py-2 shadow-none"
                                    placeholder="Aman Myradow" autofocus>
                            </div>
                            <div class="col-12 text-white">
                                <label class="small opacity-75 ms-2 mb-1">{{__('app.checkout-input-phone-num-subtitle')}} <span class="text-danger">*</span></label>
                                <input type="text" id="customer-phone" required
                                    class="form-control bg-dark bg-opacity-75 text-white border-secondary rounded-pill px-4 py-2 shadow-lg"
                                    placeholder="+993 65 999990">
                            </div>
                            <div class="col-12">
                                <label class="small opacity-75 ms-2 mb-1">E-poçta salgyňyz (Bildiriş üçin)</label>
                                <input type="email" id="customer-email"
                                    class="form-control bg-dark bg-opacity-75 text-white border-secondary rounded-pill px-4 py-2 shadow-none"
                                    placeholder="mysal@gmail.com">
                            </div>
                            <div class="col-12">
                                <label class="small opacity-75 ms-2 mb-1">{{__('app.checkout-input-teaxtarea-subtitle')}}</label>
                                <textarea id="customer-address"
                                    class="form-control bg-dark bg-opacity-75 text-white border-secondary rounded-4 px-4 py-2 shadow-none"
                                    rows="3" placeholder="Aşgabat ş., Magtymguly şaýoly..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="p-4 rounded-4 border border-white border-opacity-10 h-100 d-flex flex-column justify-content-between"
                            style="background-color: rgba(31, 30, 30, 0.51); backdrop-filter: blur(5px);">
                            <div>
                                <h5 class="text-white fw-bold mb-4">{{ __('app.checkout-about-order') }}</h5>

                                <div class="d-flex justify-content-between text-white-50 mb-3 small">
                                    <span>{{__('app.checkout-number-of-product')}}</span>
                                    <span class="text-white">{{ $count ?? 0 }} sany</span>
                                </div>

                                <div class="d-flex justify-content-between text-white-50 mb-3 small">
                                    <span>Harytlaryň TMT bahasy</span>
                                    <span class="text-white">{{ number_format((float)($total_tmt ?? 0), 0, '.', ' ') }} TMT</span>
                                </div>

                                <div class="mb-4">
                                    <div class="d-flex justify-content-between text-white-50 small">
                                        <span>{{__('app.checkout-delivery')}}</span>
                                        <span class="{{ ($delivery_fee ?? 0) == 0 ? 'text-success' : 'text-warning' }} fw-bold">
                                            {{ ($delivery_fee ?? 0) == 0 ? 'Mugt' : number_format((float)$delivery_fee, 0, '.', ' ') . ' TMT' }}
                                        </span>
                                    </div>
                                    @if(isset($delivery_msg))
                                    <div class="mt-2 p-2 rounded-3 border border-info border-opacity-25" style="background: rgba(13, 202, 240, 0.05);">
                                        <p class="text-info mb-0" style="font-size: 0.75rem; line-height: 1.2;">
                                            <i class="bi bi-info-circle me-1"></i> {{ $delivery_msg }}
                                        </p>
                                    </div>
                                    @endif
                                </div>

                                <div class="border-top border-white border-opacity-10 pt-3 mt-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-white-50 fw-light">{{ __('app.total_price') }}</span>
                                        <span class="h4 mb-0 text-success fw-bold">{{ number_format((float)($grand_total ?? 0), 0, '.', ' ') }} TMT</span>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-white-50" style="font-size: 0.7rem;">($ {{ number_format((float)($total_usd ?? 0), 2, '.', ' ') }})</small>
                                    </div>
                                </div>

                                {{-- TÄZE GOŞULAN CHECKBOX BÖLÜMI --}}
                                <div class="form-check mt-4">
                                    <input class="form-check-input bg-dark border-secondary shadow-none" type="checkbox" id="terms-checkbox" style="cursor: pointer;">
                                    <label class="form-check-label text-white-50 small lh-sm" for="terms-checkbox" style="cursor: pointer; user-select: none;">
                                        Men saýtyň <a href="{{ route('terms') }}" target="_blank" class="text-info text-decoration-none fw-bold">Hyzmat Şertlerini</a> we <a href="{{ route('privacy') }}" target="_blank" class="text-info text-decoration-none fw-bold">Gizlinlik Syýasatyny</a> okadym hem-de doly kabul edýärin. <span class="text-danger">*</span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <div class="mt-4">
                                    <button id="final-submit-btn" onclick="submitFinalOrder()"
                                        class="btn btn-primary rounded-pill py-3 w-100 fw-bold shadow-lg text-uppercase">
                                        {{ __('app.checkout-confirm-btn') }}
                                    </button>
                                </div>

                                <div class="text-center mt-3">
                                    <a href="{{ url()->previous() == url()->current() ? url('/') : url()->previous() }}" class="text-white-50 small text-decoration-none">
                                        <i class="bi bi-arrow-left me-1"></i> {{__('app.checkout-continue-shop-link')}}
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>

<script>
    const ORDER_STORE_URL = "{{ route('orders.store') }}";

    function submitFinalOrder() {
        const name = document.getElementById('customer-name').value;
        const phone = document.getElementById('customer-phone').value;
        const email = document.getElementById('customer-email').value;
        const address = document.getElementById('customer-address').value;

        const termsCheckbox = document.getElementById('terms-checkbox');

        if (!name || !phone) {
            alert("Hökman doldurylmaly ýerleri (At we Telefon) boş goýmaň!");
            return;
        }

        if (!termsCheckbox.checked) {
            alert("Sargydyňyzy tassyklamak üçin Hyzmat Şertlerini we Gizlinlik Syýasatyny kabul etmelisiniz!");
            return;
        }

        const btn = document.getElementById('final-submit-btn');

        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span> {{ __('app.sending') ?? 'IBERILÝÄR...' }}`;

        grecaptcha.ready(function() {
            grecaptcha.execute("{{ get_setting('recaptcha_site_key') }}", {
                    action: 'checkout'
                }).then(function(token) {
                    if (token) {
                        const data = {
                            customer_name: name,
                            customer_phone: phone,
                            customer_email: email,
                            customer_address: address,
                            terms_accepted: document.getElementById('terms-checkbox').checked,
                            'g-recaptcha-response': token,
                            _token: "{{ csrf_token() }}"
                        };
                        sendRequest(data, btn);
                    } else {
                        alert('Captcha tassyklamasy şowsuz boldy. Sahypany täzeläp görüň.');
                        resetButton(btn);
                    }
                })
                .catch(function(err) {
                    console.error('reCAPTCHA Error:', err);
                    resetButton(btn);
                });
        });
    }

    function sendRequest(data, btn) {
        fetch(ORDER_STORE_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || "{{ csrf_token() }}"
                },
                body: JSON.stringify(data)
            })
            .then(async response => {
                const result = await response.json();
                if (!response.ok) {
                    throw new Error(result.message || 'Server hatasy döredi');
                }
                return result;
            })
            .then(result => {
                if (result.status === 'success') {
                    localStorage.removeItem('cart');
                    if (typeof updateCartUI === "function") updateCartUI();

                    window.location.href = "{{ url('/success') }}?order_number=" + result.order_number;
                } else {
                    alert(result.message);
                    resetButton(btn);
                }
            })
            .catch(error => {
                console.error('Hata:', error);
                alert("Sargyt ýalňyşlygy: " + error.message);
                resetButton(btn);
            });
    }

    function resetButton(btn) {
        btn.disabled = false;
        btn.innerText = "{{ __('app.checkout-confirm-btn') }}";
    }
</script>
@endsection