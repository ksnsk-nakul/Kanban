<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roleSlug): Response
    {
        $user = $request->user();
        abort_unless($user !== null, 403);
        abort_unless($user->hasRole($roleSlug), 403);

        return $next($request);
    }
}
