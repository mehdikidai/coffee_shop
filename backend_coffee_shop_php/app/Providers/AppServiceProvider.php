<?php

namespace App\Providers;

use App\Policies\UserPolicyWeb;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('update-user',[UserPolicyWeb::class,'update']);
        Gate::define('create-user',[UserPolicyWeb::class,'create']);
        Gate::define('delete-user',[UserPolicyWeb::class,'delete']);
    }
}
