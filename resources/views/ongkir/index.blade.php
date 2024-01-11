<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

@include('template.navbar')
<body>
    <div id="iniformcekongkir">
        <form method="post" action="{{ route('cekongkoskirim1') }}" id="formCekOngkir">
            <div>
                <!-- Input state -->
                <label for="origin">Kota Pengiriman</label>
                <select name="origin" id="origin">
                    <option>kota Pengiriman</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city['city_id'] }}">{{ $city['city_name'] }}</option>
                    @endforeach
                </select>

                <label for="destination">Kota Tujuan</label>
                <select name="destination" id="destination">
                    <option>kota tujuan</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city['city_id'] }}">{{ $city['city_name'] }}</option>
                    @endforeach
                </select>

                <label for="weight">Berat paket </label>
                <input type="number" id="weight" name="weight" placeholder="Tolong isi 1000/2000 Gram" class="w-full border rounded-md px-3 py-2" >/ 1000 Gram
            </div>

            <div>
                <label for="courier" class="block mb-2">Pilih Pengiriman</label>
                <select name="courier" id="courier">
                    <option>Pilih Kurir</option>
                    <option value="jne">JNE</option>
                    <option value="pos">POS</option>
                    <option value="tiki">TIKI</option>
                </select>

            </div>
            <button type="submit" class="w-full rounded-md bg-orange-900 px-6 py-3 font-medium text-white" ">Cek Ongkir</button>
@csrf

        </form>
    </div>



    <div id="rincianOngkirSection">
        @if ($ongkir != '')
            <h1 id="rincianOngkirTitle">Rincian Ongkir</h1>

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
                                <label for="harga" id="hargaLabel{{ $loop->index }}">
                                    Harga: {{ $harga['value'] }} (est : {{ $harga['etd'] }} hari)
                                </label>
                                <form method="post" action="{{ route('simpandata') }}" class="mb-4">

                                        <input type="text" name="kota_asal" value="{{ $ongkir['origin_details']['city_name'] }}">
                                        <input type="text" name="kota_tujuan" value="{{ $ongkir['destination_details']['city_name'] }}">
                                        <input type="text" name="service" value="{{ $cost['service'] }}">
                                        <input type="text" name="harga" value="{{ $harga['value'] }}">
                                        <input type="hidden" name="estimasi_hari" value="{{ $harga['etd'] }}">

                                        <button type="submit">pilih pengiriman</button>
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
