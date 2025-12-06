<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle(Request $request, Closure $next)
    {
        // Cek login pelanggan
        if (Auth::guard('pelanggan')->check()) {
            return $next($request); // Sudah login → lanjut
        }

        // Belum login pelanggan → redirect ke login
        return redirect('/login');
    }
}
