@extends('page.admin.template.main')
@section('contents')
{{-- @include('admin.template.navbar') --}}
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank"
            href="https://datatables.net">official DataTables documentation</a>.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
        <div class="card-body">
            <div class="table-responsive">
    @if(count($keranjangs) > 0)

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                            <th>Ongkos Kirim</th>
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

                                <td>
                                    @if ($keranjang->product)
                                    {{ $keranjang->product->namabarang }}
                                    @else
                                    N/A
                                    @endif
                                </td>



                                <td>{{ $keranjang->size ?: 'N/A' }}</td>
                                <td>{{ $keranjang->quantity }}</td>
                                <td>{{ $keranjang->harga }}</td>
                                <td>{{ $keranjang->totalPrice }}</td>

                                <td>{{ $keranjang->user->name }}</td>
                                <td>
                                    @if ($keranjang->pengiriman) {{-- Tambahkan pengecekan relasi pengiriman --}}
                                        {{ $keranjang->pengiriman->hargaongkir }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if ($keranjang->pengiriman) {{-- Tambahkan pengecekan relasi pengiriman --}}
                                        {{ $keranjang->pengiriman->alamat }}
                                    @else
                                        N/A
                                    @endif
                                </td>


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
        </div>
    </div>

</div>

@endsection





