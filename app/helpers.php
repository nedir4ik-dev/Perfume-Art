<?php

if (!function_exists('get_setting')) {
    function get_setting($key, $default = null)
    {
        try {
            return \App\Models\Setting::where('key', $key)->first()?->value ?? $default;
        } catch (\Exception $e) {
            return $default;
        }
    }
}
