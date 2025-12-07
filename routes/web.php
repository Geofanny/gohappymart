<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\RajaOngkirController;
use App\Http\Controllers\AdminBeritaController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\SuperAdminRegulasiController;

// Route::get('/', function () {
//     // return view('dashboard/index');
//     return redirect('/beranda');
// });

Route::get('/', [BerandaController::class,'index']);
Route::get('/profil', [BerandaController::class,'menuSaya']);
Route::get('/pencarian', [BerandaController::class, 'cariProduk'])->name('pelanggan.cariProduk');

Route::get('/cari-produk', [BerandaController::class,'cariProduk']);
Route::get('/detail-produk/{id_produk}', [ProdukController::class,'index']);

Route::get('/detail-promo', [PromoController::class,'detailPromo']);

// Login
Route::get('/login', [AuthController::class,'login']);
Route::get('/akun-baru', [AuthController::class,'daftar']);
Route::post('/akun-baru', [AuthController::class, 'store']);

Route::middleware(['auth:pelanggan'])->group(function () {

    // Beranda
    Route::get('/keranjang/count', [BerandaController::class, 'getCount']);

    // Wishlist
    Route::post('/wishlist/favorit-multiple', [ProdukController::class, 'favoritMultiple']);
    Route::post('/wishlist/{id_produk}', [ProdukController::class,'wishlistProduk']);
    Route::get('/wishlist/count', [BerandaController::class, 'count'])->name('wishlist.count');
    Route::get('/wishlist', [WishlistController::class,'wishlist']);
    Route::get('/wishlist/data', [WishlistController::class,'wishlistData']);

    // kERANJANG
    Route::post('/tambah-keranjang', [KeranjangController::class,'tambahKeranjang']);
    Route::get('/keranjang', [KeranjangController::class,'keranjang']);
    Route::post('/keranjang/update/{id}', [KeranjangController::class, 'updateJumlah']);
    Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'hapusProduk']);
    Route::get('/keranjang/partial', [KeranjangController::class, 'renderKeranjangPartial']);
    Route::delete('/keranjang/hapus-multiple', [KeranjangController::class, 'hapusBanyak']);

    // Checkout
    Route::get('/checkout', [TransaksiController::class,'transaksi']);
    Route::post('/checkout-session', [TransaksiController::class, 'addToCheckout'])->name('checkout.session');
    Route::post('/get-snap-token', [TransaksiController::class, 'getSnapToken']);

    // RajaOngkir
    Route::get('/api/provinsi', [RajaOngkirController::class, 'getProvinces']);
    Route::get('/api/kota/{province_id}', [RajaOngkirController::class, 'getCities']);
    Route::get('/api/kecamatan/{city_id}', [RajaOngkirController::class, 'getDistricts']);
    Route::post('/api/ongkir', [RajaOngkirController::class, 'calculateShipping']);

    // PESANAN
    Route::post('/pesanan/cod', [PesananController::class, 'buatPesananCOD'])->name('pesanan.cod');
    Route::post('/pesanan/midtrans-sukses', [PesananController::class, 'buatPesananMidtrans']);
    Route::get('/pesanan-berhasil', [PesananController::class, 'pesananBerhasil']);
    Route::get('/pesanan', [PesananController::class, 'pesananSaya']);
    Route::get('/detail-pesanan/{id_pesanan}', [PesananController::class, 'detailPesanan']);
    Route::post('/pesanan-batal/{id}', [PesananController::class, 'batalkanPesanan']);

    // TERIMA PESANAN
    Route::post('/terimaPesanan/{id}', [PesananController::class, 'statusTerima']);

    // PENGEMBALIAN
    Route::get('/pesanan/ajuan/pengembalian/{id}', [PesananController::class, 'ajuanPengembalian']);
    Route::post('/pengembalian/store', [PesananController::class, 'konfirmasiPengembalian'])->name('pengembalian.store');
    Route::get('/detail-pengembalian/{id}', [PesananController::class, 'detailPengembalian']);
    Route::post('/pengembalian/{id}/update-resi-tunggu', [PesananController::class, 'updateResi']);
    Route::post('/pengembalian/selesaikan/{id}', [PesananController::class, 'selesaikanPengembalian']);

    // PENILAIAN
    Route::get('/penilaian/pesanan/{id}', [PesananController::class, 'penilaianPesanan']);
    Route::post('/ulasan/{id_pesanan}', [PesananController::class, 'tambahPenilaian'])
        ->name('ulasan.store');


});

Route::middleware(['auth.admin', 'role:superadmin'])->group(function () {

    // TOKO
    Route::get('/dashboard/toko/profil', [TokoController::class,'index']);
    Route::post('/profilToko', [TokoController::class,'storeOrUpdate']);

    // Regulasi
    Route::get('/dashboard-superadmin/regulasi', [SuperAdminRegulasiController::class,'index']);

    Route::get('/dashboard/daftarAdmin', [PelangganController::class,'daftarAdmin']);
    Route::post('/admin/store', [PelangganController::class, 'storeAdmin']);

    Route::post('/admin/{id}/update-password-admin', [PelangganController::class, 'updatePasswordAdmin']);
    // Update status pelanggan (aktif / nonaktif)
    Route::post('/admin/{id}/update-status', [PelangganController::class, 'updateStatusAdmin'])
    ->name('admin.updateStatusAdmin');

    
    Route::delete('/admin/{id}', [PelangganController::class, 'destroyAdmin'])
     ->name('admin.destroy');

    Route::get('/dashboard/rating/toko', [PesananController::class, 'menuRatingToko']);

    Route::get('/dashboard/laporan/keuangan', [PesananController::class, 'menuLaporanKeuangan']);

    Route::get('/laporan-keuangan/pdf', [LaporanController::class, 'generatePdf'])->name('laporan-keuangan.pdf');
    
});

Route::middleware(['auth.admin', 'role:admin'])->group(function () {

    Route::get('/dashboard/admin', [DashboardAdminController::class,'index']);

    // BERITA
    Route::get('/dashboard/berita', [AdminBeritaController::class, 'index']);
    Route::get('/dashboard-admin/berita/baru', [AdminBeritaController::class,'create']);
    Route::post('/beritaBaru', [AdminBeritaController::class,'store']);
    Route::delete('/hapusBerita/{id_berita}', [AdminBeritaController::class,'destroy']);
    Route::post('/publishBerita/{id_berita}', [AdminBeritaController::class,'publish']);
    Route::post('/draftBerita/{id_berita}', [AdminBeritaController::class,'unpublish']);
    Route::get('/dashboard-admin/berita/edit/{id}', [AdminBeritaController::class,'edit']);
    Route::post('/dashboard-admin/berita/update/{id_berita}', [AdminBeritaController::class,'update']);

    // PESANAN
    Route::get('/dashboard/pesanan', [PesananController::class, 'menuPesanan']);
    Route::post('/pesanan/update-status/{id}', [PesananController::class, 'updateStatus'])
    ->name('pesanan.updateStatus');
    Route::post('/pesanan/{id}/update-status', [PesananController::class, 'updateStatusTolak'])
    ->name('pesanan.updateStatusTolak');
    Route::post('/pesanan/{id}/upload-resi', [PesananController::class, 'uploadResi'])
    ->name('pesanan.uploadResi');

    // PENGIRIMAN
    Route::get('/dashboard/pengiriman', [PesananController::class, 'pengiriman']);

    // PEMBAYARAN
    Route::get('/dashboard/pembayaran', [PesananController::class, 'menuPembayaran']);

    // PENGEMBALIAN
    Route::get('/dashboard/pengembalian', [PesananController::class, 'menuPengembalian']);
    Route::post('pengembalian/{id}/terima', [PesananController::class, 'terima'])->name('pengembalian.terima');
    Route::post('pengembalian/{id}/tolak', [PesananController::class, 'tolak'])->name('pengembalian.tolak');
    Route::post('pengembalian/{id}/update-resi', [PesananController::class, 'updateResiUlang'])
    ->name('pengembalian.updateResi');
    Route::post('/pengembalian/selesaikan/{id}/admin', [PesananController::class, 'selesaikanStatusPengembalian']);

    // FAQ
    Route::get('/dashboard-admin/faq', [SuperAdminRegulasiController::class,'faq']);


    // RATING
    Route::get('/dashboard/rating', [PesananController::class, 'menuRating']);
    Route::post('/admin/ulasan/{id}/reply', [PesananController::class, 'reply'])
     ->name('admin.ulasan.reply');

     Route::get('/pelanggan/print', [LaporanController::class, 'printPelanggan'])
     ->name('pelanggan.print');

});

Route::middleware(['auth.admin', 'role:admin,superadmin'])->group(function () {

    Route::get('/dashboard/superadmin', [DashboardAdminController::class,'dashboardSuperadmin']);

    // Produk
    Route::get('/dashboard-admin/produk', [AdminProductController::class,'index']);
    Route::get('/dashboard-admin/produk/baru', [AdminProductController::class,'create']);
    Route::post('/storeProduk', [AdminProductController::class, 'store']);
    Route::delete('/destroyProduk/{id}', [AdminProductController::class, 'destroy']);
    Route::get('/dashboard-admin/produk/edit/{id}', [AdminProductController::class, 'edit'])->name('produk.edit');
    Route::put('/dashboard-admin/produk/update/{id}', [AdminProductController::class, 'update'])->name('produk.update');
    // Route::post('/produk/update-stok/{id}', [AdminProductController::class, 'updateStok'])->name('produk.updateStok');
    Route::post('/check-sku', [AdminProductController::class, 'checkSku']);

    Route::get('/dashboard-admin/stok', [AdminProductController::class,'stok']);
    // Route::post('/updateStok/{id}', [AdminProductController::class, 'updateStok']);
    Route::post('/updateStok/{id_produk}', [AdminProductController::class, 'updateStok']);

    // Kategori
    Route::get('/dashboard-admin/kategori', [AdminProductController::class,'kategori']);
    Route::get('/dashboard-admin/listKategori', [AdminProductController::class,'listKategori']);
    Route::post('/createKategori', [AdminProductController::class,'createKategori']);
    Route::delete('/destroyKategori/{id}', [AdminProductController::class,'destroyKategori']);
    Route::get('/getKategori/{id}', [AdminProductController::class, 'getKategori']);
    Route::put('/updateKategori/{id}', [AdminProductController::class, 'updateKategori']);
    Route::post('/checkKategori', [AdminProductController::class, 'checkKategori']);

    // Diskon
    Route::get('/dashboard-superadmin/diskon', [PromoController::class,'diskon']);
    Route::post('/diskonBaru', [PromoController::class, 'diskonBaru']);
    Route::post('/updateDiskon/{id_promo}', [PromoController::class, 'updateDiskon'])->name('updateDiskon');
    Route::get('/hapusDiskon/{id}', [PromoController::class, 'destroy']);

    // Flash Sale
    Route::get('/flashsale', [PromoController::class,'flashSale']);
    Route::post('/flashsale/simpan', [PromoController::class, 'simpanFlashSale'])->name('flashsale.simpan');
    Route::get('/hapusProdukFlashsale/{id_produk}', [PromoController::class, 'hapusProdukFlashsale'])->name('flashsale.hapusProduk');

    // Big Sale
    Route::get('/bigsale', [PromoController::class,'bigSale']);
    Route::post('/bigsale/simpan', [PromoController::class, 'simpanBigSale'])->name('bigsale.simpan');
    Route::get('/hapusProdukBigsale/{id_produk}', [PromoController::class, 'hapusProdukBigsale'])->name('bigsale.hapusProduk');

    // Produk Promo
    Route::get('/produk-promo', [PromoController::class,'listProduk']);
    Route::get('/promo/{id}/produk', [PromoController::class, 'getProdukPromo'])->name('promo.produk');
    Route::delete('/promo/{promo}/produk/{produk}', [PromoController::class, 'hapusProduk']);
    Route::get('/produk-belum-diskon', [PromoController::class, 'getProdukBelumDiskon']);
    Route::get('/produk-belum-flashsale', [PromoController::class, 'getProdukBelumFlashsale']);
    Route::post('/promo/{promo}/produk', [PromoController::class, 'tambahProdukPromo']);

    Route::get('/dashboard/pelanggan', [PelangganController::class,'daftarPelanggan']);
    // Update password pelanggan
    Route::post('/pelanggan/{id}/update-password-pelanggan', [PelangganController::class, 'updatePasswordPelanggan']);
    // Update status pelanggan (aktif / nonaktif)
    Route::post('/pelanggan/{id}/update-status', [PelangganController::class, 'updateStatus'])
    ->name('pelanggan.updateStatus');
    Route::delete('/pelanggan/{id}', [PelangganController::class, 'destroy'])
    ->name('pelanggan.destroy');


    Route::post('/reguslasiBaru', [SuperAdminRegulasiController::class, 'store']);
    Route::delete('/hapusRegulasi/{id_regulasi}', [SuperAdminRegulasiController::class, 'destroy']);
    Route::put('/updateRegulasi/{id_regulasi}', [SuperAdminRegulasiController::class, 'update']);

    Route::get('/stok-produk/pdf', [LaporanController::class, 'generatePdfStok'])->name('stok-produk.pdf');

    Route::get('/dashboard-admin/produk/laporan/pdf', [LaporanController::class, 'generatePdfProduk'])
    ->name('produk.pdf'); 


});

Route::get('/detail-berita/{id_berita}', [AdminBeritaController::class,'detailBerita']);
Route::get('/berita', [AdminBeritaController::class,'berita']);

Route::post('/akses-login', [AuthController::class, 'aksesLogin']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/dahsboard/login', [AuthController::class,'loginDashboard'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'loginUser'])->name('admin.login.post');
Route::get('/dahsboard/logout', [AuthController::class, 'logoutUser'])->name('admin.logout');

Route::get('/tentang-kami', [TokoController::class,'tentangKami']);
Route::get('/kontak', [TokoController::class,'kontakToko']);

// FAQ pelanggan
Route::get('/faq', [SuperAdminRegulasiController::class,'faqPelanggan']);
Route::get('/kebijakan-toko', [SuperAdminRegulasiController::class,'kebijakanToko']);
