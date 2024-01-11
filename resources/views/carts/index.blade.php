<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --}}

</head>
<body>
    @include('template.navbar')


    <h2>Shopping Cart</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($cartItems->isEmpty())
        <p>Keranjang Anda kosong.</p>
    @else
        <div class="container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Ukuran</th>
                        <th>Jumlah</th>
                        <th>harga</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $cartItem)
                        <tr>
                            <td>{{ $cartItem->product->namabarang }}</td>
                            <td>{{ $cartItem->size }}</td>
                            <td>{{ $cartItem->quantity }}</td>
                            <td>{{ $cartItem->harga }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <form action="{{ route('carts.removeFromCart', $cartItem->id) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
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
<!-- Open the modal using ID.showModal() method -->
<button class="btn" onclick="my_modal_1.showModal()">open modal</button>
<dialog id="my_modal_1" class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg">Hello!</h3>
    <p class="py-4">Press ESC key or click the button below to close</p>
    <div class="modal-action">

    </div>
  </div>
</dialog>


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
    @else
        <p>Your cart is empty.</p>
    @endif
    <button type="submit" class="btn btn-primary">Submit Checkout</button>

</form>




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



</body>
</html>
