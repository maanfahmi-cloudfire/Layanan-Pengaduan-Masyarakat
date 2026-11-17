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
        if (! $request->user()) {
            return redirect()->route('login')->with('info', 'Silakan masuk ke akun Anda terlebih dahulu.');
        }

        $user = $request->user();

        // Pecah roles jika dipisahkan koma, e.g. "masyarakat,admin"
        $allowedRoles = [];
        foreach ($roles as $role) {
            foreach (explode(',', $role) as $r) {
                $allowedRoles[] = trim($r);
            }
        }

        if (! in_array($user->role, $allowedRoles, true)) {
            // Jika admin mencoba mengakses halaman yang bukan haknya
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('error', 'Halaman tersebut tidak dapat diakses dengan role Administrator.');
            }

            // Jika masyarakat mencoba mengakses halaman admin
            return redirect()->route('dashboard')->with('error', 'Akses ditolak. Halaman tersebut khusus untuk Administrator.');
        }

        return $next($request);
    }
}
