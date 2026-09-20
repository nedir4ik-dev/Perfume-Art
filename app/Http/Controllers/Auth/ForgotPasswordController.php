<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    protected function validateEmail(Request $request)
    {
        // 1. Gelen maglumaty barlayarys
        $findUser = User::where('email', $request->email)->first();

        // 2. DEBUG: Eger tapmasa, näme üçin tapmadygyny ekrana çykaryp duruzarys
        if (!$findUser) {
            dd([
                'Ýazylan Email' => $request->email,
                'Baza Ady' => DB::connection()->getDatabaseName(),
                'Bazadaky Ulanyjylar' => User::select('id', 'username', 'email')->get()->toArray(),
                'Habar' => 'Eger bu sanawda seniň emailiň bar bolsa-da tapmasa, diýmek credentials päsgel berýärdi.'
            ]);
        }

        $request->validate(['email' => 'required|email']);
    }

    // ÜNS BERIŇ: credentials funksiýasyny POZDUK! 
    // Sebäbi Laravel standart e-mail ulanmaly.

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }
}
