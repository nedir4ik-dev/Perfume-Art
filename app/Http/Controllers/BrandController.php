<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest()->get();
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:brands,name|max:255',
            'name_tm' => 'nullable|string|max:255', // Täze
            'name_ru' => 'nullable|string|max:255', // Täze
            'logo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $logoPath = null;
        if ($request->hasFile('logo_url')) {
            $logoPath = $request->file('logo_url')->store('brands', 'public');
        }

        Brand::create([
            'name' => $request->name,
            'name_tm' => $request->name_tm, // Bazada NULL bolmaz ýaly
            'name_ru' => $request->name_ru, // Bazada NULL bolmaz ýaly
            'slug' => Str::slug($request->name),
            'logo_url' => $logoPath,
            'description' => $request->description,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.brands.index')->with('success', 'Brend üstünlikli goşuldy!');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|max:255|unique:brands,name,' . $brand->id,
            'name_tm' => 'nullable|string|max:255', // Täze
            'name_ru' => 'nullable|string|max:255', // Täze
            'logo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('logo_url')) {
            if ($brand->logo_url) {
                Storage::disk('public')->delete($brand->logo_url);
            }
            $brand->logo_url = $request->file('logo_url')->store('brands', 'public');
        }

        $brand->update([
            'name' => $request->name,
            'name_tm' => $request->name_tm,
            'name_ru' => $request->name_ru,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.brands.index')->with('success', 'Brend täzelendi!');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->logo_url) {
            Storage::disk('public')->delete($brand->logo_url);
        }
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', 'Brend pozuldy!');
    }
}
