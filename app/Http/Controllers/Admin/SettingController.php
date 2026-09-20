<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // 1. Maintenance Mode logikasy
        if ($request->has('maintenance_mode')) {
            // Ulanyjynyň ýazan habaryny Artisan komandasyna berýäris
            $message = $request->input('maintenance_message', 'Ulgamda tehniki abatlaýyş işleri geçirilýär.');

            Artisan::call('down', [
                '--secret' => 'perfume-safe',
                '--refresh' => 15,
                '--render' => 'errors::503' // Isleseň ýörite view hem döredip bilersiň
            ]);
            Setting::updateOrCreate(['key' => 'maintenance_mode'], ['value' => '1']);
        } else {
            Artisan::call('up');
            Setting::updateOrCreate(['key' => 'maintenance_mode'], ['value' => '0']);
        }

        // 2. Checkbox-laryň sanawy (Request-de gelmedik ýagdaýynda '0' diýip ýazmak üçin)
        $checkboxes = ['recaptcha_enabled', 'maintenance_mode']; // Goşmaça switch-ler bolsa şu ýere goşuň

        foreach ($checkboxes as $checkbox) {
            $status = $request->has($checkbox) ? '1' : '0';
            Setting::updateOrCreate(['key' => $checkbox], ['value' => $status]);
        }

        // 3. Ähli beýleki inputlary awtomatiki işlemek
        // Indiki ädimde täze goşjak sosyal media linkleriňiz şu ýerde awtomatiki saklanar
        $inputs = $request->except(['_token', 'maintenance_mode', 'recaptcha_enabled']);

        foreach ($inputs as $key => $value) {
            // Faýl (Logo) işlemleri
            if ($request->hasFile($key)) {
                $oldValue = Setting::where('key', $key)->first()?->value;
                if ($oldValue && Storage::disk('public')->exists($oldValue)) {
                    Storage::disk('public')->delete($oldValue);
                }
                $value = $request->file($key)->store('settings', 'public');
            }

            // null gelýän bahalary boş tekst hökmünde saklaýarys
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => is_null($value) ? '' : $value]
            );
        }

        // Cache arassalamak professional sahypalarda hökmandyr
        Artisan::call('cache:clear');
        Artisan::call('config:clear');

        return redirect()->back()->with('success', 'Sazlamalar we ulgam parametrleri üstünlikli täzelendi!');
    }
    public function clearCache()
    {
        // Laravel keşlerini programmatically arassalamak
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');

        return redirect()->back()->with('success', 'Ulgam keşi üstünlikli arassalandy!');
    }
}
