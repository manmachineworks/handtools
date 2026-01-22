<!-- Navbar Start -->
<nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0 shadow-sm">
    <!-- Brand (Mobile) -->
    <a href="{{ url('/') }}" class="navbar-brand d-flex d-lg-none me-4 align-items-center">
        <img src="/assets/new_assets/images/svg/logo.png" alt="Gurunanak Hand Tools" style="height:32px; width:auto;"
            onerror="this.style.display='none'">
        <span class="ms-2 fw-semibold text-black">Admin</span>
    </a>

    <!-- Sidebar Toggle -->
    <button class="sidebar-toggler flex-shrink-0 btn btn-link  p-0" type="button" aria-label="Toggle sidebar">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Brand (Desktop) -->
    <a href="{{ url('/') }}" class="navbar-brand d-none d-lg-flex align-items-center ms-3">
        <!--<img src="/assets/new_assets/images/svg/logo.png"-->
        <!--     alt="Gurunanak Hand Tools"-->
        <!--     style="height:34px; width:auto;"-->
        <!--     onerror="this.style.display='none'">-->
        <span class="ms-2 fw-semibold text-black">Gurunanak Hand Tools</span>
    </a>



    <div class="navbar-nav align-items-center ms-auto">
        <!-- User Dropdown -->
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown"
                aria-expanded="false">
                <img class="rounded-circle me-2" src="{{ auth()->user()->avatar ?? '/assets/admin/img/user.jpg' }}"
                    alt="Admin Profile" style="width:40px;height:40px;object-fit:cover;">
                <span class="d-none d-lg-inline-flex text-black">
                    {{ auth()->user()->name ?? 'Admin' }}
                </span>
            </a>

            <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">


                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="fa fa-sign-out-alt me-2 text-black"></i> Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>