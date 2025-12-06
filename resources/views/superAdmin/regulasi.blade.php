@extends('layouts/dashboard')

@section('links')
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
@endsection

@section('content')
    <div class="page-header mb-3">
        <div class="page-block">
            <div class="row align-items-center">
                <!-- Judul Halaman -->
                <div class="col-12 col-md-6">
                    <h1 class="mb-0 fw-semibold text-dark">Kebijakan Toko</h1>
                </div>

                <!-- Tombol Aksi -->
                <div class="col-12 col-md-6 d-flex justify-content-md-end justify-content-start mt-2 mt-md-0">
                    <a href="#" class="btn btn-success btn-sm d-flex align-items-center px-3 py-2"
                        data-bs-toggle="modal" data-bs-target="#modalKebijakan">
                        <i class="ti ti-plus me-2"></i> Tambah Kebijakan
                    </a>
                </div>
            </div>
        </div>
    </div>


    <!-- KEBIJAKAN -->
    <div id="accordionKebijakan">
        <div class="accordion" id="accordionExample1">
            @foreach ($kebijakan as $index => $item)
                <div class="accordion-item border mb-2 rounded">
                    <h2 class="accordion-header" id="headingKebijakan{{ $index }}">
                        <div class="d-flex align-items-center justify-content-between px-3 py-2">
                            <button class="accordion-button collapsed flex-grow-1" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseKebijakan{{ $index }}">
                                {{ $loop->iteration }}. {{ $item->judul }}
                            </button>
                            <div class="dropdown">
                                <a href="#" class="text-secondary" data-bs-toggle="dropdown"><i
                                        class="ti ti-dots-vertical"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#"><i
                                                class="ti ti-edit me-2 text-warning"></i>Edit</a></li>
                                    <li>
                                        <a class="dropdown-item text-danger btn-hapus" href="#"
                                            data-id="{{ $item->id_regulasi }}" data-jenis="kebijakan">
                                            <i class="ti ti-trash me-2"></i>Hapus
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </h2>
                    <div id="collapseKebijakan{{ $index }}" class="accordion-collapse collapse">
                        <div class="accordion-body">{!! $item->isi !!}</div>
                    </div>
                </div>
            @endforeach

        </div>

        <!-- pagination kebijakan -->
        <div class="mt-3">
            {{ $kebijakan->links() }}
        </div>
    </div>

    <!-- Modal Tambah Kebijakan -->
    <div class="modal fade" id="modalKebijakan" tabindex="-1" aria-labelledby="modalKebijakanLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title text-white" id="modalKebijakanLabel"><i class="ti ti-shield-check me-2"></i>
                        Tambah Kebijakan Toko</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <form id="formKebijakan" method="POST" action="/reguslasiBaru">
                    @csrf
                    <input type="hidden" name="jenis" value="kebijakan">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="judulKebijakan" class="form-label fw-semibold">Judul Kebijakan</label>
                            <input type="text" class="form-control" id="judulKebijakan" name="judul"
                                placeholder="Masukkan judul kebijakan" required>
                        </div>

                        <div class="mb-3">
                            <label for="isiKebijakan" class="form-label fw-semibold">Isi Kebijakan</label>
                            <textarea id="isiKebijakan" name="isi" rows="10" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="ti ti-device-floppy me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tambah FAQ -->
    <div class="modal fade" id="modalFaq" tabindex="-1" aria-labelledby="modalFaqLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="modalFaqLabel"><i class="ti ti-message-circle me-2"></i>
                        Tambah FAQ</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <form id="formFaq" method="POST" action="/reguslasiBaru">
                    @csrf
                    <input type="hidden" name="jenis" value="faq">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="judulFaq" class="form-label fw-semibold">Pertanyaan</label>
                            <input type="text" class="form-control" id="judulFaq" name="judul"
                                placeholder="Masukkan pertanyaan FAQ" required>
                        </div>

                        <div class="mb-3">
                            <label for="isiFaq" class="form-label fw-semibold">Jawaban</label>
                            <textarea id="isiFaq" name="isi" rows="10" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditRegulasi" tabindex="-1" aria-labelledby="modalEditRegulasiLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white" id="modalEditRegulasiLabel">
                        <i class="ti ti-edit me-2"></i> Edit Regulasi
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <form id="formEditRegulasi" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_regulasi" id="editIdRegulasi">
                    <input type="hidden" name="jenis" id="editJenis">

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editJudul" class="form-label fw-semibold">Judul</label>
                            <input type="text" class="form-control" id="editJudul" name="judul" required>
                        </div>

                        <div class="mb-3">
                            <label for="editIsi" class="form-label fw-semibold">Isi / Konten</label>
                            <textarea id="editIsi" name="isi" rows="10" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning text-white">
                            <i class="ti ti-device-floppy me-1"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/boirjcaeyjxuv3ilkyyc9ud65xynmmc9sk4fv17mlov28lxl/tinymce/8/tinymce.min.js"
        referrerpolicy="origin" crossorigin="anonymous"></script>
    <script>
        tinymce.init({
            selector: 'textarea#isiKebijakan, textarea#isiFaq',
            menubar: false,
            branding: false,
            statusbar: false,
            plugins: 'lists code table',
            toolbar: 'undo redo | bold italic underline | bullist numlist | alignleft aligncenter alignright',
            height: 300,
            content_style: 'body { font-family:Arial,Helvetica,sans-serif; font-size:14px }'
        });
    </script>

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

    <!-- Trigger Modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn.btn-success').forEach(btn => {
                if (btn.textContent.includes('Kebijakan')) {
                    btn.setAttribute('data-bs-toggle', 'modal');
                    btn.setAttribute('data-bs-target', '#modalKebijakan');
                }
            });

            document.querySelectorAll('.btn.btn-primary').forEach(btn => {
                if (btn.textContent.includes('FAQ')) {
                    btn.setAttribute('data-bs-toggle', 'modal');
                    btn.setAttribute('data-bs-target', '#modalFaq');
                }
            });


        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '{{ csrf_token() }}';

            tinymce.init({
                selector: 'textarea#editIsi',
                menubar: false,
                branding: false,
                statusbar: false,
                plugins: 'lists code table',
                toolbar: 'undo redo | bold italic underline | bullist numlist | alignleft aligncenter alignright',
                height: 300,
                content_style: 'body { font-family:Arial,Helvetica,sans-serif; font-size:14px }'
            });

            // 🔹 Fungsi inisialisasi ulang event tombol edit & hapus
            function attachActionEvents() {
                // Tombol Edit
                document.querySelectorAll('.dropdown-item').forEach(btn => {
                    if (btn.textContent.includes('Edit')) {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            const accordionItem = this.closest('.accordion-item');
                            const id = accordionItem.querySelector('.btn-hapus')?.dataset.id;
                            const jenis = accordionItem.querySelector('.btn-hapus')?.dataset.jenis;
                            const judul = accordionItem.querySelector('button.accordion-button')
                                ?.textContent.trim().split('. ').slice(1).join('. ');
                            const isi = accordionItem.querySelector('.accordion-body')?.innerHTML;

                            // Isi data ke modal
                            document.getElementById('editIdRegulasi').value = id;
                            document.getElementById('editJenis').value = jenis;
                            document.getElementById('editJudul').value = judul;
                            tinymce.get('editIsi').setContent(isi);

                            // Set action dinamis
                            document.getElementById('formEditRegulasi').setAttribute('action',
                                `/updateRegulasi/${id}`);

                            // Tampilkan modal
                            const modal = new bootstrap.Modal(document.getElementById(
                                'modalEditRegulasi'));
                            modal.show();
                        });
                    }
                });

                // Tombol Hapus
                document.querySelectorAll('.btn-hapus').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const id = this.dataset.id;
                        const jenis = this.dataset.jenis;
                        const item = this.closest('.accordion-item');

                        Swal.fire({
                            title: 'Yakin ingin menghapus?',
                            text: `Data ${jenis} ini akan dihapus permanen.`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Ya, hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                fetch(`/hapusRegulasi/${id}`, {
                                        method: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken,
                                            'Accept': 'application/json'
                                        }
                                    })
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data.success) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Terhapus!',
                                                text: data.message ||
                                                    'Data berhasil dihapus.',
                                                timer: 1500,
                                                showConfirmButton: false
                                            });
                                            item.style.transition = 'opacity 0.5s ease';
                                            item.style.opacity = '0';
                                            setTimeout(() => item.remove(), 500);
                                        } else {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Gagal!',
                                                text: data.message ||
                                                    'Terjadi kesalahan.'
                                            });
                                        }
                                    })
                                    .catch(() => {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Terjadi kesalahan saat menghapus data.'
                                        });
                                    });
                            }
                        });
                    });
                });
            }

            // 🔹 Fungsi load halaman via AJAX
            function loadPage(url) {
                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken,
                        }
                    })
                    .then(res => res.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newContent = doc.querySelector('#accordionKebijakan');
                        const container = document.querySelector('#accordionKebijakan');
                        if (newContent && container) {
                            container.innerHTML = newContent.innerHTML;
                            attachPaginationEvents(); // pasang ulang pagination
                            attachActionEvents(); // pasang ulang tombol edit & hapus
                        }
                    })
                    .catch(err => console.error('Gagal memuat halaman:', err));
            }

            // 🔹 Fungsi pasang ulang pagination event
            function attachPaginationEvents() {
                document.querySelectorAll('.pagination a').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const url = this.getAttribute('href');
                        if (url) loadPage(url);
                    });
                });
            }

            // 🔹 Jalankan pertama kali
            attachPaginationEvents();
            attachActionEvents();
        });
    </script>


    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            tinymce.init({
                selector: 'textarea#editIsi',
                menubar: false,
                branding: false,
                statusbar: false,
                plugins: 'lists code table',
                toolbar: 'undo redo | bold italic underline | bullist numlist | alignleft aligncenter alignright',
                height: 300,
                content_style: 'body { font-family:Arial,Helvetica,sans-serif; font-size:14px }'
            });

            document.querySelectorAll('.dropdown-item').forEach(btn => {
                if (btn.textContent.includes('Edit')) {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const accordionItem = this.closest('.accordion-item');
                        const id = accordionItem.querySelector('.btn-hapus')?.dataset.id;
                        const jenis = accordionItem.querySelector('.btn-hapus')?.dataset.jenis;
                        const judul = accordionItem.querySelector('button.accordion-button')
                            ?.textContent.trim().split('. ').slice(1).join('. ');
                        const isi = accordionItem.querySelector('.accordion-body')?.innerHTML;

                        // Isi data ke modal
                        document.getElementById('editIdRegulasi').value = id;
                        document.getElementById('editJenis').value = jenis;
                        document.getElementById('editJudul').value = judul;
                        tinymce.get('editIsi').setContent(isi);

                        // Set form action dinamis
                        document.getElementById('formEditRegulasi').setAttribute('action',
                            `/updateRegulasi/${id}`);

                        // Tampilkan modal
                        const modal = new bootstrap.Modal(document.getElementById(
                            'modalEditRegulasi'));
                        modal.show();
                    });
                }
            });
        });
    </script> --}}


    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // pastikan CSRF token terbaca dengan aman
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '{{ csrf_token() }}';

            document.querySelectorAll('.btn-hapus').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();

                    const id = this.dataset.id;
                    const jenis = this.dataset.jenis;
                    const item = this.closest('.accordion-item');

                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: `Data ${jenis} ini akan dihapus permanen.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/hapusRegulasi/${id}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken,
                                        'Accept': 'application/json'
                                    }
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Terhapus!',
                                            text: data.message ||
                                                'Data berhasil dihapus.',
                                            timer: 1500,
                                            showConfirmButton: false
                                        });
                                        item.style.transition = 'opacity 0.5s ease';
                                        item.style.opacity = '0';
                                        setTimeout(() => item.remove(), 500);
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Gagal!',
                                            text: data.message ||
                                                'Terjadi kesalahan.'
                                        });
                                    }
                                })
                                .catch(() => {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Terjadi kesalahan saat menghapus data.'
                                    });
                                });
                        }
                    });
                });
            });
        });
    </script> --}}

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '{{ csrf_token() }}';

            // Fungsi untuk load halaman via AJAX (khusus kebijakan)
            function loadPage(url) {
                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken,
                        }
                    })
                    .then(res => res.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newContent = doc.querySelector('#accordionKebijakan');
                        const container = document.querySelector('#accordionKebijakan');
                        if (newContent && container) {
                            container.innerHTML = newContent.innerHTML;
                            attachPaginationEvents(); // pasang ulang event pagination
                        }
                    })
                    .catch(err => console.error('Gagal memuat halaman:', err));
            }

            // Tangkap klik pagination
            function attachPaginationEvents() {
                document.querySelectorAll('.pagination a').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const url = this.getAttribute('href');
                        if (url) loadPage(url);
                    });
                });
            }

            // Pasang event pagination saat pertama kali load
            attachPaginationEvents();
        });
    </script> --}}
@endsection
