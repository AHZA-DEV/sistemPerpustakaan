<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek jika user belum login atau bukan admin
        if (!Session::has('user_id') || !Session::has('user_type') || Session::get('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak. Silakan login sebagai admin.');
        }

        return $next($request);
    }
}
