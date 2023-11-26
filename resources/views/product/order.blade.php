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
                        </div>

                        <div class="border rounded p-4 flex space-x-4">
                            <!-- Input state -->
                            <input type="text" id="provinsi" name="provinsi" class="w-full border rounded-md px-3 py-2" placeholder="Masukkan provinsi">

                            <!-- Input ZIP -->
                            <input type="text" id="kodepos" name="kodepos" class="w-full border rounded-md px-3 py-2" placeholder="Masukkan kode pos">
                        </div>

                        <div class="border rounded p-4">
                            <label for="pengiriman" class="block mb-2">Pengiriman</label>
                            <textarea id="pengiriman" name="pengiriman" class="w-full border rounded-md px-3 py-2" placeholder="Masukkan Jasa Pengiriman"></textarea>
                        </div>

                        <!-- (Sisipkan bagian form lainnya di sini) -->
                        <button type="submit" class="w-full rounded-md bg-gray-900 px-6 py-3 font-medium text-white">Bayar</button>
                    </form>
                    <div class="border-t pt-4">
                        <p id="totalHarga" class="font-bold">Total: Rp. {{ number_format($totalHarga, 0, ',', '.') }}</p>
                    </div>
                    <form action="{{ route('cancel') }}" method="post">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white rounded-md px-4 py-2 mt-4">Batalkan Pesanan</button>
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
    <script>
    function updateTotalHarga(element, harga) {
    let jumlahBarang = parseInt(element.value);
    let totalHarga = isNaN(harga) ? 0 : harga * jumlahBarang;
    document.getElementById('totalHarga').innerText = `Total: Rp. ${totalHarga.toLocaleString()}`;
}
function checkStockAndSubmit(event) {


    function checkStockAndSubmit(event) {
    const selectedQuantity = parseInt(document.getElementById('jumlahbarang').value); // Ambil nilai jumlah barang yang dipilih
    const stok = parseInt({{ $product->stok ?? 0 }}); // Ambil nilai stok dari variabel PHP dan pastikan dikonversi ke integer

    if (selectedQuantity > stok) {
        event.preventDefault(); // Batalkan pengiriman form jika jumlah yang dipilih melebihi stok
        alert('Maaf, pesanan melebihi stok yang tersedia.');
    }
}
function updateSelectedQuantity(element) {
    document.getElementById('selectedQuantity').value = element.value; // Perbarui nilai pada field hidden sesuai jumlah barang yang dipilih
}
    </script>

    </html>
