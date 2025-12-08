@extends('layouts/dashboard')

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="mb-2 f-w-400 text-muted">Total Produk</h6>
                    <h4 class="mb-3">
                        {{ number_format($totalProduk) }}
                        <span class="badge bg-light-primary border border-primary">
                            <i class="ti ti-package"></i>
                        </span>
                    </h4>
                    <p class="mb-0 text-muted text-sm">
                        Jumlah produk yang tersedia.
                    </p>
                </div>
            </div>
        </div>


        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="mb-2 f-w-400 text-muted">Total Admin</h6>
                    <h4 class="mb-3">
                        {{ number_format($totalAdmin) }}
                        <span class="badge bg-light-success border border-success">
                            <i class="ti ti-users"></i>
                        </span>
                    </h4>
                    <p class="mb-0 text-muted text-sm">
                        Total admin yang aktif.
                    </p>
                </div>
            </div>
        </div>


        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="mb-2 f-w-400 text-muted">Total Pesanan</h6>
                    <h4 class="mb-3">
                        {{ number_format($totalPesanan) }}
                        <span class="badge bg-light-warning border border-warning">
                            <i class="ti ti-clipboard-list"></i>
                        </span>
                    </h4>
                    <p class="mb-0 text-muted text-sm">
                        Total pesanan yang telah selesai.
                    </p>
                </div>
            </div>
        </div>


        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="mb-2 f-w-400 text-muted">Rating Toko</h6>
                    <h3 class="mb-3 fw-bold">
                        {{ number_format($ratingToko, 1) }}
                        <i class="fa fa-star text-warning"></i>
                    </h3>
                    <p class="mb-0 text-muted text-sm">
                        Berdasarkan {{ number_format($jumlahUlasanToko) }} ulasan
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-xl-7">
            <h5 class="mb-3">Total Penjualan</h5>
            <div class="card shadow-sm rounded-3">
                <div class="card-body">
                    <h6 class="mb-2 fw-normal text-muted">Statistik Total Penjualan</h6>
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

            <h5 class="mb-3 fw-semibold text-dark">Rating Pelanggan</h5>
            <div class="card shadow-sm rounded-3">
                <div class="list-group list-group-flush">

                    @forelse($recentRatings as $rating)
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">

                                {{-- Avatar Pelanggan --}}
                                <div class="flex-shrink-0">
                                    <div class="avatar rounded-circle bg-light-warning text-warning p-2">
                                        <i class="fas fa-star f-18"></i>
                                    </div>
                                </div>

                                {{-- Info Rating --}}
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">
                                        {{ $rating->pelanggan->nama_pelanggan ?? 'Pelanggan' }}
                                    </h6>

                                    <p class="mb-0 text-muted">
                                        "{{ Str::limit($rating->ulasan, 40) }}"
                                    </p>

                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($rating->tgl_ulasan)->locale('id')->diffForHumans() }}
                                    </small>
                                </div>

                                {{-- Jumlah Rating --}}
                                <div class="flex-shrink-0 text-warning fw-bold">
                                    @for ($s = 0; $s < $rating->rating; $s++)
                                        <i class="fa fa-star text-warning"></i>
                                    @endfor

                                    @for ($s = $rating->rating; $s < 5; $s++)
                                        <i class="fa fa-star-o text-warning"></i>
                                    @endfor
                                </div>

                            </div>
                        </a>
                    @empty
                        <div class="list-group-item text-center text-muted">
                            Belum ada rating dari pelanggan
                        </div>
                    @endforelse

                </div>
            </div>


            {{-- <h5 class="mb-3 fw-semibold text-dark">Stok Hampir Habis</h5>
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
          </div> --}}



        </div>

        <div class="col-md-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5>Grafik Promo Penjualan</h5>
                </div>
                <div class="card-body">
                    <div id="mixed-chart-2"></div>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-xl-8">
            <h5 class="mb-3">Pesanan Terbaru</h5>
            <div class="card shadow-sm rounded-3 tbl-card">
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
                                                {{ Str::limit($p->produk->nama_produk, 30) ?? '-' }}@if (!$loop->last)
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

        <div class="col-md-12 col-xl-4">
            {{-- <h5 class="mb-3 fw-semibold text-dark">Produk Terlaris</h5>
            <div class="card shadow-sm rounded-3">
                <div class="card-header">
                    <h5>Produk Paling Banyak Dipesan</h5>
                </div>
                <div class="card-body">
                    <div id="pie-produk-terlaris" style="width: 100%; height: 350px;"></div>
                </div>
            </div>             --}}

            <h5 class="mb-3 fw-semibold text-dark">Stok Produk</h5>
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



        {{-- <div class="col-md-12 col-xl-8">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="mb-0">Unique Visitor</h5>
                <ul class="nav nav-pills justify-content-end mb-0" id="chart-tab-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="chart-tab-home-tab" data-bs-toggle="pill"
                            data-bs-target="#chart-tab-home" type="button" role="tab" aria-controls="chart-tab-home"
                            aria-selected="true">Month</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="chart-tab-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#chart-tab-profile" type="button" role="tab"
                            aria-controls="chart-tab-profile" aria-selected="false">Week</button>
                    </li>
                </ul>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="tab-content" id="chart-tab-tabContent">
                        <div class="tab-pane" id="chart-tab-home" role="tabpanel" aria-labelledby="chart-tab-home-tab"
                            tabindex="0">
                            <div id="visitor-chart-1"></div>
                        </div>
                        <div class="tab-pane show active" id="chart-tab-profile" role="tabpanel"
                            aria-labelledby="chart-tab-profile-tab" tabindex="0">
                            <div id="visitor-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-xl-4">
            <h5 class="mb-3">Income Overview</h5>
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 f-w-400 text-muted">This Week Statistics</h6>
                    <h3 class="mb-3">$7,650</h3>
                    <div id="income-overview-chart"></div>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-xl-8">
            <h5 class="mb-3">Recent Orders</h5>
            <div class="card tbl-card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless mb-0">
                            <thead>
                                <tr>
                                    <th>TRACKING NO.</th>
                                    <th>PRODUCT NAME</th>
                                    <th>TOTAL ORDER</th>
                                    <th>STATUS</th>
                                    <th class="text-end">TOTAL AMOUNT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a href="#" class="text-muted">84564564</a></td>
                                    <td>Camera Lens</td>
                                    <td>40</td>
                                    <td><span class="d-flex align-items-center gap-2"><i
                                                class="fas fa-circle text-danger f-10 m-r-5"></i>Rejected</span>
                                    </td>
                                    <td class="text-end">$40,570</td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="text-muted">84564564</a></td>
                                    <td>Laptop</td>
                                    <td>300</td>
                                    <td><span class="d-flex align-items-center gap-2"><i
                                                class="fas fa-circle text-warning f-10 m-r-5"></i>Pending</span>
                                    </td>
                                    <td class="text-end">$180,139</td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="text-muted">84564564</a></td>
                                    <td>Mobile</td>
                                    <td>355</td>
                                    <td><span class="d-flex align-items-center gap-2"><i
                                                class="fas fa-circle text-success f-10 m-r-5"></i>Approved</span></td>
                                    <td class="text-end">$180,139</td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="text-muted">84564564</a></td>
                                    <td>Camera Lens</td>
                                    <td>40</td>
                                    <td><span class="d-flex align-items-center gap-2"><i
                                                class="fas fa-circle text-danger f-10 m-r-5"></i>Rejected</span>
                                    </td>
                                    <td class="text-end">$40,570</td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="text-muted">84564564</a></td>
                                    <td>Laptop</td>
                                    <td>300</td>
                                    <td><span class="d-flex align-items-center gap-2"><i
                                                class="fas fa-circle text-warning f-10 m-r-5"></i>Pending</span>
                                    </td>
                                    <td class="text-end">$180,139</td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="text-muted">84564564</a></td>
                                    <td>Mobile</td>
                                    <td>355</td>
                                    <td><span class="d-flex align-items-center gap-2"><i
                                                class="fas fa-circle text-success f-10 m-r-5"></i>Approved</span></td>
                                    <td class="text-end">$180,139</td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="text-muted">84564564</a></td>
                                    <td>Camera Lens</td>
                                    <td>40</td>
                                    <td><span class="d-flex align-items-center gap-2"><i
                                                class="fas fa-circle text-danger f-10 m-r-5"></i>Rejected</span>
                                    </td>
                                    <td class="text-end">$40,570</td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="text-muted">84564564</a></td>
                                    <td>Laptop</td>
                                    <td>300</td>
                                    <td><span class="d-flex align-items-center gap-2"><i
                                                class="fas fa-circle text-warning f-10 m-r-5"></i>Pending</span>
                                    </td>
                                    <td class="text-end">$180,139</td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="text-muted">84564564</a></td>
                                    <td>Mobile</td>
                                    <td>355</td>
                                    <td><span class="d-flex align-items-center gap-2"><i
                                                class="fas fa-circle text-success f-10 m-r-5"></i>Approved</span></td>
                                    <td class="text-end">$180,139</td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="text-muted">84564564</a></td>
                                    <td>Mobile</td>
                                    <td>355</td>
                                    <td><span class="d-flex align-items-center gap-2"><i
                                                class="fas fa-circle text-success f-10 m-r-5"></i>Approved</span></td>
                                    <td class="text-end">$180,139</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-xl-4">
            <h5 class="mb-3">Analytics Report</h5>
            <div class="card">
                <div class="list-group list-group-flush">
                    <a href="#"
                        class="list-group-item list-group-item-action d-flex align-items-center justify-content-between">Company
                        Finance Growth<span class="h5 mb-0">+45.14%</span></a>
                    <a href="#"
                        class="list-group-item list-group-item-action d-flex align-items-center justify-content-between">Company
                        Expenses Ratio<span class="h5 mb-0">0.58%</span></a>
                    <a href="#"
                        class="list-group-item list-group-item-action d-flex align-items-center justify-content-between">Business
                        Risk Cases<span class="h5 mb-0">Low</span></a>
                </div>
                <div class="card-body px-2">
                    <div id="analytics-report-chart"></div>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-xl-8">
            <h5 class="mb-3">Sales Report</h5>
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 f-w-400 text-muted">This Week Statistics</h6>
                    <h3 class="mb-0">$7,650</h3>
                    <div id="sales-report-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-xl-4">
            <h5 class="mb-3">Transaction History</h5>
            <div class="card">
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-s rounded-circle text-success bg-light-success">
                                    <i class="ti ti-gift f-18"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Order #002434</h6>
                                <p class="mb-0 text-muted">Today, 2:00 AM</P>
                            </div>
                            <div class="flex-shrink-0 text-end">
                                <h6 class="mb-1">+ $1,430</h6>
                                <p class="mb-0 text-muted">78%</P>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-s rounded-circle text-primary bg-light-primary">
                                    <i class="ti ti-message-circle f-18"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Order #984947</h6>
                                <p class="mb-0 text-muted">5 August, 1:45 PM</P>
                            </div>
                            <div class="flex-shrink-0 text-end">
                                <h6 class="mb-1">- $302</h6>
                                <p class="mb-0 text-muted">8%</P>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-s rounded-circle text-danger bg-light-danger">
                                    <i class="ti ti-settings f-18"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Order #988784</h6>
                                <p class="mb-0 text-muted">7 hours ago</P>
                            </div>
                            <div class="flex-shrink-0 text-end">
                                <h6 class="mb-1">- $682</h6>
                                <p class="mb-0 text-muted">16%</P>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div> --}}
    </div>
@endsection

@section('script')
    <!-- [Page Specific JS] start -->
    {{-- <script src="{{ asset('../assets') }}/js/plugins/apexcharts.min.js"></script>
    <script src="{{ asset('../assets') }}/js/pages/dashboard-default.js"></script> --}}
    <!-- [Page Specific JS] end -->

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
    {{-- <script>
        console.log("Pie Labels:", @json($pieLabels));
        console.log("Pie Values:", @json($pieValues));

        var options_pie_chart_1 = {
            chart: {
                height: 320,
                type: 'pie'
            },
            labels: @json($pieLabels),
            series: @json($pieValues),
            colors: ['#1890ff', '#52c41a', '#13c2c2', '#faad14', '#ff4d4f'],
            legend: {
                show: true,
                position: 'bottom'
            },
            dataLabels: {
                enabled: true,
                dropShadow: {
                    enabled: false
                }
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        console.log("Options Final:", options_pie_chart_1);

        var chart_pie_chart_1 = new ApexCharts(
            document.querySelector('#pie-produk-terlaris'),
            options_pie_chart_1
        );
        chart_pie_chart_1.render();
    </script> --}}
    <script>
        var options_mixed_chart_2 = {
            chart: {
                height: 350,
                type: 'line',
                stacked: false
            },
            stroke: {
                width: 3,
                curve: 'smooth'
            },

            colors: ['#ff4d4f', '#1890ff', '#52c41a'],

            series: [{
                    name: 'Flash Sale',
                    type: 'line',
                    data: @json($seriesFlash)
                },
                {
                    name: 'Big Sale',
                    type: 'line',
                    data: @json($seriesBig)
                },
                {
                    name: 'Promo Lainnya (Umum)',
                    type: 'line',
                    data: @json($seriesUmum)
                }
            ],

            xaxis: {
                categories: @json($labels)
            },

            yaxis: {
                min: 0
            },

            tooltip: {
                shared: true,
                intersect: false
            },

            legend: {
                labels: {
                    useSeriesColors: true
                }
            }
        };

        var charts_mixed_chart_2 = new ApexCharts(
            document.querySelector('#mixed-chart-2'),
            options_mixed_chart_2
        );

        charts_mixed_chart_2.render();
    </script>
@endsection
