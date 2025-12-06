<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Regulasi;
use Illuminate\Http\Request;

class SuperAdminRegulasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // ambil 5 item per halaman, bisa diubah sesuai kebutuhan
        $kebijakan = Regulasi::where('jenis', 'kebijakan')
                        ->orderBy('tgl_publikasi', 'desc')
                        ->paginate(2, ['*'], 'kebijakan_page');

        $faq = Regulasi::where('jenis', 'faq')
                        ->orderBy('tgl_publikasi', 'desc')
                        ->paginate(5, ['*'], 'faq_page');

        return view('superAdmin.regulasi', compact('kebijakan', 'faq'));
    }

    public function faq()
    {
        $faq = Regulasi::where('jenis', 'faq')
                        ->orderBy('tgl_publikasi', 'desc')
                        ->paginate(5, ['*'], 'faq_page');
        
        return view('admin.faq',compact('faq'));
    }

    public function faqPelanggan()
    {
        $faq = Regulasi::where('jenis','faq')->get();
        return view('pelanggan.faq',compact('faq'));
    }

    public function kebijakanToko()
    {
        $kebijakan = Regulasi::where('jenis','kebijakan')->get();
        return view('pelanggan.kebijakan-toko',compact('kebijakan'));
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
        $request->validate([
            'jenis' => 'required|in:kebijakan,faq',
            'judul' => 'required|string|max:150',
            'isi' => 'required|string',
        ]);

        $pemilik = User::first();

        Regulasi::create([
            'id_user' => $pemilik->id_user, // user yang login
            'jenis' => $request->jenis,
            'judul' => $request->judul,
            'isi' => $request->isi,
        ]);

        // Pesan sesuai jenis
        $message = $request->jenis === 'faq' ? 'FAQ berhasil ditambahkan!' : 'Kebijakan berhasil ditambahkan!';


        // Contoh store FAQ
        return redirect()->back()->with('success', $message)->with('jenis', $request->jenis);

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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_regulasi)
    {
        $regulasi = Regulasi::where('id_regulasi', $id_regulasi)->first();

        if (!$regulasi) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan.']);
        }

        $regulasi->update([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'tgl_publikasi' => now(),
        ]);

        // Pesan sesuai jenis
        $message = $request->jenis === 'faq' ? 'FAQ berhasil diperbarui!' : 'Kebijakan berhasil diperbarui!';


        // Contoh store FAQ
        return redirect()->back()->with('success', $message)->with('jenis', $request->jenis);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $regulasi = Regulasi::where('id_regulasi', $id)->first();
        if ($regulasi) {
            $regulasi->delete();
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.']);
        }
        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan.']);
    }

}
