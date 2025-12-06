<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoleCheck
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::guard('web')->user();
        
        // // Debug
        // Log::info('RoleCheck Debug', [
        //     'user_id' => $user?->id_user,
        //     'user_role' => $user?->role,
        //     'required_roles' => $roles,
        //     'is_authenticated' => Auth::guard('web')->check()
        // ]);

        // User sudah dicek di middleware AdminAuthenticate, jadi langsung cek role
        if (!in_array($user->role, $roles)) {
            // Log::error('RoleCheck: Access Denied', [
            //     'user_role' => $user->role,
            //     'required_roles' => $roles
            // ]);
            abort(403, 'Akses ditolak. Role Anda: ' . $user->role . ' (Dibutuhkan: ' . implode(', ', $roles) . ')');
        }

        return $next($request);
    }
}