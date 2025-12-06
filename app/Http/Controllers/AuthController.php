<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('pelanggan.login');
    }

    public function daftar()
    {
        return view('pelanggan.regis');
    }

    public function store(Request $request)
    {
        // $validated = $request->validate([
        //     'nama' => 'required|string|max:50',
        //     'username' => 'required|string|max:50|unique:pelanggan,username',
        //     'email' => 'required|email|unique:pelanggan,email',
        //     'no_hp' => 'nullable|string|max:20',
        //     'password' => 'required|string|min:6',
        //     'jk' => 'required|in:L,P',
        // ]);

        Pelanggan::create([
            'nama_pelanggan' => $request['nama'],
            'username' => $request['username'],
            'email' => $request['email'],
            'no_hp' => $request['no_hp'] ?? null,
            'password' => Hash::make($request['password']),
            'jk' => $request['jk'],
            'status' => 'aktif',
            'tgl_buat' => now(),
        ]);

        return redirect('/login')->with('success', 'Akun berhasil dibuat, silakan login!');
    }

    public function aksesLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Coba login pakai guard pelanggan
        if (Auth::guard('pelanggan')->attempt($credentials)) {
            $request->session()->regenerate();

            $pelanggan = Auth::guard('pelanggan')->user();
            return redirect('')->with('success', 'Berhasil login sebagai ' . $pelanggan->nama_pelanggan);
        }

        return back()->with('error', 'Username atau password salah!');
    }

    public function logout(Request $request)
    {
        Auth::guard('pelanggan')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('')->with('success', 'Anda telah logout.');
    }

    public function loginDashboard()
    {
        return view('auth.loginUser');
    }

    public function loginUser(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);
    
        $credentials = $request->only('email', 'password');
    
        // PENTING: Gunakan guard 'web' untuk login admin
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
    
            $user = Auth::guard('web')->user();
    
            // Arahkan sesuai role
            if ($user->role === 'superadmin') {
                return redirect('/dashboard/superadmin');
            }

            if ($user->role === 'admin') {
                return redirect('/dashboard/admin');
            }

            // Jika role tidak dikenal
            Auth::guard('web')->logout();
            return redirect()->route('admin.login')->with('error', 'Role tidak diizinkan!');

        }
    
        return back()->with('error', 'Email atau password salah!');
    }
    
    public function logoutUser(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login')->with('success', 'Berhasil logout');
    }

    // public function logoutUser(Request $request)
    // {
    //     Auth::logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return redirect()->route('admin.login')->with('success', 'Anda telah logout.');
    // }


}
