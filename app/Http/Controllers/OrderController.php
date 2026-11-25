<?php

namespace App\Http\Controllers;

use App\Mail\OrderAccepted;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Jobs\SendTelegramOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Checkout sahypasyny görkezmek
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        $count = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
            $count += $item['quantity'];
        }

        return view('app.checkout', compact('cart', 'total', 'count'));
    }

    /**
     * Admin panel üçin sargytlaryň sanawy
     */
    public function index()
    {
        if (!auth()->user()->hasPermission('view-dashboard')) {
            abort(403, 'Sizde sargytlary görmäge rugsat ýok!');
        }

        $orders = Order::latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Täze sargyt döretmek
     */
    public function store(Request $request)
    {
        // 1. Formanyň bar bolan maglumatlaryny barlaýarys
        $request->validate([
            'customer_name'        => 'required|string|max:255',
            'customer_phone'       => 'required|string|max:20',
            'customer_email'       => 'nullable|email|max:255',
            'g-recaptcha-response' => 'required',
            'terms_accepted'       => 'required|accepted',
        ], [
            'terms_accepted.accepted' => 'Sargydyňyzy tassyklamak üçin Hyzmat Şertlerini we Gizlinlik Syýasatyny kabul etmelisiniz!'
        ]);

        // 2. Google reCAPTCHA v3 Safe-Timeout Barlagy
        if ($request->has('g-recaptcha-response')) {
            try {
                $response = Http::withoutVerifying()
                    ->timeout(3) // Maximum 3 sekunt garaşýar
                    ->asForm()
                    ->post('https://www.google.com/recaptcha/api/siteverify', [
                        'secret'   => env('RECAPTCHA_SECRET_KEY'),
                        'response' => $request->input('g-recaptcha-response'),
                        'remoteip' => $request->ip(),
                    ]);

                $captchaResult = $response->json();

                // Eger Google-a baglanylan bolsa we bot duzulse
                if ($response->successful() && isset($captchaResult['success'])) {
                    if (!$captchaResult['success'] || (isset($captchaResult['score']) && $captchaResult['score'] < 0.3)) {
                        return response()->json(['status' => 'error', 'message' => 'Howpsuzlyk barlagyndan geçmediňiz (Bot?).'], 403);
                    }
                }
            } catch (\Exception $e) {
                // Local Serwerde VPN ýok wagty cURL Timeout bersede, saýt çökmez we sargyt dowam eder!
                Log::warning("reCAPTCHA Barlagyna baglanyp bolmady: " . $e->getMessage());
            }
        }

        $cartItems = session()->get('cart', []);

        if (empty($cartItems)) {
            return response()->json(['status' => 'error', 'message' => 'Sebediňiz boş!'], 400);
        }

        // TMT Hasaplamasy
        $total_usd = 0;
        foreach ($cartItems as $item) {
            $total_usd += (float)$item['price'] * (int)$item['quantity'];
        }
        $total_tmt = $total_usd * 20;

        $customerToken = $request->cookie('customer_token') ?? Str::random(40);
        $orderNumber = 'NED-' . date('Ymd') . '-' . strtoupper(Str::random(6));

        // 3. Bazada sargyt döretmek
        $order = DB::transaction(function () use ($request, $cartItems, $total_tmt, $customerToken, $orderNumber) {
            $order = Order::create([
                'order_number'   => $orderNumber,
                'customer_token' => $customerToken,
                'customer_name'  => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'address'        => $request->customer_address,
                'total_price'    => $total_tmt,
                'status'         => 'pending',
                'items'          => $cartItems,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item['id'],
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                ]);
            }
            return $order;
        });

        if ($order) {
            // Telegram Bildiriş Ugradyjysy
            SendTelegramOrderNotification::dispatchSync($order->toArray(), $cartItems);

            // Sessiýany sazlamak
            session()->put('last_order', [
                'order_number' => $order->order_number,
                'items'        => $cartItems,
                'total_price'  => $total_tmt
            ]);

            session()->save();
            session()->forget('cart');

            return response()->json([
                'status' => 'success',
                'order_number' => $order->order_number,
            ])->cookie('customer_token', $customerToken, 43200);
        }

        return response()->json(['status' => 'error', 'message' => 'Sargyt döredilmedi.'], 500);
    }

    /**
     * Admin panelden sargyt ýagdaýyny üýtgetmek
     */
    public function updateStatus(Request $request, $id)
    {
        if (!auth()->user()->hasPermission('manage-orders')) {
            abort(403, 'Sizde sargyt statusyny üýtgetmäge rugsat ýok!');
        }

        $order = Order::findOrFail($id);
        $oldStatus = strtolower($order->status);
        $newStatus = strtolower($request->status);

        // AMMAR LOGIKASY (Inventory Management)
        if ($oldStatus === 'pending' && in_array($newStatus, ['accepted', 'shipped'])) {
            $cartItems = $order->items;
            if (is_array($cartItems)) {
                foreach ($cartItems as $item) {
                    $productId = $item['id'] ?? $item['product_id'] ?? null;
                    if ($productId) {
                        $product = Product::find($productId);
                        if ($product) {
                            $qty = intval($item['quantity'] ?? 1);
                            $product->decrement('stock_quantity', $qty);
                        }
                    }
                }
            }

            // EMAIL BILDIRIŞI
            try {
                if ($order->customer_email) {
                    Mail::to($order->customer_email)->send(new OrderAccepted($order));
                }
            } catch (\Exception $e) {
                Log::error("Email ugradylanda hata: " . $e->getMessage());
            }
        }

        $order->status = $newStatus;
        $order->save();

        $statusMessages = [
            'accepted'  => 'Sargyt kabul edildi we müşderä habar ugradyldy!',
            'shipped'   => 'Sargyt ýola ugradyldy (Kargo)!',
            'completed' => 'Sargyt üstünlikli gowşuryldy!',
            'cancelled' => 'Sargyt ýatyryldy (Atkaz edildi).',
            'pending'   => 'Sargyt garaşylýan ýagdaýa geçirildi.',
        ];

        $msg = $statusMessages[$newStatus] ?? 'Sargyt ýagdaýy üýtgedildi.';

        return back()->with('success', $msg);
    }

    /**
     * Real-time Toast bildirişi üçin barlag
     */
    public function checkNewOrders()
    {
        if (!auth()->user()->hasPermission('view-dashboard')) {
            return response()->json(['has_new' => false], 403);
        }

        $newOrder = Order::where('created_at', '>=', now()->subMinutes(2))
            ->where('is_notified', false)
            ->first();

        if ($newOrder) {
            $newOrder->update(['is_notified' => true]);

            return response()->json([
                'has_new' => true,
                'order_no' => $newOrder->order_number,
                'customer' => $newOrder->customer_name,
                'amount' => $newOrder->total_price
            ]);
        }

        return response()->json(['has_new' => false]);
    }

    /**
     * Müşderiniň öz sargytlaryny görmegi
     */
    public function myOrders(Request $request)
    {
        $token = $request->cookie('customer_token');

        if (!$token) {
            $orders = collect();
        } else {
            $orders = Order::where('customer_token', $token)->latest()->get();
        }

        return view('app.my-orders', compact('orders'));
    }

    public function contact()
    {
        return view('app.contact');
    }

    /**
     * Sargyt üstünlikli giden sahypasy
     */
    public function success(Request $request)
    {
        $orderData = session('last_order');
        $orderNo = $request->query('order_number');

        if (!$orderData && $orderNo) {
            $order = Order::where('order_number', $orderNo)->first();

            if ($order) {
                $items = is_array($order->items) ? $order->items : json_decode($order->items, true);

                $orderData = [
                    'order_number' => $order->order_number,
                    'items'        => $items ?? [],
                    'total_price'  => $order->total_price,
                    'status'       => $order->status
                ];
            }
        }

        $token = $request->cookie('customer_token');
        $myOrders = $token ? Order::where('customer_token', $token)->latest()->get() : collect();

        return view('pages.success', [
            'orderData' => $orderData,
            'myOrders'  => $myOrders
        ]);
    }

    /**
     * Sargytlary möhletine görä köpçülikleýin pozmak
     */
    public function clearOldOrders(Request $request)
    {
        if (!auth()->user()->hasPermission('manage-orders')) {
            abort(403, 'Sizde sargytlary pozmana rugsat ýok!');
        }

        $days = $request->input('days');

        $query = Order::query();

        if ($days === '3') {
            $query->where('created_at', '<=', now()->subDays(3));
            $msg = '3 gün we ondan öňki sargytlar üstünlikli pozuldy!';
        } elseif ($days === '7') {
            $query->where('created_at', '<=', now()->subDays(7));
            $msg = '7 gün we ondan öňki sargytlar üstünlikli pozuldy!';
        } elseif ($days === '30') {
            $query->where('created_at', '<=', now()->subDays(30));
            $msg = '30 gün we ondan öňki sargytlar üstünlikli pozuldy!';
        } elseif ($days === 'all') {
            $msg = 'Ähli sargytlar üstünlikli pozuldy!';
        } else {
            return back()->with('error', 'Nädogry möhlet saýlandy!');
        }

        $orderIds = $query->pluck('id');

        if ($orderIds->isEmpty()) {
            return back()->with('info', 'Saýlanan möhlete gabat gelýän pozulasy sargyt tapylmady.');
        }

        DB::transaction(function () use ($orderIds) {
            OrderItem::whereIn('order_id', $orderIds)->delete();
            Order::whereIn('id', $orderIds)->delete();
        });

        return back()->with('success', $msg);
    }
}
