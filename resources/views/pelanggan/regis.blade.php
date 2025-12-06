@extends('layouts/main-pelanggan')

@section('link')
    <link rel="stylesheet" href="{{ asset('assets-user') }}/vendors/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="{{ asset('assets-user') }}/vendors/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets-user') }}/vendors/linericon/style.css">
    <link rel="stylesheet" href="{{ asset('assets-user') }}/vendors/bootstrap/bootstrap.min.css">
@endsection

@section('content')
    <!--================Login Box Area =================-->
    <section class="login_box_area section-margin">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login_box_img">
                        <div class="hover">
                            <img src="{{ asset('assets-user') }}/img/logo-toko.png" alt="Go Happy Mart Logo"
                                style="width: 200px; margin-bottom: 15px;">

                            <h3 style="color: #fff; font-weight: 700; margin-bottom: 10px;">
                                Selamat Datang di <span style="color: #ffb400;">Go Happy Mart</span>
                            </h3>

                            <p
                                style="
                color: #e8f0ff;
                font-size: 18px;
                font-weight: 500;
                letter-spacing: 0.5px;
                margin-top: 10px;
                font-style: italic;
            ">
                                Belanja Tanpa Ribet
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login_form_inner"
                        style="background:#fff; padding:40px 35px; border-radius:15px; box-shadow:0 3px 15px rgba(0,0,0,0.1);">
                        <h3 style="text-align:center; font-weight:700; margin-bottom:25px;">CREATE AN ACCOUNT</h3>

                        <form class="login_form" action="/akun-baru" id="contactForm" method="Post">
                            @csrf

                            <!-- Nama & Email sejajar -->
                            <div class="row">
                                <div class="col-md-6 form-group" style="margin-bottom:15px;">
                                    <label for="nama"
                                        style="font-weight:600; font-size:14px; display:block; margin-bottom:3px; text-align:left;">Nama
                                        Pelanggan</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        placeholder="Masukkan Nama Pelanggan"
                                        style="height:45px; border-radius:10px; border:1px solid #ccc; padding:10px 15px;">
                                </div>

                                <div class="col-md-6 form-group" style="margin-bottom:15px;">
                                    <label for="email"
                                        style="font-weight:600; font-size:14px; display:block; margin-bottom:3px; text-align:left;">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Masukkan Email"
                                        style="height:45px; border-radius:10px; border:1px solid #ccc; padding:10px 15px;">
                                </div>
                            </div>

                            <!-- Jenis Kelamin (vertikal) -->
                            <div class="form-group" style="margin-bottom:12px;">
                                <label
                                    style="font-weight:600; font-size:14px; display:block; margin-bottom:5px; text-align:left;">
                                    Jenis Kelamin
                                </label>
                                <div
                                    style="display:flex; flex-direction:row; align-items:center; gap:20px; padding-left:3px;">
                                    <label
                                        style="display:flex; align-items:center; gap:6px; margin:0; cursor:pointer; line-height:1;">
                                        <input type="radio" name="jk" value="L"
                                            style="accent-color:#007bff; margin:0;">
                                        <span style="font-size:14px;">Laki-laki</span>
                                    </label>
                                    <label
                                        style="display:flex; align-items:center; gap:6px; margin:0; cursor:pointer; line-height:1;">
                                        <input type="radio" name="jk" value="P"
                                            style="accent-color:#007bff; margin:0;">
                                        <span style="font-size:14px;">Perempuan</span>
                                    </label>
                                </div>
                            </div>


                            <!-- Nomor HP -->
                            <div class="form-group" style="margin-bottom:15px;">
                                <label for="no_hp"
                                    style="font-weight:600; font-size:14px; display:block; margin-bottom:3px; text-align:left;">Nomor
                                    HP</label>
                                <input type="text" class="form-control" id="no_hp" name="no_hp"
                                    placeholder="Masukkan Nomor HP"
                                    style="height:45px; border-radius:10px; border:1px solid #ccc; padding:10px 15px;">
                            </div>

                            <!-- Username & Password sejajar -->
                            <div class="row">
                                <div class="col-md-6 form-group" style="margin-bottom:15px;">
                                    <label for="username"
                                        style="font-weight:600; font-size:14px; display:block; margin-bottom:3px; text-align:left;">Username</label>
                                    <input type="text" class="form-control" id="username" name="username"
                                        placeholder="Masukkan Username"
                                        style="height:45px; border-radius:10px; border:1px solid #ccc; padding:10px 15px;">
                                </div>

                                <div class="col-md-6 form-group" style="margin-bottom:15px;">
                                    <label for="password"
                                        style="font-weight:600; font-size:14px; display:block; margin-bottom:3px; text-align:left;">Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Masukkan Password"
                                        style="height:45px; border-radius:10px; border:1px solid #ccc; padding:10px 15px;">
                                </div>
                            </div>

                            {{-- <!-- Checkbox Syarat & Ketentuan -->
                            <div class="form-group" style="margin-top:-1vh;">
                                <label
                                    style="display:flex; align-items:center; gap:8px; cursor:pointer; font-size:14px; text-align:left;">
                                    <input type="checkbox" name="agree" id="agree"
                                        style="accent-color:#007bff; margin:0;">
                                    <span data-bs-toggle="modal" data-bs-target="#termsModal">Syarat & Ketentuan</span>
                                </label>
                            </div> --}}


                            <!-- Tombol -->
                            <div class="text-center" style="margin-top:1vh;">
                                <button type="submit" class="button button-login w-100"
                                    style="background:#007bff; color:#fff; font-weight:600; border:none; padding:12px; border-radius:10px; transition:0.3s;">
                                    Daftar
                                </button>

                                <p style="text-align:center; font-size:14px; margin-top:15px;">
                                    Sudah punya akun?
                                    <a href="/login" style="color:#007bff; text-decoration:none;">Masuk</a>
                                </p>
                            </div>
                        </form>

                        <!-- MODAL SYARAT & KETENTUAN -->
                        <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                <div class="modal-content" style="border-radius:12px;">
                                    <div class="modal-header" style="border-bottom:1px solid #eee;">
                                        <h5 class="modal-title" id="termsModalLabel" style="font-weight:700;">Syarat &
                                            Ketentuan Toko</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body"
                                        style="max-height:60vh; overflow-y:auto; font-size:14px; text-align:justify;">
                                        <p><strong>1. Ketentuan Umum</strong><br>
                                            Dengan mendaftar di toko kami, Anda setuju untuk memberikan informasi yang benar
                                            dan akurat.
                                        </p>
                                        <p><strong>2. Kebijakan Privasi</strong><br>
                                            Data pribadi Anda digunakan hanya untuk keperluan transaksi dan tidak akan
                                            dibagikan tanpa izin.
                                        </p>
                                        <p><strong>3. Transaksi & Pembayaran</strong><br>
                                            Semua transaksi harus dilakukan melalui metode pembayaran resmi yang telah kami
                                            sediakan.
                                        </p>
                                        <p><strong>4. Pengiriman</strong><br>
                                            Waktu pengiriman dapat bervariasi tergantung lokasi Anda. Kami tidak bertanggung
                                            jawab atas
                                            keterlambatan akibat pihak ekspedisi.
                                        </p>
                                        <p><strong>5. Pengembalian Barang</strong><br>
                                            Barang dapat dikembalikan maksimal 3 hari setelah diterima apabila terdapat
                                            cacat produksi.
                                        </p>
                                        <p><strong>6. Perubahan Syarat</strong><br>
                                            Kami berhak mengubah syarat dan ketentuan ini sewaktu-waktu dengan pemberitahuan
                                            di situs kami.
                                        </p>

                                        <!-- Checkbox setuju di dalam modal -->
                                        <div class="form-group" style="margin-top:20px;">
                                            <label
                                                style="display:flex; align-items:center; gap:8px; cursor:pointer; font-size:14px;">
                                                <input type="checkbox" id="modalAgree"
                                                    style="accent-color:#007bff; margin:0;">
                                                <span>Saya menyetujui Syarat & Ketentuan ini</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="border-top:1px solid #eee;">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                            style="border-radius:8px;">Tutup</button>
                                        <button type="button" class="btn btn-primary" id="confirmTerms"
                                            style="border-radius:8px;">Setuju</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SCRIPT -->


                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--================End Login Box Area =================-->
@endsection

@section('script')
    <script src="{{ asset('assets-user') }}/vendors/bootstrap/bootstrap.bundle.min.js"></script>
    {{-- <script>
    // Saat tombol "Setuju" diklik di modal
    document.getElementById('confirmTerms').addEventListener('click', function () {
        const modalCheckbox = document.getElementById('modalAgree');
        const mainCheckbox = document.getElementById('agree');

        if (modalCheckbox.checked) {
            mainCheckbox.checked = true; // otomatis centang di form utama
            const modal = bootstrap.Modal.getInstance(document.getElementById('termsModal'));
            modal.hide();
        } else {
            alert('Silakan centang pernyataan "Saya menyetujui" terlebih dahulu.');
        }
    });
</script> --}}
@endsection
