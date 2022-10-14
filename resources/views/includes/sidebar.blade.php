<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon">
            {{-- <i class="fas fa-book"></i> --}}
            <i class="fas fa-balance-scale"></i>
        </div>
        <div class="sidebar-brand-text mx-3"></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span><b>Dashboard</b></span>
        </a>
    </li>

    <!-- Divider -->
    @if (Auth::user()->hasRole('manajer') )
    <hr class="sidebar-divider">

  
    <!-- Heading -->
    <div class="sidebar-heading">
        Data
    </div>

    
    <li class="nav-item">
        <a class="nav-link" href="">
            <i class="fas fa-minus"></i>
            <span><b>Data User</b></span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('kriteria.index')}}">
            <i class="fas fa-minus"></i>
            <span><b>Data Kriteria</b></span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('karyawan.index')}}">
            <i class="fas fa-minus"></i>
            <span><b>Data Karyawan</b></span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="">
            <i class="fas fa-minus"></i>
            <span><b>Kontrak Kerja</b></span>
        </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    @endif

    
    <!-- Heading -->
    <div class="sidebar-heading">
    Karyawan
    </div>
    <li class="nav-item">
        <a class="nav-link" href="">
            <i class="fas fa-plus"></i>
            <span><b>Riwayat Kerja</b></span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="">
            <i class="fas fa-minus"></i>
            <span><b>Kinerja Karyawan</b></span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="">
            <i class="fas fa-minus"></i>
            <span><b>Rangking Karyawan</b></span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
