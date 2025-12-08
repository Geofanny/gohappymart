<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function generatePdf(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $toko = Toko::first(); // ambil info toko

        $riwayatTransaksi = Pesanan::with(['produk.produk', 'pengembalian.item.produk'])
            ->whereYear('tgl_pesanan', $tahun)
            ->whereMonth('tgl_pesanan', $bulan)
            ->orderBy('tgl_pesanan', 'desc')
            ->get();

        $recentTransactions = [];

        foreach ($riwayatTransaksi as $order) {
            // Pemasukan
            if ($order->status === 'selesai') {
                $totalMasuk = 0;
                foreach ($order->produk as $pp) {
                    $totalMasuk += ($pp->jumlah * ($pp->produk->harga ?? 0));
                }
                if ($totalMasuk > 0) {
                    $recentTransactions[] = [
                        'no' => $order->no_pesanan,
                        'time' => Carbon::parse($order->tgl_pesanan),
                        'amount' => $totalMasuk,
                        'type' => 'in',
                        'keterangan' => 'Penjualan pesanan #' . $order->no_pesanan
                    ];
                }
            }

            // Pengeluaran
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

        $recentTransactions = collect($recentTransactions)->sortByDesc('time')->values();

        $totalPemasukan = $recentTransactions->where('type', 'in')->sum('amount');
        $totalPengeluaran = $recentTransactions->where('type', 'out')->sum('amount');

        $pdf = Pdf::loadView('superAdmin.laporan-keuangan-pdf', compact(
            'recentTransactions',
            'totalPemasukan',
            'totalPengeluaran',
            'bulan',
            'tahun',
            'toko'
        ));

        return $pdf->stream('laporan-keuangan_'.$bulan.'_'.$tahun.'.pdf');
    }

    public function printPelanggan(Request $request)
    {
        $status = $request->status;

        $query = Pelanggan::query();

        if ($status) {
            $query->where('status', $status);
        }

        $pelanggan = $query->orderBy('nama_pelanggan')->get();

        // Generate PDF
        $pdf = Pdf::loadView('admin.laporan-pelanggan', compact('pelanggan', 'status'));
        return $pdf->stream('laporan-pelanggan.pdf');
    }

    public function generatePdfStok(Request $request)
    {
        $status = $request->status; // ambil filter status
    
        $query = Produk::query();
    
        // Filter berdasarkan status stok sesuai legend
        if ($status) {
            if ($status === 'habis') {
                $query->where('stok', 0);
            } elseif ($status === 'hampir-habis') {
                $query->whereBetween('stok', [1, 5]);
            } elseif ($status === 'menipis') {
                $query->whereBetween('stok', [6, 20]);
            } elseif ($status === 'aman') {
                $query->where('stok', '>', 20);
            }
        }
    
        $produk = $query->orderBy('nama_produk')->get();
    
        $toko = \App\Models\Toko::first(); // info toko
        $tanggalCetak = Carbon::now()->translatedFormat('d F Y H:i');
    
        $pdf = Pdf::loadView('admin.laporan-stok', compact('produk', 'status', 'toko', 'tanggalCetak'));
        return $pdf->stream('laporan-stok-produk.pdf');
    }

    public function generatePdfProduk(Request $request)
    {
        // Ambil semua produk beserta kategori
        $produk = Produk::with('kategori')
            ->orderBy('id_kategori')
            ->orderBy('nama_produk')
            ->get();

        // Group produk per kategori (nama field di Kategori = 'nama')
        $produkPerKategori = $produk->groupBy(function($item) {
            return $item->kategori->nama ?? 'Tanpa Kategori';
        });

        // Cek hasil
        // dd($produkPerKategori);

        $toko = Toko::first(); // Info toko
        $tanggalCetak = Carbon::now()->translatedFormat('d F Y H:i');

        $pdf = Pdf::loadView('admin.laporan-produk', compact('produkPerKategori', 'toko', 'tanggalCetak'));
        return $pdf->stream('laporan-produk.pdf');
    }

    public function generatePenjualanPdf(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $toko = Toko::first(); // ambil info toko

        $riwayatTransaksi = Pesanan::with(['produk.produk', 'pengembalian.item.produk'])
            ->whereYear('tgl_pesanan', $tahun)
            ->whereMonth('tgl_pesanan', $bulan)
            ->orderBy('tgl_pesanan', 'desc')
            ->get();

        $recentTransactions = [];

        foreach ($riwayatTransaksi as $order) {
            // Pemasukan
            if ($order->status === 'selesai') {
                $totalMasuk = 0;
                foreach ($order->produk as $pp) {
                    $totalMasuk += ($pp->jumlah * ($pp->produk->harga ?? 0));
                }
                if ($totalMasuk > 0) {
                    $recentTransactions[] = [
                        'no' => $order->no_pesanan,
                        'time' => Carbon::parse($order->tgl_pesanan),
                        'amount' => $totalMasuk,
                        'type' => 'in',
                        'keterangan' => 'Penjualan pesanan #' . $order->no_pesanan
                    ];
                }
            }

            // Pengeluaran
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

        $recentTransactions = collect($recentTransactions)->sortByDesc('time')->values();

        $totalPemasukan = $recentTransactions->where('type', 'in')->sum('amount');
        $totalPengeluaran = $recentTransactions->where('type', 'out')->sum('amount');

        $pesanan = Pesanan::with([
            'produk.produk',
            'pengembalian.item.produk',
            'pembayaran',
            'pengiriman'
        ])
        ->whereYear('tgl_pesanan', $tahun)
        ->whereMonth('tgl_pesanan', $bulan)
        ->orderBy('tgl_pesanan', 'desc')
        ->get();
    
        $laporanPesananSelesai = [];
        $laporanPengembalian = [];
        $produkTerjual = [];
        $produkDikembalikan = [];
    
        foreach ($pesanan as $order) {
            // -----------------------
            // Pesanan Selesai
            // -----------------------
            if ($order->status === 'selesai') {
                $totalPesanan = 0;
                foreach ($order->produk as $pp) {
                    $jumlah = $pp->jumlah;
                    $harga = $pp->produk->harga ?? 0;
                    $totalPesanan += $jumlah * $harga;
    
                    // catat produk terjual
                    if (!isset($produkTerjual[$pp->id_produk])) {
                        $produkTerjual[$pp->id_produk] = [
                            'nama' => $pp->produk->nama_produk,
                            'jumlah' => 0,
                        ];
                    }
                    $produkTerjual[$pp->id_produk]['jumlah'] += $jumlah;
                }
    
                $laporanPesananSelesai[] = [
                    'no_pesanan' => $order->no_pesanan,
                    'tgl_pesanan' => Carbon::parse($order->tgl_pesanan),
                    'total' => $totalPesanan,
                    'metode_pembayaran' => $order->pembayaran->metode ?? '-',
                    'jasa_kirim' => $order->pengiriman->jasa_kirim ?? '-'
                ];
            }
    
            // -----------------------
            // Pengembalian Selesai
            // -----------------------
            foreach ($order->pengembalian as $pengembalian) {
                if ($pengembalian->status === 'Selesai') {
                    $totalPengembalian = 0;
                    foreach ($pengembalian->item as $item) {
                        $pp = $order->produk->firstWhere('id_produk', $item->id_produk);
                        $jumlah = $pp->jumlah ?? 1;
                        $harga = $item->produk->harga ?? 0;
                        $totalPengembalian += $jumlah * $harga;
    
                        // catat produk dikembalikan
                        if (!isset($produkDikembalikan[$item->id_produk])) {
                            $produkDikembalikan[$item->id_produk] = [
                                'nama' => $item->produk->nama_produk,
                                'jumlah' => 0,
                            ];
                        }
                        $produkDikembalikan[$item->id_produk]['jumlah'] += $jumlah;
                    }
    
                    $laporanPengembalian[] = [
                        'no_pengembalian' => $pengembalian->no_pengembalian,
                        'tgl_selesai' => Carbon::parse($pengembalian->tgl_selesai ?? $pengembalian->tgl_pengajuan),
                        'total' => $totalPengembalian,
                        'pesanan' => $order->no_pesanan,
                    ];
                }
            }
        }
    
        // Ubah array produk menjadi numerik
        $produkTerjual = array_values($produkTerjual);
        $produkDikembalikan = array_values($produkDikembalikan);

        $pdf = Pdf::loadView('admin.laporan-penjualan-pdf', compact(
            'recentTransactions',
            'totalPemasukan',
            'totalPengeluaran',
            'laporanPesananSelesai',
            'laporanPengembalian',
            'produkTerjual',
            'produkDikembalikan',
            'bulan',
            'tahun',
            'toko'
        ));

        return $pdf->stream('laporan-penjualan_'.$bulan.'_'.$tahun.'.pdf');
    }

    
    

    
}
