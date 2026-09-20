<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Setting;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (!app()->runningInConsole()) {

            $settings = Setting::pluck('value', 'key');
            View::share('site_settings', $settings);

            $exchange_rate = $settings['exchange_rate'] ?? 20;
            View::share('exchange_rate', $exchange_rate);
        }

        $author = "Nedir4ik";
        if ($author !== "Nedir4ik") {
            abort(500, "Sistemanyň awtorlyk hukugy bozuldy!");
        }

        Paginator::useBootstrapFive();
    }
}
