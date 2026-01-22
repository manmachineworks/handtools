<head>
    <meta charset="utf-8">
    <title>Gurunanak Hand Tool Admin Panel</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link href="{{ asset('assets/favicon.ico') }}" rel="icon">
    <link href="{{ asset('favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/admin/css/style.css">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('assets/admin/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('assets/admin/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('assets/admin/css/style.css') }}" rel="stylesheet">

    @php
        use Illuminate\Support\Str;
    @endphp

    @if(session('success'))
        <div class="alert-container">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="alert-container">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <style>
        :root {
            --primary: #f26022;
            --secondary: #000000;
            --light: #ffffff;
            --dark: #191c24;
            --sidebar-width: 250px;
        }

        /* Global Overrides */
        body {
            background-color: #f3f6f9;
            /* Light grey background for content area */
            color: #1a1a1a;
        }

        .text-primary {
            color: var(--primary) !important;
        }

        .bg-primary {
            background-color: var(--primary) !important;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #d94e10;
            border-color: #d94e10;
        }

        /* Sidebar Styling */
        .sidebar {
            background: #000000 !important;
            /* Force Black */
        }

        .logo-img {
            max-width: 80%;
            height: auto;
            max-height: 80px;
            object-fit: contain;
        }

        .sidebar .navbar {
            background: #000000 !important;
        }

        .sidebar .navbar .navbar-nav .nav-link {
            padding: 7px 20px;
            color: rgba(255, 255, 255, 0.7) !important;
            font-weight: 500;
            border-left: 3px solid transparent;
        }

        .sidebar .navbar .navbar-nav .nav-link:hover,
        .sidebar .navbar .navbar-nav .nav-link.active {
            color: var(--primary) !important;
            background: rgba(255, 255, 255, 0.05);
            border-left-color: var(--primary);
        }

        .sidebar .navbar .dropdown-item {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        .sidebar .navbar .dropdown-item:hover {
            background: transparent;
            color: var(--primary) !important;
        }

        /* Content Area */
        .content {
            background: #f3f6f9;
        }

        /* Navbar */
        .content .navbar {
            background: #ffffff !important;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        }

        .content .navbar .navbar-nav .nav-link,
        .content .navbar .navbar-brand {
            color: #1a1a1a !important;
        }

        .content .navbar .sidebar-toggler {
            color: var(--primary) !important;
        }

        /* Card / Containers */
        .bg-secondary,
        .bg-dark {
            background-color: #ffffff !important;
            color: #1a1a1a !important;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        }

        /* Typography overrides */
        .text-white {
            color: #1a1a1a !important;
        }

        .text-dark {
            color: #1a1a1a !important;
        }

        /* Restore White Text for Primary Elements */
        .btn-primary,
        .badge-primary,
        .bg-primary {
            color: #ffffff !important;
        }

        /* Spinner */
        #spinner.bg-dark {
            background-color: #ffffff !important;
            opacity: 0.9;
        }

        /* Dashboard Widgets */
        .rounded {
            border-radius: 8px !important;
        }

        .alert-container {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 30%;
            z-index: 1050;
        }

        /* Table overrides */
        .table-hover tbody tr:hover {
            color: #212529;
            background-color: rgba(0, 0, 0, .075);
        }

        .table {
            color: #1a1a1a !important;
            border-color: #eee;
        }

        .table thead th {
            border-bottom: 2px solid #f26022;
        }

        /* Forms Input Overrides */
        .form-control,
        .form-select {
            background-color: #fff !important;
            color: #1a1a1a !important;
            border: 1px solid #ced4da !important;
        }

        .form-control:focus,
        .form-select:focus {
            color: #1a1a1a !important;
            background-color: #fff !important;
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 0.25rem rgba(242, 96, 34, 0.25) !important;
        }

        /* Dropdowns */
        .dropdown-menu {
            border: 1px solid rgba(0, 0, 0, .15) !important;
        }

        .dropdown-item {
            color: #212529 !important;
        }

        .dropdown-item:hover {
            color: #16181b !important;
            background-color: #f8f9fa !important;
        }

        /* Pagination */
        .pagination .page-link {
            background-color: #fff !important;
            color: var(--primary) !important;
            border-color: #dee2e6 !important;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
            color: #fff !important;
        }

        .pagination .page-item.disabled .page-link {
            background-color: #fff !important;
            color: #6c757d !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                let alert = document.querySelector('.alert');
                if (alert) {
                    let bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            }, 3000); // 3000ms = 3 seconds
        });
    </script>
</head>