<?php

namespace App\Providers;

use App\Policies\OrderPolicy;
use App\Policies\UserPolicyWeb;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
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

        Paginator::useBootstrap();

        Gate::define('update-user', [UserPolicyWeb::class, 'update']);
        Gate::define('create-user', [UserPolicyWeb::class, 'create']);
        Gate::define('delete-user', [UserPolicyWeb::class, 'delete']);
        Gate::define('order-create', [OrderPolicy::class, 'create']);
        Blade::directive('setting', fn($expression) => "<?php echo setting($expression); ?>");
        Blade::if('role', fn($role) => Auth::check() && Auth::user()->role === $role);

    }
}
