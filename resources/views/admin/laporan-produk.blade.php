<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Produk Per Kategori</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 20px; color: #333; }
        .kop { text-align: left; border-bottom: 2px solid #000; padding-bottom: 5px; margin-bottom: 20px; }
        .kop img { max-height: 80px; margin-bottom: 5px; }
        .kop h2, .kop h4, .kop p { margin: 2px; }
        h3 { text-align: center; margin-top: 0; margin-bottom: 20px; }
        h4 { margin-top: 25px; margin-bottom: 10px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        table th, table td { border: 1px solid #999; padding: 6px; text-align: left; }
        table th { background-color: #f2f2f2; }
        .status { padding: 2px 6px; border-radius: 4px; color: #fff; font-weight: bold; text-align: center; }
        .status.aktif { background-color: #28a745; }
        .status.nonaktif { background-color: #dc3545; }
        footer { text-align: center; font-size: 10px; margin-top: 20px; color: #555; }
    </style>
</head>
<body>

<div class="kop">
    @if($toko && $toko->logo)
        <img src="{{ public_path('storage/uploads/toko/logo/'.$toko->logo) }}" alt="{{ $toko->nama }}">
    @endif
    <h2>{{ $toko->nama ?? 'Nama Toko' }}</h2>
    @if($toko)
        @php
            $parts = explode('|', $toko->alamat);
            $alamat = trim($parts[0]);
        @endphp
        <p>{{ $alamat ?? '' }} | Telp: {{ $toko->no_hp ?? '' }} | Email: {{ $toko->email ?? '' }}</p>
    @endif
</div>

<h3>Laporan Semua Produk</h3>

@foreach($produkPerKategori as $kategori => $items)
    <h4>{{ $kategori }}</h4> <!-- hapus style page-break -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Stok</th>
                <th>Harga (Rp)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->nama_produk }}</td>
                <td>{{ $p->stok }}</td>
                <td>{{ number_format($p->harga ?? 0, 0, ',', '.') }}</td>
                <td>
                    <span class="status {{ $p->status }}">{{ ucfirst($p->status) }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endforeach



<footer>
    Dicetak pada: {{ $tanggalCetak }}
</footer>

</body>
</html>
