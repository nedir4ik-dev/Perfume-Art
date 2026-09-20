@extends('layouts.app')

@section('title', 'Gizlinlik Syýasaty - Perfume Art Collection')

<style>
    .section-title {
        letter-spacing: -1px;
        font-weight: 800;
    }

    /* -------------------------------------------------- */
    /* ✨ BÖKLENENDE HEADER-IŇ ASTYNDA GALMAZLYGY ÜÇIN (OFFSET) */
    /* -------------------------------------------------- */
    .privacy-section-card {
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
        color: #cbc6c680 !important;
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
        border-left-color: #f1f1f1 !important;
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
            background: whitesmoke;
            color: #000 !important;
            font-weight: bold;
            border-color: #f8f8f8;
        }

        .privacy-section-card {
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
        <a href="#login" class="mobile-nav-btn active">01 Giriş</a>
        <a href="#informations" class="mobile-nav-btn">02 Maglumatlar</a>
        <a href="#our-GOAL" class="mobile-nav-btn">03 Maksatlar</a>
        <a href="#cookies" class="mobile-nav-btn">04 Kukiler</a>
        <a href="#security" class="mobile-nav-btn">05 Howpsuzlyk</a>
        <a href="#third-parties" class="mobile-nav-btn">06 Üçünji Taraplar</a>
        <a href="#rights" class="mobile-nav-btn">07 Hukuklar</a>
        <a href="#changes" class="mobile-nav-btn">08 Üýtgeşmeler</a>
    </div>

    <div class="row g-4 mt-1">

        {{-- ÇEP TARAP: Sticky Scrollspy Nav (Diňe PC-de) --}}
        <div class="col-lg-3 d-none d-lg-block">
            <div class="scrollspy-sidebar">
                <p class="text-white-50 text-uppercase small fw-bold mb-3 tracking-wider" style="letter-spacing: 1px;">Münderi (Index)</p>
                <nav id="privacy-scrollspy" class="d-flex flex-column gap-1">
                    <a class="scrollspy-nav-link active" href="#login">01. Giriş we Düzgünler</a>
                    <a class="scrollspy-nav-link" href="#informations">02. Ýygnalýan Maglumatlar</a>
                    <a class="scrollspy-nav-link" href="#our-GOAL">03. Ulanylyş Maksady</a>
                    <a class="scrollspy-nav-link" href="#cookies">04. Kuki Tehnologiýasy</a>
                    <a class="scrollspy-nav-link" href="#security">05. Howpsuzlyk Standartlary</a>
                    <a class="scrollspy-nav-link" href="#third-parties">06. Üçünji Taraplar</a>
                    <a class="scrollspy-nav-link" href="#rights">07. Siziň Hukuklaryňyz</a>
                    <a class="scrollspy-nav-link" href="#changes">08. Üýtgeşmeler</a>
                </nav>
            </div>
        </div>

        {{-- SAG TARAP: Esasy Tekstler --}}
        <div class="col-12 col-lg-9">
            <h1 class="display-5 section-title text-white fw-bold mb-2">
                Gizlinlik Syýasaty
            </h1>
            <p class="text-white-50 small mb-5">
                <i class="bi bi-calendar-event me-2 text-info"></i>Iň soňky täzelenme: 11.08.2026
            </p>

            {{-- 1. Giriş --}}
            <div id="login" class="privacy-section-card d-flex align-items-start mb-5">
                <div class="me-3 mt-1">
                    <i class="bi bi-info-circle-fill text-info fs-3"></i>
                </div>
                <div>
                    <h4 class="text-info fw-bold mb-3">1. Giriş we Umumy Düzgünler</h4>
                    <p class="text-white lh-lg opacity-90">
                        <b>Perfume Art Collection</b> hökmünde müşderilerimiziň şahsy maglumatlarynyň gizlinligine we howpsuzlygyna uly sarpa goýýarys.
                        Şu Gizlinlik Syýasaty, biziň platformamyzy ulananyňyzda şahsy maglumatlaryňyzyň nähili ýyglanylýandygyny,
                        goralýandygyny we amala ashyrlyandygyny düşündirmek maksady bilen taýýarlandy.
                        Ulgamymyzy ulanmak bilen, siz şu resminamadaky şertleri doly kabul edýärsiniz.
                    </p>
                </div>
            </div>

            {{-- 2. Ýygnalýan Maglumatlar --}}
            <div id="informations" class="privacy-section-card d-flex align-items-start mb-5">
                <div class="me-3 mt-1">
                    <i class="bi bi-file-earmark-person text-info fs-3"></i>
                </div>
                <div>
                    <h4 class="text-info fw-bold mb-3">2. Ýygnalýan Şahsy Maglumatlar</h4>
                    <p class="text-white lh-lg mb-2 opacity-90">
                        Platformamyzda sargyt danyşgyny guranyňyzda ýa-da hasap açanyňyzda diňe hyzmatyň bökdençsiz ýerine ýetirilmegi üçin zerur bolan aşakdaky anyk maglumatlary ýygnatýarys:
                    </p>
                    <ul class="text-white lh-lg ps-3 mb-0 opacity-90">
                        <li><b>Şahsy maglumatlar:</b> Adyňyz we familiýaňyz.</li>
                        <li><b>Habarlaşmak üçin:</b> Telefon belgiňiz we elektron poçta (e-mail) salgyňyz.</li>
                        <li><b>Logistika maglumatlary:</b> Sargydyňyzy gapyňyza çenli eltip bermek üçin anyk ýaşaýyş ýa-da iş salgyňyz (adresiniz).</li>
                        <li><b>Ulgamlaýyn maglumatlar:</b> IP salgyňyz, brauzeriňiziň görnüşi we saýta giren wagtyňyz (bu maglumatlar diňe howpsuzlyk we kiber-hüjümlere garşy barlaglar üçin ulanylýar).</li>
                    </ul>
                </div>
            </div>

            {{-- 3. Maglumatlaryň Ulanylyş Maksady --}}
            <div id="our-GOAL" class="privacy-section-card d-flex align-items-start mb-5">
                <div class="me-3 mt-1">
                    <i class="bi bi-gear-fill text-info fs-3"></i>
                </div>
                <div>
                    <h4 class="text-info fw-bold mb-3">3. Maglumatlaryň Ulanylyş Maksady</h4>
                    <p class="text-white lh-lg mb-2 opacity-90">
                        Sizden alýan maglumatlarymyz diňe kanuny we aşakdaky anyk maksatlar üçin amala aşyrylýar:
                    </p>
                    <div class="text-white opacity-90 ps-1">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-truck text-info me-3"></i>
                            <span>Sargyt eden parfumeriýa önümleriňizi dogry we bökdençsiz eltip bermek üçin;</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-telephone-inbound text-info me-3"></i>
                            <span>Sargydyňyz ýola çykanda ýa-da tassyklanylanda habar bermek we goldaw amallary üçin;</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-telegram text-info me-3"></i>
                            <span>Telegram nobet (Queue) ulgamy arkaly saýtyň administrasiýasyna täze sargyt barada gyssagly duýdurmak üçin;</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-shield-lock text-info me-3"></i>
                            <span>Ulgamy hileli we faken (galp) sargytlardan, şeýle hem bot hüjümlerinden goramak üçin.</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 4. Kuki Tehnologiýasy --}}
            <div id="cookies" class="privacy-section-card d-flex align-items-start mb-5">
                <div class="me-3 mt-1">
                    <i class="bi bi-cookie text-info fs-3"></i>
                </div>
                <div>
                    <h4 class="text-info fw-bold mb-3">4. Kuki (Cookie) Tehnologiýasy</h4>
                    <p class="text-white lh-lg mb-0 opacity-90">
                        Müşderilerimiziň platformadaky tejribesini ýokarlandyrmak maksady bilen kukileri ulanýarys.
                        Mysal üçin, siziň öňki sargytlaryňyzy ýatda saklamak we <b>"Sargytlarym" (My Orders)</b> sahypasynda diňe öz sargytlaryňyzy yzarlap bilmegiňiz üçin brauzeriňizde `customer_token` atly howpsuz kuki faýly ýerleşdirilýär.
                        Isledigiňiz wagty brauzeriňiziň sazlamalaryndan kukileri öçürip bilersiňiz.
                    </p>
                </div>
            </div>

            {{-- 5. Howpsuzlyk Standartlary --}}
            <div id="security" class="privacy-section-card d-flex align-items-start mb-5">
                <div class="me-3 mt-1">
                    <i class="bi bi-shield-check text-info fs-3"></i>
                </div>
                <div>
                    <h4 class="text-info fw-bold mb-3">5. Maglumatlary Goramak we Howpsuzlyk Standartlary</h4>
                    <p class="text-white lh-lg mb-0 opacity-90">
                        Müşderi maglumatlarynyň howpsuzlygy biziň üçin iň ýokary wezipedir.
                        Saýtymyzda amala ashyrlyandygyny älli maglumat akymy <b>SSL (Secure Sockets Layer)</b> howpsuzlyk sertifikaty arkaly şifrli görnüşde geçirilýär.
                        Alnan maglumatlar ýörite goralýan, howpsuz serwerlerde saklanýar we olara administrasiýanyň diňe ýörite ygtyýarly şahsyýetlerinden başga hiç kim girip bilmeýär.
                    </p>
                </div>
            </div>

            {{-- 6. Üçünji Taraplar --}}
            <div id="third-parties" class="privacy-section-card d-flex align-items-start mb-5">
                <div class="me-3 mt-1">
                    <i class="bi bi-x-circle-fill text-danger fs-3"></i>
                </div>
                <div>
                    <h4 class="text-info fw-bold mb-3">6. Üçünji Taraplar bilen Paýlaşylmazlyk Güwäsi</h4>
                    <p class="text-white lh-lg mb-0 opacity-90">
                        Biz müşderilerimiziň şahsy maglumatlaryny, telefon belgilerini ýa-da adreslerini hiç bir ýagdaýda ýerli we halkara üçünji taraplara,
                        beýleki şahsyýetlere, marketing kompaniýalaryna ýa-da mahabat agentliklerine <u>satmaýarys, kireýine bermeýäris we paýlaşmaýarys.</u>
                        Maglumatlar diňe we diňe siziň sargydyňyzy ýerine ýetirmek üçin öz ulgamymyzda saklanýar.
                    </p>
                </div>
            </div>

            {{-- 7. Müşderiniň Hukuklary --}}
            <div id="rights" class="privacy-section-card d-flex align-items-start mb-5">
                <div class="me-3 mt-1">
                    <i class="bi bi-person-check-fill text-info fs-3"></i>
                </div>
                <div>
                    <h4 class="text-info fw-bold mb-3">7. Siziň Hukuklaryňyz (Maglumatlary Öçürmek)</h4>
                    <p class="text-white lh-lg mb-0 opacity-90">
                        Siziň öz şahsy maglumatlaryňyzyň üstünde doly dolandyryş hukugyňyz bar.
                        Islendik wagt biziň goldaw merkezimiz bilen habarlaşyp, ulgamymyzda saklanýan şahsy maglumatlaryňyzy (adyňyz, telefon we adres taryhyňyz) **bütinleý we yzyna gaýtaryp bolmajak görnüşde öçürilmegini** talap edip bilersiňiz.
                    </p>
                </div>
            </div>

            {{-- 8. Üýtgeşmeler --}}
            <div id="changes" class="privacy-section-card d-flex align-items-start mb-5">
                <div class="me-3 mt-1">
                    <i class="bi bi-arrow-repeat text-info fs-3"></i>
                </div>
                <div>
                    <h4 class="text-info fw-bold mb-3">8. Syýasata Üýtgeşmeler Girizmek</h4>
                    <p class="text-white lh-lg mb-0 opacity-90">
                        Perfume Art Collection, zerurlyk bolan ýagdaýynda şu Gizlinlik Syýasatyna islendik wagt üýtgeşmeler girizmek hukugyny özünde saklaýar.
                        Täzelenmeler sahypada çap edilen pursadyndan başlap güýje girýär. Ulanyjylarymyza syýasaty yzygiderli barlap durmagy maslahat berýäris.
                    </p>
                </div>
            </div>

            {{-- Security Logo Bloky --}}
            <div class="mt-5 p-4 p-md-5 rounded-4 text-center shadow-lg" style="background-color: rgba(31, 30, 30, 0.51); backdrop-filter: blur(10px); color: white; border: 1px solid rgba(255,255,255,0.1); margin-bottom: 80px;">
                <a href="{{ asset('images/favicon/parfum-art.png') }}" data-fancybox="gallery" data-caption="Privacy Guard Security">
                    <img src="{{ asset('images/favicon/parfum-art.png') }}" class="rounded-3 shadow image-zoom" style="max-width: 150px; cursor: zoom-in;" alt="Perfume Logo">
                </a>
                <div class="mt-3">
                    <div class="d-flex align-items-center justify-content-center text-info mb-1">
                        <i class="bi bi-lock-fill me-2 fs-5"></i>
                        <span class="small fw-bold text-uppercase">End-to-End Encrypted</span>
                    </div>
                    <p class="text-white-50 small mb-0">Şahsy maglumatlaryňyz 100% biziň güwümizde goralýar.</p>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('.privacy-section-card');
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