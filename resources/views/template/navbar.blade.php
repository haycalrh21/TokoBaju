    <head>
        <meta charset="UTF-8">
        <title>Dark Mode Toggle</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <style>


        .user-name {
            /* Atur properti CSS untuk penataan */
            /* Contoh: */
            display: inline-block;
            vertical-align: middle;
        }


        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-link {
            /* Atur jarak antara logo dengan elemen lainnya */
            margin: 0;
            margin-right: 90%; /* Atur jarak antara logo dengan elemen lainnya */
        }

        .logo-img {
            max-width: 100%; /* Sesuaikan ukuran sesuai kebutuhan Anda */
            max-height: 75px; /* Sesuaikan ukuran sesuai kebutuhan Anda */
        }

        .navbar-menu {
            display: none;
            position: absolute;
            top: 60px; /* Sesuaikan dengan kebutuhan Anda */
            right: 0;
            background-color: #f9f9f9;
            padding: 20px;
            z-index: 10;
        }

        @media (max-width: 768px) {
            .navbar-menu {
                display: none;
            }

            .navbar-menu.active {
                display: flex;
            }

            .logo-link {
                display: block;
            }

            .navbar {
                flex-direction: column;
                align-items: stretch;
            }

            .navbar > div {
                margin-bottom: 10px;
            }
        }
</style>



        @include('template.loading')
        <div class="navbar bg-neutral  text-base-100">
        <div class="flex-1">
            @if (Auth::check())

            @else

            @endif
            <a class="btn btn-ghost normal-case text-xl" href="{{ route('index') }}">Home</a>

            <a class="btn btn-ghost normal-case text-xl" href="{{ route('indexproduct') }}">Product</a>
            <a class="btn btn-ghost normal-case text-xl" href="{{ route('carts.index') }}">Keranjang</a>
            <a class="btn btn-ghost normal-case text-xl" href="{{ route('selesai') }}">riwayat</a>
        </div>
        <div class="flex-1 flex items-center justify-center">
            <a href="{{ route('index') }}" class="logo-link">
                <img src="{{ asset('/logo.jpg') }}" alt="Logo" class="logo-img"/>
            </a>
        </div>

        <div class="flex-none">
            <div class="dropdown dropdown-end">

                <label tabindex="0" class="btn btn-ghost btn-circle" onclick="toggleDropdown()">
                    <!-- Tombol yang membuka dropdown -->
                    <div class="indicator">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        @if ($keranjang !== null && count($keranjang) > 0)
                        <span class="badge badge-sm indicator-item">{{ count($keranjang) }}</span>
                    @endif
                    </div>
                </label>
                <div id="dropdownContent" tabindex="0" style="display: none;" class="mt-3 z-[1] card card-compact dropdown-content w-52 bg-base-100 text-error">
                    <!-- Isi dropdown -->
                    <!-- ... kode sebelumnya ... -->

                    <div class="card-body ">
                        <div class="mt-4 space-y-6 ">
                            @if($keranjang)
                            @foreach($keranjang as $product)<center>
                                <img name="gambar" class="h-28 w-28 mr-1 rounded-md border" src="{{ asset('storage/' . $product['image']) }}" alt="" />
                                <h1 class="h6">Nama barang :{{ $product['namabarang'] }}</h1>
                                <h1 class="h6">Brang:{{ $product['brand'] }}</h1>
                                {{-- <p class="card-text" style="max-height: 3em; overflow: hidden; font-size: 14px;">Brand: {{ $ $product['jumlahbarang'] }}</p> --}}
                                {{-- <p class="card-text" style="font-size: 14px;">Harga: Rp{{ $product['harga'] }}</p> --}}
                            </center>
                            @endforeach
                        @endif
                        </div>
                    </div>
                    <!-- ... kode setelahnya ... -->
                </div>
            </div>
        </div>



            <div class="dropdown dropdown-end  text-base-100">
                <label tabindex="1" class="btn  btn-circle avatar" style="background: none; border: none;">
                    <div class="w-10 rounded-full">
                        @if (Auth::check() && Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" />
                        @else
                            {{-- Tampilkan gambar default jika avatar tidak ada --}}
                            <img src="{{ asset('img/avatar.jpg') }}" alt="Default Avatar" />
                        @endif

                </label>
                <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-neutral rounded-box w-52">
                    @auth
                    <li class="nav-item user-name">Hai!  {{ Auth::user()->name }}</li>
                    @endauth
                    @guest
                        @if (request()->routeIs('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>

                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                        @endif
                    @endguest

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    @auth


                        <li class="nav-item">
                            <a href="{{ route('selesai') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                        </li>
                        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                            @csrf
                        </form>
                    @endauth
                </ul>



            </div>
            </div>
        </div>

        <script>

        </script>






    </body>
