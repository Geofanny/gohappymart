<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pelanggan</title>
    <link rel="icon" href="{{ public_path('../assets/images/logo-toko.png') }}" type="image/x-icon">
    <style>
        body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 20px; color: #333; }
        
        .kop {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        
        .kop img {
            max-height: 80px;
            margin-right: 15px;
        }
        
        .kop .info {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .kop .info h2 {
            margin: 0;
            font-size: 18px;
        }

        .kop .info p {
            margin: 2px 0;
            font-size: 12px;
        }

        h3 { margin-top: 0; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table th, table td { border: 1px solid #999; padding: 8px; text-align: left; }
        table th { background-color: #f2f2f2; }
        tfoot td { font-weight: bold; }

        /* Label status */
        .status {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            color: #fff;
            font-size: 11px;
            font-weight: bold;
        }
        .status-aktif { background-color: #28a745; }
        .status-nonaktif { background-color: #dc3545; }

        footer { text-align: center; font-size: 10px; margin-top: 20px; color: #555; }
    </style>
</head>
<body>

@php
    $toko = \App\Models\Toko::first();
@endphp

<div class="kop">
    @if($toko && $toko->logo)
        <img src="{{ public_path('storage/uploads/toko/logo/' . $toko->logo) }}" alt="{{ $toko->nama }}">
    @endif
    <div class="info">
        <h2>{{ $toko->nama ?? 'Nama Toko' }}</h2>
        @if($toko)
            @php
                $parts = explode('|', $toko->alamat);
                $alamat = trim($parts[0]);
            @endphp
            <p>{{ $alamat ?? '' }} | Telp: {{ $toko->no_hp ?? '' }} | Email: {{ $toko->email ?? '' }}</p>
        @endif
    </div>
</div>

<h3>Laporan Pelanggan</h3>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pelanggan as $key => $p)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $p->nama_pelanggan }}</td>
            <td>{{ $p->email }}</td>
            <td>{{ $p->no_hp }}</td>
            <td>
                <span class="status {{ $p->status == 'aktif' ? 'status-aktif' : 'status-nonaktif' }}">
                    {{ ucfirst($p->status) }}
                </span>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<footer>
    Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}
</footer>

</body>
</html>
