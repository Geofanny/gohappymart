@extends('layouts/dashboard')

@section('content')
    {{-- <h1>Dashboard Dosen</h1> --}}
    {{-- <!-- [ breadcrumb ] start -->
    <div class="page-header" style="margin-bottom: -4vh">
        <div class="page-block">
            <div class="row align-items-center">
                <h1>Selamat Datang, Admin</h1>
               
            </div>
        </div>
    </div> --}}
    <!-- [ breadcrumb ] end -->
    <!-- [ Main Content ] start -->
    <div class="row">

        <!-- Total Pesanan -->
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 f-w-400 text-muted">Total Pesanan</h6>
                    <h4 class="mb-3">
                        {{ $totalPesanan }}
                        <span class="badge bg-light-primary border border-primary">
                            <i class="ti ti-clipboard-list"></i>
                        </span>
                    </h4>
                    <p class="mb-0 text-muted text-sm">Total keseluruhan pesanan</p>
                </div>
            </div>
        </div>

        <!-- Pesanan Masuk -->
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 f-w-400 text-muted">Pesanan Masuk</h6>
                    <h4 class="mb-3">
                        {{ $pesananMasuk }}
                        <span class="badge bg-light-success border border-success">
                            <i class="ti ti-calendar"></i>
                        </span>
                    </h4>
                    <p class="mb-0 text-muted text-sm">Pesanan terbaru yang masuk</p>
                </div>
            </div>
        </div>

        <!-- Pengembalian Barang -->
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 f-w-400 text-muted">Pengembalian Barang</h6>
                    <h4 class="mb-3">
                        {{ $pengembalianCount }}
                        <span class="badge bg-light-danger border border-danger">
                            <i class="ti ti-report"></i>
                        </span>
                    </h4>
                    <p class="mb-0 text-muted text-sm">Permintaan pengembalian barang</p>
                </div>
            </div>
        </div>

        <!-- Total Berita -->
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 f-w-400 text-muted">Total Berita</h6>
                    <h4 class="mb-3">
                        {{ $totalBerita }}
                        <span class="badge bg-light-info border border-info">
                            <i class="ti ti-news"></i>
                        </span>
                    </h4>
                    <p class="mb-0 text-muted text-sm">Jumlah berita yang dipublikasikan</p>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-xl-7">
            <h5 class="mb-3">Total Penjualan</h5>
            <div class="card shadow-sm rounded-3">
                <div class="card-body">
                    <h6 class="mb-2 fw-normal text-muted">Statistik Minggu Ini</h6>
                    <h3 class="mb-0">Rp {{ number_format($chartTotal, 0, ',', '.') }}</h3>
                    <div id="sales-report-chart"></div>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-xl-5">
            <h5 class="mb-3 fw-semibold text-dark">Riwayat Transaksi</h5>
            <div class="card shadow-sm rounded-3">
                <div class="list-group list-group-flush">
                    @forelse($recentTransactions as $tx)
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div
                                        class="avatar rounded-circle {{ $tx['type'] == 'in' ? 'text-success bg-light-success' : 'text-danger bg-light-danger' }} p-2">
                                        <i class="fas fa-money-bill-wave f-18"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Pesanan #{{ $tx['no'] }}</h6>
                                    <p class="mb-0 text-muted">
                                        {{ \Carbon\Carbon::parse($tx['time'])->locale('id')->diffForHumans() }}</p>
                                </div>
                                <div
                                    class="flex-shrink-0 text-end {{ $tx['type'] == 'in' ? 'text-success' : 'text-danger' }} fw-bold">
                                    {{ $tx['type'] == 'in' ? '+' : '-' }} Rp
                                    {{ number_format($tx['amount'], 0, ',', '.') }}
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="list-group-item text-center text-muted">
                            Belum ada transaksi
                        </div>
                    @endforelse
                </div>
            </div>

            <h5 class="mb-3 fw-semibold text-dark">Stok Hampir Habis</h5>
            <div class="card shadow-sm rounded-3">
                <div class="list-group list-group-flush">

                    @foreach ($lowStock as $p)
                        @php
                            if ($p->stok == 0) {
                                $status = 'Habis';
                                $color = 'danger';
                            } elseif ($p->stok <= 5) {
                                $status = 'Hampir Habis';
                                $color = 'danger';
                            } elseif ($p->stok <= 20) {
                                $status = 'Menipis';
                                $color = 'warning';
                            } else {
                                $status = 'Aman';
                                $color = 'success';
                            }
                        @endphp

                        <!-- ITEM 1 -->
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">

                                <!-- Icon -->
                                <div class="flex-shrink-0">
                                    <div
                                        class="avatar rounded-circle text-{{ $color }} bg-light-{{ $color }} p-2">
                                        <i class="fas fa-box-open f-18"></i>
                                    </div>
                                </div>

                                <!-- Info -->
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">{{ $p->nama_produk }}</h6>
                                    <p class="mb-0 text-muted">Stok tersisa {{ $p->stok }} unit</p>
                                </div>

                                <!-- Status -->
                                <div class="flex-shrink-0 text-end text-{{ $color }} fw-bold">
                                    {{ $status }}
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>



        </div>

        <div class="col-md-12 col-xl-12">
            <h5 class="mb-3">Pesanan Terbaru</h5>
            <div class="card tbl-card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless mb-0">
                            <thead>
                                <tr>
                                    <th>No. Pesanan</th>
                                    <th>Nama Produk</th>
                                    <th>Total Produk</th>
                                    <th>Status</th>
                                    <th class="text-end">Total Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $subtotal = 0;
                                @endphp
                                @forelse($recentOrders as $order)
                                    @foreach ($order->produk as $p)
                                        @php
                                            $total_harga = $p->jumlah * $p->produk->harga;
                                            $subtotal += $total_harga;
                                        @endphp
                                    @endforeach
                                    <tr>
                                        <td><a href="#" class="text-muted">{{ $order->no_pesanan }}</a></td>
                                        <td>
                                            @foreach ($order->produk as $p)
                                                {{ $p->produk->nama_produk ?? '-' }}@if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $order->produk->sum('jumlah') }}</td>
                                        <td>
                                            @php
                                                $statusClass = match ($order->status) {
                                                    'diproses' => 'text-warning', // kuning
                                                    'dikemas' => 'text-info', // biru
                                                    'dikirim' => 'text-primary', // biru tua
                                                    'selesai' => 'text-success', // hijau
                                                    'ditolak' => 'text-danger', // merah
                                                    default => 'text-secondary', // abu-abu
                                                };
                                            @endphp
                                            <span class="d-flex align-items-center gap-2">
                                                <i class="fas fa-circle {{ $statusClass }} f-10"></i>
                                                {{ ucfirst($order->status ?? '-') }}
                                            </span>
                                        </td>
                                        <td class="text-end fw-bold text-dark">Rp
                                            {{ number_format($subtotal ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada pesanan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        (function() {
            var labels = @json($chartLabels);
            var masukData = @json($chartMasuk);
            var keluarData = @json($chartKeluar);

            var totalMasuk = {{ $totalMasuk }};
            var totalKeluar = {{ $totalKeluar }};
            var totalGabungan = {{ $chartTotal }};

            function formatRupiah(val) {
                return 'Rp ' + val.toLocaleString('id-ID');
            }

            var options = {
                chart: {
                    type: 'bar',
                    height: 430,
                    toolbar: {
                        show: false
                    },
                    events: {
                        legendClick: function(chartContext, seriesIndex) {
                            setTimeout(updateTotal, 100);
                        }
                    }
                },
                plotOptions: {
                    bar: {
                        columnWidth: '30%',
                        borderRadius: 4
                    }
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                dataLabels: {
                    enabled: false
                },
                tooltip: {
                    y: {
                        formatter: val => formatRupiah(val)
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right'
                },
                colors: ['#faad14', '#1890ff'],
                series: [{
                        name: 'Masuk',
                        data: masukData
                    },
                    {
                        name: 'Keluar',
                        data: keluarData
                    }
                ],
                xaxis: {
                    categories: labels
                }
            };

            var chart = new ApexCharts(document.querySelector('#sales-report-chart'), options);
            chart.render();

            /** UPDATE TOTAL DINAMIS **/
            function updateTotal() {
                const active = chart.w.globals.seriesSeries.length; // jumlah series aktif

                let total = 0;

                // Series 0 = Masuk
                if (chart.w.globals.seriesToggle[0] !== true) {
                    total += totalMasuk;
                }

                // Series 1 = Keluar
                if (chart.w.globals.seriesToggle[1] !== true) {
                    total += (-totalKeluar);
                }

                // Jika dua-duanya aktif → pakai chartTotal dari server
                if (
                    chart.w.globals.seriesToggle[0] !== true &&
                    chart.w.globals.seriesToggle[1] !== true
                ) {
                    total = totalGabungan;
                }

                document.getElementById('total-penjualan').innerHTML = formatRupiah(total);
            }
        })();
    </script>
@endsection
