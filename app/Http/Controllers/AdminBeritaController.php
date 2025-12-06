<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Berita;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminBeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $berita = Berita::with('user')->orderBy('tgl', 'desc')->get();
        return view('admin.berita', compact('berita'));
    }

    public function detailBerita($id_berita)
    {
        $berita = Berita::findOrFail($id_berita);

        // Ambil 5 berita lain, kecuali yang sedang dibuka
        $beritaLain = Berita::where('id_berita', '!=', $id_berita)
            ->orderBy('tgl', 'desc')
            ->take(5)
            ->get();

        return view('pelanggan.detail-berita', compact('berita', 'beritaLain'));
    }


    public function berita()
    {
        $berita = Berita::where('status', 'publish')
            ->orderBy('tgl', 'desc')
            ->paginate(2); // 6 per halaman
        return view('pelanggan.berita', compact('berita'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tambah-berita');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $penulis = Auth::guard('web')->user();

        // Handle upload gambar
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads/berita', $filename, 'public');
            $gambarPath = $filename;
        }

        // $penulis = User::first();

        // Simpan ke database
        $berita = Berita::create([
            'id_user' => $penulis->id_user, // pakai UUID dari user login
            'judul' => $request->judul,
            'isi' => $request->isi,
            'status' => 'draft', // default draft
            'gambar' => $gambarPath,
            'tgl' => now(),
        ]);

        return redirect('/dashboard/berita')->with('success', 'Berita berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id_berita)
    {
        $berita = Berita::where('id_berita', $id_berita)->firstOrFail();
        return view('admin.edit-berita', compact('berita'));
    }

    public function update(Request $request, string $id_berita)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $berita = Berita::where('id_berita', $id_berita)->firstOrFail();

        $berita->judul = $request->judul;
        $berita->isi = $request->isi;

        // upload gambar baru jika ada
        if ($request->hasFile('gambar')) {
            // hapus gambar lama jika ada
            if ($berita->gambar && file_exists(storage_path('app/public/uploads/berita/' . $berita->gambar))) {
                unlink(storage_path('app/public/uploads/berita/' . $berita->gambar));
            }

            $file = $request->file('gambar');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads/berita', $filename, 'public');
            $berita->gambar = $filename;
        }

        $berita->tgl = now();
        $berita->save();

        return redirect('/dashboard/berita')
            ->with('success', 'Berita berhasil diperbarui!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_berita)
    {
        $berita = Berita::where('id_berita', $id_berita)->firstOrFail();

        if ($berita->gambar) {
            $path = public_path('storage/uploads/berita/' . $berita->gambar);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $berita->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil dihapus!'
        ]);
    }

    public function publish(string $id_berita)
    {
        $berita = Berita::where('id_berita', $id_berita)->firstOrFail();
        $berita->status = 'publish';
        $berita->tgl = now();
        $berita->save();

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil dipublish!'
        ]);
    }

    public function unpublish(string $id_berita)
    {
        $berita = Berita::where('id_berita', $id_berita)->firstOrFail();
        $berita->status = 'draft';
        $berita->save();

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil dikembalikan ke draft!'
        ]);
    }




}
