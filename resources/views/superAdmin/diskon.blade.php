@extends('layouts/dashboard')

@section('link')
    <link rel="stylesheet" href="{{ asset('../assets') }}/css/plugins/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@endsection

@section('content')
    <!-- [ breadcrumb ] start -->
    <div class="page-header mb-1" style="margin-bottom: -4vh">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-12 col-md-6 d-flex align-items-center mb-2 mb-md-0">
                    <h1 class="mb-0">Manajemen Diskon</h1>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-md-end justify-content-start">
                    <button type="button" class="btn btn-shadow btn-success d-inline-flex align-items-center"
                        data-bs-toggle="modal" data-bs-target="#modalTambahDiskon">
                        <i class="ti ti-plus me-2"></i>
                        Tambah Diskon
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <!-- DOM/Jquery table start -->
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="dt-responsive">
                    <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Diskon</th>
                                <th>Status</th>
                                <th>Tipe</th>
                                <th>Nilai</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($diskon as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}.</td>
                                    <td>{{ $item->nama_promo }}</td>
                                    <td>
                                        @if ($item->status == 'Aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->tipe }}</td>
                                    <td>
                                        {{ $item->tipe == 'Persen' ? $item->nilai_diskon . '%' : 'Rp. ' . number_format($item->nilai_diskon, 0, ',', '.') }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item->tgl_mulai)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tgl_selesai)->format('d/m/Y') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning btnEdit" data-id="{{ $item->id_promo }}"
                                            data-nama="{{ $item->nama_promo }}" data-tipe="{{ $item->tipe }}"
                                            data-nilai="{{ $item->nilai_diskon }}" data-mulai="{{ $item->tgl_mulai }}"
                                            data-selesai="{{ $item->tgl_selesai }}" data-status="{{ $item->status }}"
                                            data-gambar="{{ asset('storage/uploads/promo/' . $item->banner) }}">
                                            <i class="ti ti-edit"></i> Edit
                                        </button>
                                        <button class="btn btn-sm btn-info btnDetail" data-nama="{{ $item->nama_promo }}"
                                            data-tipe="{{ $item->tipe }}" data-nilai="{{ $item->nilai_diskon }}"
                                            data-mulai="{{ \Carbon\Carbon::parse($item->tgl_mulai)->format('Y-m-d H:i') }}"
                                            data-selesai="{{ \Carbon\Carbon::parse($item->tgl_selesai)->format('Y-m-d H:i') }}"
                                            data-status="{{ $item->status }}"
                                            data-gambar="{{ asset('storage/uploads/promo/' . $item->banner) }}">
                                            <i class="ti ti-eye"></i> Detail
                                        </button>

                                        <button class="btn btn-sm btn-danger btnHapus" data-id="{{ $item->id_promo }}"
                                            data-nama="{{ $item->nama_promo }}">
                                            <i class="ti ti-trash"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- DOM/Jquery table end -->

    <!-- Modal Tambah Diskon -->
    <div class="modal fade" id="modalTambahDiskon" tabindex="-1" aria-labelledby="modalTambahDiskonLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title text-white" id="modalTambahDiskonLabel">Tambah Diskon</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="formTambahDiskon" action="{{ url('/diskonBaru') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Preview Gambar -->
                        <div class="row mb-3">
                            <div class="col-md-12 text-center">
                                <div id="bannerPreviewContainer"
                                    style="border: 2px dashed #ccc; border-radius: 10px; overflow: hidden; background-color: #f9f9f9; height: 250px;">
                                    <img id="bannerPreview" src="#" alt="Preview Banner"
                                        style="width: 100%; height: 100%; object-fit: cover; display: none;">
                                </div>
                            </div>
                        </div>

                        <!-- Banner Promo -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Banner Promo</label>
                                <input type="file" name="banner" id="bannerInput" class="form-control" accept="image/*"
                                    required>
                            </div>
                        </div>

                        <!-- Nama Promo -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Nama Promo</label>
                                <input type="text" name="nama_promo" class="form-control"
                                    placeholder="Contoh: Diskon Spesial Ramadhan" required>
                            </div>
                        </div>

                        <!-- Tipe & Nilai Diskon -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label d-block">Tipe Diskon</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipe" id="tipePersen"
                                        value="Persen" required>
                                    <label class="form-check-label" for="tipePersen">Persen (%)</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipe" id="tipeNominal"
                                        value="Nominal" required>
                                    <label class="form-check-label" for="tipeNominal">Nominal (Rp)</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nilai Diskon</label>
                                <input type="number" name="nilai_diskon" class="form-control"
                                    placeholder="Masukkan nilai diskon" required>
                            </div>
                        </div>

                        <!-- Periode Diskon -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Waktu Mulai</label>
                                <input type="time" name="waktu_mulai" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Waktu Selesai</label>
                                <input type="time" name="waktu_selesai" class="form-control" required>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Edit Diskon -->
    <div class="modal fade" id="modalEditDiskon" tabindex="-1" aria-labelledby="modalEditDiskonLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white">Edit Diskon</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditDiskon" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- ✅ Tambahan: Upload & Preview Gambar -->
                        <div class="mb-3">
                            <div class="preview-wrapper mt-2 mb-3"
                                style="border: 2px dashed #ccc; border-radius: 10px; overflow: hidden; background-color: #f9f9f9; height: 250px;">
                                <img id="editPreviewGambar" src="" alt="Preview Gambar" class="img-fluid"
                                    style="width: 100%; height: 100%; object-fit: cover; display: none;">
                            </div>
                            <label class="form-label">Gambar Promo</label>
                            <input type="file" name="gambar_promo" id="editGambarPromo" class="form-control">
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Promo</label>
                                <input type="text" name="nama_promo" id="editNamaPromo" class="form-control"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nilai Diskon</label>
                                <input type="number" name="nilai_diskon" id="editNilaiDiskon" class="form-control"
                                    required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label d-block">Tipe Diskon</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipe" id="editTipePersen"
                                        value="Persen">
                                    <label class="form-check-label" for="editTipePersen">Persen (%)</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipe" id="editTipeNominal"
                                        value="Nominal">
                                    <label class="form-check-label" for="editTipeNominal">Nominal (Rp)</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label d-block">Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="statusAktif"
                                        value="Aktif">
                                    <label class="form-check-label" for="statusAktif">Aktif</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="statusNonaktif"
                                        value="Nonaktif">
                                    <label class="form-check-label" for="statusNonaktif">Nonaktif</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" id="editTanggalMulai" class="form-control"
                                    required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Waktu Mulai</label>
                                <input type="time" name="waktu_mulai" id="editWaktuMulai" class="form-control"
                                    required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" id="editTanggalSelesai"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Waktu Selesai</label>
                                <input type="time" name="waktu_selesai" id="editWaktuSelesai" class="form-control"
                                    required>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-warning">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Detail Diskon -->
    <div class="modal fade" id="modalDetailDiskon" tabindex="-1" aria-labelledby="modalDetailDiskonLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title text-white">Detail Diskon</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">

                    <!-- 🖼️ Preview Banner -->
                    <div id="detailBannerContainer" class="mb-3"
                        style="border: 2px dashed #ccc; border-radius: 10px; overflow: hidden; background-color: #f9f9f9; height: 250px;">
                        <img id="detailBanner" src="#" alt="Banner Promo"
                            style="width: 100%; height: 100%; object-fit: cover; display: none;">
                    </div>

                    <table class="table table-bordered table-striped mb-0 text-start">
                        <tbody>
                            <tr>
                                <th width="40%">Nama Promo</th>
                                <td id="detailNama"></td>
                            </tr>
                            <tr>
                                <th>Tipe Diskon</th>
                                <td id="detailTipe"></td>
                            </tr>
                            <tr>
                                <th>Nilai Diskon</th>
                                <td id="detailNilai"></td>
                            </tr>
                            <tr>
                                <th>Tanggal Mulai</th>
                                <td>
                                    <span id="detailTglMulai"></span><br>
                                    <small class="text-muted"><i class="ti ti-clock"></i> <span
                                            id="detailWaktuMulai"></span></small>
                                </td>
                            </tr>
                            <tr>
                                <th>Tanggal Selesai</th>
                                <td>
                                    <span id="detailTglSelesai"></span><br>
                                    <small class="text-muted"><i class="ti ti-clock"></i> <span
                                            id="detailWaktuSelesai"></span></small>
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td id="detailStatus"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="{{ asset('../assets') }}/js/plugins/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi datatable
            $('#dom-jqry').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                columnDefs: [{
                        responsivePriority: 1,
                        targets: -1
                    } // kolom terakhir = aksi
                ]
            });

            // SweetAlert Toast
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            // Pesan dari session Laravel
            @if (session('success'))
                Toast.fire({
                    icon: 'success',
                    title: "{{ session('success') }}"
                });
            @endif

            // Reset form tambah saat modal ditutup
            $('#modalTambahDiskon').on('hidden.bs.modal', function() {
                $('#formTambahDiskon')[0].reset();
                $('#formTambahDiskon .error-text').remove();
                $('#formTambahDiskon button[type="submit"]').prop('disabled', false);
            });

            // ====== Buka Modal Edit ======
            // 🔹 Saat klik tombol Edit
            $('.btnEdit').on('click', function() {
                const id = $(this).data('id');
                const mulai = $(this).data('mulai');
                const selesai = $(this).data('selesai');

                $('#formEditDiskon').attr('action', '/updateDiskon/' + id);
                $('#editNamaPromo').val($(this).data('nama'));
                $('#editNilaiDiskon').val($(this).data('nilai'));

                // Pisahkan tanggal & waktu
                const [tglMulai, waktuMulai] = mulai.split(' ');
                const [tglSelesai, waktuSelesai] = selesai.split(' ');
                $('#editTanggalMulai').val(tglMulai);
                $('#editWaktuMulai').val(waktuMulai?.slice(0, 5));
                $('#editTanggalSelesai').val(tglSelesai);
                $('#editWaktuSelesai').val(waktuSelesai?.slice(0, 5));

                // Set tipe dan status
                if ($(this).data('tipe') === 'Persen') $('#editTipePersen').prop('checked', true);
                else $('#editTipeNominal').prop('checked', true);

                if ($(this).data('status') === 'Aktif') $('#statusAktif').prop('checked', true);
                else $('#statusNonaktif').prop('checked', true);

                // 🔹 Tampilkan gambar lama (kalau ada)
                const gambar = $(this).data('gambar');
                if (gambar) {
                    $('#editPreviewGambar').attr('src', gambar).show();
                } else {
                    $('#editPreviewGambar').hide();
                }

                $('#modalEditDiskon').modal('show');
            });

            $('#editGambarPromo').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#editPreviewGambar').attr('src', e.target.result).show();
                    };
                    reader.readAsDataURL(file);
                }
            });

            // ===== SweetAlert Hapus =====
            $('.btnHapus').on('click', function() {
                const id = $(this).data('id');
                const nama = $(this).data('nama');

                Swal.fire({
                    title: 'Hapus Diskon?',
                    html: `Yakin ingin menghapus <strong>${nama}</strong>?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                }).then((result) => {
                    if (result.isConfirmed) window.location.href = '/hapusDiskon/' + id;
                });
            });

            // ===== Modal Detail =====
            // ===== Modal Detail =====
            $('.btnDetail').on('click', function() {
                const nama = $(this).data('nama');
                const tipe = $(this).data('tipe');
                const nilai = $(this).data('nilai');
                const status = $(this).data('status');
                const gambar = $(this).data('gambar'); // 🖼️ ambil gambar dari atribut data

                // Format tanggal & waktu
                const mulai = new Date($(this).data('mulai'));
                const selesai = new Date($(this).data('selesai'));

                const tglMulai = mulai.toLocaleDateString('id-ID');
                const waktuMulai = mulai.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                const tglSelesai = selesai.toLocaleDateString('id-ID');
                const waktuSelesai = selesai.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                // 🧾 Isi data ke modal
                $('#detailNama').text(nama);
                $('#detailTipe').text(tipe);
                $('#detailNilai').text(tipe === 'Persen' ? nilai + '%' : 'Rp. ' + new Intl.NumberFormat(
                    'id-ID').format(nilai));
                $('#detailTglMulai').text(tglMulai);
                $('#detailWaktuMulai').text(waktuMulai);
                $('#detailTglSelesai').text(tglSelesai);
                $('#detailWaktuSelesai').text(waktuSelesai);
                $('#detailStatus').html(
                    status === 'Aktif' ?
                    '<span class="badge bg-success">Aktif</span>' :
                    '<span class="badge bg-danger">Nonaktif</span>'
                );

                // 🖼️ Tampilkan banner jika ada
                if (gambar) {
                    $('#detailBanner').attr('src', gambar).show();
                } else {
                    $('#detailBanner').hide();
                }

                $('#modalDetailDiskon').modal('show');
            });



            // ====== VALIDASI TANGGAL & WAKTU (Tambah & Edit) ======
            function validateDateTime($form) {
                const tanggalMulai = $form.find('input[name="tanggal_mulai"]').val();
                const waktuMulai = $form.find('input[name="waktu_mulai"]').val();
                const tanggalSelesai = $form.find('input[name="tanggal_selesai"]').val();
                const waktuSelesai = $form.find('input[name="waktu_selesai"]').val();
                const $btnSubmit = $form.find('button[type="submit"]');

                // Hapus pesan error sebelumnya
                $form.find('.error-text').remove();

                let valid = true;

                // === Validasi Tanggal ===
                if (tanggalMulai && tanggalSelesai) {
                    const mulai = new Date(`${tanggalMulai}T00:00`);
                    const selesai = new Date(`${tanggalSelesai}T00:00`);
                    if (mulai > selesai) {
                        $form.find('input[name="tanggal_selesai"]').after(
                            '<small class="text-danger error-text">Tanggal selesai harus setelah tanggal mulai.</small>'
                        );
                        valid = false;
                    }
                }

                // === Validasi Waktu (berjalan walau tanggal salah) ===
                if (waktuMulai && waktuSelesai) {
                    const [jmMulai, mnMulai] = waktuMulai.split(':').map(Number);
                    const [jmSelesai, mnSelesai] = waktuSelesai.split(':').map(Number);
                    const totalMulai = jmMulai * 60 + mnMulai;
                    const totalSelesai = jmSelesai * 60 + mnSelesai;
                    if (totalMulai >= totalSelesai) {
                        $form.find('input[name="waktu_selesai"]').after(
                            '<small class="text-danger error-text">Waktu selesai harus lebih besar dari waktu mulai.</small>'
                        );
                        valid = false;
                    }
                }

                $btnSubmit.prop('disabled', !valid);
                return valid;
            }

            // Event listener untuk form tambah & edit
            $('#formTambahDiskon input[name="tanggal_mulai"], \
                                 #formTambahDiskon input[name="waktu_mulai"], \
                                 #formTambahDiskon input[name="tanggal_selesai"], \
                                 #formTambahDiskon input[name="waktu_selesai"]').on('input change', function() {
                validateDateTime($('#formTambahDiskon'));
            });

            $('#formEditDiskon input[name="tanggal_mulai"], \
                                 #formEditDiskon input[name="waktu_mulai"], \
                                 #formEditDiskon input[name="tanggal_selesai"], \
                                 #formEditDiskon input[name="waktu_selesai"]').on('input change', function() {
                validateDateTime($('#formEditDiskon'));
            });

            // Tangani submit kedua form
            $('#formTambahDiskon, #formEditDiskon').on('submit', function(e) {
                if (!validateDateTime($(this))) {
                    e.preventDefault();
                    Toast.fire({
                        icon: 'error',
                        title: 'Periksa kembali tanggal dan waktu diskon!',
                    });
                }
            });
        });
    </script>

    <!-- Script Preview Gambar -->
    <script>
        document.getElementById('bannerInput').addEventListener('change', function(event) {
            const preview = document.getElementById('bannerPreview');
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
                preview.src = '#';
            }
        });
    </script>
@endsection
