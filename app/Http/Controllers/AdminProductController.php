<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = Produk::with('kategori')->get();
        return view('admin.produk',compact('produk'));
    }

    public function kategori()
    {
        return view('admin.kategori');
    }

    public function stok()
    {
        $produk = Produk::with('kategori')->get();
        return view('admin.stok',compact('produk'));
    }

    // Ambil semua kategori untuk DataTables
    public function listKategori()
    {
        $kategori = Kategori::select(['id_kategori', 'kode', 'nama'])
        ->orderBy('kode', 'asc') // urut berdasarkan kode
        ->get();
        return response()->json(['data' => $kategori]);
    }


    public function createKategori(Request $request)
    {
        $kategori = Kategori::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan!',
            'data' => $kategori
        ]);
    }

    public function getKategori($id)
    {
        $kategori = Kategori::findOrFail($id);
        return response()->json(['data' => $kategori]);
    }

    public function updateKategori(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'kode' => $request->kode,
            'nama' => $request->nama,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diperbarui!',
            'data' => $kategori
        ]);
    }

    public function checkKategori(Request $request)
    {
        $field = $request->field;
        $value = $request->value;
        $id = $request->id ?? null; // id opsional (buat edit)

        $query = Kategori::where($field, $value);
    
        // Saat edit, abaikan data dengan id yang sama
        if ($id) {
            $query->where('id_kategori', '!=', $id);
        }

        $exists = Kategori::where($field, $value)->exists();

        return response()->json(['exists' => $exists]);
    }


    // Hapus kategori
    public function destroyKategori($id)
    {
        Kategori::where('id_kategori', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus!'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::orderBy('kode', 'asc')->get();
        return view('admin.tambah-produk',compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // 🔒 Validasi input
        $validated = $request->validate([
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'sku' => 'required|string|max:50|unique:produk,sku',
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'status' => 'required|in:aktif,nonaktif',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // 📸 Upload gambar jika ada
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads/produk', $filename, 'public');
            $gambarPath = $filename; // hanya nama file yang disimpan
        }

        // 🧾 Simpan ke database
        $produk = Produk::create([
            'id_kategori' => $validated['id_kategori'],
            'sku' => strtoupper($validated['sku']),
            'nama_produk' => ucwords($validated['nama_produk']),
            'deskripsi' => $validated['deskripsi'],
            'harga' => $validated['harga'],
            'stok' => $validated['stok'],
            'gambar' => $gambarPath,
            'status' => $validated['status'],
            'tgl_ditambahkan' => Carbon::now(),
        ]);

        // ✅ Kembalikan ke halaman produk dengan pesan sukses
        return redirect('/dashboard-admin/produk')
            ->with('success', 'Produk berhasil ditambahkan!');
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
        $produk = Produk::findOrFail($id);
        $kategori = Kategori::all(); // kalau ada relasi kategori
    
        return view('admin.edit-produk', compact('produk', 'kategori'));
    }

    public function checkSku(Request $request)
    {
        $sku = strtoupper($request->sku);
        $id = $request->id ?? null;

        $query = Produk::where('sku', $sku);
        
        if ($id) {
            $query->where('id_produk', '!=', $id);
        }

        $exists = $query->exists();

        return response()->json(['exists' => $exists]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $produk = Produk::where('id_produk', $id)->firstOrFail();

        // dd($request->all());
        // die;
    
        $validated = $request->validate([
            'sku' => 'required|string|max:50',
            'nama_produk' => 'required|string|max:255',
            'id_kategori' => 'required|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'status' => 'required|string',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        // Update data
        $produk->sku = $validated['sku'];
        $produk->nama_produk = $validated['nama_produk'];
        $produk->id_kategori = $validated['id_kategori'];
        $produk->harga = $validated['harga'];
        $produk->stok = $validated['stok'];
        $produk->status = $validated['status'];
        $produk->deskripsi = $validated['deskripsi'];
    
       // 📸 Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama (jika ada)
            if ($produk->gambar && Storage::disk('public')->exists('uploads/produk/' . $produk->gambar)) {
                Storage::disk('public')->delete('uploads/produk/' . $produk->gambar);
            }

            // Upload gambar baru ke storage/app/public/uploads/produk
            $file = $request->file('gambar');
            $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads/produk', $filename, 'public');

            // Simpan hanya nama file di database
            $produk->gambar = $filename;
        }
    
        $produk->save();
    
        return redirect('/dashboard-admin/produk')->with('success', 'Produk berhasil diperbarui.');
    }

    public function updateStok(Request $request, $id_produk)
    {
        $produk = Produk::where('id_produk', $id_produk)->firstOrFail();
        $request->validate([
            'aksi' => 'required|in:tambah,kurang',
            'jumlah' => 'required|integer|min:1',
        ]);

        // dd($request->aksi);
        // die;

        if ($request->aksi === 'tambah') {
            $produk->stok += $request->jumlah;
        } else {
            $produk->stok = max(0, $produk->stok - $request->jumlah);
        }

        $produk->save();

        return redirect()->back()->with('success', 'Stok berhasil diperbarui.');

        // return response()->json(['message' => 'Stok berhasil diperbarui.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produk = Produk::findOrFail($id);

        // Hapus file gambar kalau ada
        if ($produk->gambar && file_exists(storage_path('app/public/uploads/produk/' . $produk->gambar))) {
            unlink(storage_path('app/public/uploads/produk/' . $produk->gambar));
        }

        $produk->delete();

        return response()->json(['success' => true, 'message' => 'Produk berhasil dihapus']);
    }

}
