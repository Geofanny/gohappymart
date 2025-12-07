<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use App\Models\Berita;
use App\Models\Produk;
use App\Models\Ulasan;
use App\Models\Kategori;
use App\Models\Wishlist;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use App\Models\KeranjangProduk;
use Illuminate\Support\Facades\Auth;

class BerandaController extends Controller
{
    public function index()
    {   
        $hariIni = now();

        $produkPopuler = Produk::where('status','aktif')
            ->with(['promos' => function($q) use ($hariIni) {
                $q->where('status', 'aktif')
                  ->whereDate('tgl_mulai', '<=', $hariIni)
                  ->whereDate('tgl_selesai', '>=', $hariIni);
            }])
            ->limit(9)
            ->get();
    
        // Hitung harga promo langsung di setiap produk
        // foreach($produkPopuler as $p) {
        //     if ($p->promos->count() > 0) {
        //         $promo = $p->promos->first();
    
        //         // Diskon persen
        //         if ($promo->tipe === 'Persen') {
        //             $p->harga_promo = $p->harga - ($p->harga * ($promo->nilai_diskon / 100));
        //         }
    
        //         // Diskon nominal
        //         elseif ($promo->tipe === 'Nominal') {
        //             $p->harga_promo = max(0, $p->harga - $promo->nilai_diskon);
        //         }
        //     } else {
        //         $p->harga_promo = null;
        //     }
        // }
        
        $kategori = Kategori::all();
        $produkDiskon = Produk::where('status','aktif')->limit(10)->get();
        $produkRekomendasi = Produk::where('status', 'aktif')
        ->select('produk.*')
        ->distinct()
        ->limit(30)
        ->get();
    

        $now = now();
    
        $promoFlashsale = Promo::where('kategori', 'flashsale')
            ->where('status', 'Aktif')
            ->where('tgl_mulai', '<=', $now)
            ->where('tgl_selesai', '>=', $now)
            ->orderBy('tgl_mulai', 'desc')
            ->first();

            // dd($promoFlashsale);
    
        // Ambil produk flashsale hanya jika ada promo aktif
        $produkFlashsale = collect();
        if ($promoFlashsale) {
            $produkFlashsale = Produk::whereHas('promos', function ($query) use ($now) {
                $query->where('kategori', 'flashsale')
                      ->where('status', 'aktif')
                      ->where('tgl_mulai', '<=', $now)
                      ->where('tgl_selesai', '>=', $now);
            })
            ->where('status', 'aktif')
            ->limit(20)
            ->get();
        }

        $promoBigsale = Promo::where('kategori', 'bigsale')
        ->where('status', 'Aktif')
        ->where('tgl_mulai', '<=', $now) 
        ->where('tgl_selesai', '>=', $now)
        ->orderBy('tgl_mulai', 'desc')
        ->first();

        $produkBigsale = collect();
        if ($promoBigsale) {
            $produkBigsale = Produk::whereHas('promos', function ($query) use ($now) {
                $query->where('kategori', 'bigsale')
                    ->where('status', 'Aktif')
                    ->where('tgl_mulai', '<=', $now)
                    ->where('tgl_selesai', '>=', $now);
            })
            ->where('status', 'aktif')
            ->limit(20)
            ->get();
        }

        // $produkUmumSale = Produk::whereHas('promos', function ($query) {
        //     $query->where('kategori', 'umum')
        //           ->where('status', 'aktif');
        // })
        // ->where('status', 'aktif')
        // ->get();

        $promoUmum = Promo::where('kategori', 'umum')
        ->where('status', 'Aktif')
        ->where('tgl_mulai', '<=', $now)
        ->where('tgl_selesai', '>=', $now)
        ->orderBy('tgl_mulai', 'desc')
        ->first();

        $produkUmumSale = collect();
        if ($promoUmum) {
            $produkUmumSale = Produk::whereHas('promos', function ($query) use ($now) {
                $query->where('kategori', 'umum')
                    ->where('status', 'Aktif')
                    ->where('tgl_mulai', '<=', $now)
                    ->where('tgl_selesai', '>=', $now);
            })
            ->where('status', 'aktif')
            ->limit(20)
            ->get();
        }
        

        $wishlistProdukIds = [];
        if (Auth::guard('pelanggan')->check()) {
            $pelangganId = Auth::guard('pelanggan')->id();
            // Ambil semua id_produk yang ada di wishlist user
            $wishlistProdukIds = Wishlist::where('id_pelanggan', $pelangganId)
                                         ->pluck('id_produk')
                                         ->toArray();
        }

        $testimoniToko = Ulasan::with('pelanggan')
        ->where('tipe', 'toko')          // ambil ulasan khusus toko
        ->where('rating', '>', 0)        // rating harus ada
        ->orderBy('tgl_ulasan', 'desc')  // terbaru dulu
        ->limit(9)                        // tampilkan 9 testimoni (3×3 slide)
        ->get();

        $berita = Berita::where('status', 'publish')
        ->orderBy('tgl', 'desc')
        ->limit(8)
        ->get();

        $promoBanners = Promo::where('status', 'Aktif')
        ->whereNotNull('banner')
        ->whereDate('tgl_mulai', '<=', now())
        ->whereDate('tgl_selesai', '>=', now())
        ->orderBy('tgl_mulai', 'desc')
        ->get();

        
        return view('pelanggan.index',compact([
            'produkPopuler','kategori', 'produkDiskon','produkRekomendasi','wishlistProdukIds','produkFlashsale','produkBigsale','produkUmumSale','promoFlashsale','promoBigsale','promoUmum','testimoniToko','berita','promoBanners'
        ]));
    }

    public function cariProduk(Request $request)
    {
        $query = $request->input('q'); // ambil keyword 
        
        $kategoriFilter = $request->input('kategori');
    
        // Query pencarian
        $produk = Produk::where('status', 'aktif')
                ->when($query, function ($q) use ($query) {
                    $q->where('nama_produk', 'LIKE', "%{$query}%");
                })
                ->when($kategoriFilter, function ($q) use ($kategoriFilter) {
                    $q->where('id_kategori', $kategoriFilter);
                })
                ->select('produk.*')
                ->distinct()
                ->limit(30)
                ->get();


        $kategori = Kategori::withCount(['produk' => function ($q) {
            $q->where('status', 'aktif');
        }])->get();
    
        // Ambil wishlist user
        $wishlistProdukIds = [];
        if (Auth::guard('pelanggan')->check()) {
            $pelangganId = Auth::guard('pelanggan')->id();
            $wishlistProdukIds = Wishlist::where('id_pelanggan', $pelangganId)
                                         ->pluck('id_produk')
                                         ->toArray();
        }
    
        return view('pelanggan.pencarian', compact('produk', 'query', 'wishlistProdukIds','kategori'));
    }
    
    

    public function count()
    {
        $count = 0;
        if (Auth::guard('pelanggan')->check()) {
            $pelangganId = Auth::guard('pelanggan')->id();
            $count = Wishlist::where('id_pelanggan', $pelangganId)->count();
        }

        return response()->json([
            'count' => (int) $count
        ]);
    }

    public function getCount()
    {
        if (!Auth::guard('pelanggan')->check()) {
            return response()->json(['count' => 0]);
        }

        $pelangganId = Auth::guard('pelanggan')->id();

        // Ambil semua keranjang milik pelanggan (jaga-jaga kalau ada lebih dari satu)
        $idKeranjangList = Keranjang::where('id_pelanggan', $pelangganId)
            ->pluck('id_keranjang');

        // Hitung jumlah produk unik di semua keranjang user
        $count = \App\Models\KeranjangProduk::whereIn('id_keranjang', $idKeranjangList)
            ->distinct('id_produk')
            ->count('id_produk');

        return response()->json(['count' => $count]);
    }

    public function menuSaya()
    {
        return view('pelanggan.menu-saya');
    }

}
