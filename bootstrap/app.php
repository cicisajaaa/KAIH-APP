<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Belum login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Kalau tidak ada role yang ditentukan,
        // izinkan request
        if (empty($roles)) {
            return $next($request);
        }

        // Cek apakah role user sesuai
        if (!in_array($user->role, $roles, true)) {
            abort(403, 'AKSES DITOLAK UNTUK ROLE INI.');
        }

        return $next($request);
    }
}