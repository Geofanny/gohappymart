# Go Happy Mart (UMKM E-Commerce Platform)

Go Happy Mart adalah aplikasi **E-Commerce UMKM** berbasis **Laravel
11** yang dirancang untuk membantu pelaku UMKM dalam mengelola penjualan
secara digital. Aplikasi ini memudahkan pengelolaan produk, stok,
transaksi, serta pembayaran online (Midtrans), sehingga UMKM dapat
menjalankan bisnis secara lebih efektif dan profesional.

## 🚀 Features

-   Manajemen Produk & Kategori
-   Manajemen Stok & Laporan
-   Checkout & Pembayaran Midtrans (Snap)
-   Manajemen Pesanan & Status
-   Dashboard Admin
-   Sistem Penilaian Pesanan
-   Antarmuka modern & responsive

## 📁 Project Structure & Coding Workflow

1.  **Views** → `resources/views/`
2.  **Controllers** → daftar & hubungkan view
3.  **Routes** → `routes/web.php`
4.  **Models** → query dan proses database
5.  **Assets** → `public/`

## 📦 Installation

### 1. Clone Repository

``` bash
git clone https://github.com/Geofanny/gohappymart.git
cd gohappymart
```

### 2. Install Dependencies

``` bash
composer install
```

### 3. Copy Environment File

``` bash
cp .env.example .env
```

### 4. Generate App Key

``` bash
php artisan key:generate
```

### 5. Migrate & Seed Database

``` bash
php artisan migrate
php artisan db:seed
```

### 6. Run Server

``` bash
php artisan serve
```

## ⚙️ Environment (.env)

    APP_NAME=gohappymart
    APP_ENV=local
    APP_KEY=base64:xxxxxxxxxxxxxxxx
    APP_DEBUG=true
    APP_URL=http://localhost

    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=gohappymart
    DB_USERNAME=root
    DB_PASSWORD=

# 💳 Midtrans Integration

Aplikasi ini mendukung pembayaran online menggunakan **Midtrans Snap**.

### 🔧 Tambahkan pada `.env`:

    MIDTRANS_MERCHANT_ID=XXXXXXX
    MIDTRANS_CLIENT_KEY=SB-Mid-client-XXXXXXXX
    MIDTRANS_SERVER_KEY=SB-Mid-server-XXXXXXXX
    MIDTRANS_IS_PRODUCTION=false

### 💡 Alur Pembayaran Midtrans

1.  User melakukan checkout di aplikasi
2.  Aplikasi meminta **snap_token** ke Midtrans
3.  User membayar melalui popup Snap
4.  Midtrans mengirim notifikasi callback
5.  Status pesanan diperbarui otomatis

## 📂 Storage Symlink & File Upload Fix

Jika gambar tidak muncul dan muncul error **403 Forbidden**, lakukan
langkah berikut:

### 1. Hapus symlink lama

``` bash
rmdir public/storage -force -recurse
```

### 2. Buat ulang symlink Laravel

``` bash
php artisan storage:link
```

### 3. Pastikan struktur direktori benar

-   Path publik: `public/storage/uploads/produk/namafile.jpg`
-   Path sumber: `storage/app/public/uploads/produk/namafile.jpg`

### 4. Pastikan permission folder benar (Linux)

``` bash
chmod -R 775 storage
chmod -R 775 public/storage
```

Jika semua benar, gambar akan tampil normal.

## 🧪 Running Tests

``` bash
php artisan serve
```

## 📜 License

Open-source mengikuti ketentuan repository.
