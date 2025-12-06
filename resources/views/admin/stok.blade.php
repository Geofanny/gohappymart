@extends('layouts/dashboard')

@section('link')
    <link rel="stylesheet" href="{{ asset('../assets') }}/css/plugins/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@endsection

@section('content')
    <!-- [ breadcrumb ] start -->
    <div class="page-header mb-3">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-12 col-md-6 mb-2 mb-md-0">
                    <h1 class="mb-0">Monitoring Stok Produk</h1>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-md-end justify-content-start gap-2">

                    <!-- Select Filter Pewarnaan Stok -->
                    <select id="filterStok" class="form-select form-select-sm me-2" style="width: auto;">
                        <option value="">Semua Status</option>
                        <option value="habis">Habis</option>
                        <option value="hampir-habis">Hampir Habis</option>
                        <option value="menipis">Menipis</option>
                        <option value="aman">Aman</option>
                    </select>

                    <!-- Tombol Info Bulat -->
                    <button type="button" class="btn btn-secondary rounded-circle p-0"
                        style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;"
                        data-bs-toggle="tooltip" data-bs-placement="bottom" title="Informasi">
                        <i class="ti ti-info-circle"></i>
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
                    <table id="dom-jqry" class="table  table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>SKU</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produk as $index => $item)
                                @php
                                    // Tentukan kelas baris berdasarkan stok
                                    if ($item->stok == 0) {
                                        $rowClass = 'table-secondary bg-orange-500';
                                        $badgeClass = 'bg-secondary';
                                        $badgeText = 'Habis';
                                    } elseif ($item->stok <= 5) {
                                        $rowClass = 'table-danger';
                                        $badgeClass = 'bg-danger';
                                        $badgeText = 'Hampir Habis';
                                    } elseif ($item->stok <= 20) {
                                        $rowClass = 'table-warning';
                                        $badgeClass = 'bg-warning text-dark';
                                        $badgeText = 'Menipis';
                                    } else {
                                        $rowClass = 'table-white';
                                        $badgeClass = 'bg-success';
                                        $badgeText = 'Aman';
                                    }
                                @endphp

                                <tr class="{{ $rowClass }}">
                                    <td>{{ $index + 1 }}.</td>
                                    <td>{{ $item->sku }}</td>
                                    <td>{{ $item->nama_produk }}</td>
                                    <td>{{ $item->kategori->nama ?? '-' }}</td>

                                    {{-- Kolom stok dengan badge --}}
                                    <td>
                                        <span
                                            class="badge {{ $badgeClass }} stok-{{ strtolower(str_replace(' ', '-', $badgeText)) }}">
                                            {{ $badgeText }} ({{ $item->stok }})
                                        </span>
                                    </td>

                                    <td>
                                        <!-- Tombol Tambah -->
                                        {{-- <button type="button" class="btn btn-sm btn-primary me-1 btn-tambah"
                                            data-bs-toggle="modal" data-bs-target="#modalTambahStok"
                                            data-nama="{{ $item->nama_produk }}" data-id="{{ $item->id_produk }}"
                                            title="Tambah Stok">
                                            <i class="ti ti-plus me-1"></i> Tambah
                                        </button> --}}

                                        <button 
                                            type="button" 
                                            class="btn btn-sm btn-primary me-1 btn-tambah"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalTambahStok"
                                            data-nama="{{ $item->nama_produk }}"
                                            data-id="{{ $item->id_produk }}"
                                            >
                                            <i class="ti ti-plus me-1"></i> Tambah
                                        </button>


                                        <!-- Tombol Kurang -->
                                        <button 
                                        type="button" 
                                        class="btn btn-sm btn-danger me-1 btn-kurang"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalKurangStok"
                                        data-nama="{{ $item->nama_produk }}"
                                        data-id="{{ $item->id_produk }}"
                                    >
                                        <i class="ti ti-minus me-1"></i> Kurang
                                    </button>
                                    
                                    </td>


                                    <!-- Modal Tambah Stok -->
                                    <div class="modal fade" id="modalTambahStok" tabindex="-1"
                                        aria-labelledby="modalTambahStokLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-primary">
                                                    <h5 class="modal-title text-white" id="modalTambahStokLabel"><i
                                                            class="ti ti-plus me-2"></i>Tambah Stok Produk</h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="formTambahStok" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="aksi" value="tambah">
                                                        <input type="hidden" name="id_produk" id="id_produk_tambah">

                                                        <div class="mb-3">
                                                            <label class="form-label">Nama Produk</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $item->nama_produk }}" disabled>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Jumlah yang ingin ditambahkan</label>
                                                            <input type="number" min="1" name="jumlah"
                                                                class="form-control" placeholder="Masukkan jumlah...">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal"><i class="ti ti-x"></i>
                                                                Batal</button>
                                                            <button type="submit" class="btn btn-primary"><i
                                                                    class="ti ti-check"></i> Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Kurang Stok -->
                                    <div class="modal fade" id="modalKurangStok" tabindex="-1"
                                        aria-labelledby="modalKurangStokLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-danger">
                                                    <h5 class="modal-title text-white" id="modalKurangStokLabel"><i
                                                            class="ti ti-minus me-2"></i>Kurangi Stok Produk</h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="formKurangStok" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="aksi" value="kurang">

                                                        <input type="hidden" name="id_produk" id="id_produk_kurang">
                                                        <div class="mb-3">
                                                            <label class="form-label">Nama Produk</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $item->nama_produk }}" disabled>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Jumlah yang ingin dikurangi</label>
                                                            <input type="number" min="1" name="jumlah"
                                                                class="form-control" placeholder="Masukkan jumlah...">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal"><i class="ti ti-x"></i>
                                                                Batal</button>
                                                            <button type="submit" class="btn btn-danger"><i
                                                                    class="ti ti-check"></i> Simpan</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>SKU</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- DOM/Jquery table end -->

    <!-- Modal Informasi Admin Produk -->
    <div class="modal fade" id="modalInfoStok" tabindex="-1" aria-labelledby="infoStokLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-secondary">
                    <h5 class="modal-title text-white" id="infoStokLabel">Informasi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <!-- Modal body scrollable -->
                <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">
                    <!-- Bagian 1: Pewarnaan Stok -->
                    <h6 class="fw-bold mb-2">Pewarnaan Baris Tabel:</h6>
                    <div class="d-flex flex-column gap-2 mb-4">
                        <div class="d-flex align-items-center">
                            <div style="width: 30px; height: 30px; background-color: #6c757d; border-radius: 3px;"
                                class="me-2"></div>
                            <span>Stok 0 → Habis</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <div style="width: 30px; height: 30px; background-color: #dc3545; border-radius: 3px;"
                                class="me-2"></div>
                            <span>Stok 1–5 → Hampir Habis</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <div style="width: 30px; height: 30px; background-color: #ffc107; border-radius: 3px; border: 1px solid #6c757d;"
                                class="me-2"></div>
                            <span>Stok 6–20 → Menipis</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <div style="width: 30px; height: 30px; background-color: #ffffff; border-radius: 3px; border: 1px solid #198754;"
                                class="me-2"></div>
                            <span>Stok >20 → Aman</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('../assets') }}/js/plugins/jquery.dataTables.min.js"></script>
    <script src="{{ asset('../assets') }}/js/plugins/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="{{ asset('../assets') }}/js/plugins/sweetalert2.all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Modal Tambah
            const modalTambah = document.getElementById('modalTambahStok');
            modalTambah.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;  
                const id = button.getAttribute('data-id');
                const nama = button.getAttribute('data-nama');
    
                // set nama di input
                modalTambah.querySelector('input[disabled]').value = nama;
    
                // set hidden input id
                document.getElementById('id_produk_tambah').value = id;
    
                // set action dynamic
                document.getElementById('formTambahStok').action = "/updateStok/" + id;
            });
    
            // Modal Kurang
            const modalKurang = document.getElementById('modalKurangStok');
            modalKurang.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const nama = button.getAttribute('data-nama');
    
                modalKurang.querySelector('input[disabled]').value = nama;
                document.getElementById('id_produk_kurang').value = id;
                document.getElementById('formKurangStok').action = "/updateStok/" + id;
            });
        });
    </script>
    
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
    <script>
        $(document).ready(function() {
            $('#dom-jqry').DataTable({
                responsive: true, // <--- ini penting
                autoWidth: false, // biar kolom menyesuaikan layar
                pageLength: 10, // opsional: jumlah baris per halaman
            });

            // Tombol info modal
            $('.btn-secondary[title="Informasi"]').on('click', function() {
                $('#modalInfoStok').modal('show');
            });

            // Event tombol tambah stok
            $(document).on('click', '.btn-tambah', function() {
                let namaProduk = $(this).data('nama');
                let idProduk = $(this).data('id');

                $('#tambahNamaProduk').val(namaProduk);
                $('#tambahIdProduk').val(idProduk);
            });

            // Event tombol kurang stok
            $(document).on('click', '.btn-kurang', function() {
                let namaProduk = $(this).data('nama');
                let idProduk = $(this).data('id');

                $('#kurangNamaProduk').val(namaProduk);
                $('#kurangIdProduk').val(idProduk);
            });

        });
    </script>
    {{-- <script>
        $(document).ready(function() {
            var table = $('#dom-jqry').DataTable();

            $('#filterStok').on('change', function() {
                var value = $(this).val();
                var nomor = 1;

                $('#dom-jqry tbody tr').each(function() {
                    var status = $(this).find('td:eq(4) .badge').data('status');

                    if (!value || status === value) {
                        $(this).show();
                        // ubah isi kolom No. agar berurutan
                        $(this).find('td:first').text(nomor + '.');
                        nomor++;
                    } else {
                        $(this).hide();
                    }
                });
            });


        });
    </script> --}}

    <script>
        $(document).ready(function() {

            var table = $('#dom-jqry').DataTable();

            // Custom filter DataTables
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {

                    let selected = $('#filterStok').val(); // habis | hampir-habis | menipis | aman
                    if (!selected) return true; // tampilkan semua

                    // Ambil badge dari table row asli
                    let badge = $(table.row(dataIndex).node()).find('td:eq(4) .badge');

                    // Cek class pada badge
                    return badge.hasClass('stok-' + selected);
                }
            );

            // Trigger filter saat select berubah
            $('#filterStok').on('change', function() {
                table.draw();
            });

        });
    </script>
@endsection
@endsection
