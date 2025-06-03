<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockedUserMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {

        if ($request->user() && $request->user()->is_blocked) {
            return response()->json([
                'message' => 'Your account has been banned',
            ], 403);
        }

        return $next($request);
    }
}
