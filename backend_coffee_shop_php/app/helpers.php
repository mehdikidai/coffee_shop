<?php

use App\Models\Setting;

if (! function_exists('setting')) {
    function setting($key, $default = null)
    {
        return cache()->remember("setting_{$key}", 3600, function () use ($key, $default) {
            return Setting::where('key', $key)->value('value') ?? $default;
        });
    }
}


function pagination_limit(): int
{

    $pagination_limit_default = (int) config('setting.pagination_limit');

    return (int) setting('pagination_limit', $pagination_limit_default);
}
