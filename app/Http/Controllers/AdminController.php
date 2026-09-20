<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Activity;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SearchLog;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // 1. Rugsat barla
        if (!auth()->user()->hasPermission('view-dashboard')) {
            abort(403, 'BU BÖLÜME GIRMÄGE RUGSADYŇYZ ÝOK!');
        }

        // --- RECAPTCHA BARLAGY (Bazadan dinamiki okamak) ---
        $recaptchaEnabled   = Setting::where('key', 'recaptcha_enabled')->value('value') ?? '0';
        $recaptchaSiteKey   = Setting::where('key', 'recaptcha_site_key')->value('value');
        $recaptchaSecretKey = Setting::where('key', 'recaptcha_secret_key')->value('value');

        // Goragyň hakyky işjeňdigini kesgitlemek
        $isRecaptchaActive = (Setting::where('key', 'recaptcha_enabled')->value('value') == '1'
            && config('services.recaptcha.site_key'));

        // AJAX soraglary (System health we Chart data)
        if ($request->get('action') == 'get_system_health') {
            return response()->json($this->getSystemHealthData());
        }

        if ($request->ajax() || $request->has('range')) {
            return $this->getTrafficData($request->get('range', '7days'));
        }

        // --- STATISTIKA MAGLUMATLARY ---
        $onlineUsers = Activity::where('created_at', '>=', now()->subMinutes(5))
            ->distinct('ip_address')->count();

        $totalTraffic = Activity::count() ?: 1;
        $totalOrders = Order::count();
        $conversionRate = number_format(($totalOrders / $totalTraffic) * 100, 2);

        // Iň köp satylanlar we harytlar
        $topSellingProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_qty'))
            ->with('product')->groupBy('product_id')->orderByDesc('total_qty')->take(5)->get();

        $maxQty = $topSellingProducts->max('total_qty') ?: 1;
        $productCount = Product::count();
        $products = Product::with('category')->latest()->take(5)->get();

        $health = $this->getSystemHealthData();
        $initialChartData = $this->getTrafficData('7days')->getData();

        // Ähli maglumaty View-a ugratmak
        return view('admin.dashboard', array_merge([
            'productCount'        => $productCount,
            'products'            => $products,
            'labels'              => $initialChartData->labels,
            'trafficData'         => $initialChartData->data,
            'onlineUsers'         => $onlineUsers,
            'conversionRate'      => $conversionRate,
            'topSellingProducts'  => $topSellingProducts,
            'maxQty'              => $maxQty,
            'lowStockProducts'    => Product::where('stock_quantity', '<=', 10)->orderBy('stock_quantity', 'asc')->take(10)->get(),
            'criticalStockCount'  => Product::where('stock_quantity', '<=', 5)->count(),
            'isRecaptchaActive'   => $isRecaptchaActive,
        ], $health));
    }

    private function getSystemHealthData()
    {
        $diskFree = disk_free_space("/");
        $diskTotal = disk_total_space("/");
        $diskUsage = round((($diskTotal - $diskFree) / $diskTotal) * 100);

        $start = microtime(true);
        DB::select('SELECT 1');
        $dbLatency = round((microtime(true) - $start) * 1000, 2);

        $ramUsage = 0;
        if (PHP_OS_FAMILY === 'Darwin' || PHP_OS_FAMILY === 'Linux') {
            $free = shell_exec('free -m');
            if ($free) {
                $free = (string)trim($free);
                $free_arr = explode("\n", $free);
                $mem = explode(" ", preg_replace('/\s+/', ' ', $free_arr[1]));
                $ramUsage = round(($mem[2] / $mem[1]) * 100);
            } else {
                $ramUsage = rand(20, 45);
            }
        }

        $cpuUsage = 0;
        if (function_exists('sys_getloadavg')) {
            $load = sys_getloadavg();
            $cpuUsage = $load ? round($load[0] * 10, 1) : rand(5, 12);
        } else {
            $cpuUsage = rand(3, 15);
        }

        return [
            'cpuUsage'  => $cpuUsage,
            'diskUsage' => $diskUsage,
            'dbLatency' => $dbLatency,
            'ramUsage'  => $ramUsage,
        ];
    }

    private function getTrafficData($range)
    {
        $labels = [];
        $data = [];
        $now = Carbon::now('Asia/Ashgabat'); // Türkmenistan wagty

        switch ($range) {
            case '1hour':
                for ($i = 50; $i >= 0; $i -= 10) {
                    $t = $now->copy()->subMinutes($i);
                    $labels[] = $t->format('H:i');
                    $data[] = Activity::whereBetween('created_at', [$t->copy()->subMinutes(10), $t])->count();
                }
                break;
            case '24hours':
                for ($i = 23; $i >= 0; $i--) {
                    $start = $now->copy()->subHours($i)->startOfHour();
                    $end = $now->copy()->subHours($i)->endOfHour();
                    $labels[] = $start->format('H:00');
                    $data[] = Activity::whereBetween('created_at', [$start, $end])->count();
                }
                break;
            case '1month':
                for ($i = 29; $i >= 0; $i--) {
                    $t = $now->copy()->subDays($i);
                    $labels[] = $t->format('d M');
                    $data[] = Activity::whereDate('created_at', $t->toDateString())->count();
                }
                break;
            default: // 7days
                for ($i = 6; $i >= 0; $i--) {
                    $t = $now->copy()->subDays($i);
                    $labels[] = $t->format('D');
                    $data[] = Activity::whereDate('created_at', $t->toDateString())->count();
                }
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'total' => array_sum($data)
        ]);
    }

    public function clearLogs(Request $request)
    {
        $range = $request->get('range');
        $query = Activity::query();
        // Pozulmazdan öň log ýazmak:
        Log::info(auth()->user()->name . " tarapyndan loglar arassalandy. Aralyk: " . $request->get('range'));

        switch ($range) {
            case '1hour':
                $query->where('created_at', '>=', now()->subHour());
                $msg = "Soňky 1 sagadyň loglary pozuldy.";
                break;
            case '3days':
                $query->where('created_at', '<', now()->subDays(3));
                $msg = "3 günden köne bolan ähli loglar pozuldy.";
                break;
            case '7days':
                $query->where('created_at', '<', now()->subDays(7));
                $msg = "7 günden köne bolan ähli loglar pozuldy.";
                break;
            case '30days':
                $query->where('created_at', '<', now()->subDays(30));
                $msg = "1 aýdan köne bolan ähli loglar pozuldy.";
                break;
            case 'all':
                Activity::truncate(); // Ählisini birbada arassalaýar
                return back()->with('success', 'Ähli loglar doly arassalandy!');
            default:
                return back()->with('error', 'Nädogry baha saýlandy.');
        }

        $query->delete();

        return back()->with('success', $msg);
    }
}
