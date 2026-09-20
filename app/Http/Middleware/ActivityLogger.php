<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Activity;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // ÜNS BERIŇ: AJAX barlagyny aýyrdyk ýa-da has durnukly etdik
        try {
            $this->logActivity($request, $response);
        } catch (\Exception $e) {
            Log::error('Activity Logger Error: ' . $e->getMessage());
        }

        return $response;
    }

    protected function logActivity(Request $request, $response)
    {
        $status = $response->getStatusCode();

        // Derejäni (Level) status koda görä kesgitleýäris
        $level = 'info';
        if ($status >= 400 && $status < 500) {
            $level = 'warning'; // 404, 403 we ş.m.
        } elseif ($status >= 500) {
            $level = 'error';   // 500, 503 we ş.m.
        }

        // Ýalňyşlyk habaryny has takyk alalyň
        $errorMessage = null;
        if ($status >= 400) {
            if (isset($response->exception) && $response->exception) {
                $errorMessage = $response->exception->getMessage();
            } else {
                $errorMessage = "HTTP Error " . $status . " at " . $request->path();
            }
        }

        // Formadan gelen maglumatlaryň parollaryny gizläliň
        $payload = $request->except(['password', 'password_confirmation', '_token', 'current_password']);

        // BAZADA DUBLIKAT BOLMAZLYGY ÜÇIN: 
        // Eger şol bir IP we şol bir URL bolsa, täze setir açman 'visit_count' artdyryp bileris. 
        // Ýöne sen täze setir isleseň, Create ulanmagy dowam et.
        Activity::create([
            'ip_address'    => $request->ip(),
            'user_agent'    => $request->header('User-Agent'),
            'url'           => $request->fullUrl(),
            'referer'       => $request->header('referer'),
            'method'        => $request->method(),
            'status_code'   => $status,
            'level'         => $level,
            'error_message' => $errorMessage,
            // Diňe Hata ýa-da POST soraglarynda payload-y saklamak ýatdaşy tygşytlar
            'payload'       => ($level !== 'info' || $request->isMethod('POST')) ? $payload : null,
            'visit_count'   => 1,
            'last_activity' => now(),
        ]);
    }
}
