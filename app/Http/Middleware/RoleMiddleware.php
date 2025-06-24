<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
        {
            // dd($request->user());
            if (! $request->user()) {
                abort(403, 'Unauthorized.');
            }

            // Asumsi user memiliki kolom 'role' atau relasi 'roles'
            // Sesuaikan logika ini dengan bagaimana Anda menyimpan role user
            if (! in_array($request->user()->role, $roles)) { // Contoh jika role disimpan di kolom 'role'
                abort(403, 'Anda tidak memiliki akses sebagai ' . implode(', ', $roles) . '.');
            }

            return $next($request);
        }
}
