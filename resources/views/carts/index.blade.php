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

<div class="container">
    <h2>Shopping Cart</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($cartItems->isEmpty())
        <p>Keranjang Anda kosong.</p>
    @else
        <!-- Tampilkan isi keranjang -->
        <table class="table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Ukuran</th>
                    <th>Jumlah</th>
                    <th>harga</th>
                    <th>Hapus</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $cartItem)
                    <tr>
                        <td>{{ $cartItem->product->namabarang }}</td>
                        <td>{{ $cartItem->size }}</td>
                        <td>{{ $cartItem->quantity }}</td>
                        <td>{{ $cartItem->harga }}</td>
                        <td>
                            <form action="{{ route('carts.removeFromCart', $cartItem->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p>Total: {{ $cartItems->sum('quantity') }} barang</p>
    @endif
<!-- Open the modal using ID.showModal() method -->
<button class="btn" onclick="my_modal_1.showModal()">open modal</button>
<dialog id="my_modal_1" class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg">Hello!</h3>
    <p class="py-4">Press ESC key or click the button below to close</p>
    <div class="modal-action">
      <form method="post" action="{{ route('cekOngkir') }}">
@csrf
        <div class="">
            <!-- Input state -->
            {{-- <input type="text" id="provinsi" name="provinsi" class="w-full border rounded-md px-3 py-2" placeholder="Masukkan provinsi"> --}}
            <label for="origin" >Kota Pengiriman</label>
            <select  name="origin" id="origin">
                <option>kota Pengiriman</option>
                @foreach ($cities as $city )
                <option value="{{ $city['city_id'] }}" > {{ $city['city_name'] }}</option>

                @endforeach
            </select>


            <label for="destination">Kota Tujuan</label>
            <select  name="destination" id="destination">
                <option>kota tujuan</option>
                @foreach ($cities as $city )
                <option value="{{ $city['city_id'] }}" > {{ $city['city_name'] }}</option>

                @endforeach
            </select>

            <label for="weight"> berat paket </label>
            <input type="number" id="weight" name="weight" placeholder="Tolong isi 1000/2000 Gram" class="w-full border rounded-md px-3 py-2" >/ 1000 Gram
        </div>

        <div class="">

            <label for="courier" class="block mb-2">Pilih Pengiriman</label>
            <select  name="courier" id="courier">
                <option>Pilih Kurir</option>
                <option value="jne">JNE</option>
                <option value="pos">POS</option>
                <option value="tiki">TIKI</option>
            </select>

        </div>

<button type="submit" name="cekOngkir" class="w-full rounded-md bg-orange-900 px-6 py-3 font-medium text-white" ">cek ongkir</button>
@csrf
      </form>
    </div>
  </div>
</dialog>
<div>
    @if ($ongkir != '')
    <h1>Rincian Ongkir</h1>


    <h3>
        <ul>
            @if (isset($ongkir['origin_details']['city_name']))
            <li>Kota Pengiriman : {{ $ongkir['origin_details']['city_name'] }}</li>
        @endif

        @if (isset($ongkir['destination_details']['city_name']))
            <li>Kota Tujuan: {{ $ongkir['destination_details']['city_name'] }}</li>
        @endif


        </ul>

    </h3>
    @foreach ($ongkir['results'] ?? [] as $item)
        <div>
            <label for="name">{{ $item['name'] }}</label>
            @foreach ($item['costs'] as $cost)
                <div>
                    <label for="service">{{ $cost['service'] }}</label>
                    @foreach ($cost['cost'] as $harga)
                        <div>
                            <label for="harga">
                                Harga: {{ $harga['value'] }} (est : {{ $harga['etd'] }} hari)
                                <button type="button"
                                    class="bg-green-500 text-white rounded-md px-4 py-2 mt-4"
                                    onclick="">Pilih
                                    Pengiriman</button>
                            </label>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    @endforeach
    @endif
</div>

</div>


</body>
</html>
