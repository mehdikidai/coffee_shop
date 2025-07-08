<?php

use App\Http\Middleware\CheckRole;
use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use App\Http\Middleware\IdentifyTenant;
use App\Http\Middleware\IdentifyTenantApi;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->prependToGroup('api', IdentifyTenantApi::class);
        $middleware->prependToGroup('web', IdentifyTenant::class);
        $middleware->appendToGroup('web', SetLocale::class);
        $middleware->alias(['role' => CheckRole::class]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
