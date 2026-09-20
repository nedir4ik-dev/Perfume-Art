<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    /*
    | Bu trait täze paroly barlamak (validation) we 
    | bazada üýtgetmek işlerini awtomatiki ýerine ýetirýär.
    */
    use ResetsPasswords;

    /**
     * Parol täzelenenden soňra müşderini ugratjak salgymyz.
     */
    protected $redirectTo = '/admin/login';

    /**
     * Täze parol ýazylýan formany görkezýär.
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
