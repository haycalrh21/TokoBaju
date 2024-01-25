@extends('page.admin.template.main')

@section('title', 'Dashboard - Lu login ya ?')

@section('contents')

<!-- Donut Chart Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Total Price Overview</h6>
    </div>
    <div class="card-body">
        <canvas id="donutChart" width="150" height="25"></canvas>

    </div>
</div>

<div class="d-flex flex-wrap mb-4">
    <!-- Card 1 -->
    <div class="card shadow mb-4" style="flex-basis: calc(33.333% - 16px); max-width: calc(33.333% - 16px); margin-right: 16px;">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Jumlah Product</h6>
        </div>
        <div class="card-body">
            <p>Jumlah Product: <span id="productCount1">{{ $jumlahProduct }}</span></p>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="card shadow mb-4" style="flex-basis: calc(33.333% - 16px); max-width: calc(33.333% - 16px); margin-right: 16px;">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Jumlah Akun</h6>
        </div>
        <div class="card-body">
            <p>Jumlah Akun: <span id="productCount2">{{ $jumlahAkun }}</span></p>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="card shadow mb-4" style="flex-basis: calc(33.333% - 16px); max-width: calc(33.333% - 16px); margin-right: 16px;">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Jumlah Order</h6>
        </div>
        <div class="card-body">
            <p>Jumlah Order: <span id="productCount3">{{ $jumlahCo }}</span></p>
        </div>
    </div>

    <!-- Card 4 -->
    <div class="card shadow mb-4" style="flex-basis: calc(33.333% - 16px); max-width: calc(33.333% - 16px);">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Jumlah Keranjang</h6>
        </div>
        <div class="card-body">
            <p>Jumlah Keranjang: <span id="productCount4">{{ $jumlahKeranjang }}</span></p>
        </div>
    </div>
</div>






<!-- Table Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Sudah bayar</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Total Harga</th>
                        <th>Tanggal Check Out</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usersWithPayments as $user)
                    @foreach($user->checkOuts as $checkOut)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $checkOut->totalPrice }}</td>
                        <td>{{ $checkOut->created_at }}</td>
                        <td>{{ $checkOut->status }}</td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Fetch the data for the chart
        var totalPriceData = {!! json_encode($totalPriceData) !!}; // Assuming you pass the data from the controller

        // Create a donut chart
        var ctx = document.getElementById('donutChart').getContext('2d');
        var donutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: totalPriceData.labels,
                datasets: [{
                    data: totalPriceData.values,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 205, 86, 0.8)',
                        // Add more colors as needed
                    ],
                }],
            },
        });
    });
</script>



@endsection

