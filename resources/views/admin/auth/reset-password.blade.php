<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set New Password - {{ config('app.name', 'Laravel') }}</title>

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
        }

        .login-card {
            width: 100%;
            max-width: 440px;
            background: #ffffff;
            border-radius: 1.25rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
            overflow: hidden;
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
        }

        .btn-primary:hover {
            background-color: #5634d1;
            border-color: #5634d1;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <h3 class="fw-extrabold text-white m-0 brand-font"><span style="color: #ffffff;">Webwiders</span></h3>
            <span class="badge bg-white text-dark small fw-semibold px-3 py-1 rounded-pill mt-1">Software Solutions</span>
            <h4 class="fw-bold m-0 mt-2">Reset Password</h4>
            <p class="text-white-50 small mt-1 mb-0">Set a new secure password for your account</p>
        </div>

        <div class="login-body">
            @if(session('error'))
                <div class="alert alert-danger border-0 small mb-4 rounded-3" role="alert">
                    <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Email Input -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold small text-secondary">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $email) }}" required readonly>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold small text-secondary">New Password</label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required autofocus>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-semibold small text-secondary">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Reset Password Now <i class="fa-solid fa-key ms-2"></i>
                </button>
            </form>

            <div class="text-center mt-4 pt-3 border-top">
                <a href="{{ route('admin.login') }}" class="text-muted small text-decoration-none fw-semibold">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back to Login
                </a>
            </div>
        </div>
    </div>

</body>
</html>
