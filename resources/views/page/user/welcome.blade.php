<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>XYZ</title>



</head>
@include('page.user.template.navbar')

<body>


<section>
    <div class="hero min-h-screen relative">
        <img src="{{ asset('/img/baju.jpg') }}" alt="test" class="w-full h-full object-cover">
        <div class="hero-overlay bg-opacity-10 absolute top-0 left-0 w-full h-full"></div>
        <div class="hero-content text-center text-secondary absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
            <div class="max-w-md">
                <h1 class="mb-5 text-5xl font-bold text-white">Hai Everyone</h1>
                <p class="mb-5 text-white">Boleh kali diliat dulu bajunya, kalo ga dibeli gapapa juga ko :)</p>
                {{-- <button class="btn btn-primary">Get Started</button> --}}
            </div>
        </div>
    </div>
</section>

  <section class="bg-sky-950">
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
          <a href="{{ route('detailbaju',['id'=> $product->id])}}"  class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Detail</a>


            </div>
          </div>

        </div>
      @endforeach
      </div>
    </div>
  </section>


</body>
@include('page.user.template.footer')

</html>
