<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/navbar/index.css') }}"> --}}

    {{-- <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.0/dist/full.min.css" rel="stylesheet" type="text/css" /> --}}



</head>

<style>
    /* Atur gaya untuk logo */
.logo-img {
    max-width: 100px; /* Sesuaikan dengan lebar maksimum yang Anda inginkan */
    max-height: 100px; /* Sesuaikan dengan tinggi maksimum yang Anda inginkan */
}


</style>
@include('template.loading')
<nav>
    <div class="navbar bg-base-300">
        <div class="navbar-start">
          <div class="dropdown">
            <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /></svg>
            </div>
            <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2  neutral-content rounded-box w-52">
              <li><a class="btn btn-neutral-content normal-case text-xl" href="{{ route('indexproduct') }}">Product</a></li>

              <li> <a class="btn btn-neutral-content normal-case text-xl" href="{{ route('carts.index') }}">Keranjang</a></li>
              <li> <a class="btn btn-neutral-content normal-case text-xl" href="{{ route('invoice') }}">Riwayat</a></li>'
              @guest
              <li> <a class="btn btn-neutral-content normal-case text-xl href="{{ route('register') }}">Register</a></li>
              <li> <a class="btn btn-neutral-content normal-case text-xl" href="{{ route('login') }}">Login</a></li>
          @endguest
              <li>

                  @auth
                  <summary class="btn btn-neutral-content normal-case text-md">Hai!  {{ Auth::user()->name }}</summary>
                  @endauth
                  <ul class="p-2">
                    <li><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>




                  </ul>

              </li>
            </ul>
          </div>
          <a class="btn btn-ghost normal-case text-xl" href="{{ route('index') }}">Home</a>
        </div>
        <div class="navbar-center hidden lg:flex">
          <ul class="menu menu-horizontal px-1">
            <li><a class="btn btn-ghost normal-case text-xl" href="{{ route('indexproduct') }}">Product</a></li>

            <li> <a class="btn btn-ghost normal-case text-xl" href="{{ route('carts.index') }}">Keranjang</a></li>
            <li> <a class="btn btn-ghost normal-case text-xl" href="{{ route('invoice') }}">Riwayat</a></li>
            @guest
            <li> <a class="btn btn-ghost normal-case text-xl" href="{{ route('register') }}">Register</a></li>
            <li> <a class="btn btn-ghost normal-case text-xl" href="{{ route('login') }}">Login</a></li>
        @endguest
            <li>
                @auth
                {{-- <ul class="p-2"> --}}

                <li><a class="btn btn-ghost normal-case text-xl" href="{{ route('dashboard') }}">Dashboard</a></li>
            {{-- </ul> --}}
            <summary class="btn btn-ghost normal-case text-xl">Hai!  {{ Auth::user()->name }} </summary>

                @endauth


            </li>
          </ul>
        </div>

        <div class="navbar-end">
            @auth
            <a href="{{ route('selesai') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-ghost normal-case text-xl">
                Logout
            </a>
            <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                @csrf
            </form>
            @endauth
            <a href="{{ route('index') }}" class="logo-link">
                <img src="{{ asset('/logo.jpg') }}" alt="Logo"  class="logo-img"/>
            </a>
        </div>

      </div>
</nav>
<body>


</body>
</html>

