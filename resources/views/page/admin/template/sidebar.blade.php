<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-briefcase"></i>
        {{-- <i class="fa-solid fa-briefcase"></i> --}}
      </div>
      <div class="sidebar-brand-text mx-3">Dashboard Toko XYZ </div>
    </a>

    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link" href="{{ route('admindashboard') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
    <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>



    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('productadmin') }}" data-toggle="collapse" data-target="#collapseTwo"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-solid fa-clipboard-list"></i>

        <span>Product</span>
      </a>
      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white  collapse-inner rounded">
            <h6 class="collapse-header">Custom Components:</h6>
            <a class="collapse-item" href="{{ route('productadmin') }}">Tambah Product</a>
            <a class="collapse-item" href="cards.html">Cards</a>
        </div>
    </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.message.index', ['userId' => auth()->user()->id]) }}">

          <i class="fas fa-solid fa-envelope"></i>

          <span>Pesan</span></a>
      </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('tampilorder') }}">
          <i class="fas fa-solid fa-receipt"></i>

          <span>Order</span></a>
      </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


  </ul>
