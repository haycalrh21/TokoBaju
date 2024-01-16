<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Invoice</title>
    <style>
        /* Add your custom styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
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
    </style>
</head>

<body>
    @include('template.navbar')
    <h2>Invoice</h2>

    @forelse($groupedCheckoutItems ?? [] as $product => $items)
        @php
            $mergedItem = $items->reduce(function ($carry, $item) {
                $carry['quantity'] += $item->quantity;
                $carry['totalPrice'] += $item->totalPrice;
                return $carry;
            }, ['size' => '', 'quantity' => 0, 'totalPrice' => 0]);
        @endphp

        <div class="card">
            <div>
                <strong>Product:</strong> {{ $product }}
            </div>
            <div>
                <strong>Size:</strong> {{ implode(', ', $items->pluck('size')->unique()->toArray()) }}
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
                @if($items->first()->status == 'belum bayar')
                    <button class="btn btn-success pay-button" data-snap-token="{{ $items->first()->snap_token }}">Bayar</button>
                @else
                    <span class="paid-label">Sudah Dibayar</span>
                @endif
            </div>
        </div>
    @empty
        <p>Tidak ada pembayaran</p>
    @endforelse

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('.pay-button').click(function () {
                var snapToken = $(this).data('snap-token');
                snap.pay(snapToken, {
                    onSuccess: function (result) {
                        alert('Payment successful!');
                        updatePaymentStatus(result.order_id);
                        window.location.reload(true);
                    },
                    onPending: function (result) {
                        alert('Payment is pending. You will be notified once the payment is processed.');
                    },
                    onError: function (result) {
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

</body>

</html>
