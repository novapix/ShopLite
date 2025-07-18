<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  mixed  ...$roles  // Accept multiple roles
     * @return Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user()->loadMissing('roles');
        $userRole = $user->roles->role ?? null;

        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        abort(401, 'Unauthorized');
    }
}
