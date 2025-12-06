<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Promo;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\ProdukPromo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PromoController extends Controller
{
    public function diskon()
    {
        $user = User::first();
        $diskon = Promo::where('id_user', $user->id_user)->where('kategori','umum')->get();

        // dd($diskon);
        // die;
        return view('superAdmin.diskon', compact('diskon'));
    }


    public function diskonBaru(Request $request)
    {
        $request->validate([
            'banner' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'nama_promo' => 'required|string|max:255',
            'tipe' => 'required|in:Persen,Nominal',
            'nilai_diskon' => 'required|integer|min:1',
            'tanggal_mulai' => 'required|date',
            'waktu_mulai' => 'required',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'waktu_selesai' => 'required',
        ]);

        $user = User::first();

        // 📸 Upload banner jika ada
        $bannerPath = null;
        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads/promo', $filename, 'public');
            $bannerPath = $filename;
        }

        // 🧾 Simpan data promo ke database
        Promo::create([
            'id_user' => $user->id_user,
            'banner' => $bannerPath, // simpan nama file banner
            'nama_promo' => $request->nama_promo,
            'tipe' => $request->tipe,
            'nilai_diskon' => $request->nilai_diskon,
            'tgl_mulai' => $request->tanggal_mulai . ' ' . $request->waktu_mulai,
            'tgl_selesai' => $request->tanggal_selesai . ' ' . $request->waktu_selesai,
            'status' => 'Aktif',
            'kategori' => 'umum',
        ]);

        return redirect('/dashboard-superadmin/diskon')
            ->with('success', 'Diskon berhasil ditambahkan!');
    }


    public function updateDiskon(Request $request, string $id_promo)
    {
        $promo = Promo::where('id_promo', $id_promo)->firstOrFail();

        // Validasi data
        $validated = $request->validate([
            'nama_promo' => 'required|string|max:255',
            'tipe' => 'required|in:Persen,Nominal',
            'nilai_diskon' => 'required|integer|min:1',
            'tanggal_mulai' => 'required|date',
            'waktu_mulai' => 'required',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'waktu_selesai' => 'required',
            'status' => 'required|in:Aktif,Nonaktif',
            'gambar_promo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Update field umum
        $promo->nama_promo   = $validated['nama_promo'];
        $promo->tipe         = $validated['tipe'];
        $promo->nilai_diskon = $validated['nilai_diskon'];
        $promo->tgl_mulai    = $validated['tanggal_mulai'] . ' ' . $validated['waktu_mulai'];
        $promo->tgl_selesai  = $validated['tanggal_selesai'] . ' ' . $validated['waktu_selesai'];
        $promo->status       = $validated['status'];
        $promo->kategori     = "umum";

        // Upload gambar jika ada
        if ($request->hasFile('gambar_promo')) {
            // Hapus banner lama jika ada
            if ($promo->banner && Storage::disk('public')->exists('uploads/promo/' . $promo->banner)) {
                Storage::disk('public')->delete('uploads/promo/' . $promo->banner);
            }

            // Upload banner baru
            $file = $request->file('gambar_promo');
            $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads/promo', $filename, 'public');

            // Simpan nama file ke kolom banner
            $promo->banner = $filename;
        }

        $promo->save();

        return redirect('/dashboard-superadmin/diskon')
            ->with('success', 'Diskon berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // Cari data promo
        $promo = Promo::findOrFail($id);

        // Hapus file banner jika ada dan benar-benar tersimpan
        if ($promo->banner && file_exists(storage_path('app/public/uploads/promo/' . $promo->banner))) {
            unlink(storage_path('app/public/uploads/promo/' . $promo->banner));
        }

        // Hapus data dari database
        $promo->delete();

        // Kalau kamu mau pakai SweetAlert redirect seperti sebelumnya:
        return redirect()->back()->with('success', 'Diskon berhasil dihapus!');
    }


    public function listProduk()
    {
        $kategoris = Kategori::all();

        // Ambil promo aktif + jumlah produk yang terhubung
        $promos = Promo::where('status', 'Aktif')
            ->where('kategori','umum')
            ->withCount('produks') // hitung jumlah produk di setiap promo
            ->get();

        $produks = Produk::with('kategori')->get();

        return view('superAdmin.produkPromo', compact('kategoris', 'promos', 'produks'));
    }

    public function getProdukPromo($id)
    {
        $promo = Promo::with(['produks.kategori'])->findOrFail($id);

         // bentuk respon data JSON
        $data = $promo->produks->map(function ($produk, $i) use ($promo) {
            return [
                'no' => $i + 1,
                'id_produk' => $produk->id_produk,
                'sku' => $produk->sku,
                'nama' => $produk->nama_produk,
                'kategori' => $produk->kategori->nama ?? '-',
                'harga' => $produk->harga, // pakai angka murni, bukan format string
                'tipe_diskon' => $promo->tipe,
                'nilai_diskon' => $promo->nilai_diskon,
            ];
        });

        return response()->json($data);
    }

    public function hapusProduk($promoId, $produkId)
    {
        try {
            $deleted = DB::table('produk_promo')
                ->where('id_promo', $promoId)
                ->where('id_produk', $produkId)
                ->delete();

            if ($deleted) {
                return response()->json(['success' => true, 'message' => 'Produk berhasil dihapus']);
            } else {
                return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getProdukBelumDiskon(Request $request)
    {
        $kategori = $request->kategori;

        $query = Produk::whereDoesntHave('promos', function($q) {
            $q->whereIn('kategori', ['flashsale', 'umum', 'bigsale']);
        })
        ->where('status', 'aktif');

        if ($kategori) {
            $query->whereHas('kategori', function($q) use ($kategori) {
                $q->where('nama', $kategori);
            });
        }

        $produks = $query->with('kategori')->get();

        $data = $produks->map(function($produk, $i) {
            return [
                'no' => $i + 1,
                'id_produk' => $produk->id_produk,
                'sku' => $produk->sku,
                'nama' => $produk->nama_produk,
                'kategori' => $produk->kategori->nama ?? '-',
                'harga' => $produk->harga
            ];
        });

        return response()->json($data);
    }

    public function getProdukBelumFlashsale(Request $request)
    {
        $kategori = $request->kategori;

        // Ambil produk yang TIDAK punya promo kategori flashsale, umum, atau bigsale
        $query = Produk::whereDoesntHave('promos', function($q) {
            $q->whereIn('kategori', ['flashsale', 'umum', 'bigsale']);
        })
        ->where('status', 'aktif');

        // Jika user pilih filter kategori produk
        if ($kategori) {
            $query->whereHas('kategori', function($q) use ($kategori) {
                $q->where('nama', $kategori);
            });
        }

        // Ambil data produk beserta kategori
        $produks = $query->with('kategori')->get();

        // Format data untuk DataTable
        $data = $produks->map(function($produk, $i) {
            return [
                'no' => $i + 1,
                'id_produk' => $produk->id_produk,
                'sku' => $produk->sku,
                'nama' => $produk->nama_produk,
                'kategori' => $produk->kategori->nama ?? '-',
                'harga' => $produk->harga
            ];
        });

        return response()->json($data);
    }

    public function tambahProdukPromo(Request $request, $promoId)
    {
        try {
            $produkIds = $request->produk_ids;

            if (!$produkIds || !is_array($produkIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada produk yang dipilih.'
                ], 400);
            }

            $insertData = [];
            foreach ($produkIds as $id_produk) {
                $insertData[] = [
                    'id_promo' => $promoId,
                    'id_produk' => $id_produk,
                ];
            }

            // Simpan ke pivot table
            DB::table('produk_promo')->insert($insertData);

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan ke promo!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


    public function flashSale()
    {
        $user = User::first();
        $diskon = Promo::where('id_user', $user->id_user)
               ->where('kategori', 'flashsale')
               ->get();

        $flashsale = Promo::where('id_user', $user->id_user)
                ->where('kategori', 'flashsale')
                ->first();
        
        $kategoris = Kategori::all();

        $produkFlashsale = Promo::where('id_user', $user->id_user)
        ->where('kategori', 'flashsale')
        ->with('produks.kategori')
        ->get();

        $produks = Produk::with('kategori')->get();
       

        return view('superAdmin.flashsale', compact('diskon','flashsale','kategoris','produkFlashsale','produks'));
    }

    public function simpanFlashSale(Request $request)
    {
        $request->validate([
            'banner' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tipe' => 'required|in:Persen,Nominal',
            'jumlah_diskon' => 'required|integer|min:1',
            'tanggal_mulai' => 'required|date',
            'waktu_mulai' => 'required',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'waktu_selesai' => 'required',
        ]);

        $user = User::first(); // ubah sesuai login user jika pakai auth
        $bannerPath = null;

        // 🔹 Cek apakah ini edit atau tambah baru
        $promo = null;
        if ($request->filled('id_promo')) {
            $promo = Promo::find($request->id_promo);
            if (!$promo) {
                return back()->with('error', 'Promo tidak ditemukan.');
            }
        }

        // 📸 Upload banner baru jika ada
        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads/flashsale', $filename, 'public');
            $bannerPath = $filename;

            // hapus banner lama jika sedang update
            if ($promo && $promo->banner && Storage::disk('public')->exists('uploads/flashsale/' . $promo->banner)) {
                Storage::disk('public')->delete('uploads/flashsale/' . $promo->banner);
            }
        }

        // 🔹 Gabungkan tanggal dan waktu
        $tglMulai = $request->tanggal_mulai . ' ' . $request->waktu_mulai;
        $tglSelesai = $request->tanggal_selesai . ' ' . $request->waktu_selesai;

        if ($promo) {
            // 🔧 UPDATE DATA
            $promo->update([
                'banner' => $bannerPath ?? $promo->banner,
                'tipe' => $request->tipe,
                'nilai_diskon' => $request->jumlah_diskon,
                'tgl_mulai' => $tglMulai,
                'tgl_selesai' => $tglSelesai,
                'status' => 'Aktif',
            ]);

            return back()->with('success', 'Flash Sale diterapkan!');
        } else {
            // 🆕 INSERT DATA BARU
            Promo::create([
                'id_user' => $user->id_user,
                'banner' => $bannerPath,
                'nama_promo' => 'Flash Sale ' . now()->format('d/m/Y H:i'),
                'tipe' => $request->tipe,
                'nilai_diskon' => $request->jumlah_diskon,
                'tgl_mulai' => $tglMulai,
                'tgl_selesai' => $tglSelesai,
                'status' => 'Aktif',
                'kategori' => 'flashsale',
            ]);

            return back()->with('success', 'Flash Sale diterapkan!');
        }
    }

    public function hapusProdukFlashsale($id_produk)
    {
        try {
            // Cari produk yang ingin dihapus dari flashsale
            $produk = \App\Models\Produk::find($id_produk);
    
            if (!$produk) {
                return redirect()->back()->with('error', 'Produk tidak ditemukan.');
            }
    
            // Ambil promo kategori flashsale yang terkait dengan produk ini
            $promoFlashsale = $produk->promos()
                ->where('kategori', 'flashsale')
                ->first();
    
            if (!$promoFlashsale) {
                return redirect()->back()->with('error', 'Produk ini tidak terhubung ke promo flashsale.');
            }
    
            // Hapus relasi produk dari promo flashsale
            $produk->promos()->detach($promoFlashsale->id_promo);
    
            return redirect()->back()->with('success', 'Produk berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function bigSale()
    {
        $user = User::first();
        $diskon = Promo::where('id_user', $user->id_user)
               ->where('kategori', 'flashsale')
               ->get();

        $bigsale = Promo::where('id_user', $user->id_user)
                ->where('kategori', 'bigsale')
                ->first();
        
        $kategoris = Kategori::all();

        $produkBigsale = Promo::where('id_user', $user->id_user)
        ->where('kategori', 'bigsale')
        ->with('produks.kategori')
        ->get();

        $produks = Produk::with('kategori')->get();
       

        return view('superAdmin.bigsale', compact('diskon','bigsale','kategoris','produkBigsale','produks'));
    }

    public function simpanBigSale(Request $request)
    {
        $request->validate([
            'banner' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tipe' => 'required|in:Persen,Nominal',
            'jumlah_diskon' => 'required|integer|min:1',
            'tanggal_mulai' => 'required|date',
            'waktu_mulai' => 'required',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'waktu_selesai' => 'required',
        ]);

        $user = User::first(); // ubah sesuai login user jika pakai auth
        $bannerPath = null;

        // 🔹 Cek apakah ini edit atau tambah baru
        $promo = null;
        if ($request->filled('id_promo')) {
            $promo = Promo::find($request->id_promo);
            if (!$promo) {
                return back()->with('error', 'Promo tidak ditemukan.');
            }
        }

        // 📸 Upload banner baru jika ada
        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads/bigsale', $filename, 'public');
            $bannerPath = $filename;

            // hapus banner lama jika sedang update
            if ($promo && $promo->banner && Storage::disk('public')->exists('uploads/bigsale/' . $promo->banner)) {
                Storage::disk('public')->delete('uploads/bigsale/' . $promo->banner);
            }
        }

        // 🔹 Gabungkan tanggal dan waktu
        $tglMulai = $request->tanggal_mulai . ' ' . $request->waktu_mulai;
        $tglSelesai = $request->tanggal_selesai . ' ' . $request->waktu_selesai;

        if ($promo) {
            // 🔧 UPDATE DATA
            $promo->update([
                'banner' => $bannerPath ?? $promo->banner,
                'tipe' => $request->tipe,
                'nama_promo' => $request->nama_promo,
                'nilai_diskon' => $request->jumlah_diskon,
                'tgl_mulai' => $tglMulai,
                'tgl_selesai' => $tglSelesai,
                'status' => $request->status,
            ]);

            return back()->with('success', 'Big Sale diterapkan!');
        } else {
            // 🆕 INSERT DATA BARU
            Promo::create([
                'id_user' => $user->id_user,
                'banner' => $bannerPath,
                'nama_promo' => $request->nama_promo,
                'tipe' => $request->tipe,
                'nilai_diskon' => $request->jumlah_diskon,
                'tgl_mulai' => $tglMulai,
                'tgl_selesai' => $tglSelesai,
                'status' => $request->status,
                'kategori' => 'bigsale',
            ]);

            return back()->with('success', 'Big Sale diterapkan!');
        }
    }

    public function hapusProdukBigsale($id_produk)
    {
        try {
            // Cari produk yang ingin dihapus dari flashsale
            $produk = \App\Models\Produk::find($id_produk);
    
            if (!$produk) {
                return redirect()->back()->with('error', 'Produk tidak ditemukan.');
            }
    
            // Ambil promo kategori flashsale yang terkait dengan produk ini
            $promoFlashsale = $produk->promos()
                ->where('kategori', 'bigsale')
                ->first();
    
            if (!$promoFlashsale) {
                return redirect()->back()->with('error', 'Produk ini tidak terhubung ke promo bigsale.');
            }
    
            // Hapus relasi produk dari promo flashsale
            $produk->promos()->detach($promoFlashsale->id_promo);
    
            return redirect()->back()->with('success', 'Produk berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    

}
