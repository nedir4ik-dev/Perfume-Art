@extends('layouts.app')

@section('title', 'Hyzmat Şertleri - Perfume Art Collection')

<style>
    .section-title {
        letter-spacing: -1px;
        font-weight: 800;
    }

    /* -------------------------------------------------- */
    /* ✨ BÖKLENENDE HEADER-IŇ ASTYNDA GALMAZLYGY ÜÇIN (OFFSET) */
    /* -------------------------------------------------- */
    .terms-section-card {
        scroll-margin-top: 130px !important;
    }

    /* -------------------------------------------------- */
    /* 🖥️ PC ÜÇIN STICKY SCROLLSPY MENÝU STILI */
    /* -------------------------------------------------- */
    .scrollspy-sidebar {
        position: -webkit-sticky !important;
        position: sticky !important;
        top: 110px;
        background: rgba(31, 30, 30, 0.26) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(12px);
        padding: 20px;
        border-radius: 12px;
        z-index: 10;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .scrollspy-nav-link {
        color: rgba(255, 255, 255, 0.5) !important;
        font-size: 0.9rem;
        font-weight: 600;
        padding: 8px 16px;
        display: block;
        border-left: 2px solid rgba(255, 255, 255, 0.1);
        text-decoration: none !important;
        transition: all 0.3s ease;
    }

    .scrollspy-nav-link:hover {
        color: #fff !important;
        border-left-color: rgba(255, 255, 255, 0.4);
    }

    .scrollspy-nav-link.active {
        color: #fff !important;
        border-left-color: #fff !important;
        font-weight: 800;
        padding-left: 22px;
    }

    /* -------------------------------------------------- */
    /* 📱 MOBIL ÜÇIN KESE SCROLLBAR MENÝU */
    /* -------------------------------------------------- */
    @media (max-width: 991px) {
        .mobile-quick-nav {
            display: flex !important;
            overflow-x: auto;
            white-space: nowrap;
            gap: 8px;
            padding-bottom: 8px;
            position: sticky;
            top: 65px;
            z-index: 99;
            background: rgba(18, 18, 18, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding-top: 8px;
        }

        .mobile-quick-nav::-webkit-scrollbar {
            display: none;
        }

        .mobile-nav-btn {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #fff !important;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            text-decoration: none !important;
        }

        .mobile-nav-btn.active {
            background: #fff;
            color: #000 !important;
            font-weight: bold;
            border-color: #fff;
        }

        .terms-section-card {
            background: rgba(31, 30, 30, 0.4) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            backdrop-filter: blur(8px);
            padding: 18px;
            border-radius: 18px;
            margin-bottom: 24px !important;
            scroll-margin-top: 120px !important;
        }
    }

    /* PC-de mobil menýuny gizlemek */
    @media (min-width: 992px) {
        .mobile-quick-nav {
            display: none !important;
        }
    }
</style>

@section('content')
<div class="w-100 px-3 px-md-5 py-4">

    {{-- Dil Saýlama Bölümi --}}
    <div class="d-flex justify-content-end mb-3">
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

    {{-- Mobil üçin Kese Scrollbar --}}
    <div class="mobile-quick-nav mb-4">
        <a href="#acceptance" class="mobile-nav-btn active">01 Ylalaşyk</a>
        <a href="#orders" class="mobile-nav-btn">02 Sargytlar</a>
        <a href="#delivery" class="mobile-nav-btn">03 Eltip bermek</a>
        <a href="#prohibited" class="mobile-nav-btn">04 Gadagançylyklar</a>
        <a href="#rights" class="mobile-nav-btn">05 Hukuklar</a>
        <a href="#copyright" class="mobile-nav-btn">06 Awtorlyk</a>
        <a href="#changes" class="mobile-nav-btn">07 Üýtgeşmeler</a>
    </div>

    <div class="row g-4 mt-1">

        {{-- ÇEP TARAP: Sticky Scrollspy Nav (Diňe PC-de) --}}
        <div class="col-lg-3 d-none d-lg-block">
            <div class="scrollspy-sidebar">
                <p class="text-white-50 text-uppercase small fw-bold mb-3 tracking-wider" style="letter-spacing: 1px;">Münderi (Index)</p>
                <nav id="terms-scrollspy" class="d-flex flex-column gap-1">
                    <a class="scrollspy-nav-link active" href="#acceptance">01. Şertleriň Kabul Edilmegi</a>
                    <a class="scrollspy-nav-link" href="#orders">02. Sargyt Şertleri</a>
                    <a class="scrollspy-nav-link" href="#delivery">03. Eltip Bermek we Töleg</a>
                    <a class="scrollspy-nav-link" href="#prohibited">04. Gadagan Edilýän Amallar</a>
                    <a class="scrollspy-nav-link" href="#rights">05. Platformanyň Hukuklary</a>
                    <a class="scrollspy-nav-link" href="#copyright">06. Awtorlyk Hukugy</a>
                    <a class="scrollspy-nav-link" href="#changes">07. Şertleriň Üýtgedilmegi</a>
                </nav>
            </div>
        </div>

        {{-- SAG TARAP: Esasy Tekstler --}}
        <div class="col-12 col-lg-9 p-xl-5 p-3 rounded-3" style="background: rgba(31, 30, 30, 0.26) !important;
        backdrop-filter: blur(10px);">
            <h1 class="display-5 section-title text-white fw-bold mb-2">
                Hyzmat Şertleri
            </h1>
            <p class="text-white-50 small mb-5">
                <i class="bi bi-calendar-event me-2 text-info"></i>Iň soňky täzelenme: 11.08.2026
            </p>

            {{-- 1. Şertleriň Kabul Edilmegi --}}
            <div id="acceptance" class="terms-section-card d-flex align-items-start mb-5">
                <div class="me-3 mt-1">
                    <i class="bi bi-file-earmark-check-fill text-info fs-3"></i>
                </div>
                <div>
                    <h4 class="text-info fw-bold mb-3">1. Şertleriň Kabul Edilmegi</h4>
                    <p class="text-white lh-lg opacity-90">
                        <b>Perfume Art Collection</b> platformasyna girmek, saýty ulanmak we sargyt etmek bilen, siz şu resminamada görkezilen ähli hyzmat şertlerini, düzgünleri we kanuny borçnamalary doly kabul edendigiňiz barada ylalaşýarsyňyz. Eger şu şertleriň her nähili hem olsa bir bölegi bilen ylalaşmaýan bolsaňyz, platformanyň hyzmatlaryndan peýdalanmazlygyňyzy haýyş edýäris.
                    </p>
                </div>
            </div>

            {{-- 2. Sargyt we Hyzmat Esaslary --}}
            <div id="orders" class="terms-section-card d-flex align-items-start mb-5">
                <div class="me-3 mt-1">
                    <i class="bi bi-cart-check-fill text-info fs-3"></i>
                </div>
                <div>
                    <h4 class="text-info fw-bold mb-3">2. Sargyt Şertleri we Önüm Maglumatlary</h4>
                    <p class="text-white lh-lg mb-2 opacity-90">
                        Platformamyz arkaly amala aşyrylýan sargytlarda aşakdaky düzgünler güýje girýär:
                    </p>
                    <ul class="text-white lh-lg ps-3 mb-0 opacity-90">
                        <li><b>Sargyt tassyklamasy:</b> Saýtda goýlan sargytlar administrasiýa tarapyndan gözden geçirilensoň we görkezilen telefon belgiňiz arkaly habarlaşylan pursadyndan başlap resmi taýdan kabul edilen hasaplanýar.</li>
                        <li><b>Maglumatlaryň dogrulygy:</b> Sargyt wagtynda berýän maglumatlaryňyzyň (Adyňyz, telefon we adres) doly we dogry bolmagy müşderiniň öz jogapkärçiligindedir. Ýalňyş berlen maglumatlar sebäpli gijikmelerde platformamyz jogapkärçilik çekmeýär.</li>
                    </ul>
                </div>
            </div>

            {{-- 3. Eltip Bermek (Logistika) Düzgünleri --}}
            <div id="delivery" class="terms-section-card d-flex align-items-start mb-5">
                <div class="me-3 mt-1">
                    <i class="bi bi-truck text-info fs-3"></i>
                </div>
                <div>
                    <h4 class="text-info fw-bold mb-3">3. Eltip Bermek we Gapyda Töleg</h4>
                    <p class="text-white lh-lg opacity-90">
                        Eltip bermek hyzmaty görkezilen wagt aralygynda amala aşyrylýar. Tölegler haryt gapyňyza eltilip, doly barlanyp, gözden geçirilensoň <b>gapyda nagt ýa-da ylalaşykly elektron görnüşde</b> kabul edilýär. Eger haryt eltilende öndürijiniň hatasy ýa-da daşalma pursadynda zeper ýetenligi ýüze çyksa, müşderi haryt kabul etmekden ýa-da töleg etmekden şol pursat ýüz döndürip biler.
                    </p>
                </div>
            </div>

            {{-- 4. Ulanyjynyň Borçlary we Gadagançylyklar --}}
            <div id="prohibited" class="terms-section-card d-flex align-items-start mb-5">
                <div class="me-3 mt-1">
                    <i class="bi bi-exclamation-triangle-fill text-warning fs-3"></i>
                </div>
                <div>
                    <h4 class="text-info fw-bold mb-3">4. Gadagan Edilýän Amallar</h4>
                    <p class="text-white lh-lg mb-2 opacity-90">
                        Platformamyzyň durnukly işlemegi üçin aşakdaky hereketleri etmek gadagandyr:
                    </p>
                    <ul class="text-white lh-lg ps-3 mb-0 opacity-90">
                        <li>Botlar, awtomatlaşdyrylan skriptler ýa-da emeli programmalary ulanyp, ulgama galp (fake) sargytlary ibermek;</li>
                        <li>Platformanyň bökdençsiz işlemegine zyýan ýetirjek kiber-hüjümleri (DDoS, sql injection we ş.m.) guramak ýa-da synanyşmak;</li>
                        <li>Başga bir şahsyýetiň adyny, telefon belgisini bikanun ýagdaýda ulanyp, onuň adyna sargyt etmek.</li>
                    </ul>
                </div>
            </div>

            {{-- 5. Sahypanyň Hukuklary we Çäklendirmeleri --}}
            <div id="rights" class="terms-section-card d-flex align-items-start mb-5">
                <div class="me-3 mt-1">
                    <i class="bi bi-shield-lock-fill text-info fs-3"></i>
                </div>
                <div>
                    <h4 class="text-info fw-bold mb-3">5. Platformanyň Hukuklary (Sargyt Ýatyrmak)</h4>
                    <p class="text-white lh-lg opacity-90">
                        <b>Perfume Art Collection</b> islendik wagt hileli, şübheli ýa-da yzygiderli ýalňyş maglumat berýän ulanyjylaryň sargytlaryny <b>hiç hili duýduryşsyz ýatyrmak (cancel) we blocklamak</b> hukugyny özünde saklaýar. Şeýle hem, önümleriň bahalaryny ýa-da stok ýagdaýlaryny öňünden duýdurman üýtgetmäge doly ygtyýarlydyr.
                    </p>
                </div>
            </div>

            {{-- 6. Intellektual Eýeçilik (Copyright) --}}
            <div id="copyright" class="terms-section-card d-flex align-items-start mb-5">
                <div class="me-3 mt-1">
                    <i class="bi bi-patch-check-fill text-info fs-3"></i>
                </div>
                <div>
                    <h4 class="text-info fw-bold mb-3">6. Intellektual Eýeçilik we Awtorlyk Hukugy</h4>
                    <p class="text-white lh-lg opacity-90">
                        Saýtda ýerleşdirilen ähli dizaýnlar, logotipler, tekstler, suratlar, grafiki şekiller we kodlar <b>Perfume Art Collection</b>-yň eýeçiligidir we halkara awtorlyk hukugy tarapyndan goralýar. Olary rugsatsyz göçürmek, başga ýerde çap etmek ýa-da täjirçilik maksatlary üçin ulanmak gadagandyr.
                    </p>
                </div>
            </div>

            {{-- 7. Şertleriň Täzelenmegi --}}
            <div id="changes" class="terms-section-card d-flex align-items-start mb-5">
                <div class="me-3 mt-1">
                    <i class="bi bi-arrow-clockwise text-info fs-3"></i>
                </div>
                <div>
                    <h4 class="text-info fw-bold mb-3">7. Şertleriň Üýtgedilmegi</h4>
                    <p class="text-white lh-lg opacity-90">
                        Biz şu Hyzmat Şertlerini zerur bolan ýagdaýynda islendik wagt täzelemäge ýa-da üýtgetmäge doly ygtyýarlydyrys. Sahypada çap edilen pursadyndan başlap üýtgeşmeler güýje girýär. Ulanyjylarymyzyň düzgünleri yzygiderli okap durmagyny maslahat berýäris.
                    </p>
                </div>
            </div>

            {{-- Security / Terms Logo Bloky --}}
            <div class="mt-5 p-4 p-md-5 rounded-4 text-center shadow-lg" style="background-color: rgba(31, 30, 30, 0.51); backdrop-filter: blur(10px); color: white; border: 1px solid rgba(255,255,255,0.1); margin-bottom: 80px;">
                <a href="{{ asset('images/favicon/parfum-art.png') }}" data-fancybox="gallery" data-caption="Terms of Service Security">
                    <img src="{{ asset('images/favicon/parfum-art.png') }}" class="rounded-3 shadow image-zoom" style="max-width: 150px; cursor: zoom-in;" alt="Perfume Logo">
                </a>
                <div class="mt-3">
                    <div class="d-flex align-items-center justify-content-center text-info mb-1">
                        <i class="bi bi-file-earmark-text-fill me-2 fs-5"></i>
                        <span class="small fw-bold text-uppercase">Terms & Conditions</span>
                    </div>
                    <p class="text-white-50 small mb-0">Platformamyzy ulanmak bilen şertleri doly kabul edýärsiniz.</p>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('.terms-section-card');
        const pcNavLinks = document.querySelectorAll('.scrollspy-nav-link');
        const mobileNavBtns = document.querySelectorAll('.mobile-nav-btn');

        window.addEventListener('scroll', () => {
            let currentSectionId = '';

            sections.forEach(section => {
                const sectionTop = section.offsetTop - 160;
                if (pageYOffset >= sectionTop) {
                    currentSectionId = section.getAttribute('id');
                }
            });

            if (currentSectionId) {
                pcNavLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === '#' + currentSectionId) {
                        link.classList.add('active');
                    }
                });

                mobileNavBtns.forEach(btn => {
                    btn.classList.remove('active');
                    if (btn.getAttribute('href') === '#' + currentSectionId) {
                        btn.classList.add('active');
                        btn.scrollIntoView({
                            behavior: 'smooth',
                            inline: 'center',
                            block: 'nearest'
                        });
                    }
                });
            }
        });
    });

    // Fancybox baglamak (surata basylanda ulalmagy üçin)
    if (typeof Fancybox !== 'undefined') {
        Fancybox.bind("[data-fancybox='gallery']", {
            Images: {
                zoom: true
            },
        });
    }
</script>
@endsection