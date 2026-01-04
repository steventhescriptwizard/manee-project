<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('setting')) {
    /**
     * Get the specified setting value.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    function setting($key, $default = null)
    {
        // Try getting from cache (all settings) first to minimize queries
        $settings = Cache::rememberForever('settings.all', function () {
            return Setting::all()->keyBy('key');
        });

        if ($setting = $settings->get($key)) {
            return $setting->value;
        }

        return $default;
    }
}
