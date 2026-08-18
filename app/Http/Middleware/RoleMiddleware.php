<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        // Belum login
        if (!$user) {
            return redirect()->route('login');
        }

        // Tidak ada role
        if (!$user->role) {
            abort(403, 'Role akun tidak ditemukan.');
        }

        // Kalau tidak ada role yang ditentukan,
        // izinkan dulu supaya tidak memblokir route lama.
        if (empty($roles)) {
            return $next($request);
        }

        // Cek role
        if (!in_array($user->role, $roles, true)) {
            abort(403, 'AKSES DITOLAK UNTUK ROLE INI.');
        }

        return $next($request);
    }
}