<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
    @include('template.loading')
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}


</head>
@include('template.navbar')

<style>
     .custom-footer {
  position: relative; /* Atur posisi kembali ke relatif */

  /* Atur properti lainnya sesuai kebutuhan halaman ini */
}

    .card {
  width: 100%;
  max-width: 20rem;
  height: 100%;
  border: 1px solid #ccc;
  border-radius: 0.375rem;
  padding: 1rem;
  margin-bottom: 1.5rem; /* Menambahkan margin bawah */
  margin-right: 1rem; /* Menambahkan margin kanan */
}

.card img {
  width: 100%;
  height: 10rem; /* Sesuaikan ukuran gambar */
  object-fit: cover;
  border-radius: 0.375rem;
  /* margin-bottom: 1rem; */
}

.card h1 {
  font-size: 1.25rem;
  margin: 0;
}

.card p {
  font-size: 14px;
  margin: 0;
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
}

.btn-add-to-cart {
  display: block;
  width: 100%;
  padding: 0.5rem;
  text-align: center;
  border: none;
  border-radius: 0.375rem;
  background-color: #007bff;
  color: #fff;
  text-decoration: none;
}

/* Hover effect */
.card:hover {
  transform: scale(1.01, 1.01);
}

/* Responsive design for image heights */
@media (min-width: 576px) {
  .card img {
    height: 50vw;
  }
}

@media (min-width: 768px) {
  .card img {
    height: 30vw;
  }
}

@media (min-width: 992px) {
  .card img {
    height: 20vw;
  }
}

@media (min-width: 1200px) {
  .card img {
    height: 20vw;
  }
}

/* Media query to change flex direction and width on smaller screens */
@media (max-width: 768px) {
  .card-container {
    flex-direction: column; /* Kartu produk ditumpuk secara vertikal di layar yang lebih kecil */
  }

  .card {
    flex: 0 0 100%; /* Lebar penuh di layar yang lebih kecil */
  }
}

.size-list li {
  display: inline-block;
  margin-right: 10px;
}

.size-list input[type="radio"] {
  /* Hapus properti display: none; agar radio button dapat di-klik */
}

.size-list input[type="radio"]:checked + label {
  background-color: #007bff;
  color: #fff;
}

</style>


<body>
    <br>
    <br>
    <br>

    <div class="flex flex-wrap items-center justify-center">
        @foreach ($products as $product)
            @if ($product->stok > 0)
                <div class="col-1 col-md-6 col-lg-3 mb-4">
                    <div class="card">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image">
                        <h1>{{ $product->namabarang }}</h1>
                        <h1>{{ $product->jenisbarang }}</h1>
                        <p>Brand: {{ $product->brand }}</p>
                        <p>Harga: Rp {{ number_format($product['harga'], 0, ',', '.') }}</p>
                        <form action="{{ route('carts.addToCart', ['productId' => $product->id]) }}" method="post">
                            @csrf
                            <p>Pilih Ukuran:</p>
                            <ul class="size-list">
                                @foreach ($product->productSizes as $size)
                                    <li>
                                        <input type="radio" name="ukuran[{{ $product->id }}]" id="{{ $size->size }}" value="{{ $size->size }}" required>
                                        <label for="{{ $size->size }}">{{ $size->size }}</label>
                                    </li>
                                @endforeach
                            </ul>

                            <select name="quantity[{{ $product->id }}]" id="quantity">
                                @for ($i = 1; $i <= 50; $i++)
                                    <option value="{{ $i }}" data-stok="{{ $product->stok }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <div>
                                Stok untuk: {{ $product->stok }}
                            </div>
                            <br>
                            <br>
                            <button type="submit" class="btn-add-to-cart">Tambah ke Keranjang</button>
                        </form>

                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <div class="flex flex-wrap items-center justify-center">
       <!-- Tambahkan script berikut di dalam tag <script> di akhir bagian body HTML Anda -->

    </div>


</body>
<footer class="footer footer-center p-4 bg-base-300 text-base-content custom-footer">
    @include('template.footer')
</footer>

</html>
