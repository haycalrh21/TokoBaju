@extends('page.admin.template.main')

@section('contents')
<div class="d-flex align-items-center justify-content-between">
    <h1 class="mb-0">Tambah Product</h1>
    <a href="{{ route('productadmin') }}" class="btn btn-primary">Daftar Postingan</a>
</div>
<hr />

<form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="namabarang" class="form-label">Nama Barang</label>
                <input type="text" name="namabarang" class="form-control" id="nambarang" placeholder="Nama Barang">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="jenisbarang" class="form-label">Jenis Barang</label>
                <input type="text" name="jenisbarang" class="form-control" id="jenisbarang" placeholder="Jenis Barang">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="brand" class="form-label">Brand</label>
                <input type="text" name="brand" class="form-control" id="brand" placeholder="Brand">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="ukuran" class="form-label">Ukuran</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="ukuran[]" id="s" value="S">
                <label class="form-check-label" for="s">S</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="ukuran[]" id="m" value="M">
                <label class="form-check-label" for="m">M</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="ukuran[]" id="l" value="L">
                <label class="form-check-label" for="l">L</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="ukuran[]" id="xl" value="XL">
                <label class="form-check-label" for="xl">XL</label>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="text" name="stok" class="form-control" id="stok" placeholder="Stok">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="text" name="harga" class="form-control" id="harga" placeholder="Harga">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="mb-3">
                <label for="image" class="form-label">Gambar</label><br>
                <input type="file"  name="image" id="image" class="file-input file-input-ghost w-full max-w-xs" />

            </div>
        </div>
    </div>



            <button type="submit"class="btn btn-ghost">Simpan</button>
</form>
@endsection
