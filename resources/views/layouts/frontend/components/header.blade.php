<header id="header">

    <!-- Navbar -->
    <nav data-aos="zoom-out" data-aos-delay="700" class="navbar navbar-expand bg-overlay">
        
        <div class="container header">

            <!-- Navbar Brand-->
            <a class="navbar-brand" href="{{ url('') }}">
                <img class="navbar-brand-regular" src="{{ url('assets/apps/img/logo-transparent.png') }}" alt="brand-logo" style="height: 90px; border-radius: 10%;">
                <img class="navbar-brand-sticky" src="{{ url('assets/apps/img/logo.png') }}" alt="sticky brand-logo" style="height: 90px; border-radius: 10%;">
            </a>

            <div class="ml-auto"></div>

            <!-- Navbar -->
            <ul class="navbar-nav items">
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ url('kenapa-packer') }}">Kenapa Packer</a>
                    <div class="dropdown-divider"></div>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ url('cara-kerja') }}">Cara Kerja</a>
                    <div class="dropdown-divider"></div>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ url('layanan') }}">Layanan</a>
                    <div class="dropdown-divider"></div>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ url('price-list') }}">Price List</a>
                    <div class="dropdown-divider"></div>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ url('mitra-gudang') }}">Mitra Gudang</a>
                    <div class="dropdown-divider"></div>
                </li>
            </ul>

            <!-- Navbar Toggler -->
            <ul class="navbar-nav toggle">
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark" data-toggle="modal" data-target="#menu">
                        <i class="fas fa-bars toggle-icon m-0"></i>
                    </a>
                </li>
            </ul>

            <!-- Navbar Action Button -->
            <ul class="navbar-nav action">
                <li class="nav-item ml-3">
                    <a href="{{ Session::has('id') ? url('admin/main/dashboard') : url('login') }}" class="btn ml-lg-auto btn-bordered-white text-dark" style="border: 2px solid #343a40 !important;"><i class="fas fa-sign-in-alt contact-icon mr-md-2"></i>{{ Session::has('id') ? 'Dashboard' : 'Login' }}</a>
                </li>
            </ul>

        </div>

    </nav>

</header>