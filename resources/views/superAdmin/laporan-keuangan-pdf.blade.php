<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ public_path('../assets/images/logo-toko.png') }}" type="image/x-icon">
    <title>Laporan Keuangan</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }

        .kop {
            text-align: left;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }

        .kop img {
            max-height: 80px;
            margin-bottom: 5px;
        }

        .kop h2,
        .kop h4,
        .kop p {
            margin: 2px;
        }

        h3 {
            text-align: center;
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th,
        table td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        tfoot td {
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        footer {
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #555;
        }
    </style>
</head>

<body>

    @php
        $toko = \App\Models\Toko::first();
    @endphp

    <div class="kop">
        @if ($toko && $toko->logo)
            <img src="{{ public_path('storage/uploads/toko/logo/' . $toko->logo) }}" alt="{{ $toko->nama }}">
        @endif
        <h2>{{ $toko->nama ?? 'Nama Toko' }}</h2>
        @if ($toko)
            @php
                $parts = explode('|', $toko->alamat);
                $alamat = trim($parts[0]);
            @endphp
            <p>{{ $alamat ?? '' }} | Telp: {{ $toko->no_hp ?? '' }} | Email: {{ $toko->email ?? '' }}</p>
        @endif
    </div>

    @php
        \Carbon\Carbon::setLocale('id');
        $bulanNama = \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F');
    @endphp

    <h3>Laporan Keuangan Bulanan<br>{{ $bulanNama }} {{ $tahun }}</h3>


    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Keterangan</th>
                <th class="text-right">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($recentTransactions as $key => $trx)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $trx['time']->format('d-m-Y') }}</td>
                    <td>{{ $trx['type'] === 'in' ? 'Pemasukan' : 'Pengeluaran' }}</td>
                    <td>{{ $trx['keterangan'] }}</td>
                    <td class="text-right">{{ number_format($trx['amount'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right">Total Pemasukan</td>
                <td class="text-right">{{ number_format($totalPemasukan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="4" class="text-right">Total Pengeluaran</td>
                <td class="text-right">{{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="4" class="text-right">Saldo Bersih</td>
                <td class="text-right">{{ number_format($totalPemasukan - $totalPengeluaran, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <footer>
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}
    </footer>

</body>

</html>
