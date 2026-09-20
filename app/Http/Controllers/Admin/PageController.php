<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    // 1. Ähli sahypalaryň sanawy (Index)
    public function index()
    {
        $pages = Page::orderBy('id', 'desc')->get();
        return view('admin.pages.index', compact('pages'));
    }

    // 2. Täze sahypa döretme ekrany (Create)
    public function create()
    {
        return view('admin.pages.create');
    }

    // 3. Täze sahypany baza ýazmak (Store)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->all();

        // Dynamic sahypalar (about-us, contact) üçin slug-y berkidýäris
        $data['slug'] = Str::slug($request->title);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('pages', 'public');
        }

        Page::create($data);

        return redirect()->route('admin.pages.index')->with('success', 'Sahypa we dizaýn bloklary döredildi!');
    }

    // 4. Sahypany redaktirleme ekrany (Edit)
    public function edit(Page $page)
    {
        // Edit sahypasynda hem vizual redaktory çagyrjak we munuň üçin aýratyn faýl ulanarys
        return view('admin.pages.edit', compact('page'));
    }

    // 5. Sahypany täzelemek (Update)
    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($page->image) {
                Storage::disk('public')->delete($page->image);
            }
            $data['image'] = $request->file('image')->store('pages', 'public');
        }

        $page->update($data);

        return redirect()->route('admin.pages.index')->with('success', 'Dizaýn we mazmun üstünlikli täzelendi!');
    }

    // 6. Sahypany pozmak (Destroy)
    public function destroy(Page $page)
    {
        if ($page->image) {
            Storage::disk('public')->delete($page->image);
        }

        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Sahypa öçürildi!');
    }

    // 7. Ulanyjy Tarapda Sahypany Görkezmek
    public function show($slug)
    {
        $page = Page::where('slug', $slug)->where('is_active', true)->firstOrFail();

        // Eger dizaýnyny üýtgetjek sahypaňyz (about-us, contact) öňden bar bolsa şony açýar,
        // bar bolmasa täze ýasan dynamic arassa şablonymyzy açýar.
        if (view()->exists("pages.{$slug}")) {
            return view("pages.{$slug}", compact('page'));
        }

        return view('pages.cms', compact('page'));
    }
}
