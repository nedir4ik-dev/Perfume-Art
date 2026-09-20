<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TickerController extends Controller
{
    public function index()
    {
        $tickerStatus = DB::table('settings')->where('key', 'ticker_active')->value('value');
        $tickers = Ticker::latest()->get();

        return view('admin.tickers.index', compact('tickers', 'tickerStatus'));
    }

    public function toggleGlobal(Request $request)
    {
        $status = $request->status;

        DB::table('settings')
            ->where('key', 'ticker_active')
            ->update(['value' => $status]);

        DB::table('tickers')->update(['is_active' => (int)$status]);

        return back()->with('success', 'Ulgam doly täzelendi!');
    }

    /**
     * Täze 3 dilli Ticker goşýar (Optimizirlendi)
     */
    public function store(Request $request)
    {
        $request->validate([
            'content_tm' => 'required|string|max:255',
            'content_ru' => 'nullable|string|max:255',
            'content_en' => 'nullable|string|max:255',
            'icon'       => 'required|string|max:100',
            'color'      => 'nullable|string|max:100',
        ]);

        // Ygtybarly ýazgy döretmek
        $ticker = new Ticker();
        $ticker->content_tm = $request->content_tm;
        $ticker->content_ru = $request->content_ru;
        $ticker->content_en = $request->content_en;
        $ticker->icon       = $request->icon;
        $ticker->color      = $request->color ?? 'text-info';
        $ticker->is_active  = $request->has('is_active') ? 1 : 1;
        $ticker->save();

        return back()->with('success', 'Habar akymy (Ticker) üstünlikli goşuldy!');
    }

    public function destroy(Ticker $ticker)
    {
        $ticker->delete();
        return back()->with('success', 'Pozuldy!');
    }
}
