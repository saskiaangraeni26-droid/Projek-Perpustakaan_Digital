<!DOCTYPE html>
<html>
<head>
    <title>Laporan Peminjaman</title>
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

<h2>LAPORAN PEMINJAMAN BUKU</h2>
<p class="info">Tanggal Cetak: {{ date('d-m-Y') }}</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Judul</th>
            <th>Tgl Pinjam</th>
            <th>Jatuh Tempo</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @php $no=1; @endphp
        @foreach($data as $item)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $item->nama }}</td>
            <td>{{ optional($item->buku)->judul_buku }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d-m-Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tgl_kembali)->format('d-m-Y') }}</td>
            <td>
                @php $status = trim(strtolower($item->status)); @endphp

                @if($status == 'menunggu')
                    Menunggu

                @elseif($status == 'dipinjam')
                    Dipinjam

                @elseif($status == 'menunggu_konfirmasi')
                    Menunggu Konfirmasi

                @elseif($status == 'ditolak')
                    Ditolak

                @elseif($status == 'dikembalikan')
                    Selesai

                @else
                    {{ $item->status }}
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>

    <tfoot>
        <tr>
            <td colspan="6"><b>Total Data: {{ count($data) }}</b></td>
        </tr>
    </tfoot>
</table>

</body>
</html>