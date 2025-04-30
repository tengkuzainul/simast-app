<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AssignRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $user = Auth::user();

        if (!$user) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Silakan login untuk melanjutkan.');
        }

        $allowedRoles = explode('|', $roles);

        if (in_array($user->role, $allowedRoles)) {
            return $next($request);
        }

        return redirect()->back()->with('warning', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
