@extends('layouts.app')

@section('title', 'Biz Barada - Perfume Art Collection')

@section('content')
<style>
    .section-title {
        letter-spacing: -1px;
        font-weight: 800;
    }

    .glass-card {
        background: rgba(37, 36, 36, 0.18);
        backdrop-filter: blur(10px);
        opacity: 0.90;
        -webkit-backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        transition: all 0.3s ease;
    }

    .glass-card:hover {
        transform: translateY(-5px);
        border-color: rgba(13, 202, 240, 0.4);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5);
    }

    .stat-number {
        font-size: 2.2rem;
        font-weight: 800;
        background: linear-gradient(45deg, #ffffff, #0dcaf0);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .process-step-badge {
        width: 40px;
        height: 40px;
        background: rgba(13, 202, 240, 0.2);
        color: #0dcaf0;
        border: 1px solid rgba(13, 202, 240, 0.4);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    /* Pulse Point Icon Circle */
    .pulse-icon-box {
        width: 50px;
        height: 50px;
        background: rgba(13, 202, 240, 0.15);
        border: 1px solid rgba(13, 202, 240, 0.3);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0dcaf0;
        font-size: 1.4rem;
    }
</style>

<div class="container-xl">
    <div class="d-flex justify-content-end pt-4">
        <div class="dropdown">
            <button class="btn btn-outline-light dropdown-toggle border-0 px-3 py-2 rounded-pill shadow-xl d-flex align-items-center justify-content-center"
                type="button" id="langDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                style="background: rgba(92, 90, 90, 0.57); height: 42px; min-width: 95px; font-size: 13px;">
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

<div class="container-xl my-5 py-3">
    <div class="row align-items-center g-5">
        <div class="col-xl-6">
            <div class="glass-card p-4">
                <h1 class="display-5 section-title text-white fw-bold mb-4">
                    {{ __('app.about-page-title') }}
                </h1>

                <p class="text-white fs-5 mb-4">
                    {{ __('app.about-page-description') }}
                </p>

                <p class="text-end text-info fw-semibold fst-italic mb-5">
                    {{ __('app.about-page-signature') }}
                </p>
            </div>

            <div class="row pt-3 g-3">
                <div class="col-sm-6">
                    <div class="glass-card p-3 rounded-4 d-flex align-items-center">
                        <i class="bi bi-patch-check-fill text-info fs-2 me-3"></i>
                        <div>
                            <div class="text-white fw-bold">{{ __('app.about-page-feature-1') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="glass-card p-3 rounded-4 d-flex align-items-center">
                        <i class="bi bi-truck text-info fs-2 me-3"></i>
                        <div>
                            <div class="text-white fw-bold">{{ __('app.about-page-feature-2') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 text-center">
            <div class="glass-card p-3 rounded-4 text-center">
                <a href="{{ asset('images/favicon/parfum-art.png') }}" data-fancybox="gallery" data-caption="Perfume Art Logo">
                    <img src="{{ asset('images/favicon/parfum-art.png') }}" class="w-50 rounded-3 shadow-lg mb-4" style="cursor: zoom-in;" alt="Perfume Logo">
                </a>

                <div class="row pt-4 mt-5 border-top border-white border-opacity-10 g-3">
                    <div class="col-6 col-xl-4 col-md-4">
                        <div class="stat-number">
                            <span class="counter" data-target="100">0</span>%
                        </div>
                        <div class="text-white-50 small">Original</div>
                    </div>
                    <div class="col-6 col-xl-4 col-md-4">
                        <div class="stat-number">
                            <span class="counter" data-target="500">0</span>+
                        </div>
                        <div class="text-white-50 small">Müşderiler</div>
                    </div>
                    <div class="col-12 col-xl-4 col-md-4">
                        <div class="stat-number">24/7</div>
                        <div class="text-white-50 small">Goldaw</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 pt-5">
        <div class="text-center mb-5">
            <h2 class="text-white fw-bold section-title">Näme üçin Perfume Art?</h2>
            <p class="text-white">Biz size diňe atyr däl, eýsem özboluşly duýgulary hödürleýäris.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="glass-card p-4 rounded-4 h-100 text-center">
                    <div class="mb-3 text-info fs-1"><i class="bi bi-gem"></i></div>
                    <h5 class="text-white fw-bold mb-2">Ekskluziw Ýygyndy</h5>
                    <p class="text-white-50 small mb-0">Dünýä belli luxury brendleriň iň saýlama yslary bir ýerde.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="glass-card p-4 rounded-4 h-100 text-center">
                    <div class="mb-3 text-info fs-1"><i class="bi bi-shield-check"></i></div>
                    <h5 class="text-white fw-bold mb-2">Hil Kepilligi</h5>
                    <p class="text-white-50 small mb-0">Ähli önümlerimiz öndürijilerden göni getirilen hakyky atyrlardyr.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="glass-card p-4 rounded-4 h-100 text-center">
                    <div class="mb-3 text-info fs-1"><i class="bi bi-box-seam"></i></div>
                    <h5 class="text-white fw-bold mb-2">Owadan Gaplama</h5>
                    <p class="text-white-50 small mb-0">Ýörite sowgatlyk gaplamalarymyz bilen ýakynlaryňyzy begendiriň.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="glass-card p-4 rounded-4 h-100 text-center">
                    <div class="mb-3 text-info fs-1"><i class="bi bi-headset"></i></div>
                    <h5 class="text-white fw-bold mb-2">Ýokary Hyzmat</h5>
                    <p class="text-white-50 small mb-0">Atyr saýlamakda professional maslahat beriş hyzmatymyz bar.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 pt-5">
        <div class="text-center mb-5">
            <h2 class="text-white fw-bold section-title">Sargyt Etmek Nädip Aşat?</h2>
            <p class="text-white">Öýüňizden çykman 3 ýönekeý ädimde öz ysgyňyza eýe boluň.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="glass-card p-4 rounded-4 h-100 position-relative">
                    <div class="d-flex align-items-center mb-3">
                        <div class="process-step-badge me-3">1</div>
                        <h5 class="text-white fw-bold mb-0">Saýlaň</h5>
                    </div>
                    <p class="text-white-50 small mb-0">Katalogymyzdan öz stilňize we göwnüňize laýyk gelýän atyry aňsatlyk bilen tapyň.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="glass-card p-4 rounded-4 h-100 position-relative">
                    <div class="d-flex align-items-center mb-3">
                        <div class="process-step-badge me-3">2</div>
                        <h5 class="text-white fw-bold mb-0">Sargyt Ediň</h5>
                    </div>
                    <p class="text-white-50 small mb-0">Bir klikde sargyt ediň ýa-da göni biziň bilen habarlaşyp maglumatyňyzy galdyryň.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="glass-card p-4 rounded-4 h-100 position-relative">
                    <div class="d-flex align-items-center mb-3">
                        <div class="process-step-badge me-3">3</div>
                        <h5 class="text-white fw-bold mb-0">Eltip Bermek</h5>
                    </div>
                    <p class="text-white-50 small mb-0">Kuryerimiz sargytdan gysga wagtyň içinde gapyňyza çenli eltip berer.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- TÄZE BÖLEK: ATYRY NÄDEŇDE DOGRY ULANYP BOLÝAR? (FRAGRANCE ETIQUETTE) --}}
    <div class="mt-5 pt-5">
        <div class="text-center mb-5">
            <h2 class="text-white fw-bold section-title">Atyry Nädeňde Dogry Ulanyp Bolýar?</h2>
            <p class="text-white">Atyryň galyjylygyny (stoykost) we täsirini arttyrmak üçin professional maslahatlar.</p>
        </div>

        <div class="row g-4 align-items-stretch">
            {{-- Pulsiýa Nükteleri --}}
            <div class="col-lg-6">
                <div class="glass-card p-4 p-md-5 rounded-4 h-100">
                    <div class="d-flex align-items-center mb-4">
                        <i class="bi bi-heart-pulse text-info fs-2 me-3"></i>
                        <h4 class="text-white fw-bold mb-0">Pulsiýa Nükteleri</h4>
                    </div>
                    <p class="text-white-50 mb-4 small">Beden temperaturasy ýokary bolan ýerlerde ys janlanýar we töwerege has gowy ýaýraýar:</p>

                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-center">
                            <div class="pulse-icon-box me-3"><i class="bi bi-person-lines-fill"></i></div>
                            <div>
                                <div class="text-white fw-bold">Boýun we Gulak Arty</div>
                                <div class="text-white-50 small">Ysyň ilkinji bolup töwerege duýulmagyny üpjün edýär.</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="pulse-icon-box me-3"><i class="bi bi-hand-index-thumb"></i></div>
                            <div>
                                <div class="text-white fw-bold">Bilekleriň Içi (Pulse Points)</div>
                                <div class="text-white-50 small">Damar urşy bilen bilelikde ysy gün boyy täzelep durýar.</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="pulse-icon-box me-3"><i class="bi bi-arrows-expand"></i></div>
                            <div>
                                <div class="text-white fw-bold">Jübüt Dyz we Düşük Nükteler</div>
                                <div class="text-white-50 small">Ys aşakdan ýokaryk galýandygy üçin durnuklylygy arttyrýar.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3 Altyn Düzgün --}}
            <div class="col-lg-6">
                <div class="glass-card p-4 p-md-5 rounded-4 h-100">
                    <div class="d-flex align-items-center mb-4">
                        <i class="bi bi-stars text-info fs-2 me-3"></i>
                        <h4 class="text-white fw-bold mb-0">3 Altyn Düzgün</h4>
                    </div>

                    <div class="d-flex flex-column gap-4">
                        <div class="d-flex">
                            <div class="text-info fw-bold fs-4 me-3">01</div>
                            <div>
                                <div class="text-white fw-bold mb-1">Derini Çyglandyryň</div>
                                <div class="text-white-50 small">Gurak deride ys çalt uçýar. Atyr sypmazdan öň ygşyl, yssyz krem ýa-da lotion ulansaňyz ys 2 esse köp saklanar.</div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="text-info fw-bold fs-4 me-3">02</div>
                            <div>
                                <div class="text-white fw-bold mb-1">Bilekleri Bir-birine Süýkemäň</div>
                                <div class="text-white-50 small">Atyr syzyp bilekleri süýkemek ysyň molekulalaryny bozýar we ýokarky (Top Notes) yslary çalt öçürýär.</div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="text-info fw-bold fs-4 me-3">03</div>
                            <div>
                                <div class="text-white fw-bold mb-1">Salkyn we Garaňky Ýerde Saklaň</div>
                                <div class="text-white-50 small">Atyrlary gün şölesinden we bany ýaly çygly/yssy ýerlerden uzakda tutmak olaryň hilini ýyllar boýy saklaýar.</div>
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
<script>
    if (typeof Fancybox !== 'undefined') {
        Fancybox.bind("[data-fancybox='gallery']", {
            Images: {
                zoom: true
            },
        });
    }

    // SANLARY ARTDIRÝAN ANIMASIÝA (COUNT UP)
    document.addEventListener('DOMContentLoaded', function() {
        const counters = document.querySelectorAll('.counter');
        const speed = 240; // Animasiýanyň tizligi

        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;

                const inc = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + inc);
                    setTimeout(updateCount, 15);
                } else {
                    counter.innerText = target;
                }
            };

            updateCount();
        });
    });
</script>
@endsection