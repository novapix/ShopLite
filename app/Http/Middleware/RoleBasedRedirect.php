<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleBasedRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user()->loadMissing('roles');
            $userRole = $user->roles->role ?? null;

            // If accessing generic dashboard, redirect based on role
            if ($request->is('dashboard')) {
                if (in_array($userRole, ['admin', 'superadmin'])) {
                    return redirect()->route('admin.dashboard');
                }
            }

            // Prevent non-admin users from accessing admin routes
            if ($request->is('admin') || $request->is('admin/*')) {
                if (!in_array($userRole, ['admin', 'superadmin'])) {
                    abort(403, 'Access denied. Admin privileges required.');
                }
            }
        }

        return $next($request);
    }
}
