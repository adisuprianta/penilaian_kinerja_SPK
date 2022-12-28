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
        <a class="nav-link" href="{{route('dashboard')}}">
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
        <a class="nav-link" href="{{route('perusahaan.index')}}">
        <i class="fa fa-building"></i>
            <span><b>Perusahaan Partner</b></span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('user.index')}}">
        <i class="fa fa-users"></i>
            <span><b>Data User</b></span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('kriteria.index')}}">
        <i class="fa fa-book"></i>
            <span><b>Data Kriteria</b></span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('karyawan.index')}}">
        <i class="fa fa-users"></i>
            <span><b>Data Karyawan</b></span>
        </a>
    </li>
    
    <!-- Divider -->
    <hr class="sidebar-divider">
    @endif

    
    <!-- Heading -->
    <div class="sidebar-heading">
    Karyawan
    </div>
    @if (Auth::user()->hasRole('manajer') )
    <li class="nav-item">
        <a class="nav-link" href="{{route('kontrak.index')}}">
            <i class="fa fa-file-signature"></i>
            <span><b>Kontrak Karyawan</b></span>
        </a>
    </li>
    @endif
    <!-- <li class="nav-item">
        <a class="nav-link" href="">
        <i class="fa fa-pen"></i>
            <span><b>Riwayat Kerja</b></span>
        </a>
    </li> -->
    @if (Auth::user()->hasRole('user') or Auth::user()->hasRole('team_leader') )
    <li class="nav-item">
        <a class="nav-link" href="{{route('penilaian.index')}}">
            <i class="fa fa-file-signature"></i>
            <span><b>Kinerja Karyawan</b></span>
        </a>
    </li>
<!--     
    <li class="nav-item">
        <a class="nav-link" href="">
            <i class="fa fa-file-signature"></i>
            <span><b>Pekerjaan Karyawan</b></span>
        </a>
    </li> -->
    @endif
    @if (Auth::user()->hasRole('manajer') )
    <li class="nav-item">
        <a class="nav-link" href="{{route('penilaian_manajer.index')}}">
            <i class="fa fa-file-signature"></i>
            <span><b>Kinerja Team Leader</b></span>
        </a>
    </li>
     <li class="nav-item">
        <a class="nav-link" href="{{route('laporan.index')}}">
        <i class="fa-solid fa-ranking-star"></i>
        <i class="fa fa-file"></i>
            <span><b>Laporan Karyawan</b></span>
        </a>
    </li>
    @endif
   

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
