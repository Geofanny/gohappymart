<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\KeranjangProduk;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function keranjang()
    {
        $pelangganId = Auth::guard('pelanggan')->id();

        $keranjang = Keranjang::with(['produk.produk.kategori'])
            ->where('id_pelanggan', $pelangganId)
            ->first();

        $items = $keranjang ? $keranjang->produk : collect();

        $produkIds = $items->pluck('id_produk');
        $kategoriIds = $items->pluck('produk.id_kategori')->unique()->filter();

        $produkRekomendasi = Produk::whereIn('id_kategori', $kategoriIds)
            ->whereNotIn('id_produk', $produkIds)
            ->inRandomOrder()
            ->limit(20)
            ->get();

        if ($produkRekomendasi->isEmpty()) {
            $produkRekomendasi = Produk::inRandomOrder()->limit(10)->get();
        }

        $wishlistProdukIds = [];
        if (Auth::guard('pelanggan')->check()) {
            $wishlistProdukIds = Auth::guard('pelanggan')->user()
                ->wishlist()
                ->pluck('id_produk')
                ->toArray();
        }

        return view('pelanggan.keranjang', compact('items', 'produkRekomendasi', 'wishlistProdukIds'));
    }


    public function updateJumlah(Request $request, $id)
    {
        $item = KeranjangProduk::find($id);
        if ($item) {
            $item->jumlah = $request->jumlah;
            $item->save();
        }
        return response()->json(['success' => true]);
    }

    public function renderKeranjangPartial()
    {
        $pelangganId = Auth::guard('pelanggan')->id();
        $keranjang = Keranjang::with(['produk.produk'])
            ->where('id_pelanggan', $pelangganId)->first();
        $items = $keranjang ? $keranjang->produk : collect();

        return view('pelanggan.keranjang-item', compact('items'))->render();
    }


    public function hapusProduk($id)
    {
        KeranjangProduk::find($id)?->delete();
        return response()->json(['success' => true]);
    }

    public function hapusBanyak(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['error' => 'Tidak ada produk yang dipilih.'], 400);
        }

        KeranjangProduk::whereIn('id_keranjang_produk', $ids)->delete();

        return response()->json(['success' => true]);
    }


    public function tambahKeranjang(Request $request)
    {
        // pastikan user login
        if (!Auth::guard('pelanggan')->check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Silakan login terlebih dahulu.'
            ], 401);
        }

        $pelangganId = Auth::guard('pelanggan')->id();
        $idProduk = $request->id_produk;
        $jumlah = $request->jumlah ?? 1;

        // cek produk ada atau tidak
        $produk = Produk::find($idProduk);
        if (!$produk) {
            return response()->json([
                'status' => 'error',
                'message' => 'Produk tidak ditemukan.'
            ], 404);
        }

        // ambil atau buat keranjang pelanggan
        $keranjang = Keranjang::firstOrCreate(
            ['id_pelanggan' => $pelangganId]
        );

        // cek apakah produk sudah ada di keranjang
        $keranjangProduk = KeranjangProduk::where('id_keranjang', $keranjang->id_keranjang)
                                          ->where('id_produk', $idProduk)
                                          ->first();

        if ($keranjangProduk) {
            // update jumlah
            $keranjangProduk->jumlah += $jumlah;
            $keranjangProduk->save();
        } else {
            // tambah produk baru
            KeranjangProduk::create([
                'id_keranjang' => $keranjang->id_keranjang,
                'id_produk' => $idProduk,
                'jumlah' => $jumlah,
                'tgl_ditambahkan' => Carbon::now(),
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil ditambahkan ke keranjang.'
        ]);
    }
}
