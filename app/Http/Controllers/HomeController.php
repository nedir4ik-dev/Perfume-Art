<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Advertisement;
use App\Models\Ticker;

class HomeController extends Controller
{
    public function index()
    {
        $advertisements = Advertisement::where('is_active', 1)->get();
        $products = Product::with(['brand', 'category'])->paginate(18);
        $tickers = Ticker::where('is_active', true)->get();

        return view('pages.index', compact('products', 'advertisements', 'tickers'));
    }

    public function locale($locale)
    {
        $locale = in_array($locale, ['tm', 'ru', 'en']) ? $locale : 'en';
        session()->put('locale', $locale);

        return redirect()->back();
    }
}
