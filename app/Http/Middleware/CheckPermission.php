<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        // 1. Login bolanmy?
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // 2. Super Admin bolsa (role_id == 1), barlagsyz goýberýäris
        if ($user->role_id == 1) {
            return $next($request);
        }

        // 3. Moderatorlar we beýlekiler üçin barlag:
        // Hem is_admin bolmaly, hem-de şol permission-y bolmaly
        if ($user->is_admin == 1 && $user->hasPermission($permission)) {
            return $next($request);
        }

        // 4. Rugsat ýok bolsa:
        abort(403, 'Bu bölüme girmäge rugsadyňyz ýok! Gerekli rugsat: ' . $permission);
    }
}
