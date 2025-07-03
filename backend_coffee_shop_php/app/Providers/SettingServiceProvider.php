<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        $this->app->booted(function () {
            if (Schema::hasTable('settings')) {
                config(['setting.currency' => setting('currency', '$')]);
                config(['setting.site_name' => setting('site_name', 'site name test')]);
                config(['setting.pagination_limit' => setting('pagination_limit', '12')]);
            }
        });
    }
}
