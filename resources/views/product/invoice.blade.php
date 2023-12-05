    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Invoice Page</title>
        <!-- Sertakan file CSS Bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    @include('template.navbar')
    @include('template.loading')
    <body>
        <!-- Isi dari halaman -->

        @yield('content')

        <h1 >
            <center> <strong>Riwayat Pemebelian</strong></center>
            </h1>
            <br>
        <div id="accordion">
            @foreach($keranjangItems as $keranjang)
            <div class="card mb-3">
                <div class="card-header" id="heading{{ $keranjang->id }}">
                    <h2 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{ $keranjang->id }}" aria-expanded="true" aria-controls="collapse{{ $keranjang->id }}">
                            Invoice {{ \Carbon\Carbon::parse($keranjang->created_at)->format('Ymd') }}/MPL/{{ $keranjang->id }}
                        </button>
                    </h2>
                </div>

                <div id="collapse{{ $keranjang->id }}" class="collapse" aria-labelledby="heading{{ $keranjang->id }}" data-parent="#accordion">
                    <div class="card-body">
                        {{-- Konten Invoice --}}
                        <p><strong>No. Invoice:</strong> INV/{{ \Carbon\Carbon::parse($keranjang->created_at)->format('Ymd') }}/MPL/{{ $keranjang->id }}</p>
                        <p><strong>Tanggal Pembelian:</strong> {{ \Carbon\Carbon::parse($keranjang->created_at)->format('d F Y, H:i T') }}</p>

                        <h3 style="margin-top: 20px;">Detail Barang</h3>
                        <ul style="list-style-type: none; padding: 0; margin: 0;">
                            {{-- Detail barang lainnya --}}
                            <li><strong>Barang:</strong> {{ $keranjang->namabarang }}</li>
                            <li><strong>Brand:</strong> {{ $keranjang->brand }}</li>
                            <li><strong>Ukuran:</strong> {{ $keranjang->ukuran ?? 'N/A' }}</li>
                            <li><strong>Jumlah Barang:</strong> {{ $keranjang->jumlahbarang }}</li>
                            <li><strong>Harga Satuan:</strong> Rp. {{ $keranjang->harga }}</li>
                        </ul>

                        <p style="margin-top: 20px;"><strong>Total Belanja:</strong> Rp{{ number_format($keranjang->total_harga, 0, ',', '.') }}</p>

                        @if($keranjang->status_pembayaran == 'success')
                            <p style="color: green;"><strong>Status Pembayaran:</strong> Pembayaran telah berhasil.</p>
                        @elseif($keranjang->status_pembayaran == 'pending')
                            <p style="color: red;"><strong>Status Pembayaran:</strong> Segera selesaikan pembayaran. Anda memiliki waktu 24 jam.</p>
                            <p id="time_left{{ $keranjang->id }}"><strong>Waktu tersisa:</strong> <span></span></p>
                            <p>Silakan transfer ke rekening xxx-xxx-xxxx atas nama [Nama Pemilik Rekening]</p>
                        @endif

                        @if($keranjang->status_pembayaran == 'pending')
                        <button onclick="checkPaymentStatus('{{ $keranjang->id }}')" class="btn btn-primary" style="margin-top: 20px;">Cek Status Pembayaran</button>
                        <p id="payment_status{{ $keranjang->id }}"></p>
                    @endif
                    </div>
                    <div>
                        <button type="submit" id="pay-button">cek pembayaran</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    <!-- Script untuk menghitung waktu tersisa -->
    

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function(){
            // SnapToken acquired from the controller
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    // You may add your own js here, this is just an example
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                onPending: function(result){
                    // You may add your own js here, this is just an example
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                onError: function(result){
                    // You may add your own js here, this is just an example
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                }
            });
        };
    


        // Tanggal dan waktu sekarang
        const now = new Date().getTime();

        @foreach($keranjangItems as $keranjang)
            // Cek apakah batas waktu tersimpan di local storage
            const storedDeadline{{ $keranjang->id }} = localStorage.getItem('deadline{{ $keranjang->id }}');

            if (storedDeadline{{ $keranjang->id }}) {
                const storedTimeLeft{{ $keranjang->id }} = parseInt(storedDeadline{{ $keranjang->id }}) - now;

                if (storedTimeLeft{{ $keranjang->id }} > 0) {
                    startTimer(storedTimeLeft{{ $keranjang->id }}, 'time_left{{ $keranjang->id }}');
                } else {
                    document.getElementById("time_left{{ $keranjang->id }}").innerHTML = "Waktu pembayaran telah habis";

                    // Tambahkan logika di sini jika waktu pembayaran telah habis, misalnya, menandai pembayaran sebagai gagal
                    updateStatusPembayaran('{{ $keranjang->id }}', 'failed');
                }
            } else {
                startTimer(24 * 60 * 60 * 1000, 'time_left{{ $keranjang->id }}'); // Dimulai dengan 24 jam
            }
        @endforeach

        function startTimer(timeLeft, elementId) {
            const x = setInterval(function() {
                const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                document.getElementById(elementId).innerHTML = `<strong>Waktu tersisa:</strong> ${minutes} menit ${seconds} detik`;

                timeLeft -= 1000;

                if (timeLeft < 0) {
                    clearInterval(x);
                    document.getElementById(elementId).innerHTML = "Waktu pembayaran telah habis";

                    // Tambahkan logika di sini jika waktu pembayaran telah habis, misalnya, menandai pembayaran sebagai gagal
                    updateStatusPembayaran('{{ $keranjang->id }}', 'failed');
                }

                // Simpan batas waktu ke local storage
                localStorage.setItem('deadline{{ $keranjang->id }}', (now + timeLeft).toString());
            }, 1000);
        }

        // Tambahkan fungsi untuk mengirim permintaan AJAX dan memperbarui status pembayaran
        function updateStatusPembayaran(orderId, status) {
            // Anda perlu menggantinya dengan endpoint atau URL yang sesuai di aplikasi Anda
            const apiUrl = '/admin/order/check-payment-status/';

            // Kirim permintaan AJAX
            fetch(apiUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    order_id: orderId,
                    status: status,
                }),
            })
            .then(response => response.json())
            .then(data => {
                // Tambahkan logika di sini jika Anda perlu menangani respons dari server
                console.log(data);
            })
            .catch(error => {
                // Tambahkan logika di sini jika terjadi kesalahan
                console.error('Error:', error);
            });
        }

        // Fungsi untuk memeriksa status pembayaran
        function checkPaymentStatus(orderId) {
        // Gantilah dengan endpoint atau URL yang sesuai di aplikasi Anda
        const apiUrl = '/admin/order/check-payment-status/' + orderId;

        // Kirim permintaan AJAX
        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                // Perbarui teks status pembayaran
                const statusElement = document.getElementById('payment_status{{ $keranjang->id }}');
                statusElement.innerHTML = '<strong>Status Pembayaran:</strong> ' + data.status;

                // Tambahkan logika untuk notifikasi jika belum terverifikasi
                if (data.status !== 'verified') {
                    // Tampilkan notifikasi (Windows Alert)
                    window.alert('Pembayaran belum terverifikasi. Harap tunggu.');
                }

                // Tambahkan logika lain di sini jika perlu
            })
            .catch(error => {
                // Tambahkan logika di sini jika terjadi kesalahan
                console.error('Error:', error);
            });
    }

    // Perbarui status pembayaran setiap 5 detik
    setInterval(function() {
        @if($keranjang->status_pembayaran == 'pending')
            checkPaymentStatus('{{ $keranjang->id }}');
        @endif
    }, 5000); // 5 detik
    </script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>

    </html>
