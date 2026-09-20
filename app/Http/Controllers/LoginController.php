<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; // Google API-e sorag ugratmak üçin gerek

class LoginController extends Controller
{
    public function index()
    {
        $productCount = Product::count();
        return view('admin.dashboard', compact('productCount'));
    }

    public function login(Request $request)
    {
        // 1. Honeypot barlagy (Seniň öňki goýan goragyň)
        if ($request->filled('honeypot')) {
            return abort(403, 'Bot detected!');
        }

        // 2. Google reCAPTCHA v3 Barlagy
        $recaptchaResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        $recaptchaData = $recaptchaResponse->json();

        if (!$recaptchaData['success'] || $recaptchaData['score'] < 0.5) {
            return back()->withErrors([
                'captcha' => 'Howpsuzlyk barlagyndan geçmediňiz. Gaýtadan synanyşyň.',
            ])->onlyInput('username');
        }

        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, true)) {
            $request->session()->regenerate();

            if (Auth::user()->is_admin) {
                return redirect('/admin/dashboard');
            }

            return redirect()->route('home');
        }

        return back()->withErrors([
            'username' => 'Giris ustunlikli däl. Username yada password ýalňyş bolup biler.',
        ])->onlyInput('username');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
