<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @include('template.navbar')
    @vite('resources/css/app.css')
</head>

@include('template.loading')
<style>
  .product-image {
    width: 100%; /* Set the width to fill its container */
    aspect-ratio: 1 / 1; /* Maintain a 1:1 aspect ratio */
    object-fit: cover; /* Ensure the image covers the entire area */
  }
</style>
<body>



<div class="hero min-h-screen" style="background-image: url(https://daisyui.com/images/stock/photo-1507358522600-9f71e620c44e.jpg);">
    <div class="hero-overlay bg-opacity-10"></div>
    <div class="hero-content text-center text-neutral-content">
      <div class="max-w-md">
        <h1 class="mb-5 text-5xl font-bold">Hai Everyone</h1>
        <p class="mb-5">Boleh kali diliat dulu bajunya , kalo ga di beli gapapa juga ko :) </p>
        {{-- <button class="btn btn-primary">Get Started</button> --}}
      </div>
    </div>
  </div>

  <section>
    <b><h1 style="font-size: 50px; text-align: center;">Last Update</h1></b>
    <div class="max-w-screen-xl px-4 py-8 mx-auto sm:py-12 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 gap-4 lg:grid-cols-3 lg:items-stretch">
        <div class="grid p-6 bg-gray-100 rounded place-content-center sm:p-8">
          <div class="max-w-md mx-auto text-center lg:text-left">
            <header>
              <h2 class="text-xl font-bold text-gray-900 sm:text-3xl">Baju</h2>
              <p class="mt-4 text-gray-500">
                Yakali Baju loh itu itu , di order lah bray biar makin bagus koleksi baju lo
              </p>
            </header>
            <a href="{{ route('indexproduct') }}" class="inline-block px-12 py-3 mt-8 text-sm font-medium text-white transition bg-gray-900 border border-gray-900 rounded hover:shadow focus:outline-none focus:ring">
              Cari barang lo disini
            </a>
          </div>
        </div>
        @foreach ($products as $product)
        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
          <a href="#">
            <img class="product-image" src="{{ asset('storage/' . $product->image) }}" alt="Product Image">
          </a>
          <div class="px-5 pb-5">
            <a href="#">
              <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $product->namabarang }}</h5>
            </a>
            <br>
            <div class="flex items-center justify-between">
              <span class="text-1xl font-bold text-gray-900 dark:text-white">Harga: Rp {{ number_format($product['harga'], 0, ',', '.') }}</span>
              {{-- <form action="{{ route('tambahkeranjang') }}" method="post"> --}}
              <a href="{{ route('indexproduct')}}"  class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add to cart</a>
            {{-- <button type="submit">masukan keranjang</button> --}}
            {{-- </form> --}}
            </div>
          </div>
        </div>
      @endforeach
      </div>
    </div>
  </section>


</body>
{{-- @include('template.footer') --}}

</html>
