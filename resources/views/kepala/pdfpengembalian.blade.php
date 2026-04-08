<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengembalian</title>
    <style>
        body { font-family: sans-serif; }
        h2 { text-align: center; margin-bottom: 5px; }
        .info { font-size: 12px; margin-bottom: 10px; }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 6px;
            font-size: 12px;
            text-align: center;
        }
        th {
            background: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>LAPORAN PENGEMBALIAN BUKU</h2>
<p class="info">Tanggal Cetak: {{ date('d-m-Y') }}</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Nama</th>
            <th>Tgl Pinjam</th>
            <th>Jatuh Tempo</th>
            <th>Kembali</th>
            <th>Terlambat</th>
            <th>Denda</th>
        </tr>
    </thead>

    <tbody>
        @php $no=1; $total=0; @endphp

        @foreach($data as $item)
        @php
            $tglPinjam = \Carbon\Carbon::parse($item->tgl_pinjam);
            $jatuhTempo = \Carbon\Carbon::parse($item->tgl_kembali);
            $dikembalikan = \Carbon\Carbon::parse($item->tgl_dikembalikan);

            $telat = $dikembalikan->gt($jatuhTempo)
                ? $jatuhTempo->diffInDays($dikembalikan)
                : 0;

            $denda = $telat * 5000;
            $total += $denda;
        @endphp

        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ optional($item->buku)->judul_buku }}</td>
            <td>{{ $item->nama }}</td>
            <td>{{ $tglPinjam->format('d-m-Y') }}</td>
            <td>{{ $jatuhTempo->format('d-m-Y') }}</td>
            <td>{{ $dikembalikan->format('d-m-Y') }}</td>
            <td>{{ $telat }}</td>
            <td>Rp {{ number_format($denda,0,',','.') }}</td>
        </tr>
        @endforeach
    </tbody>

    <tfoot>
        <tr>
            <td colspan="7"><b>Total Denda</b></td>
            <td><b>Rp {{ number_format($total,0,',','.') }}</b></td>
        </tr>
    </tfoot>
</table>

</body>
</html>