<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Mail\ContactReplyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function adminIndex()
    {
        $messages = Contact::latest()->get(); // Paginate ulanýan bolsaňyz: paginate(10)
        return view('admin.messages.index', compact('messages'));
    }

    public function markAsRead($id)
    {
        $message = Contact::findOrFail($id);
        $message->update(['is_read' => true]);
        return back()->with('success', 'Hat okaldy diýip bellendi.');
    }

    public function store(Request $request)
    {

        // 1. Validasiýa (reCAPTCHA diňe admin panelde işjeň bolsa hökmany bolar)
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'message' => 'required|min:10',
        ];

        if (get_setting('recaptcha_enabled') == '1') {
            $rules['g-recaptcha-response'] = 'required';
        }

        $request->validate($rules);

        // 2. Google reCAPTCHA Barlagy (Diňe işjeň bolsa)
        if (get_setting('recaptcha_enabled') == '1') {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => env('RECAPTCHA_SECRET_KEY') ?? config('services.recaptcha.secret'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ]);

            $recaptchaData = $response->json();

            // Bot barlagyndan geçmedik bolsa
            if (!$recaptchaData['success'] || (isset($recaptchaData['score']) && $recaptchaData['score'] < 0.3)) {
                return back()->withInput()->with('error', 'Howpsuzlyk barlagyndan geçmediňiz (Bot?). Täzeden synanyşyň.');
            }
        }

        // 3. Bazada döretmek (reCAPTCHA ýapyk bolsa göni şu ýere geçer)
        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Hatyňyz üstünlikli ugradyldy!');
    }

    // Jogap bermek funksiýasy (Doly we dogry görnüşi)
    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply_message' => 'required|string|min:5',
        ]);

        $message = Contact::findOrFail($id);

        try {
            // 1. Müşderiniň emailine jogaby hakykatdan hem ugratmak
            Mail::to($message->email)->send(new ContactReplyMail($request->reply_message, $message));

            // 2. Haty okaldy diýip bellemek
            $message->update(['is_read' => true]);

            return redirect()->back()->with('success', 'Jogap müşderiniň emailine ugradyldy!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Mail ugratmakda hata ýüze çykdy: ' . $e->getMessage());
        }
    }
}
