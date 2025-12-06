@extends('layouts/dashboard')

@section('content')

    <div class="page-header mb-3">
        <div class="page-block">
            <div class="row align-items-center justify-content-between">
                <div class="col-6">
                    <h1 class="mb-0 fw-semibold text-dark">Profil Toko</h1>
                </div>
                <div class="col-6 text-end">
                    <button type="submit" id="btn-simpan" form="form-toko" class="btn btn-primary px-4">
                        <i class="ti ti-device-floppy me-1"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3 w-100">
        <div class="card-body">
            <form id="form-toko" action="/profilToko" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3 align-items-center">
                    <!-- LOGO -->
                    <div class="col-md-6 d-flex align-items-center gap-3 mb-4">
                        <img src="{{ $toko && $toko->logo ? asset('storage/uploads/toko/logo/' . $toko->logo) : asset('assets/images/logo-toko.png') }}"
                            alt="Logo Toko"
                            style="width:80px;height:80px;object-fit:cover;border-radius:10px;border:2px solid #e5e7eb;">
                        <div class="flex-grow-1">
                            <label class="form-label mb-1 fw-semibold">Logo Toko</label>
                            <input type="file" name="logo" class="form-control form-control-sm w-100 mb-1">
                            <small class="text-muted">JPG, PNG. Max 2MB</small><br>
                            <small class="text-danger d-none error-logo"></small> <!-- pesan error -->
                        </div>
                    </div>

                    <!-- GAMBAR -->
                    <div class="col-md-6 d-flex align-items-center gap-3 mb-4">
                        <img src="{{ $toko && $toko->gambar ? asset('storage/uploads/toko/gambar/' . $toko->gambar) : asset('assets/images/logo-toko.png') }}"
                            alt="Gambar Toko"
                            style="width:80px;height:80px;object-fit:cover;border-radius:10px;border:2px solid #e5e7eb;">
                        <div class="flex-grow-1">
                            <label class="form-label mb-1 fw-semibold">Gambar Toko</label>
                            <input type="file" name="gambar" class="form-control form-control-sm w-100 mb-1">
                            <small class="text-muted">JPG, PNG. Max 2MB</small><br>
                            <small class="text-danger d-none error-gambar"></small> <!-- pesan error -->
                        </div>
                    </div>
                </div>


                <div class="row mb-3 align-items-center">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Nama Toko</label>
                        <input type="text" name="nama" class="form-control w-100"
                            value="{{ old('nama', $toko->nama ?? '') }}" placeholder="Masukkan Nama Toko">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Tagline Toko</label>
                        <input type="text" name="tagline" class="form-control w-100"
                            value="{{ old('tagline', $toko->tagline ?? '') }}" placeholder="Masukkan Tagline Toko">
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Nomor Handphone</label>
                        <input type="text" name="no_hp" class="form-control w-100"
                            value="{{ old('no_hp', $toko->no_hp ?? '') }}" placeholder="Contoh: 081234567890">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control w-100"
                            value="{{ old('email', $toko->email ?? '') }}" placeholder="Contoh: ">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-dark">Visi</label>
                        <textarea name="visi" class="form-control" placeholder="Visi Toko" rows="4">{{ old('visi', $toko->visi ?? '') }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-dark">Misi</label>
                        <textarea name="misi" class="form-control" placeholder="Misi Toko" rows="4">{{ old('misi', $toko->misi ?? '') }}</textarea>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold text-dark">Deskripsi Toko</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control mb-3" rows="3" placeholder="Deskripsikan toko Anda di sini...">{{ old('deskripsi', $toko->deskripsi ?? '') }}</textarea>
                    </div>
                </div>

                <!-- Alamat & Koordinat -->
                @php
                    // Pisahkan alamat dan koordinat dari kolom alamat yang digabung "alamat | koordinat"
                    $alamat = '';
                    $koordinat = '';
                    if ($toko && $toko->alamat) {
                        $parts = explode('|', $toko->alamat);
                        $alamat = trim($parts[0] ?? '');
                        $koordinat = trim($parts[1] ?? '');
                    }
                @endphp

                <div class="mb-4">
                    <label class="form-label fw-bold text-dark">Alamat Lengkap</label>
                    <textarea name="alamat" class="form-control mb-3" rows="3" placeholder="Contoh: Jl. Merdeka No. 45, RT 03/RW 02, Kel. Sukamaju, Kec. Cibinong, Kab. Bogor">{{ old('alamat', $alamat) }}</textarea>

                    <label class="form-label fw-semibold">Koordinat Lokasi</label>
                    <input type="text" name="coordinate" id="coordinate" class="form-control mb-3"
                        value="{{ old('coordinate', $koordinat) }}" placeholder="Contoh: -6.175392, 106.827153">

                    <div style="position: relative; width: 100%; height: 400px; border-radius:8px; overflow:hidden;">
                        <iframe id="mapIframe"
                            src="https://www.google.com/maps?q={{ $koordinat ?: '-6.200000,106.816666' }}&hl=es;z=15&output=embed"
                            style="width:100%;height:100%;border:0;">
                        </iframe>
                        <div id="circleOverlay"
                            style="position: absolute; width: 50px; height: 50px; border-radius: 50%;
                                border: 2px solid red; background-color: rgba(255,0,0,0.2);
                                top: 50%; left: 50%; transform: translate(-50%, -50%);">
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const coordInput = document.getElementById('coordinate');
            const mapIframe = document.getElementById('mapIframe');

            // Update iframe jika koordinat berubah
            coordInput.addEventListener('change', function() {
                const val = coordInput.value.trim();
                if (val.includes(',')) {
                    mapIframe.src = `https://www.google.com/maps?q=${val}&hl=es;z=15&output=embed`;
                }
            });
        });
    </script>
    <!-- Script TinyMCE (WYSIWYG Editor) -->
    <script src="https://cdn.tiny.cloud/1/boirjcaeyjxuv3ilkyyc9ud65xynmmc9sk4fv17mlov28lxl/tinymce/8/tinymce.min.js"
        referrerpolicy="origin" crossorigin="anonymous"></script>
    <script>
        tinymce.init({
            selector: 'textarea#deskripsi',
            menubar: false,
            branding: false,
            statusbar: false,
            plugins: 'lists code table',
            toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist | code',
            height: 300,
            content_style: 'body { font-family:Arial,Helvetica,sans-serif; font-size:14px }'
        });
    </script>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInputs = [{
                    name: 'logo',
                    errorClass: '.error-logo'
                },
                {
                    name: 'gambar',
                    errorClass: '.error-gambar'
                }
            ];

            const btnSimpan = document.getElementById('btn-simpan');
            let fileError = false; // status global error file

            fileInputs.forEach(({
                name,
                errorClass
            }) => {
                const input = document.querySelector(`input[name="${name}"]`);
                const errorText = document.querySelector(errorClass);

                input.addEventListener('change', function() {
                    const file = this.files[0];
                    errorText.classList.add('d-none');
                    errorText.textContent = '';

                    if (!file) {
                        checkButtonState();
                        return;
                    }

                    const allowedTypes = ['image/jpeg', 'image/png'];
                    const maxSize = 2 * 1024 * 1024; // 2MB

                    // 🔴 Cek format
                    if (!allowedTypes.includes(file.type)) {
                        errorText.textContent =
                            'Format file tidak valid. Hanya JPG dan PNG yang diperbolehkan.';
                        errorText.classList.remove('d-none');
                        this.value = '';
                        fileError = true;
                        checkButtonState();
                        return;
                    }

                    // 🔴 Cek ukuran
                    if (file.size > maxSize) {
                        errorText.textContent = 'Ukuran file terlalu besar. Maksimal 2MB.';
                        errorText.classList.remove('d-none');
                        this.value = '';
                        fileError = true;
                        checkButtonState();
                        return;
                    }

                    // ✅ File valid → tampilkan preview
                    const reader = new FileReader();
                    reader.onload = e => {
                        const imgPreview = this.closest('.d-flex').querySelector('img');
                        imgPreview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);

                    // Reset error
                    fileError = false;
                    checkButtonState();
                });
            });

            // 🔐 Fungsi untuk aktif/nonaktif tombol
            function checkButtonState() {
                const anyError = document.querySelectorAll('.text-danger:not(.d-none)').length > 0;
                btnSimpan.disabled = anyError;
                btnSimpan.style.opacity = anyError ? '0.6' : '1';
                btnSimpan.style.cursor = anyError ? 'not-allowed' : 'pointer';
            }
        });
    </script> --}}


    <script src="{{ asset('../assets') }}/js/plugins/sweetalert2.all.min.js"></script>

    <script>
        // Buat instance mixin reusable
        const Toast = Swal.mixin({
            toast: true, // jadi alert-nya tampil seperti toast
            position: 'top-end', // posisi di kanan atas
            showConfirmButton: false, // tanpa tombol OK
            timer: 5000, // auto-close dalam 3 detik
            timerProgressBar: true, // ada progress bar
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if (session('success'))
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        @endif
    </script>
@endsection
