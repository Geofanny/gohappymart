<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function wishlist()
    {
        // pastikan pelanggan login
        $pelangganId = Auth::guard('pelanggan')->id();

        $wishlistProdukIds = [];
        if (Auth::guard('pelanggan')->check()) {
            $pelangganId = Auth::guard('pelanggan')->id();
            // Ambil semua id_produk yang ada di wishlist user
            $wishlistProdukIds = Wishlist::where('id_pelanggan', $pelangganId)
                                         ->pluck('id_produk')
                                         ->toArray();
        }

        // ambil wishlist pelanggan, beserta data produk
        $wishlist = Wishlist::with('produk')
            ->where('id_pelanggan', $pelangganId)
            ->get();

        return view('pelanggan.wishlist', compact('wishlist','wishlistProdukIds'));
    }

    public function wishlistData()
    {
        $pelangganId = Auth::guard('pelanggan')->id();
        
        $wishlistProdukIds = Wishlist::where('id_pelanggan', $pelangganId)
                                    ->pluck('id_produk')
                                    ->toArray();
        
        $wishlist = Wishlist::with('produk')
                            ->where('id_pelanggan', $pelangganId)
                            ->get();

        // Render partial view
        return view('pelanggan.list-wishlist', compact('wishlist','wishlistProdukIds'))->render();
    }

}
