<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail {{ $products->namabarang }}</title>
</head>
@extends('page.admin.template.main')

@section('contents')
<body>
<p>{{ $products->namabarang }}</p>
<p>{{ $products->jenisbarang }}</p>
<p>{{ $products->brand }}</p>
<p>{{ $products->stok }}</p>
<p>{{ $products->harga }}</p>
<img src="{{ asset('storage/' . $products->image) }}" alt="">
</body>
</html>
@endsection
