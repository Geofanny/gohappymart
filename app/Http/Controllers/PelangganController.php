<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PelangganController extends Controller
{
    public function daftarPelanggan()
    {
        $pelanggan = Pelanggan::all();

        return view('admin.pelanggan',compact('pelanggan'));
    }

    public function updatePasswordPelanggan(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'password' => 'required'
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->password = Hash::make($request->password);
        $pelanggan->save();

        return back()->with('success', 'Password diperbarui.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:aktif,nonaktif'
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->status = $request->status;
        $pelanggan->save();

        return back()->with('success', 'Status diperbarui.');
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        return redirect()->back()->with('success', 'Pelanggan berhasil dihapus.');
    }


    public function daftarAdmin()
    {
        $users = User::where('role','admin')->get();
        return view('superAdmin.admin',compact('users'));
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required',
            'password' => 'required',
        ]);

        User::create([
            'nama'      => $request->nama,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => 'admin',
            'status'    => 'aktif',
            'tgl_buat'  => now(),
        ]);

        return back()->with('success', 'Admin baru ditambahkan.');
    }

    public function updatePasswordAdmin(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'password' => 'required'
        ]);

        $user = User::findOrFail($id);
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password diperbarui.');
    }

    public function updateStatusAdmin(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:aktif,nonaktif'
        ]);

        $user = User::findOrFail($id);
        $user->status = $request->status;
        $user->save();

        return back()->with('success', 'Status diperbarui.');
    }

    public function destroyAdmin($id)
    {
        $pelanggan = User::findOrFail($id);
        $pelanggan->delete();

        return redirect()->back()->with('success', 'Admin berhasil dihapus.');
    }



}
