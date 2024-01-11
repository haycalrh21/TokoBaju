
<style>
    .logo-img {
        max-width: 100px; /* Sesuaikan dengan lebar maksimum yang Anda inginkan */
        max-height: 100px; /* Sesuaikan dengan tinggi maksimum yang Anda inginkan */
    }
</style>
@include('template.loading')
<div class="navbar bg-base-100">
    <div class="navbar-start">
      <div class="dropdown">
        <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /></svg>
        </div>
        <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
          <li><a class="btn btn-ghost normal-case text-xl" href="{{ route('indexproduct') }}">Product</a></li>

          <li> <a class="btn btn-ghost normal-case text-xl" href="{{ route('carts.index') }}">Keranjang</a></li>
          <li> <a class="btn btn-ghost normal-case text-xl" href="{{ route('invoice') }}">riwayat</a></li>
          <li>

              @auth
              <summary class="btn btn-ghost normal-case text-md">Hai!  {{ Auth::user()->name }}</summary>
              @endauth
              <ul class="p-2">
                @guest
                @if (request()->routeIs('login'))
                <li> <a class="nav-link" href="{{ route('register') }}">Register</a></li>
                @else
                <li> <a class="nav-link" href="{{ route('login') }}">Login</a></li>
                @endif
                @endguest
                @auth
                <li> <a href="{{ route('selesai') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  Logout
              </a></li>
              <li><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>

                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                  @csrf
              </form>
              @endauth
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
        <li> <a class="btn btn-ghost normal-case text-xl" href="{{ route('invoice') }}">riwayat</a></li>
        <li>
          <details class="normal-case text-xl mt-2">

            @auth
            <summary class="btn btn-ghost normal-case text-xl">Hai!  {{ Auth::user()->name }}</summary>
            @endauth
            <ul class="p-2">
              @guest
              @if (request()->routeIs('login'))
              <li> <a class="nav-link" href="{{ route('register') }}">Register</a></li>
              @else
              <li> <a class="nav-link" href="{{ route('login') }}">Login</a></li>
              @endif
              @endguest
              @auth
              <li> <a href="{{ route('selesai') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a></li>
            <li><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>

              <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                @csrf
            </form>
            @endauth
            </ul>
          </details>
        </li>
      </ul>
    </div>
    <div class="navbar-end">
        <a href="{{ route('index') }}" class="logo-link">
            <img src="{{ asset('/logo.jpg') }}" alt="Logo"  class="logo-img"/>
        </a>
    </div>
  </div>
