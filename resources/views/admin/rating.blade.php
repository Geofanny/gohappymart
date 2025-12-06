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
                    <h1 class="mb-0">Rating Produk</h1>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-md-end justify-content-start gap-2">

                    <!-- Select Filter Pewarnaan Stok -->
                    <select id="filterStok" class="form-select form-select-sm me-2" style="width: auto;">
                        <option value="">Semua Rating</option>
                        <option value="1">1 Bintang</option>
                        <option value="2">2 Bintang</option>
                        <option value="3">3 Bintang</option>
                        <option value="4">4 Bintang</option>
                        <option value="5">5 Bintang</option>
                    </select>


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
                                <th>#</th>
                                <th>Nama Pelanggan</th>
                                <th>Nama Produk</th>
                                <th>Rating</th>
                                <th>Tanggal Rating</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($ulasan as $u)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $u->pelanggan->nama_pelanggan ?? '-' }}</td>
                                    <td>{{ $u->produk->nama_produk ?? '-' }}</td>
                                    <td>
                                        <span class="d-none rating-value">{{ $u->rating }}</span>

                                        @for ($s = 0; $s < $u->rating; $s++)
                                            <i class="fa fa-star text-warning"></i>
                                        @endfor
                                        @for ($s = $u->rating; $s < 5; $s++)
                                            <i class="fa fa-star-o text-warning"></i>
                                        @endfor
                                    </td>

                                    <td>{{ $u->tgl_ulasan }}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#detailModal-{{ $u->id_ulasan }}">
                                            <i class="ti ti-eye me-1"></i> Detail
                                        </button>

                                        @if (empty($u->balasan))
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#replyModal-{{ $u->id_ulasan }}">
                                                <i class="ti ti-message me-1"></i> Tanggapi
                                            </button>
                                        @else
                                            <button class="btn btn-secondary btn-sm ms-2" data-bs-toggle="modal"
                                                data-bs-target="#replyModal-{{ $u->id_ulasan }}">
                                                <i class="ti ti-edit me-1"></i> Edit Balasan
                                            </button>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Nama Pelanggan</th>
                                <th>Nama Produk</th>
                                <th>Rating</th>
                                <th>Tanggal Rating</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        </tbody>
                    </table>

                    @foreach ($ulasan as $u)
                        <div class="modal fade" id="detailModal-{{ $u->id_ulasan }}" tabindex="-1">
                            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                <div class="modal-content">

                                    <div class="modal-header bg-info">
                                        <h5 class="modal-title text-white fs-4">
                                            Detail Ulasan – {{ $u->produk->nama_produk }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body fs-5">

                                        {{-- CARD UTAMA --}}
                                        <div class="card shadow-sm border-0 mb-4">
                                            <div class="card-body">

                                                <div class="row g-4">

                                                    {{-- FOTO PRODUK --}}
                                                    <div class="col-md-4 text-center">
                                                        <div class="border rounded overflow-hidden"
                                                            style="max-height: 280px;">
                                                            @if ($u->produk && $u->produk->gambar)
                                                                <img src="{{ asset('storage/uploads/produk/' . $u->produk->gambar) }}"
                                                                    class="img-fluid"
                                                                    style="object-fit: cover; height: 280px; width: 100%;">
                                                            @else
                                                                <div class="text-muted py-5 fs-5">Tidak ada foto produk
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    {{-- DETAIL PRODUK + RATING --}}
                                                    <div class="col-md-8">

                                                        <h4 class="fw-bold mb-3">{{ $u->produk->nama_produk ?? '-' }}</h4>

                                                        {{-- RATING --}}
                                                        <div class="mb-3">
                                                            <span class="fw-semibold me-2">Rating:</span>
                                                            @for ($s = 0; $s < $u->rating; $s++)
                                                                <i class="fa fa-star text-warning"></i>
                                                            @endfor
                                                            @for ($s = $u->rating; $s < 5; $s++)
                                                                <i class="fa fa-star-o text-warning"></i>
                                                            @endfor
                                                        </div>

                                                        {{-- INFO LIST --}}
                                                        <ul class="list-group list-group-flush">

                                                            <li
                                                                class="list-group-item px-0 d-flex justify-content-between fs-5">
                                                                <span class="fw-semibold text-muted fs-6">Nama
                                                                    Pelanggan</span>
                                                                <span>{{ $u->pelanggan->nama_pelanggan ?? '-' }}</span>
                                                            </li>

                                                            <li
                                                                class="list-group-item px-0 d-flex justify-content-between fs-5">
                                                                <span class="fw-semibold text-muted fs-6">Tanggal
                                                                    Rating</span>
                                                                <span>{{ $u->tgl_ulasan }}</span>
                                                            </li>

                                                            <li
                                                                class="list-group-item px-0 d-flex justify-content-between fs-5">
                                                                <span class="fw-semibold text-muted fs-6">No. Pesanan</span>
                                                                <span>{{ $u->pesanan->no_pesanan }}</span>
                                                            </li>

                                                        </ul>

                                                        {{-- ULASAN --}}
                                                        <div class="mt-4">
                                                            <h6 class="fw-semibold mb-2 fs-5">Ulasan:</h6>
                                                            <p class="text-muted fs-5">{{ $u->ulasan }}</p>
                                                        </div>

                                                    </div>

                                                </div>

                                            </div>
                                        </div>

                                        {{-- BUKTI ULASAN --}}
                                        <h5 class="fw-bold mb-3 fs-4">Bukti Ulasan</h5>

                                        @if ($u->bukti->count() > 0)
                                            <div class="row g-3">

                                                @foreach ($u->bukti as $b)
                                                    <div class="col-md-3 col-6">
                                                        <div class="border rounded overflow-hidden shadow-sm"
                                                            style="height: 180px;">
                                                            <img src="{{ asset('storage/uploads/ulasan/' . $b->nama_file) }}"
                                                                class="img-fluid"
                                                                style="height: 100%; width: 100%; object-fit: cover;">
                                                        </div>
                                                    </div>
                                                @endforeach

                                            </div>
                                        @else
                                            <div class="text-muted fs-5">Tidak ada bukti ulasan</div>
                                        @endif

                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-secondary fs-5" data-bs-dismiss="modal">Tutup</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="replyModal-{{ $u->id_ulasan }}" tabindex="-1">
                            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                <div class="modal-content">

                                    <div class="modal-header bg-primary">
                                        <h5 class="modal-title text-white fs-4">
                                            Balasan Ulasan Pelanggan
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body p-4">

                                        {{-- ULASAN SECTION --}}
                                        <section class="mb-4">
                                            <h6 class="text-uppercase text-muted fw-semibold mb-3"
                                                style="letter-spacing: .5px;">
                                                Informasi Ulasan
                                            </h6>

                                            {{-- NAMA PRODUK --}}
                                            <div class="mb-2">
                                                <span class="text-muted small">Produk</span>
                                                <div class="fw-semibold fs-5">
                                                    {{ $u->produk->nama_produk ?? '-' }}
                                                </div>
                                            </div>

                                            {{-- RATING --}}
                                            <div class="mb-2">
                                                <span class="text-muted small">Rating</span>
                                                <div class="pt-1">
                                                    @for ($s = 0; $s < $u->rating; $s++)
                                                        <i class="fa fa-star text-warning fs-5 me-1"></i>
                                                    @endfor
                                                    @for ($s = $u->rating; $s < 5; $s++)
                                                        <i class="fa fa-star-o text-warning fs-5 me-1"></i>
                                                    @endfor
                                                </div>
                                            </div>

                                            {{-- ULASAN TEKS --}}
                                            <div class="mt-3">
                                                <span class="text-muted small">Ulasan Pelanggan</span>
                                                <p class="fs-5 mt-1 text-dark" style="line-height: 1.6;">
                                                    {{ $u->ulasan }}
                                                </p>
                                            </div>

                                            <hr class="my-4">
                                        </section>

                                        {{-- FORM BALASAN --}}
                                        <section>
                                            <h6 class="text-uppercase text-muted fw-semibold mb-3"
                                                style="letter-spacing: .5px;">
                                                Balas Ulasan
                                            </h6>

                                            <form action="{{ route('admin.ulasan.reply', $u->id_ulasan) }}"
                                                method="POST">
                                                @csrf

                                                {{-- TEXTAREA --}}
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold text-dark">Balasan Anda</label>
                                                    <textarea name="balasan" class="form-control fs-5" rows="4"
                                                        style="resize: vertical; padding: 14px; border-radius: 6px;">{{ $u->balasan ?? '' }}</textarea>
                                                </div>

                                                {{-- BUTTON --}}
                                                <div class="text-end mt-3">
                                                    <button type="submit" class="btn btn-primary px-4 py-2 fs-5"
                                                        style="border-radius: 6px;">
                                                        Kirim Balasan
                                                    </button>
                                                </div>
                                            </form>
                                        </section>

                                    </div>


                                    <div class="modal-footer">
                                        <button class="btn btn-secondary fs-5" data-bs-dismiss="modal">Tutup</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </div>
    </div>
    <!-- DOM/Jquery table end -->

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('../assets') }}/js/plugins/jquery.dataTables.min.js"></script>
    <script src="{{ asset('../assets') }}/js/plugins/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
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
    <script>
        $(document).ready(function() {
            $('#dom-jqry').DataTable({
                responsive: true, // <--- ini penting
                autoWidth: false, // biar kolom menyesuaikan layar
                pageLength: 10, // opsional: jumlah baris per halaman
            });

        });
    </script>
    <script>
        $(document).ready(function() {

            var table = $('#dom-jqry').DataTable();

            // Tambahkan row kosong untuk pesan "Tidak ada data"
            var emptyRow = `
            <tr class="empty-message">
                <td colspan="6" class="text-center py-4 text-muted fw-semibold">
                    Tidak ada data ditemukan
                </td>
            </tr>
        `;

            $('#filterStok').on('change', function() {
                var value = $(this).val();

                var anyVisible = false;

                table.rows().every(function() {
                    var rating = $(this.node()).find('.rating-value').text().trim();

                    if (value === "" || rating === value) {
                        $(this.node()).show();
                        anyVisible = true;
                    } else {
                        $(this.node()).hide();
                    }
                });

                // Hilangkan pesan lama
                $('#dom-jqry tbody .empty-message').remove();

                // Jika tidak ada baris tampil → tampilkan pesan
                if (!anyVisible) {
                    $('#dom-jqry tbody').append(emptyRow);
                }
            });

        });
    </script>





    <script>
        $(document).ready(function() {

            // SHOW DETAIL MODAL
            $(document).on('click', '.btn-detail', function() {
                var target = $(this).data('target');
                var modal = new bootstrap.Modal(document.getElementById(target));
                modal.show();
            });

            // OPTIONAL: CLOSE MODAL MANUAL (jika dibutuhkan)
            $(document).on('click', '.close-detail-modal', function() {
                var target = $(this).data('target');
                var modal = bootstrap.Modal.getInstance(document.getElementById(target));
                modal.hide();
            });

        });
    </script>
@endsection
@endsection
