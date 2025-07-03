<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Services\TenantService;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenantApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $tenant_token = $request->header('X-Tenant-Token');

        if (!$tenant_token) abort(400, 'Tenant token header missing');

        $tenant = Tenant::where('tenant_token', $tenant_token)->first();

        TenantService::switchToTenant($tenant);

        return $next($request);

    }
}
