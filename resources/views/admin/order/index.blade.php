@extends('admin.template.main')
@section('contents')

<div class="container">

    <h2>List of Orders</h2>
    @if(count($keranjangs) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Brand</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total Price</th>
                    <th>User</th>
                    <th>Order Time</th>
                    <th>Status pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @foreach($keranjangs as $keranjang)
                    <tr>
                        <td>{{ $keranjang->id }}</td>
                        <td>{{ $keranjang->namabarang }}</td>
                        <td>{{ $keranjang->brand }}</td>
                        <td>{{ $keranjang->ukuran ?: 'N/A' }}</td>
                        <td>{{ $keranjang->jumlahbarang }}</td>
                        <td>{{ $keranjang->harga }}</td>
                        <td>{{ $keranjang->total_harga }}</td>
                        <td>{{ optional($keranjang->pembelian)->pembeli->namalengkap ?? 'N/A' }}</td>
                        <td>{{ $keranjang->created_at }}</td>
                        <td>{{ $keranjang->status_pembayaran }}</td>
<!-- Tambahkan pada loop foreach di dalam <td> terakhir -->
<td>
    <form action="{{ route('updatePaymentStatus') }}" method="post">
        @csrf
        <input type="hidden" name="keranjang_id" value="{{ $keranjang->id }}">
        <button type="submit" class="btn btn-success">Mark as Paid</button>
    </form>
</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No orders found.</p>
    @endif
</div>

@endsection
