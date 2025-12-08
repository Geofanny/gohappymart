<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Berita;
use App\Models\Produk;
use App\Models\Ulasan;
use App\Models\Pesanan;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use App\Models\PesananProduk;

class DashboardAdminController extends Controller
{
    public function index()
    {
        // Total Pesanan
        $totalPesanan = Pesanan::count();

        // Pesanan Masuk
        $pesananMasuk = Pesanan::where('status', 'diproses')->count();

        // Pengembalian Barang (yang belum selesai)
        $pengembalianCount = Pengembalian::where('status', '!=', 'selesai')->count();

        // Total Berita
        $totalBerita = Berita::count();

        // Recent Orders: ambil 10 terakhir dengan produk
        $recentOrders = Pesanan::with('produk')->orderBy('tgl_pesanan', 'desc')->take(10)->get();

        $riwayatTransaksi = Pesanan::with('produk')->orderBy('tgl_pesanan', 'desc')->get();

        $recentTransactions = [];

        // Recent Transactions Dinamis (Pengeluaran / Pengembalian Dana)
        foreach ($riwayatTransaksi as $order) {
            // Transaksi masuk: hanya yang status selesai
            if ($order->status === 'selesai') {

                $totalMasuk = 0;

                foreach ($order->produk as $pp) {
                    // jumlah produk yang dibeli
                    $jumlah = $pp->jumlah;
        
                    // harga produk asli
                    $harga = $pp->produk->harga ?? 0;
        
                    $totalMasuk += $jumlah * $harga;
                }

                $recentTransactions[] = [
                    'no' => $order->no_pesanan,
                    'time' => Carbon::parse($order->tgl_pesanan),
                    'amount' => $totalMasuk,
                    'type' => 'in', // uang masuk
                ];
            }
        
            // Transaksi keluar: pengembalian dana selesai
            foreach ($order->pengembalian as $pengembalian) {
                if ($pengembalian->solusi === 'Pengembalian dana' && $pengembalian->status === 'Selesai') {
                    $totalPengembalian = 0;
        
                    foreach ($pengembalian->item as $item) {

                        // Ambil jumlah dari pesanan_produk untuk produk yang sama
                        $pp = $order->produk->firstWhere('id_produk', $item->id_produk);
                        $jumlah = $pp->jumlah ?? 1;

                        // Harga ambil dari produk->harga
                        $harga = $item->produk->harga ?? 0;
                        $totalPengembalian += $jumlah * $harga;
                        
                    }
        
                    if ($totalPengembalian > 0) {
                        $recentTransactions[] = [
                            'no' => $order->no_pesanan,
                            'time' => Carbon::parse($pengembalian->tgl_selesai ?? $pengembalian->tgl_pengajuan),
                            'amount' => $totalPengembalian,
                            'type' => 'out', // uang keluar
                        ];
                    }
                }
            }
        }
        
        // Sort descending by time
        $recentTransactions = collect($recentTransactions)->sortByDesc('time')->take(2)->values();


        $dataChart = Pesanan::with('produk', 'pengembalian.item.produk')
        ->orderBy('tgl_pesanan', 'desc')
        ->take(7) // contoh 7 hari terakhir
        ->get();


        Carbon::setLocale('id'); // Set locale ke Indonesia

        // Array 7 hari minggu ini (Senin s/d Minggu)
        $startOfWeek = Carbon::now()->startOfWeek(); // Senin
        $chartLabels = [];
        $chartMasuk = [];
        $chartKeluar = [];
        $chartTotal = 0;

        $hariArray = [];
        for ($i = 0; $i < 7; $i++) {
            $day = $startOfWeek->copy()->addDays($i);
            $hariArray[$day->format('Y-m-d')] = [
                'label' => $day->translatedFormat('D'), // Singkatan hari: Sen, Sel, Rab, ...
                'masuk' => 0,
                'keluar' => 0
            ];
        }

        // Masukkan data transaksi
        foreach ($dataChart as $order) {
            $tgl = Carbon::parse($order->tgl_pesanan)->format('Y-m-d');

            $masuk = 0;
            $keluar = 0;

            // Masuk
            if ($order->status === 'selesai') {
                foreach ($order->produk as $pp) {
                    $jumlah = $pp->jumlah;
                    $harga = $pp->produk->harga ?? 0; // harga asli produk
            
                    $masuk += $jumlah * $harga;
                }

                // dd($masuk);
            }


            // Keluar
            foreach ($order->pengembalian as $pengembalian) {
                if ($pengembalian->solusi === 'Pengembalian dana' && $pengembalian->status === 'Selesai') {
                    $totalPengembalian = 0;
                    foreach ($pengembalian->item as $item) {
                        $pp = $order->produk->firstWhere('id_produk', $item->id_produk);
                        $jumlah = $pp->jumlah ?? 1;
                        $harga = $item->produk->harga ?? 0;
                        $totalPengembalian += $jumlah * $harga;
                    }
                    $keluar += $totalPengembalian;
                }
            }

            if (isset($hariArray[$tgl])) {
                $hariArray[$tgl]['masuk'] += $masuk;
                $hariArray[$tgl]['keluar'] += $keluar;
                $chartTotal += ($masuk - $keluar);
            }
        }

        // Masukkan ke array chart
        foreach ($hariArray as $h) {
            $chartLabels[] = $h['label'];
            $chartMasuk[] = $h['masuk'];
            $chartKeluar[] = $h['keluar'];
        }

        $totalMasuk = array_sum($chartMasuk);
        $totalKeluar = array_sum($chartKeluar);


        $lowStock = Produk::orderBy('stok', 'asc')
        ->limit(3)
        ->get();

        return view('admin.index', compact(
            'totalPesanan',
            'pesananMasuk',
            'pengembalianCount',
            'totalBerita',
            'recentOrders',
            'recentTransactions',
            'chartLabels',
            'chartMasuk',
            'chartKeluar',
            'chartTotal',
            'totalMasuk',
            'totalKeluar',
            'lowStock'
        ));
    }

    
    public function dashboardSuperadmin()
    {
        // 1. Total produk aktif
        $totalProduk = Produk::where('status', 'aktif')->count();
    
        // 2. Total admin aktif
        $totalAdmin = User::where('role', 'admin')
                            ->where('status', 'aktif')
                            ->count();
    
        // 3. Total pesanan selesai
        $totalPesanan = Pesanan::where('status', 'Selesai')->count();
    
        // 4. Rating toko (rata-rata tipe 'toko')
        $ratingToko = Ulasan::where('tipe', 'toko')->avg('rating') ?? 0;
    
        // total ulasan toko
        $jumlahUlasanToko = Ulasan::where('tipe', 'toko')->count();

        $recentOrders = Pesanan::with('produk')->orderBy('tgl_pesanan', 'desc')->take(10)->get();

        $riwayatTransaksi = Pesanan::with('produk')->orderBy('tgl_pesanan', 'desc')->get();

        $recentTransactions = [];

        // Recent Transactions Dinamis (Pengeluaran / Pengembalian Dana)
        foreach ($riwayatTransaksi as $order) {
            // Transaksi masuk: hanya yang status selesai
            if ($order->status === 'selesai') {

                $totalMasuk = 0;

                foreach ($order->produk as $pp) {
                    // jumlah produk yang dibeli
                    $jumlah = $pp->jumlah;
        
                    // harga produk asli
                    $harga = $pp->produk->harga ?? 0;
        
                    $totalMasuk += $jumlah * $harga;
                }

                $recentTransactions[] = [
                    'no' => $order->no_pesanan,
                    'time' => Carbon::parse($order->tgl_pesanan),
                    'amount' => $totalMasuk,
                    'type' => 'in', // uang masuk
                ];
            }
        
            // Transaksi keluar: pengembalian dana selesai
            foreach ($order->pengembalian as $pengembalian) {
                if ($pengembalian->solusi === 'Pengembalian dana' && $pengembalian->status === 'Selesai') {
                    $totalPengembalian = 0;
        
                    foreach ($pengembalian->item as $item) {

                        // Ambil jumlah dari pesanan_produk untuk produk yang sama
                        $pp = $order->produk->firstWhere('id_produk', $item->id_produk);
                        $jumlah = $pp->jumlah ?? 1;

                        // Harga ambil dari produk->harga
                        $harga = $item->produk->harga ?? 0;
                        $totalPengembalian += $jumlah * $harga;
                        
                    }
        
                    if ($totalPengembalian > 0) {
                        $recentTransactions[] = [
                            'no' => $order->no_pesanan,
                            'time' => Carbon::parse($pengembalian->tgl_selesai ?? $pengembalian->tgl_pengajuan),
                            'amount' => $totalPengembalian,
                            'type' => 'out', // uang keluar
                        ];
                    }
                }
            }
        }
        
        // Sort descending by time
        $recentTransactions = collect($recentTransactions)->sortByDesc('time')->take(2)->values();


        $dataChart = Pesanan::with('produk', 'pengembalian.item.produk')
        ->orderBy('tgl_pesanan', 'desc')
        ->get();


        Carbon::setLocale('id'); // Set locale ke Indonesia

        // Array 7 hari minggu ini (Senin s/d Minggu)
        $year = Carbon::now()->year;
        $chartLabels = [];
        $chartMasuk = [];
        $chartKeluar = [];
        $chartTotal = 0;

        $bulanArray = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulanArray[$i] = [
                'label' => Carbon::create($year, $i, 1)->translatedFormat('M'), // Jan, Feb, Mar...
                'masuk' => 0,
                'keluar' => 0
            ];
        }

        foreach ($dataChart as $order) {

            $bulan = Carbon::parse($order->tgl_pesanan)->month;
        
            $masuk = 0;
            $keluar = 0;
        
            // Masuk
            if ($order->status === 'selesai') {
                foreach ($order->produk as $pp) {
                    $jumlah = $pp->jumlah;
                    $harga = $pp->produk->harga ?? 0; // harga asli produk
            
                    $masuk += $jumlah * $harga;
                }
            }
        
            // Keluar
            foreach ($order->pengembalian as $pengembalian) {
                if ($pengembalian->solusi === 'Pengembalian dana' && $pengembalian->status === 'Selesai') {
                    $totalPengembalian = 0;
        
                    foreach ($pengembalian->item as $item) {
                        $pp = $order->produk->firstWhere('id_produk', $item->id_produk);
                        $jumlah = $pp->jumlah ?? 1;
                        $harga = $item->produk->harga ?? 0;
        
                        $totalPengembalian += ($jumlah * $harga);
                    }
        
                    $keluar += $totalPengembalian;
                }
            }
        
            // Masukkan ke bulan terkait
            if (isset($bulanArray[$bulan])) {
                $bulanArray[$bulan]['masuk'] += $masuk;
                $bulanArray[$bulan]['keluar'] += $keluar;
                $chartTotal += ($masuk - $keluar);
            }
        }
        
        // Siapkan data untuk chart
        $chartLabels = [];
        $chartMasuk = [];
        $chartKeluar = [];
        
        foreach ($bulanArray as $b) {
            $chartLabels[] = $b['label'];
            $chartMasuk[] = $b['masuk'];
            $chartKeluar[] = $b['keluar'];
        }
        
        $totalMasuk = array_sum($chartMasuk);
        $totalKeluar = array_sum($chartKeluar);


        $lowStock = Produk::orderBy('stok', 'asc')
        ->limit(3)
        ->get();

        $recentRatings = Ulasan::with('pelanggan')
        ->orderBy('tgl_ulasan', 'desc')
        ->where('tipe','toko')
        ->limit(3)
        ->get();

        $produkTerlaris = PesananProduk::select('id_produk')
        ->with('produk')
        ->whereHas('pesanan', function ($q) {
            $q->where('status', 'Selesai');
        })
        ->selectRaw('SUM(jumlah) as total_terjual')
        ->groupBy('id_produk')
        ->orderByDesc('total_terjual')
        ->take(5) // ambil 5 teratas
        ->get();
        

        // dd($produkTerlaris);
        // Siapkan data untuk Chart
        $pieLabels = $produkTerlaris->pluck('produk.nama_produk');
        $pieValues = $produkTerlaris->pluck('total_terjual');

        $penjualanPromo = PesananProduk::selectRaw('
            MONTH(pesanan.tgl_pesanan) as bulan,
            promo.kategori,
            SUM(pesanan_produk.jumlah) as total_terjual
        ')
        ->join('pesanan', 'pesanan.id_pesanan', '=', 'pesanan_produk.id_pesanan')
        ->leftJoin('pengembalian', function($join){
            $join->on('pengembalian.id_pesanan', '=', 'pesanan.id_pesanan')
                ->where('pengembalian.status', 'Selesai');
        })
        ->join('produk_promo', 'produk_promo.id_produk', '=', 'pesanan_produk.id_produk')
        ->join('promo', 'promo.id_promo', '=', 'produk_promo.id_promo')
        ->where('pesanan.status', 'Selesai')
        ->whereNull('pengembalian.id_pengembalian') // pastikan tidak ada pengembalian selesai
        ->groupBy('bulan', 'promo.kategori')
        ->get();

        $labels = [];
        $seriesFlash = [];
        $seriesBig = [];
        $seriesUmum = [];

        for ($i = 1; $i <= 12; $i++) {

            $labels[] = Carbon::create(null, $i, 1)->translatedFormat('M');

            $seriesFlash[] = $penjualanPromo->where('bulan', $i)
                                            ->where('kategori', 'flashsale')
                                            ->sum('total_terjual');

            $seriesBig[] = $penjualanPromo->where('bulan', $i)
                                        ->where('kategori', 'bigsale')
                                        ->sum('total_terjual');

            $seriesUmum[] = $penjualanPromo->where('bulan', $i)
                                        ->where('kategori', 'umum')
                                        ->sum('total_terjual');
        }



        // dd($pieLabels);

        return view('superAdmin.index', compact(
            'totalProduk',
            'totalAdmin',
            'totalPesanan',
            'ratingToko',
            'jumlahUlasanToko',
            'recentOrders',
            'recentTransactions',
            'chartLabels',
            'chartMasuk',
            'chartKeluar',
            'chartTotal',
            'totalMasuk',
            'totalKeluar',
            'lowStock',
            'recentRatings',
            'pieLabels',
            'pieValues',
            'labels',
            'seriesFlash',
            'seriesBig',
            'seriesUmum'
        ));
    }
    
}
