<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use App\Models\Produk;
use App\Models\Ulasan;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{    

    public function index($id_produk)
    {
        $produk = Produk::where('id_produk',$id_produk)->first();

        $isInWishlist = false;

        if (Auth::guard('pelanggan')->check()) {
            $id_pelanggan = Auth::guard('pelanggan')->user()->id_pelanggan;
            $isInWishlist = Wishlist::where('id_pelanggan', $id_pelanggan)
                                    ->where('id_produk', $id_produk)
                                    ->exists();
    
            // Ambil semua id_produk yang ada di wishlist user (untuk tanda hati)
            $wishlistProdukIds = Wishlist::where('id_pelanggan', $id_pelanggan)
                                         ->pluck('id_produk')
                                         ->toArray();
        } else {
            $wishlistProdukIds = [];
        }

        $ulasan = Ulasan::with('pelanggan','bukti')
        ->where('id_produk', $id_produk)
        ->get();


        $totalReviews = $ulasan->count();
        // $averageRating = $totalReviews ? round($ulasan->avg('rating'),1) : 0;
        
        $averageRating = $totalReviews ? $ulasan->avg('rating') : 0;

        // Hitung jumlah tiap rating
        $ratingCounts = [
            5 => $ulasan->where('rating',5)->count(),
            4 => $ulasan->where('rating',4)->count(),
            3 => $ulasan->where('rating',3)->count(),
            2 => $ulasan->where('rating',2)->count(),
            1 => $ulasan->where('rating',1)->count(),
        ];

        $produkRekomendasi = Produk::where('status', 'aktif')
        ->where('id_kategori', $produk->id_kategori)
        ->where('id_produk', '!=', $produk->id_produk)
        ->inRandomOrder()
        ->limit(10)
        ->get();

        if ($produkRekomendasi->isEmpty()) {
            $produkRekomendasi = Produk::inRandomOrder()->limit(10)->get();
        }

        $hariIni = now()->toDateString();

        $promo = Promo::whereHas('produks', function ($q) use ($produk) {
                $q->where('produk.id_produk', $produk->id_produk);
            })
            ->where('status', 'aktif')
            ->whereDate('tgl_mulai', '<=', $hariIni)
            ->whereDate('tgl_selesai', '>=', $hariIni)
            ->first();

        //    dd($promo);
        //    die;

        // Default harga normal
        $hargaPromo = $produk->harga;

        // Jika promo ada → hitung harga promo
        if ($promo) {
            if ($promo->tipe === 'Persen') {
                $hargaPromo = $produk->harga - (($promo->nilai_diskon / 100) * $produk->harga);
            } elseif ($promo->tipe === 'Nominal') {
                $hargaPromo = max(0, $produk->harga - $promo->nilai_diskon);
                // dd($hargaPromo);
                // die;
            }
        }


        return view('pelanggan.detail-produk', compact('produk', 'isInWishlist','produkRekomendasi','wishlistProdukIds','ulasan','totalReviews','averageRating','ratingCounts','hargaPromo'));
    }

    public function wishlistProduk(Request $request, $id_produk)
    {
        $user = Auth::guard('pelanggan')->user();
    
        if (!$user) {
            return response()->json(['error' => 'Silakan login terlebih dahulu!'], 401);
        }
    
        // Cek apakah produk sudah ada di wishlist user ini
        $exists = Wishlist::where('id_pelanggan', $user->id_pelanggan)
                          ->where('id_produk', $id_produk)
                          ->first();
    
        if ($exists) {
            // Hapus jika sudah ada (toggle)
            $exists->delete();
            return response()->json(['status' => 'removed']);
        }
    
        // Tambahkan wishlist baru
        Wishlist::create([
            'id_pelanggan' => $user->id_pelanggan,
            'id_produk' => $id_produk,
        ]);
    
        return response()->json(['status' => 'added']);
    }

    public function favoritMultiple(Request $request)
    {
        $user = Auth::guard('pelanggan')->user();

        if (!$user) {
            return response()->json(['error' => 'Silakan login terlebih dahulu!'], 401);
        }

        $produkIds = $request->input('produk_ids', []);

        if (empty($produkIds)) {
            return response()->json(['error' => 'Tidak ada produk yang dipilih.'], 400);
        }

        foreach ($produkIds as $id_produk) {
            // Cek apakah produk sudah ada di wishlist user ini
            $exists = Wishlist::where('id_pelanggan', $user->id_pelanggan)
                            ->where('id_produk', $id_produk)
                            ->first();

            // Jika belum ada, tambahkan ke wishlist
            if (!$exists) {
                Wishlist::create([
                    'id_pelanggan' => $user->id_pelanggan,
                    'id_produk' => $id_produk,
                ]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Produk ditambahkan ke wishlist ❤️']);
    }

}
