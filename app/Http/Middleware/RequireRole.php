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
    public function handle(Request $request, Closure $next, string $roleSlugs): Response
    {
        $user = $request->user();
        abort_unless($user !== null, 403);

        $roleSlugs = trim($roleSlugs);
        $roles = preg_split('/[,\|]/', $roleSlugs) ?: [];
        $roles = array_values(array_filter(array_map('trim', $roles), fn ($r) => $r !== ''));
        abort_unless($roles !== [], 403);

        $allowed = false;
        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                $allowed = true;
                break;
            }
        }
        abort_unless($allowed, 403);

        return $next($request);
    }
}
