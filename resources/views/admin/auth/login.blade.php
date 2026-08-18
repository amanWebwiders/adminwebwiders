<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - {{ config('app.name', 'Laravel') }}</title>

    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0F172A 0%, #1e1b4b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        /* Decorative background shapes */
        body::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(106,71,237,0.3) 0%, rgba(106,71,237,0) 70%);
            top: -100px;
            left: -100px;
            z-index: 0;
        }

        body::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(106,71,237,0.2) 0%, rgba(106,71,237,0) 70%);
            bottom: -150px;
            right: -150px;
            z-index: 0;
        }

        .login-card {
            width: 100%;
            max-width: 440px;
            background: #ffffff;
            border-radius: 1.25rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            position: relative;
            z-index: 1;
        }

        .login-header {
            background: #6A47ED;
            color: #ffffff;
            padding: 2.5rem 2rem 2rem 2rem;
            text-align: center;
        }

        .login-header img {
            max-height: 40px;
            margin-bottom: 0.75rem;
        }

        .login-body {
            padding: 2.25rem 2rem;
        }

        .form-control {
            border-radius: 0.6rem;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
        }

        .form-control:focus {
            border-color: #6A47ED;
            box-shadow: 0 0 0 3px rgba(106, 71, 237, 0.15);
        }

        .btn-primary {
            background-color: #6A47ED;
            border-color: #6A47ED;
            padding: 0.8rem;
            font-weight: 700;
            border-radius: 0.6rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #5634d1;
            border-color: #5634d1;
            box-shadow: 0 8px 20px rgba(106, 71, 237, 0.35);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <h3 class="fw-extrabold text-white m-0 brand-font"><span style="color: #ffffff;">Webwiders</span></h3>
            <span class="badge bg-white text-dark small fw-semibold px-3 py-1 rounded-pill mt-1">Software Solutions</span>
            <p class="text-white-50 small mt-2 mb-0">Sign in to access Webwiders Admin Dashboard</p>
        </div>

        <div class="login-body">
            @if(session('success'))
                <div class="alert alert-success border-0 small mb-4 rounded-3" role="alert">
                    <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger border-0 small mb-4 rounded-3" role="alert">
                    <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <!-- Email Input -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold small text-secondary">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius: 0.6rem 0 0 0.6rem;">
                            <i class="fa-regular fa-envelope"></i>
                        </span>
                        <input type="email" name="email" id="email" class="form-control border-start-0 @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="admin@blog.com" required autofocus style="border-radius: 0 0.6rem 0.6rem 0;">
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label for="password" class="form-label fw-semibold small text-secondary m-0">Password</label>
                        <a href="{{ route('admin.password.request') }}" class="small text-decoration-none fw-semibold" style="color: #6A47ED;">Forgot Password?</a>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius: 0.6rem 0 0 0.6rem;">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" name="password" id="password" class="form-control border-start-0 @error('password') is-invalid @enderror" placeholder="••••••••" required style="border-radius: 0 0.6rem 0.6rem 0;">
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100 mt-3">
                    Sign In To Dashboard <i class="fa-solid fa-arrow-right-long ms-2"></i>
                </button>
            </form>

            <div class="text-center mt-4 pt-3 border-top">
                <a href="{{ env('MAIN_SITE_URL', 'http://localhost/webwiders/') }}" class="text-muted small text-decoration-none fw-semibold">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back to Public Website
                </a>
            </div>
        </div>
    </div>

</body>
</html>
