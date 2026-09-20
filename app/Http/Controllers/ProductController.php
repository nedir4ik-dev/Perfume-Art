<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SearchLog;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function liveSearch(Request $request)
    {
        $term = trim($request->query('term'));

        if (empty($term)) {
            return response()->json([]);
        }

        // Diňe kerekli meýdanlary alýarys (çalt işlemesi üçin)
        $products = Product::where('name', 'LIKE', "%{$term}%")
            ->orWhere('description', 'LIKE', "%{$term}%")
            ->select('id', 'name', 'slug')
            ->latest()
            ->limit(7) // Dropdown-a sypmar ýaly maksimum 7 sany görkezýäris
            ->get();

        // Gözleg logyny ýazýarys
        SearchLog::create([
            'query' => $term,
            'results_count' => $products->count()
        ]);

        return response()->json($products);
    }

    /**
     * Umumy haryt gözleg funksiýasy (Dükanyň esasy sahypalary üçin)
     */
    public function search(Request $request)
    {
        $term = trim($request->query('term'));

        if (empty($term)) {
            return response()->json([]);
        }

        $products = Product::where('name', 'LIKE', "%{$term}%")
            ->orWhere('description', 'LIKE', "%{$term}%")
            ->orWhere('gender', 'LIKE', "%{$term}%")
            ->with(['brand', 'category'])
            ->latest()
            ->get();

        // Gözleg taryhyny loglaýarys
        SearchLog::create([
            'query' => $term,
            'results_count' => $products->count()
        ]);

        return response()->json($products);
    }

    /**
     * Haryt maglumat sahypasy
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->with(['brand', 'category'])->firstOrFail();

        // Meňzeş harytlar: Şol bir brendden bolan başga 4 sany tötänleýin haryt
        $relatedProducts = Product::where('brand_id', $product->brand_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('pages.show', compact('product', 'relatedProducts'));
    }

    // --- PANEL / ADMIN BÖLÜMLERI (Goragly) ---

    /**
     * Admin Panel: Harytlaryň sanawy
     */
    public function index(Request $request)
    {
        if (!auth()->user()->hasPermission('manage-products') && !auth()->user()->hasPermission('view-dashboard')) {
            abort(403, 'Sizde harytlary görmäge rugsat ýok!');
        }

        $products = Product::query()
            ->with(['brand', 'category'])
            ->when($request->category_id, fn($q, $id) => $q->where('category_id', $id)) // brand_id ýerine category_id barlagy
            ->when($request->min_price, fn($q, $min) => $q->where('price', '>=', $min))
            ->when($request->max_price, fn($q, $max) => $q->where('price', '<=', $max))
            ->when($request->search, function ($q, $s) {
                $q->where(function ($sub) use ($s) {
                    $sub->where('name', 'LIKE', "%{$s}%")
                        ->orWhere('description', 'LIKE', "%{$s}%");
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::all(); // 👈 Kategoriýalary bazadan alýarys
        $brands = Brand::all();

        return view("admin.products.index", compact('products', 'categories', 'brands')); // 👈 compact-a 'categories' goşduk
    }

    /**
     * Täze haryt goşmak sahypasy
     */
    public function create()
    {
        if (!auth()->user()->hasPermission('manage-products')) {
            abort(403, 'Sizde täze haryt goşmaga rugsat ýok!');
        }

        $brands = Brand::where('is_active', true)->get();
        $categories = Category::all();
        return view('admin.products.create', compact('brands', 'categories'));
    }

    /**
     * Täze harydy maglumat bazasyna ýazmak
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermission('manage-products')) {
            abort(403);
        }

        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'price'               => 'required|numeric',
            'discount_percent'    => 'nullable|integer|min:0|max:99',
            'discount_expires_at' => 'nullable|date|after:now',
            'ml_size'             => 'required',
            'brand_id'            => 'required|exists:brands,id',
            'category_id'         => 'required|exists:categories,id',
            'image'               => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description'         => 'nullable|string',
            'gender'              => 'nullable|string',
            'stock_quantity'      => 'required|integer|min:0',
            'scent_notes'         => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('perfumes', 'public');
            $validated['image'] = $path;
        }

        $validated['discount_percent'] = $request->input('discount_percent', 0) ?? 0;
        $validated['slug'] = Str::slug($request->name) . '-' . time();
        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Haryt üstünlikli goşuldy!');
    }

    /**
     * Haryt redaktirlemek sahypasy
     */
    public function edit($id)
    {
        if (!auth()->user()->hasPermission('manage-products')) {
            abort(403);
        }

        $product = Product::findOrFail($id);
        $brands = Brand::all();
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'brands', 'categories'));
    }

    /**
     * Haryt maglumatlaryny täzelemek funksiýasy
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->hasPermission('manage-products')) {
            abort(403);
        }

        $product = Product::findOrFail($id);
        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'price'               => 'required|numeric|min:0',
            'discount_percent'    => 'nullable|integer|min:0|max:99',
            'discount_expires_at' => 'nullable|date|after:now',
            'ml_size'             => 'required|integer|min:1',
            'brand_id'            => 'required|exists:brands,id',
            'category_id'         => 'required|exists:categories,id',
            'description'         => 'nullable|string',
            'gender'              => 'required|in:Men,Women,Unisex',
            'stock_quantity'      => 'nullable|integer|min:0',
            'image'               => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'scent_notes'         => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('perfumes', 'public');
            $validated['image'] = $path;
        }

        $validated['discount_percent'] = $request->input('discount_percent', 0) ?? 0;

        if ($validated['discount_percent'] == 0) {
            $validated['discount_expires_at'] = null;
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['slug'] = Str::slug($request->name) . '-' . $product->id;

        $product->update($validated);
        return redirect()->route('admin.products.index')->with('success', 'Haryt kämilleşdirildi.');
    }

    /**
     * Kämilleşdirilen haryt pozmak funksiýasy (SoftDeletes + AJAX Uyumly)
     */
    public function destroy($id)
    {
        if (!auth()->user()->hasPermission('manage-products')) {
            return response()->json([
                'success' => false,
                'message' => 'Sizde haryt pozmaga rugsat ýok!'
            ], 403);
        }

        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Haryt üstünlikli zibil gutusyna taşlandy! 🗑️'
        ], 200);
    }

    // --- SEBET WE CHECKOUT ULGAMY ---

    /**
     * Sebede haryt goşmak
     */
    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $cart = session()->get('cart', []);

        $finalPrice = $product->price;
        if ($product->discount_percent > 0 && (!$product->discount_expires_at || $product->discount_expires_at->isFuture())) {
            $finalPrice = $product->price - ($product->price * ($product->discount_percent / 100));
        }

        if (isset($cart[$request->id])) {
            $cart[$request->id]['quantity']++;
        } else {
            $cart[$request->id] = [
                "id"       => $product->id,
                "name"     => $product->name,
                "quantity" => 1,
                "price"    => $finalPrice,
                "image"    => asset('storage/' . $product->image)
            ];
        }

        session()->put('cart', $cart);
        return response()->json($this->getCartStats());
    }

    /**
     * Sebetdäki haryt sanyny täzelemek
     */
    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->id])) {
            $cart[$request->id]['quantity'] += $request->delta;

            if ($cart[$request->id]['quantity'] <= 0) {
                unset($cart[$request->id]);
            }
            session()->put('cart', $cart);
        }

        return response()->json($this->getCartStats());
    }

    /**
     * Harydy sebetden doly aýyrmak
     */
    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
        }
        return response()->json($this->getCartStats());
    }

    /**
     * Häzirki sebet maglumatlaryny getirýär
     */
    public function getCartData()
    {
        return response()->json($this->getCartStats());
    }

    /**
     * Sebet statistikalaryny hasaplaýan kömekçi metod
     */
    private function getCartStats()
    {
        $cart = session()->get('cart', []);
        $total_usd = 0;
        $count = 0;

        foreach ($cart as $item) {
            $total_usd += (float)$item['price'] * (int)$item['quantity'];
            $count += (int)$item['quantity'];
        }

        $exchange_rate = (float) Setting::where('key', 'exchange_rate')->value('value') ?: 20;
        $total_tmt = $total_usd * $exchange_rate;

        if ($total_tmt >= 5000) {
            $delivery_fee = 0;
            $delivery_msg = "Gulluk mugt! ✅";
        } elseif ($total_tmt >= 4000) {
            $diff_tmt = 5000 - $total_tmt;
            $diff_usd = $diff_tmt / $exchange_rate;
            $delivery_fee = 20;
            $delivery_msg = "Mugt eltip bermek üçin ýene " . $diff_tmt . " TMT ($" . number_format($diff_usd, 2) . ") haryt goşuň.";
        } else {
            $diff_tmt = 4000 - $total_tmt;
            $diff_usd = $diff_tmt / $exchange_rate;
            $delivery_fee = 50;
            $delivery_msg = "Eltip berme 20 TMT bolmagy üçin ýene " . $diff_tmt . " TMT ($" . number_format($diff_usd, 2) . ") haryt goşuň.";
        }

        return [
            'items'        => $cart,
            'total'        => $total_usd,
            'total_usd'    => (float)$total_usd,
            'total_tmt'    => $total_tmt,
            'delivery_fee' => (float)$delivery_fee,
            'delivery_msg' => $delivery_msg,
            'grand_total'  => (float)($total_tmt + $delivery_fee),
            'count'        => (int)$count
        ];
    }

    /**
     * Sargydy tamamlamak (Checkout) sahypasy
     */
    public function checkout()
    {
        $stats = $this->getCartStats();

        if (!isset($stats['count']) || $stats['count'] <= 0) {
            return redirect()->route('home')->with('warning', 'Sebediňiz boş!');
        }

        return view('app.checkout', [
            'count'        => (int) $stats['count'],
            'total_tmt'    => (float) $stats['total_tmt'],
            'delivery_fee' => (float) $stats['delivery_fee'],
            'delivery_msg' => $stats['delivery_msg'],
            'grand_total'  => (float) $stats['grand_total'],
            'total_usd'    => (float) $stats['total_usd'],
            'items'        => $stats['items']
        ]);
    }

    // --- ZIBIL GUTUSY ULGAMY (SoftDeletes Dowamy) ---

    /**
     * Zibil gutusyndaky (öçürilen) harytlaryň sanawy
     */
    public function trash()
    {
        if (!auth()->user()->hasPermission('manage-products')) {
            abort(403, 'Sizde zibil gutusyny görmäge rugsat ýok!');
        }

        $products = Product::onlyTrashed()->with(['brand', 'category'])->latest()->paginate(12);

        return view('admin.products.trash', compact('products'));
    }

    public function restore($id)
    {
        if (!auth()->user()->hasPermission('manage-products')) {
            abort(403, 'Sizde harydy yzyna getirmäge rugsat ýok!');
        }

        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('admin.products.index')->with('success', 'Haryt üstünlikli dükana yzyna getirildi! 🔄');
    }

    /**
     * Harydy maglumat bazasyndan we diskden hemişelik pozmak (Force Delete)
     */
    public function forceDelete($id)
    {
        if (!auth()->user()->hasPermission('manage-products')) {
            abort(403, 'Sizde harydy hemişelik pozmaga rugsat ýok!');
        }

        $product = Product::onlyTrashed()->findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->forceDelete();

        return redirect()->route('admin.products.trash')->with('success', 'Haryt maglumat bazasyndan hemişelik pozuldy! ❌');
    }
}
