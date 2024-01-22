<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Keranjang</title>


</head>

<style>
    html, body {
    height: 100%;

}




    .footer {
      position: fixed;
      bottom: 0;
      width: 100%;
    }

    .flex {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
    }

    .card {
        min-width: 200px; /* Lebar minimum setiap kartu */
        margin-right: 10px; /* Jarak antara setiap kartu */
    }

    /* Atur lebar kartu untuk perangkat mobile */
    @media (max-width: 576px) {
        .flex {
            flex-wrap: wrap;
            overflow-x: hidden; /
        }

        .card {
            flex: 0 0 calc(100% - 10px); /* Ambil 100% lebar container dan kurangi jarak antara kartu */
        }
    }
</style>
@include('template.navbar')

<body class="bg-sky-950 ">

<div class=""">
    <h2 class="text-center">Shopping Cart</h2>


    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($cartItems->isEmpty())
        <p class="text-center">Keranjang Anda kosong.</p>
    @else

    <div class="flex">
        @foreach($cartItems as $cartItem)

        <div class="card w-96 glass mr-4">
          <figure><img src="{{ asset('storage/' . $cartItem->product->image) }}" alt="{{ $cartItem->product->namabarang }}" alt="car!"/></figure>
          <div class="card-body">

            <h2 class="card-title">Nama Product: {{ $cartItem->product->namabarang }}</h2>
                    <p>Ukuran: {{ $cartItem->size }}</p>
                    <p>Jumlah: {{ $cartItem->quantity }}</p>
                    <p>Harga: {{ $cartItem->harga }}</p>
                    <form action="{{ route('carts.removeFromCart', $cartItem->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
          </div>
        </div>
        @endforeach


      </div>




        @php
        $totalPrice = 0;
    @endphp
      @foreach($cartItems as $cartItem)
      @php
          $subtotal = $cartItem->quantity * $cartItem->harga;
          $totalPrice += $subtotal;
      @endphp
  @endforeach
  <p id="totalPrice">Total Harga: {{ $totalPrice }}</p>

        <p>Total: {{ $cartItems->sum('quantity') }} barang</p>
    @endif




<form method="post" action="{{ route('cekongkos') }}">
    @csrf
    @if($cartItems->isNotEmpty())
        <input type="hidden" id="totalPriceInput" name="totalPrice" value="{{ $totalPrice }}">
        @foreach($cartItems as $index => $cartItem)
            <input type="hidden" name="cartItems[{{ $index }}][product_id]" value="{{ $cartItem->product->id }}">
            <input type="hidden" name="cartItems[{{ $index }}][size]" value="{{ $cartItem->size }}">
            <input type="hidden" name="cartItems[{{ $index }}][quantity]" value="{{ $cartItem->quantity }}">
            <input type="hidden" name="cartItems[{{ $index }}][harga]" value="{{ $cartItem->harga }}">
            <!-- Include other hidden inputs for other attributes of cart items -->
        @endforeach
        <button type="submit" class="btn btn-primary">Submit Checkout</button>
    @else

    @endif

</form>

</div>






{{-- <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script> --}}

<script type="text/javascript">


    function updateTotalPrice(newHarga) {
        // Get the current total price from the DOM
        var currentTotal = document.getElementById('totalPrice').innerHTML;

        // Extract the numerical value from the current total price
        var currentTotalValue = parseFloat(currentTotal.split(':')[1].trim());

        // Calculate the new total price by adding the newHarga to the current total
        var newTotalPrice = currentTotalValue + newHarga;

        // Update the total price in the DOM
        document.getElementById('totalPrice').innerHTML = 'Total Harga: ' + newTotalPrice;

        // Hide the "Rincian Ongkir" section
        // document.getElementById('rincianOngkirSection').style.display = 'none';
    }
</script>


    <footer class="footer footer-center p-4 bg-base-300 text-base-content">
        <aside>
          <p>Copyright © 2023 - All right reserved by Toko Baju XYZ </p>
        </aside>
    </footer>


</body>
</html>
