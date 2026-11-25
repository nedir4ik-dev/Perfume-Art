<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{
    public function index()
    {
        $advertisements = Advertisement::latest()->get();
        return view('admin.advertisements.index', compact('advertisements'));
    }

    public function create()
    {
        return view('admin.advertisements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_tm' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $ad = new Advertisement();

        $ad->title_tm = $request->title_tm;
        $ad->title_ru = $request->title_ru;
        $ad->title_en = $request->title_en;

        $ad->badge_tm = $request->badge_tm;
        $ad->badge_ru = $request->badge_ru;
        $ad->badge_en = $request->badge_en;

        $ad->description_tm = $request->description_tm;
        $ad->description_ru = $request->description_ru;
        $ad->description_en = $request->description_en;

        $ad->link = $request->link;
        $ad->seconds = $request->seconds ?? 5;
        $ad->is_active = $request->has('is_active');

        if ($request->hasFile('image')) {
            $ad->image = $request->file('image')->store('ads', 'public');
        }

        $ad->save();

        return redirect(url('/admin/ads'))->with('success', 'Täze mahabat üstünlikli goşuldy!');
    }

    public function edit($id)
    {
        $ad = Advertisement::findOrFail($id);
        return view('admin.advertisements.edit', compact('ad'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title_tm' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $ad = Advertisement::findOrFail($id);

        $ad->title_tm = $request->title_tm;
        $ad->title_ru = $request->title_ru;
        $ad->title_en = $request->title_en;

        $ad->badge_tm = $request->badge_tm;
        $ad->badge_ru = $request->badge_ru;
        $ad->badge_en = $request->badge_en;

        $ad->description_tm = $request->description_tm;
        $ad->description_ru = $request->description_ru;
        $ad->description_en = $request->description_en;

        $ad->link = $request->link;
        $ad->seconds = $request->seconds ?? 5;
        $ad->is_active = $request->has('is_active');

        if ($request->hasFile('image')) {
            if ($ad->image && Storage::disk('public')->exists($ad->image)) {
                Storage::disk('public')->delete($ad->image);
            }
            $ad->image = $request->file('image')->store('ads', 'public');
        }

        $ad->save();

        return redirect(url('/admin/ads'))->with('success', 'Mahabat maglumaty täzelendi!');
    }

    public function destroy($id)
    {
        $ad = Advertisement::findOrFail($id);

        if ($ad->image && Storage::disk('public')->exists($ad->image)) {
            Storage::disk('public')->delete($ad->image);
        }

        $ad->delete();
        return back()->with('success', 'Mahabat doly pozuldy!');
    }
}
