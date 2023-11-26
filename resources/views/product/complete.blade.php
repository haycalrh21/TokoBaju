<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <!-- Masukkan bagian head atau stylesheet Anda di sini -->
    @include('template.navbar')
    @include('template.loading')
    <style>
        /* CSS untuk style tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        thead {
            background-color: #f2f2f2;
        }

        th {
            background-color: #d9d9d9;
        }
    </style>
</head>
<body>
    <center>
   <b>
    <h1>Invoice</h1>
    </b>

    </center>

    <table>
        <thead>
            <tr>
                <th>Pembelian ID</th>
                <th>Nama Barang</th>
                <th>Brand</th>
                <th>Ukuran</th>
                <th>Jumlah Barang</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transformedItems as $item)
                <tr>
                    <td>{{ $item['pembelian_id'] }}</td>
                    <td>{{ $item['namabarang'] }}</td>
                    <td>{{ $item['brand'] }}</td>
                    <td>{{ $item['ukuran'] }}</td>
                    <td>{{ $item['jumlahbarang'] }}</td>
                    <td><button>Cek Rincian</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>



    <!-- Form pembayaran atau tombol untuk melakukan pembayaran bisa ditambahkan di sini -->
    Sukses


</body>
@include('template.footer')
</html>
