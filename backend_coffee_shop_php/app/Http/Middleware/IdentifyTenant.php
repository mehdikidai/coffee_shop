<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Services\TenantService;

use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {




        $host = $request->getHost();

        $tenant = Tenant::where('domain', $host)->first();

        TenantService::switchToTenant($tenant);

        return $next($request);


    }
}
