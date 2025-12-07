<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Stok Produk</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #333;
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
        .kop p {
            margin: 2px;
        }

        h3 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
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

        /* Warna baris berdasarkan stok */
        .baris-habis {
            background-color: #6c757d;
            color: #fff;
        }

        .baris-habis td {
            color: #fff;
        }

        .baris-hampir-habis {
            background-color: #dc3545;
            color: #fff;
        }

        .baris-hampir-habis td {
            color: #fff;
        }

        .baris-menipis {
            background-color: #ffc107;
            color: #000;
            border: 1px solid #6c757d;
        }

        .baris-aman {
            background-color: #ffffff;
            color: #198754;
            border: 1px solid #198754;
        }

        footer {
            text-align: center;
            font-size: 10px;
            margin-top: 20px;
            color: #555;
        }
    </style>
</head>

<body>

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

    <h3>Laporan Stok Produk {{ $status ? ucfirst(str_replace('-', ' ', $status)) : 'Semua Status' }}</h3>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produk as $key => $p)
                @php
                    $kelasBaris = '';
                    $st = '';
                    if ($p->stok == 0) {
                        $st = 'Habis';
                        $kelasBaris = 'baris-habis';
                    } elseif ($p->stok >= 1 && $p->stok <= 5) {
                        $st = 'Hampir Habis';
                        $kelasBaris = 'baris-hampir-habis';
                    } elseif ($p->stok >= 6 && $p->stok <= 20) {
                        $st = 'Menipis';
                        $kelasBaris = 'baris-menipis';
                    } else {
                        $st = 'Aman';
                        $kelasBaris = 'baris-aman';
                    }
                @endphp
                <tr class="{{ $kelasBaris }}">
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $p->nama_produk }}</td>
                    <td>{{ $p->kategori->nama_kategori ?? '-' }}</td>
                    <td>{{ $p->stok }}</td>
                    <td>{{ $st }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <footer>
        Dicetak pada: {{ $tanggalCetak }}
    </footer>

</body>

</html>
