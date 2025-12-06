<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Produk;
use Illuminate\Http\Request;
use App\Models\KeranjangProduk;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function transaksi(Request $request)
    {
        // Ambil data dari session
        $checkoutItems = session('checkout_items', []);
        return view('pelanggan.checkout', compact('checkoutItems'));
    }

    public function addToCheckout(Request $request)
    {
        // CASE 1: Checkout dari keranjang
        if ($request->has('items')) {
            $itemsData = $request->input('items', []);
    
            if (empty($itemsData)) {
                return response()->json(['error' => 'Tidak ada produk yang dipilih.'], 400);
            }
    
            // Ambil semua id_keranjang_produk dari items
            $keranjangIds = collect($itemsData)->pluck('id_keranjang_produk')->toArray();
    
            $items = KeranjangProduk::with('produk')
                ->whereIn('id_keranjang_produk', $keranjangIds)
                ->get();
    
            if ($items->isEmpty()) {
                return response()->json(['error' => 'Produk tidak ditemukan.'], 404);
            }
    
            $checkoutItems = $items->map(function ($item) {
                $produk = $item->produk;
                return [
                    'id_produk' => $produk->id_produk,
                    'nama_produk' => $produk->nama_produk,
                    'harga' => $produk->harga,
                    'jumlah' => $item->jumlah,
                    'gambar' => $produk->gambar,
                    'subtotal' => $produk->harga * $item->jumlah,
                ];
            })->toArray();
    
            session(['checkout_items' => $checkoutItems]);
    
            return response()->json(['status' => 'success']);
        }
    
        // CASE 2: Checkout langsung dari detail produk
        elseif ($request->has('id_produk')) {
            $produk = Produk::find($request->id_produk);
    
            if (!$produk) {
                return response()->json(['error' => 'Produk tidak ditemukan.'], 404);
            }
    
            $item = [
                'id_produk' => $produk->id_produk,
                'nama_produk' => $produk->nama_produk,
                'harga' => $produk->harga,
                'jumlah' => $request->jumlah ?? 1,
                'gambar' => $produk->gambar,
                'subtotal' => $produk->harga * ($request->jumlah ?? 1),
            ];
    
            session(['checkout_items' => [$item]]);
    
            return response()->json(['status' => 'success']);
        }
    
        // CASE 3: Tidak ada data valid
        return response()->json(['error' => 'Data checkout tidak valid.'], 400);
    }
    

    public function getSnapToken(Request $request)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $pelanggan = Auth::guard('pelanggan')->user();

        // Data dari frontend
        $paymentMethod = $request->input('paymentMethod');
        $subtotal = $request->input('subtotal');
        $namaPenerima = $request->input('namaPenerima');
        $noHp = $request->input('noHp');

        // Tentukan metode pembayaran yg diizinkan
        $enabledPayments = [];
        if ($paymentMethod === 'transfer') {
            $enabledPayments = ['bca_va', 'bni_va', 'bri_va', 'permata_va']; // bank transfer
        } elseif ($paymentMethod === 'ewallet') {
            $enabledPayments = ['gopay', 'shopeepay', 'qris']; // e-wallet
        }

        $rand6   = random_int(100000, 999999);
        $tanggal = now()->format('Ymd');
        $rand4   = random_int(1000, 9999);

        $noPesanan = $rand6 . $tanggal . $rand4;

        $params = [
            'transaction_details' => [
                'order_id' => $noPesanan,
                'gross_amount' => (int) $subtotal,
            ],
            'expiry' => [
                'unit' => 'minute',
                'duration' => 1  // ← expires dalam 2 menit
            ],
            'customer_details' => [
                'first_name' => $namaPenerima ?? $pelanggan->nama,
                'email' => $pelanggan->email,
                'phone' => $noHp ?? '-',
            ],
            'enabled_payments' => $enabledPayments, // <— penting!
        ];


        // Buat Snap Token
        $snapToken = Snap::getSnapToken($params);

        return response()->json([
            'snap_token' => $snapToken,
            'no_pesanan' => $noPesanan
        ]);
        
    }
}
