@foreach($activities as $index => $activity)
@php
// 🧮 Pagination Tertip Nomerini Hasaplamak (#1, #2, #3...)
$rowNumber = ($activities->currentPage() - 1) * $activities->perPage() + $loop->iteration;

$statusCode = $activity->status_code ?? 200;
$level = $activity->level ?? ($statusCode >= 500 ? 'error' : ($statusCode >= 400 ? 'warning' : 'info'));

// Undefined variable $rowClass ýalňyşlygyny öňlemek üçin
$rowClass = '';
$borderClass = 'border-bottom border-white border-opacity-10';
$statusColor = 'text-success';

if ($level === 'error' || $statusCode >= 500) {
$rowClass = 'bg-danger bg-opacity-10';
$statusColor = 'text-danger';
$borderClass = 'border-start border-4 border-danger';
} elseif ($level === 'warning' || $statusCode >= 400) {
$rowClass = 'bg-warning bg-opacity-10';
$statusColor = 'text-warning';
$borderClass = 'border-start border-4 border-warning';
}

// Method reňkleri
$method = strtoupper($activity->method ?? 'GET');
$methodBadge = match($method) {
'POST' => 'bg-info text-dark',
'DELETE' => 'bg-danger text-white',
'PUT', 'PATCH' => 'bg-warning text-dark',
default => 'bg-dark text-info border border-info border-opacity-25'
};

// User Agent maglumaty
$agent = strtolower($activity->user_agent ?? '');

// 1. ENJAM GÖRNÜŞI
if (str_contains($agent, 'iphone') || (str_contains($agent, 'android') && str_contains($agent, 'mobile'))) {
$deviceIcon = 'bi-phone text-white';
} elseif (str_contains($agent, 'ipad') || str_contains($agent, 'tablet')) {
$deviceIcon = 'bi-tablet-landscape text-success';
} else {
$deviceIcon = 'bi-laptop text-white';
}

// 2. OPERASION ULGAM (OS)
if (str_contains($agent, 'windows')) {
$osIcon = 'bi-microsoft text-primary';
} elseif (str_contains($agent, 'macintosh') || str_contains($agent, 'mac os') || str_contains($agent, 'iphone') || str_contains($agent, 'ipad')) {
$osIcon = 'bi-apple text-white';
} elseif (str_contains($agent, 'android')) {
$osIcon = 'bi-android2 text-success';
} elseif (str_contains($agent, 'linux') || str_contains($agent, 'ubuntu')) {
$osIcon = 'bi-ubuntu text-danger';
} else {
$osIcon = 'bi-cpu text-warning';
}

// 3. BRAUZER
if (str_contains($agent, 'edg')) {
$browserIcon = 'bi-browser-edge text-info';
} elseif (str_contains($agent, 'chrome')) {
$browserIcon = 'bi-browser-chrome text-warning';
} elseif (str_contains($agent, 'safari') && !str_contains($agent, 'chrome')) {
$browserIcon = 'bi-browser-safari text-white';
} elseif (str_contains($agent, 'firefox')) {
$browserIcon = 'bi-browser-firefox text-danger';
} else {
$browserIcon = 'bi-globe text-muted';
}

// Onlaýn statusyny barlamak (Soňky 5 minut)
$isOnline = $activity->updated_at && $activity->updated_at->gt(now()->subMinutes(5));
@endphp

<tr class="{{ $rowClass }} {{ $borderClass }} align-middle">
    {{-- 1. TERTIP NUMERI (#) --}}
    <td class="ps-4 py-3 text-center" style="width: 50px;">
        <span class="badge bg-dark text-info border border-info border-opacity-25 rounded-pill px-2 py-1" style="font-size: 10px;">
            #{{ $rowNumber }}
        </span>
    </td>

    {{-- 2. ULANYJY / IP --}}
    <td class="py-3" style="min-width: 160px;">
        <div class="d-flex align-items-center position-relative {{ $isOnline ? 'ps-3' : '' }}">
            @if($isOnline)
            <div class="status-dot-pulse position-absolute start-0" title="Häzir onlaýn" style="flex-shrink: 0;"></div>
            @endif
            <div class="d-flex flex-column">
                <div class="d-flex align-items-center gap-1">
                    <span class="text-white fw-bold small">
                        {{ $activity->ip_address }}
                    </span>
                    @if($level !== 'info')
                    <i class="bi bi-exclamation-triangle-fill {{ $statusColor }}" style="font-size: 11px;" title="Şübheli Hereket"></i>
                    @endif
                </div>
                <span class="text-white-50 fw-light" style="font-size: 10px;">
                    <i class="bi bi-person me-1 text-info"></i> {{ $activity->user->name ?? 'Guest User' }}
                </span>
            </div>
        </div>
    </td>

    {{-- 3. OS (Operasion Ulgam) --}}
    <td class="py-3 text-center" style="width: 70px;">
        <div class="bg-dark bg-opacity-25 rounded-3 p-2 d-inline-block border border-white border-opacity-10" title="Operasion Ulgam">
            <i class="bi {{ $osIcon }} fs-5"></i>
        </div>
    </td>

    {{-- 4. ENJAM --}}
    <td class="py-3 text-center" style="width: 80px;">
        <div class="bg-dark bg-opacity-25 rounded-3 p-2 d-inline-block border border-white border-opacity-10" title="Enjam">
            <i class="bi {{ $deviceIcon }} fs-6"></i>
        </div>
    </td>

    {{-- 5. BRAUZER --}}
    <td class="py-3 text-center" style="width: 80px;">
        <div class="bg-dark bg-opacity-25 rounded-3 p-2 d-inline-block border border-white border-opacity-10" title="Brauzer">
            <i class="bi {{ $browserIcon }} fs-6"></i>
        </div>
    </td>

    {{-- 6. GIREN SAHPASY --}}
    <td class="py-3" style="min-width: 220px;">
        <div class="d-flex flex-column">
            <div class="d-flex align-items-center flex-wrap gap-1">
                <span class="badge {{ $methodBadge }}" style="font-size: 9px; letter-spacing: 0.5px;">
                    {{ $method }}
                </span>

                <span class="badge {{ $statusCode >= 400 ? 'bg-danger text-white' : 'bg-success bg-opacity-20 text-white' }}" style="font-size: 9px;">
                    {{ $statusCode }}
                </span>

                <code class="text-white-50 small ms-1">
                    {{ Str::limit(str_replace(url('/'), '', $activity->url ?? ''), 35) ?: '/' }}
                </code>
            </div>
            @if(!empty($activity->error_message))
            <span class="text-danger mt-1 fw-medium" style="font-size: 10px;">
                <i class="bi bi-bug-fill me-1"></i>{{ Str::limit($activity->error_message, 45) }}
            </span>
            @endif
        </div>
    </td>

    {{-- 7. WAGTY --}}
    <td class="pe-4 py-3 text-end" style="min-width: 110px;">
        <div class="d-flex flex-column align-items-end">
            <span class="text-white fw-medium small mb-1">
                @if($activity->updated_at && $activity->updated_at->isToday())
                {{ $activity->updated_at->format('H:i:s') }}
                @elseif($activity->updated_at)
                {{ $activity->updated_at->format('d M H:i') }}
                @else
                ---
                @endif
            </span>
            <a href="{{ route('admin.activities.show', $activity->id) }}"
                class="btn btn-sm btn-link text-info text-decoration-none p-0 fw-bold hover-translate-x"
                style="font-size: 10px; letter-spacing: 1px;">
                DETAILS <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </td>
</tr>
@endforeach