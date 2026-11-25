@extends('layouts.app')

@section('title', 'Show Activities - Perfume Art Collection')

@section('content')
<style>
    body {
        background: #121212;
    }

    .main-content {
        background-color: rgba(31, 30, 30, 0.51) !important;
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
    }

    .info-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 15px;
        backdrop-filter: blur(10px);
        transition: transform 0.3s ease, border-color 0.3s ease;
    }

    .info-card:hover {
        border-color: rgba(255, 255, 255, 0.15);
    }

    .status-badge {
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: bold;
        font-size: 14px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .history-item {
        border-left: 2px solid rgba(13, 202, 240, 0.3);
        padding-left: 15px;
        position: relative;
        transition: all 0.2s ease;
    }

    .history-item:hover {
        border-left-color: #0dcaf0;
        background: rgba(255, 255, 255, 0.01);
    }

    .history-item::before {
        content: '';
        position: absolute;
        left: -6px;
        top: 6px;
        width: 10px;
        height: 10px;
        background: #0dcaf0;
        border-radius: 50%;
        box-shadow: 0 0 8px #0dcaf0;
    }

    .copy-btn {
        position: absolute;
        right: 15px;
        top: 15px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.6);
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 6px;
        backdrop-filter: blur(5px);
        transition: 0.2s;
    }

    .copy-btn:hover {
        background: #0dcaf0;
        color: #000;
    }

    .progress-thin {
        height: 6px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.1);
    }

    @media (max-width: 991.98px) {
        .main-content {
            padding: 12px !important;
        }

        .stat-grid .col-6 {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding-top: 12px;
            padding-bottom: 12px;
        }

        .stat-grid .col-6:nth-last-child(-n+2) {
            border-bottom: none;
        }
    }
</style>

<div class="admin-wrapper d-flex">
    @include('admin.partials.sidebar')

    <div class="main-content flex-grow-1 p-2 p-sm-4 min-vh-100">
        <div class="container-xl pt-4 pt-sm-5">

            <div class="row align-items-center g-3 mb-4 pt-2">
                <div class="col-12 col-sm-4 text-start">
                    <h3 class="text-white fw-bold mb-0">Activity Details</h3>
                    <small class="text-white-50">Log ID: <span class="text-info">#{{ $activity->id ?? 'N/A' }}</span></small>
                </div>

                <div class="col-12 col-sm-8 d-flex justify-content-start justify-content-sm-end align-items-center gap-3">
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle border-0 px-3 py-2 rounded-pill shadow-sm d-flex align-items-center justify-content-center"
                            type="button" id="langDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                            style="background: rgba(255,255,255,0.1); height: 38px; min-width: 90px;">
                            <i class="bi bi-translate me-1 text-info"></i>
                            <span class="text-uppercase small fw-bold" style="font-size: 11px;">{{ app()->getLocale() }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 p-2"
                            aria-labelledby="langDropdown"
                            style="background: rgba(40, 40, 40, 0.85); backdrop-filter: blur(5px); border-radius: 15px; min-width: 140px; z-index: 9999;">
                            <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'tm') }}">🇹🇲 Turkmen</a></li>
                            <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'ru') }}">🇷🇺 Русский</a></li>
                            <li><a class="dropdown-item rounded-3 text-white py-2" href="{{ route('locale', 'en') }}">🇺🇸 English</a></li>
                        </ul>
                    </div>

                    <a href="{{ route('admin.activities.index') }}" class="btn btn-sm btn-outline-light rounded-pill px-3 d-flex align-items-center" style="height: 38px;">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>

            <div class="row g-3 g-sm-4">
                <div class="col-lg-8">

                    <div class="info-card p-3 p-sm-4 mb-4">
                        <div class="row text-center stat-grid g-0">
                            <div class="col-6 col-md-3 border-sm-end border-white border-opacity-10">
                                <small class="text-white-50 d-block mb-2 text-uppercase tracking-wider" style="font-size: 10px;">Status Code</small>
                                <span class="status-badge {{ ($activity->status_code ?? 200) >= 400 ? 'bg-danger text-white' : (($activity->status_code ?? 200) >= 300 ? 'bg-info text-dark' : 'bg-success text-white') }} d-inline-block">
                                    {{ $activity->status_code ?? '200' }}
                                </span>
                                <small class="d-block text-white-50 mt-2" style="font-size: 9px;">
                                    @if(($activity->status_code ?? 200) == 200) OK
                                    @elseif(($activity->status_code ?? 200) == 404) Not Found
                                    @elseif(($activity->status_code ?? 200) == 500) Server Error
                                    @else HTTP Response @endif
                                </small>
                            </div>
                            <div class="col-6 col-md-3 border-md-end border-white border-opacity-10">
                                <small class="text-white-50 d-block mb-1 text-uppercase tracking-wider" style="font-size: 10px;">Last Move</small>
                                <span class="text-white fw-bold mb-0 d-block" style="margin-top: 6px;">
                                    {{ $activity->updated_at ? $activity->updated_at->diffForHumans() : 'Now' }}
                                </span>
                                <small class="text-white-50 d-block mt-1" style="font-size: 9px;">
                                    {{ $activity->created_at ? $activity->created_at->format('Y-m-d H:i:s') : '-' }}
                                </small>
                            </div>
                            <div class="col-6 col-md-3 border-sm-end border-white border-opacity-10">
                                <small class="text-white-50 d-block mb-2 text-uppercase tracking-wider" style="font-size: 10px;">Method</small>
                                @php
                                $methodClass = match($activity->method ?? 'GET') {
                                'POST' => 'bg-info text-dark',
                                'DELETE' => 'bg-danger text-white',
                                'PUT', 'PATCH' => 'bg-warning text-dark',
                                default => 'bg-secondary text-white'
                                };
                                @endphp
                                <span class="badge {{ $methodClass }} fw-bold text-uppercase px-3 py-1 rounded-3">
                                    {{ $activity->method ?? 'GET' }}
                                </span>
                            </div>
                            <div class="col-6 col-md-3">
                                <small class="text-white-50 d-block mb-1 text-uppercase tracking-wider" style="font-size: 10px;">IP Address</small>
                                <span class="text-white fw-bold d-block" style="margin-top: 6px; word-break: break-all;">{{ $activity->ip_address ?? '127.0.0.1' }}</span>
                                <span class="badge bg-white bg-opacity-10 text-white-50 mt-1" style="font-size: 9px;">v4 / v6</span>
                            </div>
                        </div>
                    </div>

                    @if(isset($security))
                    <div class="info-card p-3 p-sm-4 mb-4 {{ $security['border_class'] ?? 'border-info' }}">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="text-white fw-bold mb-0 d-flex align-items-center">
                                <i class="bi bi-shield-lock-fill text-info me-2 fs-5"></i> Security Insights & Risk Score
                            </h6>
                            <span class="badge {{ $security['badge_class'] }} px-3 py-1 rounded-pill fw-bold" style="font-size: 11px;">
                                {{ $security['level'] }} ({{ $security['score'] }}%)
                            </span>
                        </div>

                        <div class="progress progress-thin mb-3">
                            <div class="progress-bar {{ str_contains($security['badge_class'], 'danger') ? 'bg-danger' : (str_contains($security['badge_class'], 'warning') ? 'bg-warning' : 'bg-success') }}"
                                role="progressbar"
                                style="width: {{ $security['score'] }}%;"
                                aria-valuenow="{{ $security['score'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-2 rounded-3 bg-black bg-opacity-20 border border-white border-opacity-5">
                                    <small class="text-white-50 d-block text-uppercase" style="font-size: 9px;">Session Identifier</small>
                                    <code class="text-info small fw-bold" style="word-break: break-all;">{{ $security['session_id'] }}</code>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-2 rounded-3 bg-black bg-opacity-20 border border-white border-opacity-5">
                                    <small class="text-white-50 d-block text-uppercase" style="font-size: 9px;">Traffic Source (Referer)</small>
                                    <span class="text-white small fw-medium text-truncate d-block" title="{{ $security['referer'] }}">
                                        <i class="bi bi-box-arrow-up-right me-1 text-info"></i> {{ $security['traffic_source'] }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        @if(!empty($security['reasons']))
                        <div class="mt-3 pt-3 border-top border-white border-opacity-10">
                            <small class="text-white-50 d-block mb-1" style="font-size: 10px;">DETECTED ANOMALIES / REASONS:</small>
                            <ul class="mb-0 ps-3 text-warning small">
                                @foreach($security['reasons'] as $reason)
                                <li>{{ $reason }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                    @endif

                    @if(!empty($activity->error_message) || !empty($activity->payload))
                    <div class="info-card p-3 p-sm-4 mb-4 position-relative">

                        @if(!empty($activity->error_message))
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="text-danger fw-bold mb-0"><i class="bi bi-bug me-2"></i>Error Message</h6>
                                <button class="btn copy-btn btn-sm" onclick="copyToClipboard('error-text')"><i class="bi bi-clipboard me-1"></i>Copy</button>
                            </div>
                            <p id="error-text" class="text-white-50 small bg-danger bg-opacity-10 p-3 rounded border border-danger border-opacity-20 user-select-all mb-0">
                                {{ $activity->error_message }}
                            </p>
                        </div>
                        @endif

                        @if(!empty($activity->payload))
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="text-info fw-bold mb-0"><i class="bi bi-code-slash me-2"></i>Request Payload</h6>
                                <button class="btn copy-btn btn-sm" onclick="copyToClipboard('payload-text')"><i class="bi bi-clipboard me-1"></i>Copy JSON</button>
                            </div>
                            <pre id="payload-text" class="bg-dark p-3 rounded text-info small mb-0 user-select-all" style="max-height: 250px; overflow: auto; border: 1px solid rgba(255,255,255,0.05);">{{ json_encode($activity->payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                        @endif
                    </div>
                    @endif

                    <div class="info-card p-3 p-sm-4 mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="text-white fw-bold mb-0"><i class="bi bi-clock-history me-2"></i>Recent Activity Timeline</h6>
                            <span class="badge bg-dark bg-opacity-5 text-white-50 small">Last {{ count($userHistory ?? []) }} steps</span>
                        </div>
                        <div class="ms-2">
                            @forelse($userHistory ?? [] as $history)
                            <div class="history-item mb-4">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-opacity-10 {{ $history->method == 'POST' ? 'bg-info text-info' : 'bg-secondary text-white-50' }}" style="font-size: 9px;">
                                            {{ $history->method ?? 'GET' }}
                                        </span>
                                        <code class="text-white small" style="word-break: break-all;">{{ str_replace(url('/'), '', $history->url ?? '') ?: '/' }}</code>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-white-50" style="font-size: 11px;"><i class="bi bi-clock me-1"></i>{{ $history->created_at ? $history->created_at->format('H:i:s') : '' }}</span>
                                        <span class="badge bg-opacity-10 {{ ($history->status_code ?? 200) >= 400 ? 'bg-danger text-danger' : 'bg-success text-success' }}" style="font-size: 9px;">{{ $history->status_code ?? '200' }}</span>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p class="text-white-50 small text-center py-3 mb-0">No other activities recorded for this session.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    @if(isset($performance))
                    <div class="info-card p-4 mb-4">
                        <h6 class="text-white-50 small text-uppercase mb-3 tracking-wider" style="font-size: 11px;">
                            <i class="bi bi-speedometer2 text-info me-1"></i> Performance Metrics
                        </h6>

                        <div class="d-flex align-items-center justify-content-between p-3 rounded-3 bg-black bg-opacity-30 border border-white border-opacity-5 mb-2">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-stopwatch text-warning me-2 fs-5"></i>
                                <span class="text-white-50 small">Execution Time</span>
                            </div>
                            <span class="text-white fw-bold small">{{ $performance['execution_time'] }}</span>
                        </div>

                        <div class="d-flex align-items-center justify-content-between p-3 rounded-3 bg-black bg-opacity-30 border border-white border-opacity-5 mb-2">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-cpu text-info me-2 fs-5"></i>
                                <span class="text-white-50 small">RAM Usage</span>
                            </div>
                            <span class="text-info fw-bold small">{{ $performance['memory_usage'] }}</span>
                        </div>

                        <div class="d-flex align-items-center justify-content-between p-3 rounded-3 bg-black bg-opacity-30 border border-white border-opacity-5">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-diagram-3 text-success me-2 fs-5"></i>
                                <span class="text-white-50 small">Protocol</span>
                            </div>
                            <span class="text-white small fw-mono">{{ $performance['http_protocol'] }}</span>
                        </div>
                    </div>
                    @endif

                    <div class="info-card p-4 mb-4 text-center">
                        <h6 class="text-white-50 small text-uppercase mb-3 text-start tracking-wider" style="font-size: 11px;">User Information</h6>
                        @if($activity->user)
                        <div class="position-relative d-inline-block mb-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($activity->user->name) }}&background=0dcaf0&color=000&bold=true" class="rounded-circle shadow-lg border border-2 border-info" style="width: 65px; height: 65px;">
                            <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-light rounded-circle" title="Registered User"></span>
                        </div>
                        <h5 class="text-white fw-bold mb-1">{{ $activity->user->name }}</h5>
                        <p class="text-white-50 small mb-2" style="word-break: break-all;">{{ $activity->user->email }}</p>
                        <span class="badge bg-info bg-opacity-10 text-info px-3 py-1 rounded-pill" style="font-size: 11px;">Admin / Operator</span>
                        @else
                        <div class="d-flex align-items-center justify-content-center bg-dark bg-opacity-5 rounded-circle mx-auto mb-3" style="width: 65px; height: 65px; border: 1px dashed rgba(255,255,255,0.2);">
                            <i class="bi bi-person-x text-white-50 fs-3"></i>
                        </div>
                        <h5 class="text-white-50 fw-bold mb-1">Guest User</h5>
                        <p class="text-white-50 small mb-0" style="font-size: 11px;">Unauthenticated Session</p>
                        @endif
                    </div>

                    <div class="info-card overflow-hidden mb-4">
                        <div class="p-4 text-center border-bottom border-white border-opacity-10 bg-dark bg-opacity-5">
                            <h6 class="text-white text-uppercase fw-bold mb-0 small" style="letter-spacing: 2px;">
                                <i class="bi bi-globe2 text-info me-2"></i>Geo Analitika
                            </h6>
                        </div>
                        <div class="p-4 text-center">
                            @if(isset($geo['countryCode']) && !in_array($geo['countryCode'], ['MQ', 'FAIL']))
                            <div class="position-relative d-inline-block mb-3">
                                <img src="https://flagcdn.com/w160/{{ strtolower($geo['countryCode']) }}.png"
                                    class="rounded-3 shadow-lg" style="width: 100px; border: 2px solid rgba(255,255,255,0.1);">
                                <span class="position-absolute bottom-0 end-0 badge rounded-pill bg-dark border border-secondary border-1" style="font-size: 10px;">
                                    {{ $geo['countryCode'] }}
                                </span>
                            </div>
                            @endif
                            <h3 class="text-white fw-bold mb-1">{{ $geo['country'] ?? 'Localhost' }}</h3>
                            <p class="text-info mb-0 fw-medium small"><i class="bi bi-geo-alt-fill me-1"></i>{{ $geo['city'] ?? 'Development' }}</p>

                            <div class="mt-4 p-3 bg-black bg-opacity-20 rounded-3 border border-white border-opacity-5 text-start">
                                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom border-white border-opacity-5">
                                    <span class="text-white-50 small"><i class="bi bi-router text-info me-1"></i> ISP Provider:</span>
                                    <span class="text-info small fw-bold text-truncate text-end d-block" style="max-width: 160px;" title="{{ $geo['isp'] ?? 'Local Network' }}">
                                        {{ $geo['isp'] ?? 'Local Network' }}
                                    </span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-white-50 small"><i class="bi bi-hdd-network text-white-50 me-1"></i> AS Number:</span>
                                    <span class="text-white small fw-mono" style="font-size: 11px;">
                                        {{ $geo['asn'] ?? 'AS-Internal' }}
                                    </span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-white-50 small"><i class="bi bi-clock text-white-50 me-1"></i> Timezone:</span>
                                    <span class="text-white small fw-bold">{{ $geo['timezone'] ?? 'UTC' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="info-card p-4 mb-4">
                        <h6 class="text-white-50 small text-uppercase mb-4 tracking-wider" style="font-size: 11px;">Environment & Browser</h6>

                        @php
                        $agent = strtolower($activity->user_agent ?? '');

                        if (str_contains($agent, 'iphone') || str_contains($agent, 'ipad')) {
                        $os = 'iOS (iPhone/iPad)';
                        $osI = 'bi-apple text-white';
                        } elseif (str_contains($agent, 'macintosh') || str_contains($agent, 'mac os x')) {
                        $os = 'macOS';
                        $osI = 'bi-apple text-white';
                        } elseif (str_contains($agent, 'windows')) {
                        $os = 'Windows';
                        $osI = 'bi-microsoft text-primary';
                        } elseif (str_contains($agent, 'android')) {
                        $os = 'Android';
                        $osI = 'bi-android2 text-success';
                        } else {
                        $os = 'Unknown Device / Bot';
                        $osI = 'bi-cpu text-warning';
                        }

                        if (str_contains($agent, 'crios')) {
                        $br = 'Google Chrome (iOS)';
                        $brI = 'bi-browser-chrome text-warning';
                        } elseif (str_contains($agent, 'fxios')) {
                        $br = 'Mozilla Firefox (iOS)';
                        $brI = 'bi-browser-firefox text-danger';
                        } elseif (str_contains($agent, 'chrome') && !str_contains($agent, 'edge') && !str_contains($agent, 'opr')) {
                        $br = 'Google Chrome';
                        $brI = 'bi-browser-chrome text-warning';
                        } elseif (str_contains($agent, 'safari') && !str_contains($agent, 'chrome') && !str_contains($agent, 'crios')) {
                        $br = 'Apple Safari';
                        $brI = 'bi-browser-safari text-white';
                        } elseif (str_contains($agent, 'firefox')) {
                        $br = 'Mozilla Firefox';
                        $brI = 'bi-browser-firefox text-danger';
                        } else {
                        $br = 'Web Browser / API';
                        $brI = 'bi-globe text-info';
                        }
                        @endphp

                        <div class="d-flex align-items-center mb-3">
                            <div class="d-flex align-items-center justify-content-center bg-black bg-opacity-40 rounded-circle" style="width: 45px; height: 45px; border: 1px solid rgba(255,255,255,0.05);">
                                <i class="bi {{ $osI }}"></i>
                            </div>
                            <div class="ms-3">
                                <small class="text-white-50 d-block" style="font-size: 10px;">OS</small>
                                <span class="text-white fw-bold">{{ $os }}</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="d-flex align-items-center justify-content-center bg-black bg-opacity-40 rounded-circle" style="width: 45px; height: 45px; border: 1px solid rgba(255,255,255,0.05);">
                                <i class="bi {{ $brI }}"></i>
                            </div>
                            <div class="ms-3">
                                <small class="text-white-50 d-block" style="font-size: 10px;">BROWSER</small>
                                <span class="text-white fw-bold">{{ $br }}</span>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top border-white border-opacity-10">
                            <small class="text-white-50 d-block mb-1" style="font-size: 10px;">USER AGENT</small>
                            <p class="text-white-50 mb-0" style="font-size: 9px; word-break: break-all; opacity: 0.6; line-height: 14px;">
                                {{ $activity->user_agent ?? 'No User Agent Provided' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(elementId) {
        const text = document.getElementById(elementId).innerText;
        navigator.clipboard.writeText(text).then(() => {
            const btn = event.target.closest('.copy-btn');
            const originalHTML = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-check-all me-1 text-success"></i>Copied!';
            btn.style.background = 'rgba(25, 135, 84, 0.2)';

            setTimeout(() => {
                btn.innerHTML = originalHTML;
                btn.style.background = '';
            }, 2000);
        }).catch(err => {
            console.error('Göçürmek başartmady: ', err);
        });
    }
</script>
@endsection