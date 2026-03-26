<?php

/**
 * CheckRole Middleware — Restricts routes to specific user roles.
 *
 * Satisfies: FR-AUTH-06, FR-AUTH-07
 *
 * Pre-existing state: This file DID NOT EXIST. Created from scratch.
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * FR-AUTH-07: Returns HTTP 403 "Unauthorized Action" if the authenticated
     *             user's Role is not in the allowed $roles list.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles  Allowed role names (e.g., 'Admin', 'SalesStaff')
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!in_array(Auth::user()->Role, $roles)) {
            abort(403, 'Unauthorized Action');
        }

        return $next($request);
    }
}
