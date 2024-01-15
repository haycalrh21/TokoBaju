@extends('admin.template.main')
@section('contents')

<div class="container">

    <h2>List of Orders</h2>
    @if(count($keranjangs) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cart ID</th>
                    <th>Product Name</th>

                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total Price</th>
                    <th>User</th>
                    <th>Alamat</th>
                    <th>Status pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($keranjangs as $keranjang)
                    <tr>
                        <td>{{ $keranjang->id }}</td>
                        <td>{{ $keranjang->cart_id }}</td>
                        <td>{{ $keranjang->product->namabarang }}</td>

                        <td>{{ $keranjang->size ?: 'N/A' }}</td>
                        <td>{{ $keranjang->quantity }}</td>
                        <td>{{ $keranjang->harga }}</td>
                        <td>{{ $keranjang->totalPrice }}</td>

                        <td>{{ $keranjang->user->name }}</td>
                        <td>{{ $keranjang->pengiriman->alamat}}</td>
                        <td>{{ $keranjang->created_at }}</td>
                        <td>{{ $keranjang->status }}</td>


                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No orders found.</p>
    @endif
</div>

@endsection
