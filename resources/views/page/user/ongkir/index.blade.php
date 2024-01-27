<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

@include('page.user.template.navbar')
<body>
    <div id="iniformcekongkir">
        <form method="post" action="{{ route('cekongkoskirim1') }}" id="formCekOngkir">
            <div class="mb-4">
                <!-- Input state -->
                <label for="origin" class="block mb-2">Kota Pengiriman</label>
                <select name="origin" id="origin" class="w-full border rounded-md px-3 py-2">
                    <option disabled selected>Pilih Kota Pengiriman</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city['city_id'] }}">{{ $city['city_name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="destination" class="block mb-2">Kota Tujuan</label>
                <select name="destination" id="destination" class="w-full border rounded-md px-3 py-2">
                    <option disabled selected>Pilih Kota Tujuan</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city['city_id'] }}">{{ $city['city_name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="weight" class="block mb-2">Berat paket</label>
                <input type="number" id="weight" name="weight" placeholder="Masukkan berat dalam gram" class="w-full border rounded-md px-3 py-2" />
            </div>

            <div class="mb-4">
                <label for="courier" class="block mb-2">Pilih Pengiriman</label>
                <select name="courier" id="courier" class="w-full border rounded-md px-3 py-2">
                    <option disabled selected>Pilih Kurir</option>
                    <option value="jne">JNE</option>
                    <option value="pos">POS</option>
                    <option value="tiki">TIKI</option>
                </select>
            </div>

            <button type="submit" class="w-full rounded-md bg-orange-900 px-6 py-3 font-medium text-white">Cek Ongkir</button>

            @csrf
        </form>
    </div>




    <div id="rincianOngkirSection">
        @if ($ongkir != '')
            <h1 id="rincianOngkirTitle">Rincian Ongkir</h1>

            <h3>
                <ul>
                    @if (isset($ongkir['origin_details']['city_name']))
                        <li>Kota Pengiriman: {{ $ongkir['origin_details']['city_name'] }}</li>
                    @endif

                    @if (isset($ongkir['destination_details']['city_name']))
                        <li>Kota Tujuan: {{ $ongkir['destination_details']['city_name'] }}</li>
                    @endif
                </ul>
            </h3>

            @foreach ($ongkir['results'] ?? [] as $item)
                <div class="mb-4">
                    <label for="name">{{ $item['name'] }}</label>

                    @foreach ($item['costs'] as $cost)
                        <div>
                            <label for="service">{{ $cost['service'] }}</label>

                            @foreach ($cost['cost'] as $harga)
                                <div class="mb-2">
                                    <label for="harga" id="hargaLabel{{ $loop->index }}">
                                        Harga: {{ $harga['value'] }} (est: {{ $harga['etd'] }} hari)
                                    </label>

                                    <form method="post" action="{{ route('simpandata') }}">
                                        <input type="hidden" name="kota_asal" value="{{ $ongkir['origin_details']['city_name'] }}">
                                        <input type="hidden" name="kota_tujuan" value="{{ $ongkir['destination_details']['city_name'] }}">
                                        <input type="hidden" name="service" value="{{ $cost['service'] }}">
                                        <input type="hidden" name="hargaongkir" value="{{ $harga['value'] }}">
                                        <input type="hidden" name="estimasi_hari" value="{{ $harga['etd'] }}">
                                        <input type="text" name="alamat" value="">

                                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Pilih Pengiriman</button>
                                        @csrf
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>


</body>




</html>
