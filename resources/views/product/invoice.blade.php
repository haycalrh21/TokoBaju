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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
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

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Size</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($groupedCheckoutItems ?? [] as $product => $items)
                @php
                    $mergedItem = $items->reduce(function ($carry, $item) {
                        $carry['quantity'] += $item->quantity;
                        $carry['totalPrice'] += $item->totalPrice;
                        return $carry;
                    }, ['size' => '', 'quantity' => 0, 'totalPrice' => 0]);
                @endphp
                <tr>
                    <td>{{ $product }}</td>
                    <td>{{ implode(', ', $items->pluck('size')->unique()->toArray()) }}</td>
                    <td>{{ $mergedItem['quantity'] }}</td>
                    <td>{{ $items->first()->harga }}</td>
                    <td>
                        {{ $items->first()->totalPrice }}
                    </td>
                    <td>
                        @if($items->first()->status == 'belum bayar')
                            <button class="btn btn-success pay-button" data-snap-token="{{ $items->first()->snap_token }}">Bayar</button>
                        @else
                            <span class="paid-label">Sudah Dibayar</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Tidak ada pembayaran</td>
                </tr>
            @endforelse
        </tbody>
    </table>










    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

    <script type="text/javascript">


        $(document).ready(function () {
        $('.pay-button').click(function () {
            var snapToken = $(this).data('snap-token');
            snap.pay(snapToken, {
                // ... other options
                onSuccess: function (result) {
                    // Handle successful payment
                    // You may add your own logic here
                    alert('Payment successful!');
                    // Add AJAX request to update payment status on the server
                    updatePaymentStatus(result.order_id); // Pass the order ID or any other identifier
                },
                onPending: function (result) {
                    // Handle pending payment
                    // You may add your own logic here
                    alert('Payment is pending. You will be notified once the payment is processed.');
                },
                onError: function (result) {
                    // Handle payment error
                    // You may add your own logic here
                    alert('Payment failed. Please try again.');
                }
            });
        });
    });

// Function to send AJAX request to update payment status
function updatePaymentStatus(orderId) {
    $.ajax({
        url: '/updatestatus', // Adjust the URL to your Laravel route
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            orderId: orderId, // Pass the order ID or any other identifier
        },
        success: function(response) {
            console.log(response); // Log the server response
        },
        error: function(error) {
            console.error(error); // Log any errors
        }
    });
}

    </script>

</body>
</html>
