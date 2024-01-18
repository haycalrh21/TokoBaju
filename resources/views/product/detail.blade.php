<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail baju</title>
</head>
@include('template.navbar')

<body>
    <!-- resources/views/product/detail.blade.php -->

<div class="text-center">
    <img class="product-image mx-auto" src="{{ asset('storage/' . $product->image) }}" alt="Product Image">
    <h1>{{ $product->namabarang }} Details</h1>

    <p>{{ $product->brand }}</p>
    <p>Stock: {{ $product->stok }}</p>
    <p>Price: {{ $product->harga }}</p>

    <!-- Form for adding to the cart (assuming you have a route for it) -->
    <form action="{{ route('carts.addToCart', ['productId' => $product->id]) }}" method="post">
        @csrf

        <label for="quantity"></label>
        <input type="number" name="quantity[{{ $product->id }}]" id="quantity" value="1" min="1" required>
        @error('quantity.' . $product->id)
            <span class="text-danger">{{ $message }}</span>
        @enderror

        <div class="mt-3">
            <label>Select Size:</label><br>
            <div class="form-check form-check-inline">
                @foreach ($product->productSizes as $size)
                    <input type="radio" name="ukuran[{{ $product->id }}]" id="{{ $size->size }}" value="{{ $size->size }}" class="form-check-input" required>
                    <label for="{{ $size->size }}" class="form-check-label">{{ $size->size }}</label>
                @endforeach
            </div>
            @error('ukuran.' . $product->id)
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-3">Add to Cart</button>
    </form>
</div>






</body>

@include('template.footer')
</html>
