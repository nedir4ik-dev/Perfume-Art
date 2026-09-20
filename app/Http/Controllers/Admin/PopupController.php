<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Popup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PopupController extends Controller
{
    public function index()
    {
        $popups = Popup::latest()->get();
        return view('admin.popups.index', compact('popups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_tm'       => 'nullable|string|max:255',
            'title_ru'       => 'nullable|string|max:255',
            'title_en'       => 'nullable|string|max:255',
            'description_tm' => 'nullable|string',
            'description_ru' => 'nullable|string',
            'description_en' => 'nullable|string',
            'image'          => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link'           => 'nullable|url',
            'seconds'        => 'required|integer|min:1|max:30',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('popups', 'public');
        }

        Popup::create($data);

        return back()->with('success', 'Täze Popup üstünlikli goşuldy!');
    }

    public function toggle(Popup $popup)
    {
        // Bir wagtda diňe 1 sany popup aktiw bolar ýaly, beýlekileri passiw edýäris
        if (!$popup->is_active) {
            Popup::where('id', '!=', $popup->id)->update(['is_active' => false]);
        }

        $popup->update(['is_active' => !$popup->is_active]);

        return back()->with('success', 'Popup statusy üýtgedildi!');
    }

    public function destroy(Popup $popup)
    {
        if ($popup->image) {
            Storage::disk('public')->delete($popup->image);
        }

        $popup->delete();
        return back()->with('success', 'Popup üstünlikli pozuldy!');
    }
}
