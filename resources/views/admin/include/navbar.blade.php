<!-- Navbar Start -->
<nav class="navbar navbar-expand bg-transparent navbar-dark sticky-top top-bar px-4 py-2 d-flex align-items-center shadow-sm">
    <button class="sidebar-toggler btn btn-link text-white p-0 me-3" type="button" aria-label="Toggle sidebar">
        <i class="fas fa-bars fa-lg"></i>
    </button>

    <div class="d-flex align-items-center gap-2 brand-pill">
        <span class="text-uppercase fw-bold brand-tag">GHT</span>
        <div class="flex-column">
            <span class="fs-6 fw-semibold mb-0 text-white">Gurunanak Hand Tools</span>
            <small class="text-muted">Admin Portal</small>
        </div>
    </div>

    <div class="ms-auto d-flex align-items-center gap-3">
        <div class="d-none d-sm-inline text-white-50 small">Welcome back, {{ auth()->user()->name ?? 'Admin' }}</div>
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle d-flex align-items-center gap-2 text-white py-1" data-bs-toggle="dropdown"
                aria-expanded="false">
                <span class="avatar rounded-circle">
                    <img src="{{ auth()->user()->avatar ?? '/assets/admin/img/user.jpg' }}" alt="Admin profile"
                        onerror="this.src='/assets/admin/img/user.jpg'">
                </span>
                <span class="d-none d-md-inline">{{ auth()->user()->name ?? 'Admin' }}</span>
            </a>

            <div class="dropdown-menu dropdown-menu-end rounded-3 shadow-lg border-0 p-2 bg-black">
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="dropdown-item rounded-2 text-white">
                        <i class="fas fa-sign-out-alt me-2 text-orange"></i>Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

@include('admin.include.alerts')
<!-- Navbar End -->
