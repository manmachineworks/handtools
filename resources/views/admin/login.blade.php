<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin Login | Gurunanak Hand Tools</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="{{ asset('assets/new_assets/images/svg/favicon.png') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #f26022;
            --secondary: #000000;
            --light: #ffffff;
            --dark: #191c24;
        }

        body {
            font-family: 'Heebo', sans-serif;
            background-color: var(--light);
            margin: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Split Layout Backgrounds */
        .login-wrapper {
            width: 100%;
            height: 100%;
            display: flex;
        }

        .login-side {
            width: 100%;
            max-width: 500px;
            background: var(--light);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
            position: relative;
            z-index: 2;
            box-shadow: 10px 0 30px rgba(0, 0, 0, 0.05);
        }

        .image-side {
            flex: 1;
            background: linear-gradient(135deg, #000000, #1a1a1a);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .image-side::before {
            content: '';
            position: absolute;
            width: 150%;
            height: 150%;
            background: radial-gradient(circle, var(--primary) 0%, transparent 60%);
            opacity: 0.1;
            animation: pulse 10s infinite alternate;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.1;
            }

            100% {
                transform: scale(1.2);
                opacity: 0.15;
            }
        }

        /* Form Styling */
        .login-header {
            margin-bottom: 40px;
        }

        .login-header h3 {
            font-weight: 700;
            color: var(--secondary);
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .login-header p {
            color: #6c757d;
        }

        .login-brand {
            margin-bottom: 50px;
            display: block;
        }

        .login-brand img {
            max-height: 50px;
            /* Adjust based on actual logo */
        }

        .border-primary-left {
            border-left: 5px solid var(--primary);
            padding-left: 15px;
        }

        .form-floating>.form-control {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            height: 55px;
            box-shadow: none !important;
        }

        .form-floating>.form-control:focus {
            border-color: var(--primary);
        }

        .form-floating>label {
            color: #999;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            padding: 12px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #d94e10;
            border-color: #d94e10;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(242, 96, 34, 0.3);
        }

        /* Error Message */
        .alert-danger {
            border-radius: 8px;
            font-size: 0.9rem;
            border: none;
            background-color: #fff2f2;
            color: #dc3545;
            border-left: 4px solid #dc3545;
        }

        .spinner-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: #fff;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.5s ease;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
            color: var(--primary);
        }

        @media (max-width: 768px) {
            .image-side {
                display: none;
            }

            .login-side {
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
    <!-- Spinner -->
    <div id="spinner" class="spinner-wrapper">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="login-wrapper">
        <!-- Left Side: Login Form -->
        <div class="login-side">
            <div class="login-brand">
                <a href="{{ url('/') }}">
                    <h3 class="text-primary fw-bold"><i class="fa fa-tools me-2"></i>GHT Admin</h3>
                </a>
            </div>

            <div class="login-header border-primary-left">
                <h3>Welcome Back</h3>
                <p>Sign in to manage your dashboard</p>
            </div>

            <!-- Error Display -->
            @if ($errors->any())
                <div class="alert alert-danger mb-4 fade show" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.login') }}" method="POST">
                @csrf
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                        required autofocus>
                    <label for="username">Username / Email</label>
                </div>
                <div class="form-floating mb-4">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                        required>
                    <label for="password">Password</label>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <a href="#" class="text-primary text-decoration-none small">Forgot Password?</a>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-4">Sign In</button>
            </form>

            <div class="text-center mt-auto">
                <p class="text-muted small">&copy; {{ date('Y') }} Gurunanak Hand Tools. All rights reserved.</p>
            </div>
        </div>

        <!-- Right Side: Brand/Image -->
        <div class="image-side">
            <div class="text-center text-white p-5">
                <i class="fa fa-wrench fa-5x mb-4" style="color: var(--primary); opacity: 0.8;"></i>
                <h1 class="display-4 fw-bold mb-3">Precision & Power</h1>
                <p class="lead" style="opacity: 0.7; max-width: 400px; margin: 0 auto;">Admin Control Panel for managing
                    products, enquiries, and orders.</p>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Spinner logic
        $(window).on('load', function () {
            $('#spinner').fadeOut('slow', function () {
                $(this).remove();
            });
        });
    </script>
</body>

</html>