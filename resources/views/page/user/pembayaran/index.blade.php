<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Invoice</title>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .card {
            border: 1px solid #ddd;
            margin-bottom: 20px;
            padding: 10px;
        }

        .total-section {
            margin-top: 20px;
            text-align: right;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
@include('page.user.template.navbar')

<body class="bg-sky-950">

    <div>
        <h1 class="text-center">Riwayat</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama barang</th>
                    <th>Ukuran</th>
                    <th>Jenis Barang</th>
                    <th>Alamat</th>
                    <th>Harga Ongkir</th>
                    <th>Estimasi Hari</th>
                    <th>Jumlah</th>
                    <th>Harga satuan</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($riwayat) && count($riwayat) > 0)
                    @foreach ($riwayat as $item)
                        <tr>
                            <td>{{ $item->namabarang }}</td>
                            <td>{{ $item->size }}</td>
                            <td>{{ $item->jenisbarang }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td>{{ $item->hargaongkir }}</td>
                            <td>{{ $item->estimasi_hari }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->harga }}</td>
                            <td>{{ $item->totalPrice }}</td>
                            <td>{{ $item->status }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="10">Tidak ada riwayat pesanan.</td>
                    </tr>
                @endif
            </tbody>


        </table>

    </div>
    <h2 class="text-center">INVOICE</h2>

    <div class="flex flex-wrap items-center justify-center mt-10 mb-8 gap-4">
        @forelse($groupedCheckoutItems ?? [] as $product => $items)
            @php
                $mergedItem = $items->reduce(
                    function ($carry, $item) {
                        $carry['quantity'] += $item->quantity;
                        $carry['totalPrice'] += $item->totalPrice;
                        return $carry;
                    },
                    ['size' => '', 'quantity' => 0, 'totalPrice' => 0],
                );
            @endphp
            <div class="col-1 col-md-6 col-lg-3 mb-4">

                <div class="card glass">
                    <div>
                        <strong>Product:</strong> {{ $product }}
                    </div>
                    <div>
                        <strong>Size:</strong> {{ implode(', ',$items->pluck('size')->unique()->toArray()) }}
                    </div>
                    <div>
                        <strong>Quantity:</strong> {{ $mergedItem['quantity'] }}
                    </div>
                    <div>
                        <strong>Unit Price:</strong> {{ $items->first()->harga }}
                    </div>
                    <div>
                        <strong>Total Price:</strong> {{ $items->first()->totalPrice }}
                    </div>
                    <div class="text-right">
                        @if ($items->first()->status == 'belum bayar')
                            <button class="btn btn-success pay-button"
                                data-snap-token="{{ $items->first()->snap_token }}">Bayar</button>
                        @else
                            <span class="paid-label">Sudah Dibayar</span>
                        @endif
                    </div>
                </div>
            </div>

        @empty
            <p>Tidak ada pembayaran</p>
        @endforelse
    </div>



</body>

<footer class="footer footer-center p-4 bg-base-300 text-base-content">
    <aside>
        <p>Copyright © 2023 - All right reserved by Toko Baju XYZ </p>
    </aside>
</footer>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.pay-button').click(function() {
            var snapToken = $(this).data('snap-token');
            snap.pay(snapToken, {
                onSuccess: function(result) {
                    alert('Payment successful!');
                    updatePaymentStatus(result.order_id);
                    window.location.reload(true);
                },
                onPending: function(result) {
                    alert(
                        'Payment is pending. You will be notified once the payment is processed.');
                },
                onError: function(result) {
                    alert('Payment failed. Please try again.');
                }
            });
        });
    });

    function updatePaymentStatus(orderId) {
        $.ajax({
            url: '/updatestatus',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                orderId: orderId,
            },
            success: function(response) {
                console.log(response);
            },
            error: function(error) {
                console.error(error);
            }
        });
    }
</script>



</html>
