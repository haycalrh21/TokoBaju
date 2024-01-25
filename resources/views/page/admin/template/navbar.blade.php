<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>



    <ul class="navbar-nav ml-auto">






        <li class="nav-item dropdown no-arrow mx-1">
            <!-- ... (kode dropdown untuk Alerts) ... -->
        </li>

        <li class="nav-item dropdown no-arrow mx-1">
            <!-- ... (kode dropdown untuk Messages) ... -->
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{ auth()->user()->name }}
                    <br>
                    <small>{{ auth()->user()->level }}</small>
                </span>
                <img class="img-profile rounded-circle" src="https://startbootstrap.github.io/startbootstrap-sb-admin-2/img/undraw_profile.svg">
            </a>


            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">


                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item" >
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                    <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                        @csrf
                    </form>
                </a>

            </div>
        </li>
    </ul>
</nav>
<script>
    $(document).ready(function () {
        // Ketika elemen dengan class 'nav-link' di klik
        $('.nav-link').on('click', function () {
            // Sembunyikan badge dengan class 'badge-counter'
            $('.badge-counter').hide();
        });
    });
    </script>
