<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Produk;
use App\Models\Ulasan;
use App\Models\Pesanan;
use App\Models\Keranjang;
use App\Models\Pembayaran;
use App\Models\Pengiriman;
use App\Models\BuktiUlasan;
use Illuminate\Support\Str;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use App\Models\PesananProduk;
use App\Models\KeranjangProduk;
use App\Models\ItemPengembalian;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{

    function generatePaymentNumber($method)
    {
        $kode = match ($method) {
            'COD' => '1',
            'bank_transfer' => '2',
            'ewallet' => '3',
            default => '9',
        };

        $tanggal = now()->format('Ymd');
        $random = str_pad(random_int(0, 999999999), 9, '0', STR_PAD_LEFT);

        return $kode . $tanggal . $random; // total 18 digit
    }


    public function buatPesananCOD(Request $request)
    {
        $pelanggan = Auth::guard('pelanggan')->user();
    
        if (!$pelanggan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Silakan login terlebih dahulu'
            ], 401);
        }
    
        $keranjang = Keranjang::where('id_pelanggan', $pelanggan->id_pelanggan)
            ->with('produk.produk')
            ->first();
    
        $produkPesanan = collect();
    
        // 🔹 Jika checkout dari halaman detail (langsung beli)
        if ($request->has('produk_ids') && is_array($request->produk_ids)) {
            foreach ($request->produk_ids as $idProduk) {
                $produk = Produk::find($idProduk);
                if ($produk) {
                    $jumlah = $request->jumlah[$idProduk] ?? 1;
                    $produkPesanan->push((object)[
                        'id_produk' => $produk->id_produk,
                        'jumlah' => $jumlah,
                        'produk' => $produk
                    ]);
                }
            }
        }
        // 🔹 Jika checkout dari keranjang (tidak ada produk_ids khusus)
        else if ($keranjang && $keranjang->produk->isNotEmpty()) {
            foreach ($keranjang->produk as $item) {
                $id = $item->id_produk;
                $jumlah = $request->jumlah[$id] ?? $item->jumlah ?? 1;
    
                $produkPesanan->push((object)[
                    'id_produk' => $id,
                    'jumlah' => $jumlah,
                    'produk' => $item->produk
                ]);
            }
        }
    
        if ($produkPesanan->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada produk untuk dipesan'
            ], 400);
        }
    
        $alamat = $request->alamat ?? '-';
        $catatan = $request->catatan ?? '-';
        $jasaKirim = $request->jasa_kirim ?? '-';
        $noResi = strtoupper(Str::random(10));
        $metode = $request->metode ?? 'cod';
        $totalHarga = $request->subtotal;
        $ongkir = $request->shippingCost;
    
        
        $rand6   = random_int(100000, 999999);
        $tanggal = now()->format('Ymd');
        $rand4   = random_int(1000, 9999);

        $noPesanan = $rand6 . $tanggal . $rand4;

    
        // 🔹 Simpan pesanan
        $pesanan = Pesanan::create([
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'tgl_pesanan' => Carbon::now(),
            'no_pesanan' => $noPesanan,
            'status' => 'diproses',
            'total_harga' => $totalHarga,
            'catatan' => $catatan,
            'alasan' => null,
        ]);
    
        // 🔹 Simpan produk pesanan
        foreach ($produkPesanan as $item) {
            PesananProduk::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'id_produk' => $item->id_produk,
                'jumlah' => $item->jumlah,
            ]);

            // 🔹 Kurangi stok produk
            $produk = $item->produk;
            if ($produk->stok >= $item->jumlah) {
                $produk->stok -= $item->jumlah;
            } else {
                $produk->stok = 0; // jaga-jaga kalau stok kurang
            }
            $produk->save();
        }
    
        // 🔹 Simpan pengiriman
        Pengiriman::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'status' => 'pending',
            'tgl_kirim' => null,
            'tgl_selesai' => null,
            'alamat' => $alamat,
            'jasa_kirim' => $jasaKirim,
            'no_resi' => null,
            'ongkir' => $ongkir,
        ]);

        $noPembayaran = $this->generatePaymentNumber('COD');

        Pembayaran::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'no_pembayaran' => $noPembayaran,
            'metode'     => 'COD',
            'status'     => 'pending',
            'jumlah'     => $totalHarga,
            'tgl_pembayaran' => null,
        ]);
    
        // 🔹 Hapus produk dari keranjang hanya jika keranjang ada
        if ($keranjang) {
            KeranjangProduk::where('id_keranjang', $keranjang->id_keranjang)
                ->whereIn('id_produk', $produkPesanan->pluck('id_produk')->toArray())
                ->delete();
        }
    
        return response()->json([
            'status' => 'success',
            'message' => 'Pesanan COD berhasil dibuat!',
            'pesanan_id' => $pesanan->id_pesanan
        ]);
    }
    
    public function buatPesananMidtrans(Request $request)
    {
        $pelanggan = Auth::guard('pelanggan')->user();
    
        if (!$pelanggan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Silakan login terlebih dahulu'
            ], 401);
        }

        $result = $request->result;
        $paymentType = $result['payment_type'] ?? '-';
        $bank = $result['va_numbers'][0]['bank'] ?? ($result['bank'] ?? null);
        $metodeKode = '';

        // Buat label metode pembayaran
        if ($paymentType === 'bank_transfer' && $bank) {
            $metodePembayaran = "Transfer(" . strtoupper($bank) . ")";
            $metodeKode = 'bank_transfer';
        } elseif ($paymentType === 'echannel') {
            $metodePembayaran = 'transfer(mandiri)';
            $metodeKode = 'bank_transfer';
        } elseif ($paymentType === 'qris' || $paymentType === 'gopay' || $paymentType === 'shopeepay') {
            $metodePembayaran = "ewallet($paymentType)";
            $metodeKode = 'ewallet';
        } else {
            $metodePembayaran = $paymentType ?? 'lainnya';
            $metodeKode = 'lainnya';
        }

        $noPembayaran = $this->generatePaymentNumber($metodeKode);
    
        $keranjang = Keranjang::where('id_pelanggan', $pelanggan->id_pelanggan)
            ->with('produk.produk')
            ->first();
    
        $produkPesanan = collect();
    
        // 🔹 Jika checkout dari halaman detail (langsung beli)
        if ($request->has('produk_ids') && is_array($request->produk_ids)) {
            foreach ($request->produk_ids as $idProduk) {
                $produk = Produk::find($idProduk);
                if ($produk) {
                    $jumlah = $request->jumlah[$idProduk] ?? 1;
                    $produkPesanan->push((object)[
                        'id_produk' => $produk->id_produk,
                        'jumlah' => $jumlah,
                        'produk' => $produk
                    ]);
                }
            }
        }
        // 🔹 Jika checkout dari keranjang (tidak ada produk_ids khusus)
        else if ($keranjang && $keranjang->produk->isNotEmpty()) {
            foreach ($keranjang->produk as $item) {
                $id = $item->id_produk;
                $jumlah = $request->jumlah[$id] ?? $item->jumlah ?? 1;
    
                $produkPesanan->push((object)[
                    'id_produk' => $id,
                    'jumlah' => $jumlah,
                    'produk' => $item->produk
                ]);
            }
        }
    
        if ($produkPesanan->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada produk untuk dipesan'
            ], 400);
        }
    
        $alamat = $request->alamat ?? '-';
        $catatan = $request->catatan ?? '-';
        $jasaKirim = $request->jasa_kirim ?? '-';
        $noResi = strtoupper(Str::random(10));
    
        $ongkir = $request->shippingCost;

        $totalHarga = $request->subtotal;

        $noPesanan = $request->no_pesanan;
    
        // 🔹 Simpan pesanan
        $pesanan = Pesanan::create([
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'tgl_pesanan' => Carbon::now(),
            'no_pesanan' => $noPesanan,
            'status' => 'diproses',
            'total_harga' => $totalHarga,
            'catatan' => $catatan,
            'alasan' => null,
        ]);
    
        // 🔹 Simpan produk pesanan
        foreach ($produkPesanan as $item) {
            PesananProduk::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'id_produk' => $item->id_produk,
                'jumlah' => $item->jumlah,
            ]);

            // 🔹 Kurangi stok produk
            $produk = $item->produk;
            if ($produk->stok >= $item->jumlah) {
                $produk->stok -= $item->jumlah;
            } else {
                $produk->stok = 0; // jaga-jaga kalau stok kurang
            }
            $produk->save();
        }
    
        // 🔹 Simpan pengiriman
        Pengiriman::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'status' => 'pending',
            'tgl_kirim' => null,
            'tgl_selesai' => null,
            'alamat' => $alamat,
            'jasa_kirim' => $jasaKirim,
            'no_resi' => null,
            'ongkir' => $ongkir,
        ]);

        Pembayaran::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'no_pembayaran' => $noPembayaran,
            'metode'     => $metodePembayaran,
            'status'     => 'Berhasil',
            'jumlah'     => $totalHarga,
            'tgl_pembayaran' => Carbon::now(),
        ]);
    
        // 🔹 Hapus produk dari keranjang hanya jika keranjang ada
        if ($keranjang) {
            KeranjangProduk::where('id_keranjang', $keranjang->id_keranjang)
                ->whereIn('id_produk', $produkPesanan->pluck('id_produk')->toArray())
                ->delete();
        }
    
        return response()->json([
            'status' => 'success',
            'message' => 'Pesanan berhasil dibuat!',
            'pesanan_id' => $pesanan->id_pesanan
        ]);
    }

    public function pesananBerhasil()
    {
        return view('pelanggan.pesananBerhasil');
    }

    public function pesananSaya()
    {
        $pelanggan = Auth::guard('pelanggan')->user();
    
        // Query dasar
        $query = Pesanan::where('id_pelanggan', $pelanggan->id_pelanggan)
            ->with(['produk.produk','ulasan'])
            ->orderBy('tgl_pesanan', 'desc');
    
        // Ambil semua pesanan
        $pesanan = $query->get();
    
        // Filter per status
        $pesananDiproses   = $pesanan->where('status', 'diproses');
        $pesananDikirim    = $pesanan->where('status', 'dikirim');
        $pesananDikemas    = $pesanan->where('status', 'dikemas');
        $pesananSelesai    = $pesanan->where('status', 'selesai');
        $pesananDibatalkan = $pesanan->where('status', 'dibatalkan');

        // Filter pengembalian
        $pengembalianMenunggu = $pesanan
        ->pluck('pengembalian')      
        ->flatten();

        // dd($pengembalianMenunggu);
        // die;
    
        return view('pelanggan.pesananSaya', compact(
            'pesanan',
            'pesananDiproses',
            'pesananDikemas',
            'pesananDikirim',
            'pesananSelesai',
            'pesananDibatalkan',
            'pengembalianMenunggu'
        ));
    }
    

    public function detailPesanan($id_pesanan)
    {
        $pesanan = Pesanan::with(['produk.produk', 'pengiriman', 'pembayaran'])
                    ->where('id_pesanan', $id_pesanan)
                    ->firstOrFail();

        return view('pelanggan.detail-pesanan', compact('pesanan'));
    }

    public function batalkanPesanan(Request $request, $id_pesanan)
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        // Ambil pesanan + produk + pengiriman + pembayaran
        $pesanan = Pesanan::with(['produk.produk', 'pengiriman', 'pembayaran'])
            ->where('id_pesanan', $id_pesanan)
            ->where('id_pelanggan', $pelanggan->id_pelanggan)
            ->firstOrFail();

        // Ambil alasan
        $alasan = $request->alasan;
        if ($alasan === 'Lainnya') {
            $alasan = $request->alasan_lain ?: 'Lainnya';
        }

        // Simpan alasan ke database
        $pesanan->alasan = $alasan;
        $pesanan->status = 'dibatalkan';
        $pesanan->save();

        // Kembalikan stok produk
        foreach ($pesanan->produk as $item) {
            $produk = $item->produk;
            if ($produk) {
                $produk->stok += $item->jumlah;
                $produk->save();
            }
        }

        // Update pengiriman → dibatalkan
        if ($pesanan->pengiriman) {
            $pesanan->pengiriman->status = 'dibatalkan';
            $pesanan->pengiriman->tgl_selesai = now();
            $pesanan->pengiriman->save();
        }

        // Update pembayaran → dibatalkan (jika ada)
        if ($pesanan->pembayaran && $pesanan->pembayaran->metode === 'COD') {
            $pesanan->pembayaran->status = 'dibatalkan';
            $pesanan->pembayaran->save();
        }        

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function menuPesanan()
    {
        $pesanan = Pesanan::with(['produk.produk', 'pengiriman', 'pembayaran'])
                    ->get();

        return view('admin.pesanan',compact('pesanan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $pesanan = Pesanan::findOrFail($id);

        // update status
        $pesanan->status = $request->status;
        $pesanan->save();

        return back()->with('success', 'Pesanan dalam pengemasan');
    }

    public function updateStatusTolak(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        // Ambil pesanan
        $pesanan = Pesanan::findOrFail($id);

        $formattedAlasan = $request->alasan . ' | admin';

        // Update status utama
        $pesanan->status = $request->status;
        $pesanan->alasan = $formattedAlasan;

        $pesanan->save();

        if ($pesanan->pengiriman) {
            $pesanan->pengiriman->update([
                'status' => 'dibatalkan',
                'tgl_selesai' => now(), // opsional
            ]);
        }

        return back()->with('success', 'Pesanan berhasil dibatalkan');
    }

    public function uploadResi(Request $request, $id)
    {
        $request->validate([
            'no_resi' => 'required|string|max:255',
        ]);
    
        // Ambil pesanan + relasi pengiriman
        $pesanan = Pesanan::findOrFail($id);
    
        // Update status pesanan
        $pesanan->update([
            'status' => 'dikirim',
        ]);
    
        // Update tabel pengiriman
        if ($pesanan->pengiriman) {
            $pesanan->pengiriman->update([
                'status' => 'dikirim',
                'no_resi' => $request->no_resi,
                'tgl_kirim' => now(),
            ]);
        }
    
        return back()->with('success', 'Pesanan dalam pengiriman');
    }

    public function pengiriman()
    {
        $pengiriman = Pesanan::with(['pengiriman'])
                    ->get();

        return view('admin.pengiriman',compact('pengiriman'));
    }
    
    public function menuPembayaran()
    {
        $pembayaran = Pesanan::with(['pembayaran'])
                    ->get();

        return view('admin.pembayaran',compact('pembayaran'));
    }

    public function statusTerima(Request $request, $id_pesanan)
    {
        $pelanggan = Auth::guard('pelanggan')->user();
    
        // Ambil pesanan beserta relasinya
        $pesanan = Pesanan::with(['produk.produk', 'pengiriman', 'pembayaran'])
            ->where('id_pesanan', $id_pesanan)
            ->where('id_pelanggan', $pelanggan->id_pelanggan)
            ->firstOrFail();
    
        // Update status pesanan
        $pesanan->status = 'selesai';
        $pesanan->save();
    
        // Update status pengiriman
        if ($pesanan->pengiriman) {
            $pesanan->pengiriman->status = 'selesai';
            $pesanan->pengiriman->tgl_selesai = now();
            $pesanan->pengiriman->save();
        }
    
        // Update status pembayaran jika metode COD
        if ($pesanan->pembayaran && $pesanan->pembayaran->metode === 'COD') {
            $pesanan->pembayaran->status = 'Berhasil';
            $pesanan->pembayaran->tgl_pembayaran = now();
            $pesanan->pembayaran->save();
        }
    
        return redirect()->back()->with('success', 'Pesanan berhasil diterima.');
    }

    public function ajuanPengembalian($id_pesanan)
    {
        $pesanan = Pesanan::with(['produk.produk', 'pengiriman', 'pembayaran'])
                    ->where('id_pesanan', $id_pesanan)
                    ->firstOrFail();

        return view('pelanggan.ajuan-pengembalian',compact('pesanan'));
    }

    public function konfirmasiPengembalian(Request $request)
    {
        $request->validate([
            'id_pesanan' => 'required',
            'alasan'     => 'required',
            'solusi'     => 'required',
            'deskripsi'  => 'nullable',
            'produk'     => 'required|array',
        ]);

        $rand6   = random_int(100000, 999999);
        $tanggal = now()->format('Ymd');
        $rand4   = random_int(1000, 9999);

        $noPengembalian = $rand6 . $tanggal . $rand4;

        // 1. Simpan tabel pengembalian
        $pengembalian = Pengembalian::create([
            'id_pesanan'            => $request->id_pesanan,
            'no_pengembalian'       => $noPengembalian,
            'alasan'                => $request->alasan,
            'solusi'                => $request->solusi,
            'deskripsi'             => $request->deskripsi,
            'status'                => 'Menunggu Konfirmasi',
            'tgl_pengajuan'         => now(),
        ]);

        // 2. Simpan item pengembalian
        foreach ($request->produk as $id_produk) {
            ItemPengembalian::create([
                'id_pengembalian' => $pengembalian->id_pengembalian,
                'id_produk'       => $id_produk,
            ]);
        }

        return redirect('/pesanan')->with('success', 'Pengembalian berhasil diajukan!');
    }

    public function detailPengembalian($id_pengembalian)
    {
        $pengembalian = Pengembalian::with([
            'item.produk', // data produk di pengembalian
            'pesanan.produk' // semua produk di pesanan asli
        ])->findOrFail($id_pengembalian);
    
        // Build mapping id_produk => jumlah
        $jumlahProduk = $pengembalian->pesanan->produk->pluck('jumlah', 'id_produk');
    
        return view('pelanggan.detail-pengembalian', compact('pengembalian', 'jumlahProduk'));
    }
    
    public function updateResi(Request $request, $id)
    {
        $request->validate([
            'no_resi_pengembalian' => 'required|string|max:50',
        ]);

        $pengembalian = Pengembalian::findOrFail($id);

        // Update nomor resi dan status
        $pengembalian->update([
            'no_resi_pengembalian' => $request->no_resi_pengembalian,
            'status' => 'Dalam Pengiriman', // contoh status setelah resi diinput
        ]);

        return redirect('/pesanan')->with('success', 'Nomor resi berhasil dikirim dan status diperbarui.');
    }

    public function menuPengembalian()
    {
        $pengembalians = Pengembalian::with(['pesanan.pelanggan'])->get();
        return view('admin.pengembalian', compact('pengembalians'));
    }

     // Terima pengembalian
     public function terima($id)
     {
         $pengembalian = Pengembalian::findOrFail($id);
         $pengembalian->status = 'Diterima';
         $pengembalian->save();
 
         return redirect()->back()->with('success', 'Pengembalian diterima.');
     }
 
    // Tolak pengembalian
    public function tolak($id)
    {
         $pengembalian = Pengembalian::findOrFail($id);
         $pengembalian->status = 'Ditolak';
         $pengembalian->tgl_selesai = now(); // set tanggal selesai
         $pengembalian->save();
 
         return redirect()->back()->with('success', 'Pengembalian ditolak.');
    }

    public function updateResiUlang(Request $request, $id)
    {
        // Validasi input resi
        $request->validate([
            'no_resi_pengiriman' => 'required|string|max:100',
        ]);

        // Cari pengembalian berdasarkan ID
        $pengembalian = Pengembalian::findOrFail($id);

        // Update nomor resi balasan dan status
        $pengembalian->no_resi_balasan = $request->no_resi_pengiriman;
        $pengembalian->status = 'Dikirim'; // ubah sesuai kebutuhan
        $pengembalian->save();

        return redirect()->back()->with('success', 'Nomor resi ditambahkan');
    }

    public function selesaikanPengembalian($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        // Update status & tanggal selesai
        $pengembalian->status = 'Selesai';
        $pengembalian->tgl_selesai = now();
        $pengembalian->save();

        return redirect('/pesanan')->with('success', 'Pengembalian berhasil diselesaikan.');
    }

    public function selesaikanStatusPengembalian($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        // Update status & tanggal selesai
        $pengembalian->status = 'Selesai';
        $pengembalian->tgl_selesai = now();
        $pengembalian->save();

        return redirect()->back()->with('success', 'Pengembalian Selesai');
    }

    public function penilaianPesanan($id_pesanan)
    {
        $pesanan = Pesanan::with(['produk.produk'])
                    ->where('id_pesanan', $id_pesanan)
                    ->firstOrFail();

        return view('pelanggan.penilaianPesanan',compact('pesanan'));
    }

    public function tambahPenilaian(Request $request, $id_pesanan)
    {
        $request->validate([
            'produk_id.*'      => 'required|uuid',
            'rating_produk.*'  => 'required|integer|min:1|max:5',
            'ulasan_produk.*'  => 'nullable|string',
            'foto_produk.*.*'  => 'nullable|file|max:2048',
    
            'rating_toko'      => 'required|integer|min:1|max:5',
            'ulasan_toko'      => 'nullable|string',
        ]);
    
        $id_pelanggan = Auth::guard('pelanggan')->user()->id_pelanggan;
    
        foreach ($request->produk_id as $index => $id_produk) {
            $ulasan = Ulasan::create([
                'id_pesanan'   => $id_pesanan,
                'id_produk'    => $id_produk,
                'id_pelanggan' => $id_pelanggan,
                'tipe'         => 'produk',
                'balasan'         => null,
                'tgl_ulasan'         => now(),
                'rating'       => $request->rating_produk[$index],
                'ulasan'       => $request->ulasan_produk[$index],
            ]);
    
            // simpan foto produk
            if ($request->hasFile("foto_produk.$index")) {
                foreach ($request->file("foto_produk.$index") as $file) {
            
                    $namaFile = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('uploads/ulasan', $namaFile, 'public');
            
                    BuktiUlasan::create([
                        'id_ulasan' => $ulasan->id_ulasan,
                        'nama_file' => $namaFile,
                        'tipe_bukti' => $file->getMimeType(),
                    ]);
                }
            }
            
        }
    
        Ulasan::create([
            'id_pesanan'   => $id_pesanan,
            'id_produk'    => null,
            'id_pelanggan' => $id_pelanggan,
            'tipe'         => 'toko',
            'tgl_ulasan'   => now(),
            'rating'       => $request->rating_toko,
            'ulasan'       => $request->ulasan_toko,
        ]);
    
        return redirect('/pesanan')->with('success', 'Terima kasih, ulasan berhasil dikirim!');
    }


    public function menuRating()
    {
        // Ambil ulasan yang bertipe produk + relasi pelanggan & produk
        $ulasan = Ulasan::with(['pelanggan', 'produk'])
                    ->where('tipe', 'produk')
                    ->orderBy('tgl_ulasan', 'DESC')
                    ->get();
    
        return view('admin.rating', compact('ulasan'));
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'balasan' => 'required|string|max:2000'
        ]);

        $ulasan = Ulasan::findOrFail($id);

        $ulasan->update([
            'balasan' => $request->balasan
        ]);

        return redirect()->back()->with('success', 'Balasan berhasil dikirim.');
    }

    public function menuRatingToko()
    {
        // Ambil ulasan yang bertipe produk + relasi pelanggan & produk
        $ulasan = Ulasan::with(['pelanggan'])
                    ->where('tipe', 'toko')
                    ->orderBy('tgl_ulasan', 'DESC')
                    ->get();
    
        return view('superadmin.rating', compact('ulasan'));
    }

    public function menuLaporanKeuangan()
    {
        $riwayatTransaksi = Pesanan::with(['produk.produk', 'pengembalian.item.produk'])
                                    ->orderBy('tgl_pesanan', 'desc')
                                    ->get();
    
        $recentTransactions = [];
    
        foreach ($riwayatTransaksi as $order) {
    
            // ---------------------
            // Pemasukan
            // ---------------------
            if ($order->status === 'selesai') {
    
                $totalMasuk = 0;
    
                foreach ($order->produk as $pp) {
                    $jumlah = $pp->jumlah;
                    $harga = $pp->produk->harga ?? 0;
                    $totalMasuk += $jumlah * $harga;
                }
    
                if($totalMasuk > 0){
                    $recentTransactions[] = [
                        'no' => $order->no_pesanan,
                        'time' => Carbon::parse($order->tgl_pesanan),
                        'amount' => $totalMasuk,
                        'type' => 'in',
                        'keterangan' => 'Penjualan pesanan #' . $order->no_pesanan
                    ];
                }
            }
    
            // ---------------------
            // Pengeluaran (Pengembalian Dana)
            // ---------------------
            foreach ($order->pengembalian as $pengembalian) {
                if ($pengembalian->solusi === 'Pengembalian dana' && $pengembalian->status === 'Selesai') {
                    $totalPengembalian = 0;
    
                    foreach ($pengembalian->item as $item) {
                        $pp = $order->produk->firstWhere('id_produk', $item->id_produk);
                        $jumlah = $pp->jumlah ?? 1;
                        $harga = $item->produk->harga ?? 0;
                        $totalPengembalian += $jumlah * $harga;
                    }
    
                    if ($totalPengembalian > 0) {
                        $recentTransactions[] = [
                            'no' => $order->no_pesanan,
                            'time' => Carbon::parse($pengembalian->tgl_selesai ?? $pengembalian->tgl_pengajuan),
                            'amount' => $totalPengembalian,
                            'type' => 'out',
                            'keterangan' => 'Pengembalian dana pesanan #' . $order->no_pesanan
                        ];
                    }
                }
            }
        }
    
        // Urutkan terbaru dulu
        $recentTransactions = collect($recentTransactions)
                                ->sortByDesc('time')
                                ->values();
    
        // ---------------------
        // Hitung total pemasukan dan pengeluaran
        // ---------------------
        $totalPemasukan = $recentTransactions->where('type', 'in')->sum('amount');
        $totalPengeluaran = $recentTransactions->where('type', 'out')->sum('amount');
    
        return view('superAdmin.laporan-keuangan', compact('recentTransactions', 'totalPemasukan', 'totalPengeluaran'));
    }

    public function menuLaporanPenjualan()
    {
        $riwayatTransaksi = Pesanan::with(['produk.produk', 'pengembalian.item.produk'])
                                    ->orderBy('tgl_pesanan', 'desc')
                                    ->get();

        $recentTransactions = [];
        $totalTransaksi = 0;

        foreach ($riwayatTransaksi as $order) {

            // ---------------------
            // Pemasukan (Pesanan Selesai)
            // ---------------------
            if ($order->status === 'selesai') {

                $totalMasuk = 0;

                foreach ($order->produk as $pp) {
                    $jumlah = $pp->jumlah;
                    $harga = $pp->produk->harga ?? 0;
                    $totalMasuk += $jumlah * $harga;
                }

                if($totalMasuk > 0){
                    $recentTransactions[] = [
                        'no' => $order->no_pesanan,
                        'time' => Carbon::parse($order->tgl_pesanan),
                        'amount' => $totalMasuk,
                        'type' => 'in',
                    ];

                    $totalTransaksi++; // hitung transaksi selesai
                }
            }

            // ---------------------
            // Pengeluaran (Pengembalian Dana Selesai)
            // ---------------------
            foreach ($order->pengembalian as $pengembalian) {
                if ($pengembalian->solusi === 'Pengembalian dana' && $pengembalian->status === 'Selesai') {
                    $totalPengembalian = 0;

                    foreach ($pengembalian->item as $item) {
                        $pp = $order->produk->firstWhere('id_produk', $item->id_produk);
                        $jumlah = $pp->jumlah ?? 1;
                        $harga = $item->produk->harga ?? 0;
                        $totalPengembalian += $jumlah * $harga;
                    }

                    if ($totalPengembalian > 0) {
                        $recentTransactions[] = [
                            'no' => $order->no_pesanan,
                            'time' => Carbon::parse($pengembalian->tgl_selesai ?? $pengembalian->tgl_pengajuan),
                            'amount' => $totalPengembalian,
                            'type' => 'out',
                        ];

                        $totalTransaksi++; // hitung transaksi selesai
                    }
                }
            }
        }

        // Urutkan terbaru dulu
        $recentTransactions = collect($recentTransactions)
                                ->sortByDesc('time')
                                ->values();

        // Hitung total pemasukan & pengeluaran
        $totalPemasukan = $recentTransactions->where('type', 'in')->sum('amount');
        $totalPengeluaran = $recentTransactions->where('type', 'out')->sum('amount');

        return view('admin.laporan-penjualan', compact('recentTransactions', 'totalPemasukan', 'totalPengeluaran', 'totalTransaksi'));
    }

    

}
