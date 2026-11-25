<style>
    /* Sidebar umumy link dizaýny */
    .nav-link-custom {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        margin-bottom: 5px;
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        border-radius: 12px;
        transition: all 0.3s ease;
        position: relative;
    }

    /* Üstüne baranda (Hover) */
    .nav-link-custom:hover {
        color: #fff;
        background: rgba(13, 202, 240, 0.1);
        transform: translateX(5px);
    }

    /* Ikonkalaryň reňki */
    .nav-link-custom i {
        font-size: 1.1rem;
        transition: transform 0.3s ease;
    }

    .nav-link-custom:hover i {
        transform: scale(1.2);
        color: #0dcaf0;
    }

    /* Sahypa işjeň wagty (Active State) */
    .nav-link-custom.active {
        color: #fff;
        background: linear-gradient(90deg, rgba(13, 202, 240, 0.2) 0%, transparent 100%);
        border-left: 3px solid #0dcaf0;
        font-weight: 600;
    }

    #typing-effect::after {
        content: '|';
        margin-left: 5px;
        color: #0dcaf0;
        animation: blink 0.8s infinite;
    }

    @keyframes blink {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0;
        }
    }

    .btn-outline-danger:hover {
        box-shadow: 0 0 15px rgba(220, 53, 69, 0.3);
        transform: translateY(-2px);
    }
</style>

<button class="btn btn-dark d-lg-none position-fixed top-0 start-0 m-3 z-3 shadow" style="background-color: rgba(31, 30, 30, 0.51); backdrop-filter: blur(5px); min-height: auto;" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebar">
    <i class="bi bi-list fs-4"></i>
</button>

<div class="sidebar offcanvas-lg offcanvas-start p-4 d-flex flex-column shadow-lg border-end border-white border-opacity-10 vh-100"
    id="adminSidebar"
    style="background-color: rgba(31, 30, 30, 0.51); backdrop-filter: blur(5px); width: 280px;">

    <div class="d-flex d-lg-none justify-content-end mb-3">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#adminSidebar"></button>
    </div>

    <div class="mb-5 text-center pt-3 flex-shrink-0">
        <h3 class="text-white fw-bold mb-0" id="typing-effect">
            Perfume <span class="text-info">Art</span>
        </h3>
        <div class="bg-info mx-auto mt-2" style="height: 2px; width: 40px; border-radius: 10px;"></div>
    </div>

    <nav class="flex-grow-1 overflow-auto pe-2" style="scrollbar-width: thin;">
        <div class="nav-label small text-white-50 text-uppercase mb-3 ps-2"
            style="letter-spacing: 1px; font-size: 0.7rem;">{{ __('app.admin-page-sidebar-nav-label-1') }}</div>

        {{-- Dashboard --}}
        @if(auth()->user()->hasPermission('view-dashboard'))
        <a href="{{ route('admin.dashboard') }}"
            class="nav-link-custom pe-3 {{ Request::is('admin/dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill me-3"></i>{{__('app.admin-page-sidebar-nav-link-1')}}
        </a>
        @endif

        {{-- Harytlar --}}
        @if(auth()->user()->hasPermission('manage-products'))
        <a href="{{ route('admin.products.index') }}"
            class="nav-link-custom mb-2 {{ Request::is('admin/products*') ? 'active' : '' }}">
            <i class="bi bi-bag-fill me-3"></i> {{__('app.admin-page-sidebar-nav-link-2')}}
        </a>
        @endif

        {{-- Brandlar --}}
        @if(auth()->user()->hasPermission('manage-brands'))
        <a href="{{ route('admin.brands.index') }}"
            class="nav-link-custom mb-2 {{ Request::is('admin/brands*') ? 'active' : '' }}">
            <i class="bi bi-patch-check-fill me-3"></i> {{__('app.admin-page-sidebar-nav-link-3')}}
        </a>
        @endif

        {{-- Kategoriýalar --}}
        @if(auth()->user()->hasPermission('manage-categories'))
        <a href="{{ route('admin.categories.index') }}"
            class="nav-link-custom mb-2 {{ Request::is('admin/categories*') ? 'active' : '' }}">
            <i class="bi bi-tags-fill me-3"></i> {{__('app.admin-page-sidebar-nav-link-4')}}
        </a>
        @endif

        {{-- Sargytlar --}}
        @if(auth()->user()->hasPermission('manage-orders'))
        @php $newOrders = \App\Models\Order::where('status', 'pending')->count(); @endphp
        <a href="{{ route('admin.orders.index') }}"
            class="nav-link-custom mb-2 {{ Request::is('admin/orders*') ? 'active' : '' }}">
            <i class="bi bi-cart-fill me-3"></i> {{__('app.admin-page-sidebar-nav-link-5')}}
            @if($newOrders > 0)
            <span class="badge ms-2 rounded-pill bg-danger" id="sidebarOrderBadge">{{ $newOrders }}</span>
            @endif
        </a>
        @endif

        {{-- Aktiwiteler (Loglar) --}}
        @if(auth()->user()->hasPermission('manage-activities'))
        <a href="{{ route('admin.activities.index') }}"
            class="nav-link-custom mb-2 {{ Request::is('admin/activities*') ? 'active' : '' }}">
            <i class="bi bi-graph-up-arrow me-3"></i> {{__('app.admin-page-sidebar-nav-link-6')}}
        </a>
        @endif

        {{-- Mahabatlar --}}
        @if(auth()->user()->hasPermission('manage-ads'))
        <a href="{{ route('admin.ads.index') }}"
            class="nav-link-custom mb-2 {{ Request::is('admin/ads*') ? 'active' : '' }}">
            <i class="bi bi-megaphone-fill me-3"></i> {{ __('app.admin-page-sidebar-nav-link-7') }}
        </a>
        @endif

        {{-- Popups --}}
        <a href="{{ route('admin.popups.index') }}"
            class="nav-link-custom mb-2 {{ Request::is('admin/popups*') ? 'active' : '' }}">
            <i class="bi bi-front me-3"></i> {{ __('app.admin-page-sidebar-nav-link-8') }}
        </a>

        {{-- Tickers --}}
        @if(auth()->user()->hasPermission('manage-tickers'))
        <a href="{{ route('admin.tickers.index') }}"
            class="nav-link-custom mb-2 {{ Request::is('admin/tickers*') ? 'active' : '' }}">
            <i class="bi bi-hr me-3"></i> {{ __('app.admin-page-sidebar-nav-link-9') }}
        </a>
        @endif

        {{-- 🎯 Sahypalar (CMS Bölümi) - Siz super admin bolanyňyz üçin hasPermission goýduk --}}
        @if(auth()->user()->hasPermission('manage-settings') || auth()->user()->is_admin)
        <a href="{{ route('admin.pages.index') }}"
            class="nav-link-custom mb-2 {{ Request::is('admin/pages*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text-fill me-3"></i> {{__('app.admin-page-sidebar-nav-link-10')}}
        </a>
        @endif

        {{-- Backup --}}
        @if(auth()->user()->hasPermission('manage-backups'))
        <a href="{{ route('admin.backup.index') }}"
            class="nav-link-custom mb-2 {{ Request::is('admin/backup*') ? 'active' : '' }}">
            <i class="bi bi-database-down me-3"></i>{{__('app.admin-page-sidebar-nav-link-11')}}
        </a>
        @endif

        {{-- Sazlamalar --}}
        @if(auth()->user()->hasPermission('manage-settings'))
        <a href="{{ route('admin.settings.index') }}"
            class="nav-link-custom mb-2 {{ Request::is('admin/settings*') ? 'active' : '' }}">
            <i class="bi bi-gear-fill me-3"></i> {{__('app.admin-page-sidebar-nav-link-12')}}
        </a>
        @endif

        {{-- Habarlar (Messages) --}}
        @if(auth()->user()->is_admin)
        @php $unreadCount = \App\Models\Contact::where('is_read', false)->count(); @endphp
        <a href="{{ route('admin.messages.index') }}"
            class="nav-link-custom mb-2 {{ Request::is('admin/messages*') ? 'active' : '' }}">
            <i class="bi bi-envelope me-3"></i> {{__('app.admin-page-sidebar-nav-link-13')}}
            @if($unreadCount > 0)
            <span class="badge ms-2 rounded-pill bg-danger shadow-lg">{{ $unreadCount }}</span>
            @endif
        </a>
        @endif

        {{-- Rollar --}}
        @if(auth()->user()->hasPermission('manage-roles'))
        <a href="{{ route('admin.roles.index') }}"
            class="nav-link-custom mb-2 {{ Request::is('admin/roles*') ? 'active' : '' }}">
            <i class="bi bi-shield-check me-3"></i> {{__('app.admin-page-sidebar-nav-link-14')}}
        </a>
        @endif

        {{-- Ulanyjylar --}}
        @if(auth()->user()->hasPermission('manage-users'))
        <a href="{{ route('admin.users.index') }}"
            class="nav-link-custom mb-2 {{ Request::is('admin/users*') ? 'active' : '' }}">
            <i class="bi bi-person-badge me-3"></i> {{__('app.admin-page-sidebar-nav-link-15')}}
        </a>
        @endif

        <div class="border-top mt-4 pt-3 border-opacity-10 border-white">
            <div class="nav-label small text-white-50 text-uppercase mb-3 ps-2"
                style="letter-spacing: 1px; font-size: 0.7rem;">{{ __('app.admin-page-sidebar-nav-label-2') }}</div>
            <a href="{{ route('home') }}" class="nav-link-custom mb-2">
                <i class="bi-arrow-left-circle me-3"></i>View Site
            </a>
        </div>
    </nav>

    <div class="mt-auto border-top border-white border-opacity-10 pt-4 flex-shrink-0">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-100 rounded-4 py-2 fw-bold">
                <i class="bi bi-box-arrow-left me-2"></i> {{ __('app.admin-page-sidebar-logout-btn') }}
            </button>
        </form>
    </div>
</div>

<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 99999;">
    <div id="newOrderToast" class="toast align-items-center text-white bg-dark bg-opacity-10 border border-info shadow-lg rounded-4" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
        <div class="d-flex p-2">
            <div class="toast-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-info bg-opacity-20 p-3 text-info d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                    <i class="bi bi-bag-check-fill fs-4"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1 text-info">🔔 TÄZE SARGYT</h6>
                    <div class="small text-white-50" id="toastCustomerName">Müşderi: ...</div>
                    <div class="fw-bold text-warning small" id="toastOrderAmount">Jemi: 0.00 TMT</div>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="border-top border-white border-opacity-10 p-2 text-center">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-info w-100 rounded-pill fw-bold text-dark">
                Sargytlary Gör <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</div>

<script src="{{ asset('js/sweetalert2@11.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const element = document.getElementById('typing-effect');
        const text = "Perfume Art";

        if (sessionStorage.getItem('animationPlayed')) {
            element.innerHTML = 'Perfume <span class="text-info">Art</span>';
        } else {
            element.innerHTML = '';
            let i = 0;

            function typeWriter() {
                if (i < text.length) {
                    if (i >= 8) {
                        if (i === 8) element.innerHTML += '<span class="text-info"></span>';
                        element.querySelector('.text-info').innerHTML += text.charAt(i);
                    } else {
                        element.innerHTML += text.charAt(i);
                    }
                    i++;
                    setTimeout(typeWriter, 120);
                } else {
                    sessionStorage.setItem('animationPlayed', 'true');
                }
            }
            typeWriter();

        function playNotificationSound() {
            try {

                const osc1 = audioCtx.createOscillator();
                const gain1 = audioCtx.createGain();
                osc1.type = 'sine';
                osc1.frequency.setValueAtTime(587.33, audioCtx.currentTime);
                gain1.gain.setValueAtTime(0.3, audioCtx.currentTime);
                gain1.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.3);
                osc1.connect(gain1);

                const osc2 = audioCtx.createOscillator();
                const gain2 = audioCtx.createGain();
                osc2.type = 'sine';
                osc2.frequency.setValueAtTime(880, audioCtx.currentTime + 0.15);
                gain2.gain.setValueAtTime(0.4, audioCtx.currentTime + 0.15);
                gain2.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.5);
                osc2.connect(gain2);
                gain2.connect(audioCtx.destination);

                osc1.start(audioCtx.currentTime);
                osc1.stop(audioCtx.currentTime + 0.3);
                osc2.start(audioCtx.currentTime + 0.15);
                osc2.stop(audioCtx.currentTime + 0.5);
            } catch (e) {
                console.log("Audio Error: ", e);
            }
        }

        setInterval(function() {
            fetch("{{ route('admin.orders.check') }}", {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Accept": "application/json"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.has_new) {
                        document.getElementById('toastCustomerName').innerText = "Müşderi: " + data.customer;
                        document.getElementById('toastOrderAmount').innerText = "Jemi: " + parseFloat(data.amount).toFixed(2) + " TMT";

                        const toastEl = document.getElementById('newOrderToast');
                        const bsToast = new bootstrap.Toast(toastEl);
                        bsToast.show();

                        playNotificationSound();
                    }
                })
                .catch(error => console.error("Order Check Error:", error));
        }, 600000);

    });
</script>