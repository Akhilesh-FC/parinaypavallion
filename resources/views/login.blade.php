<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login | Parinay Pavallion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: #f5f7fb; /* Light soft background */
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 10px 35px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 420px;
            padding: 35px;
        }

        .brand-logo {
            width: 60px;
            margin-bottom: 10px;
        }

        .brand-title {
            font-size: 20px;
            font-weight: 700;
            color: #0F3D2E;
            white-space: nowrap;
        }

        .brand-sub {
            font-size: 13px;
            color: #6c757d;
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 500;
            font-size: 14px;
        }

        .form-control {
            height: 45px;
        }

        .btn-primary {
            background: #0F3D2E;
            border: none;
            height: 45px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: #145A44;
        }
    </style>
</head>
<body>

<div class="login-card text-center">

    <!-- BRAND -->
    <img src="{{ asset('assets/img/parinay.png') }}" alt="Parinay" class="brand-logo">
    <div class="brand-title">Parinay Pavallion</div>
    <div class="brand-sub">Admin Login</div>

    <!-- FORM -->
    <form method="POST" action="{{ route('admin.login.submit') }}" class="text-start">
        @csrf

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="mb-3">
            <label class="form-label">Email</label>
            <div class="input-group">
                <span class="input-group-text bg-light">
                    <i class="fas fa-envelope text-secondary"></i>
                </span>
                <input type="email"
                       name="email"
                       class="form-control"
                       placeholder="admin@example.com"
                       required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-light">
                    <i class="fas fa-lock text-secondary"></i>
                </span>
                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="••••••••"
                       required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 mt-2">
            Login
        </button>
    </form>

</div>

</body>
</html>
