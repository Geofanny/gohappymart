<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TokoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pemilik = User::first();
        // $toko = Toko::where('id_user', $pemilik->id_user)->first();

        // ambil data toko milik user (sementara pakai id_user manual)
        $toko = Toko::where('id_user', $pemilik->id_user)->first();

        // kirim ke view
        return view('superAdmin.toko', compact('toko'));
    }

    public function tentangKami()
    {
        $toko = Toko::first();
        // dd($toko);
        // die;

        return view('pelanggan.toko',compact('toko'));
    }

    public function kontakToko()
    {
        $kontak = Toko::first();
        return view('pelanggan.kontak',compact('kontak'));
    }


    public function storeOrUpdate(Request $request)
    {
        // dd($request);
        // die;
        // Validasi input
        $validated = $request->validate([
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'alamat' => 'nullable|string',
            'coordinate' => 'nullable|string', // untuk input koordinat dari form
        ]);

        $pemilik = User::first();
        // Ambil toko berdasarkan user (sementara masih hardcoded, nanti ganti Auth::id_user)
        $toko = Toko::where('id_user', $pemilik->id_user)->first();

        if (!$toko) {
            $toko = new Toko();
            $toko->id_user = $pemilik->id_user;
        }

        // 📸 Upload logo
        if ($request->hasFile('logo')) {
            if ($toko->logo && Storage::disk('public')->exists('uploads/toko/logo/' . $toko->logo)) {
                Storage::disk('public')->delete('uploads/toko/logo/' . $toko->logo);
            }

            $file = $request->file('logo');
            $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads/toko/logo', $filename, 'public');
            $toko->logo = $filename;
        }

        // 📸 Upload gambar
        if ($request->hasFile('gambar')) {
            if ($toko->gambar && Storage::disk('public')->exists('uploads/toko/gambar/' . $toko->gambar)) {
                Storage::disk('public')->delete('uploads/toko/gambar/' . $toko->gambar);
            }

            $file = $request->file('gambar');
            $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads/toko/gambar', $filename, 'public');
            $toko->gambar = $filename;
        }

        // 🧾 Simpan data lain
        $toko->nama = $validated['nama'];
        $toko->no_hp = $validated['no_hp'] ?? null;
        $toko->email = $validated['email'] ?? null;
        $toko->tagline = $validated['tagline'] ?? null;
        $toko->visi = $validated['visi'] ?? null;
        $toko->misi = $validated['misi'] ?? null;
        $toko->deskripsi = $validated['deskripsi'] ?? null;

        // Gabungkan alamat + koordinat (pakai tanda "|")
        $alamat = $validated['alamat'] ?? '';
        $koordinat = $validated['coordinate'] ?? '';
        $toko->alamat = trim($alamat . ' | ' . $koordinat, ' |');

        $toko->save();

        return redirect()->back()->with('success', 'Data toko berhasil disimpan.');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Toko $toko)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Toko $toko)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Toko $toko)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Toko $toko)
    {
        //
    }
}
