@extends('admin.template.main')

@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">Daftar Produk</h1>
        <a href="{{ route('admin.product.create') }}" class="btn btn-primary">Tambah Produk</a>
    </div>
    <hr />
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <table class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jenis Barang</th>
                <th>Brand</th>
                <th>Ukuran</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Gambar</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if($product->count() > 0)
                @foreach($product as $product)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $product->namabarang }}</td>
                        <td class="align-middle">{{ $product->jenisbarang }}</td>
                        <td class="align-middle">{{ $product->brand }}</td>
                        <td class="align-middle">{{ $product->ukuran }}</td>
                        <td class="align-middle">{{ $product->stok }}</td>
                        <td class="align-middle">{{ $product->harga }}</td>
                        <td class="align-middle">
                            @if ($product->image)
                                <img style="width: 100px; height: 100px;" src="{{ asset('storage/' . $product->image) }}" alt="Image">
                            @else
                                <p>No image available</p>
                            @endif
                        </td>
                        <td class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic example">

                                <a href="{{ route('admin.product.show', $product->id) }}" type="button" class="btn btn-secondary">Detail</a>
                                <a href="{{ route('admin.product.edit', $product->id)}}" type="button" class="btn btn-warning">Edit</a>
                                <form action="{{ route('admin.product.destroy', $product->id) }}" method="POST" type="button" class="btn btn-danger p-0" onsubmit="return confirm('Hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger m-0">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="6">Belum ada produk.</td>
                </tr>
            @endif
        </tbody>
    </table>
@endsection
