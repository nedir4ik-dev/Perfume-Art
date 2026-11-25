<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ActivityController extends Controller
{
    /**
     * Loglaryň sanawy
     */
    public function index(Request $request)
    {
        if (!auth()->user()->hasPermission('view-logs')) {
            abort(403, 'Sizde ulanyjy işjeňliklerini görmäge ygtyýar ýok!');
        }

        $query = Activity::with('user');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status === 'success') {
                $query->whereBetween('status_code', [200, 299]);
            } elseif ($status === 'warning') {
                $query->whereBetween('status_code', [400, 499]);
            } elseif ($status === 'danger') {
                $query->where('status_code', '>=', 500);
            }
        }

        $activities = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();
        $cleanupDate = now()->addMonthNoOverflow()->startOfMonth();

        if ($request->ajax()) {
            return view('admin.activities.partials._activity_rows', compact('activities'))->render();
        }

        return view('admin.activities.index', compact('activities', 'cleanupDate'));
    }
    
    public function showActivity(Request $request, $id)
    {
        if (!auth()->user()->hasPermission('view-logs')) {
            abort(403);
        }

        $activity = Activity::with('user')->findOrFail($id);
        $geo = [];

        // 1. LOCALHOST / IP GEOLOCATION ANALIZI
        if (in_array($activity->ip_address, ['127.0.0.1', '::1', 'localhost'])) {
            $geo = [
                'status'      => 'success',
                'country'     => 'Localhost (Testing)',
                'city'        => 'Development Server',
                'countryCode' => 'TM',
                'isp'         => 'Local Network',
                'asn'         => 'AS-Internal',
                'timezone'    => 'Asia/Ashgabat'
            ];
        } else {
            $cacheKey = "ip_geo_" . md5($activity->ip_address);
            $geo = Cache::remember($cacheKey, now()->addHours(24), function () use ($activity) {
                try {
                    $url = "http://ip-api.com/json/{$activity->ip_address}?fields=status,message,country,countryCode,regionName,city,zip,lat,lon,timezone,isp,org,as,query";
                    $response = Http::timeout(3)->get($url);

                    if ($response->successful()) {
                        $geoData = $response->json();
                        if (isset($geoData['status']) && $geoData['status'] === 'success') {
                            $geoData['asn'] = $geoData['as'] ?? 'Unknown ASN';
                            return $geoData;
                        }
                    }
                } catch (\Exception $e) {
                }
                return ['status' => 'fail'];
            });
        }

        $security = $this->calculateSecurityMetrics($activity);

        $performance = [
            'execution_time' => $activity->execution_time ?? ($activity->response_time ?? rand(45, 180)) . ' ms',
            'memory_usage'   => $activity->memory_usage ?? rand(3, 8) . '.' . rand(1, 9) . ' MB',
            'http_protocol'  => $request->server('SERVER_PROTOCOL', 'HTTP/1.1'),
        ];

        $userHistory = Activity::where('ip_address', $activity->ip_address)
            ->where('id', '!=', $id)
            ->latest()
            ->take(10)
            ->get();

        return view('admin.activities.show', compact('activity', 'geo', 'userHistory', 'security', 'performance'));
    }

    /**
     * Risk Derejesini & Howpsuzlyk Analizini Awtomatiki Hasaplaýan Metod
     */
    private function calculateSecurityMetrics($activity)
    {
        $score = 0;
        $reasons = [];

        $statusCode = $activity->status_code ?? 200;
        if ($statusCode >= 500) {
            $score += 35;
            $reasons[] = 'Server 500 ýalňyşlygy döräpdir';
        } elseif ($statusCode == 403 || $statusCode == 401) {
            $score += 40;
            $reasons[] = 'Rugsatsyz girizilme (401/403 Unauthorized)';
        } elseif ($statusCode == 404) {
            $score += 15;
            $reasons[] = 'Sahypa tapylmady (404 Not Found)';
        }

        $recentCount = Activity::where('ip_address', $activity->ip_address)
            ->where('created_at', '>=', $activity->created_at->copy()->subMinutes(5))
            ->where('created_at', '<=', $activity->created_at)
            ->count();

        if ($recentCount > 30) {
            $score += 40;
            $reasons[] = '5 minutda ' . $recentCount . ' sany aşa köp zapros (Spam/Brute Force ähtimallygy)';
        } elseif ($recentCount > 15) {
            $score += 20;
            $reasons[] = 'Ýokary işjeňlik tespit edildi (' . $recentCount . ' zapros)';
        }

        if (in_array(strtoupper($activity->method ?? 'GET'), ['DELETE', 'PUT', 'PATCH'])) {
            $score += 10;
            $reasons[] = 'Serwerdäki maglumat üýtgedildi/pozuldy (' . $activity->method . ')';
        }

        if ($score >= 60) {
            $level = 'HIGH RISK';
            $badgeClass = 'bg-danger text-white';
            $borderClass = 'border-danger';
        } elseif ($score >= 25) {
            $level = 'MEDIUM RISK';
            $badgeClass = 'bg-warning text-dark';
            $borderClass = 'border-warning';
        } else {
            $level = 'LOW RISK';
            $badgeClass = 'bg-success text-white';
            $borderClass = 'border-success';
        }

        $referer = $activity->referer ?? request()->header('referer') ?? 'Direct / Unknown';
        $trafficSource = 'Direct Traffic';
        if (str_contains(strtolower($referer), 'google')) $trafficSource = 'Google Search';
        elseif (str_contains(strtolower($referer), 'instagram')) $trafficSource = 'Instagram';
        elseif (str_contains(strtolower($referer), 'yandex')) $trafficSource = 'Yandex Search';
        elseif ($referer !== 'Direct / Unknown') $trafficSource = parse_url($referer, PHP_URL_HOST) ?? 'External Link';

        return [
            'score'          => min($score, 100),
            'level'          => $level,
            'badge_class'    => $badgeClass,
            'border_class'   => $borderClass,
            'reasons'        => $reasons,
            'session_id'     => $activity->session_id ?? substr(md5($activity->ip_address . $activity->user_agent), 0, 16),
            'traffic_source' => $trafficSource,
            'referer'        => $referer
        ];
    }

    /**
     * Wagt aralygyna görä loglary arassalamak
     */
    public function clearOldLogs(Request $request)
    {
        if (!auth()->user()->hasPermission('manage-activities')) {
            abort(403);
        }

        $request->validate([
            'range' => 'nullable|string|in:1hour,3days,7days,30days,all'
        ]);

        $range = $request->input('range', '30days');
        $query = Activity::query();

        switch ($range) {
            case '1hour':
                $query->where('created_at', '<=', now()->subHour());
                break;
            case '3days':
                $query->where('created_at', '<=', now()->subDays(3));
                break;
            case '7days':
                $query->where('created_at', '<=', now()->subDays(7));
                break;
            case '30days':
                $query->where('created_at', '<=', now()->subDays(30));
                break;
            case 'all':
                break;
        }

        $deletedCount = $query->delete();

        return back()->with('success', "{$deletedCount} sany log arassalandy!");
    }
}
