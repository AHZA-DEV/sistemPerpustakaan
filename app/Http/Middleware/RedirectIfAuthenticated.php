<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek jika user sudah login
        if (Session::has('user_id') && Session::has('user_type')) {
            $userType = Session::get('user_type');
            
            // Redirect ke dashboard sesuai tipe user
            if ($userType === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($userType === 'anggota') {
                return redirect()->route('user.dashboard');
            }
        }

        return $next($request);
    }
}
