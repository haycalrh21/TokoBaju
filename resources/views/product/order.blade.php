    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        @vite('resources/css/app.css')
        @include('template.loading')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>


    @include('template.navbar')
    <div class="flex items-center justify-center space-x-4">
        <div class="w-full lg:w-2/3">
            <!-- Daftar Barang di Keranjang -->
            <div>
                @if(session('keranjang') && count(session('keranjang')) > 0)
                    @php $totalHarga = 0; @endphp
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        @foreach(session('keranjang') as $product)
                            <div class="flex items-center border-b pb-4">
                                <!-- Tampilkan detail produk -->
                                <img name="gambar" class="h-24 w-28 mr-4 rounded-md border" src="{{ asset('storage/' . $product['image']) }}" alt="">
                                <div>
                                    <p class="font-semibold">{{ $product['brand'] }}</p>
                                    <p class="text-lg font-bold">Rp. {{ number_format($product['harga'], 0, ',', '.') }}</p>
                                    <h2>{{ $product['namabarang'] }}</h2>
                                    <p>Ukuran:</p>
                                    <ul>
                                        @if(!empty($product['ukuran']) && is_array($product['ukuran']))
                                            @foreach ($product['ukuran'] as $size)
                                                <li>{{ is_array($size) ? json_encode($size) : $size }}</li>
                                            @endforeach
                                        @endif
                                    </ul>
                                    <label for="jumlahbarang">Jumlah Barang: {{ $product['jumlahbarang'] }}</label>
                                </div>
                                <!-- Hitung total harga untuk setiap produk -->
                                @php $totalHarga += $product['harga'] * $product['jumlahbarang']; @endphp
                            </div>
                        @endforeach

                    </div>

                    <!-- Formulir Detail Pembayaran -->
                    <form action="{{ route('selesaiorder') }}" onsubmit="checkStockAndSubmit(event)" class="space-y-4" method="post">
                        @csrf
                        <div class="border rounded p-4">
                            <label for="namalengkap" class="block mb-2">Nama Lengkap</label>
                            <input type="text" id="namalengkap" name="namalengkap" class="w-full border rounded-md px-3 py-2" placeholder="Masukkan nama lengkap">
                        </div>
                        <div class="border rounded p-4">
                            <label for="email" class="block mb-2">Email</label>
                            <input type="email" id="email" name="email" class="w-full border rounded-md px-3 py-2" placeholder="Masukkan alamat email">
                        </div>

                        <div class="border rounded p-4">
                            <label for="alamat" class="block mb-2">Alamat</label>
                            <textarea id="alamat" name="alamat" class="w-full border rounded-md px-3 py-2" placeholder="Masukkan alamat rumah"></textarea>
                            <input type="text" id="kodepos" name="kodepos" class="w-full border rounded-md px-3 py-2" placeholder="Masukkan kode pos">

                        </div>

                        <div class="border rounded p-4 flex space-x-4">
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

                        <div class="border rounded p-4">

                            <label for="courier" class="block mb-2">Pilih Pengiriman</label>
                            <select  name="courier" id="courier">
                                <option>Pilih Kurir</option>
                                <option value="jne">JNE</option>
                                <option value="pos">POS</option>
                                <option value="tiki">TIKI</option>
                            </select>
                            <label for="notes" class="block mb-2">Notes</label>
                            <input type="text" id="notes" name="notes" class="w-full border rounded-md px-3 py-2" placeholder="Masukkan alamat email">
                        </div>

                        <div>
                            <button type="submit" name="cekOngkir" class="w-full rounded-md bg-gray-900 px-6 py-3 font-medium text-white" formaction="{{ route('selesaiorder') }} ">Bayar</button>
                            <button type="submit" name="cekOngkir" class="w-full rounded-md bg-orange-900 px-6 py-3 font-medium text-white" formaction="{{ route('cekOngkir') }} ">cek ongkir</button>

                           
                        </div>

                    </form>

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
                    <div class="border-t pt-4">
                        <p id="totalHarga" class="font-bold">Total Harga : Rp. {{ number_format($totalHarga, 0, ',', '.') }}</p>
                    </div>

                    <form action="{{ route('cancel') }}" method="post">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white rounded-md px-4 py-2 mt-4">Batalkan Pesanan</button>
                    </form>

                    <form action="{{ route('cekOngkir') }}" method="post">
                        @csrf

                    </form>

                @else
                    <p>Data keranjang kosong</p>
                @endif
            </div>
        </div>
    </div>




        @yield('content')


    </body>
    {{-- @include('template.footer') --}}



        <!-- Your existing HTML content -->
    
        <script>
 
    
            function updateTotalHarga(element, harga) {
                let jumlahBarang = parseInt(element.value);
                let totalHarga = isNaN(harga) ? 0 : harga * jumlahBarang;
                document.getElementById('totalHarga').innerText = `Total: Rp. ${totalHarga.toLocaleString()}`;
            }
    
            function checkStockAndSubmit(event) {
                const selectedQuantity = parseInt(document.getElementById('jumlahbarang').value);
                const stok = parseInt({{ $product->stok ?? 0 }});
    
                if (selectedQuantity > stok) {
                    event.preventDefault();
                    alert('Maaf, pesanan melebihi stok yang tersedia.');
                }
            }
    
            function updateSelectedQuantity(element) {
                document.getElementById('selectedQuantity').value = element.value;
            }
        </script>

    
    

    </html>
