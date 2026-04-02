<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vault — Secure Password Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); color: #fff; min-height: 100vh; }
        .hero { padding: 6rem 0 4rem; }
        .feature-icon { width: 3.5rem; height: 3.5rem; border-radius: .75rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; background: rgba(78,115,223,.15); color: #4e73df; }
        .feature-card { background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.08); border-radius: 1rem; transition: transform .2s; }
        .feature-card:hover { transform: translateY(-4px); background: rgba(255,255,255,.08); }
        .btn-get-started { padding: .75rem 2rem; font-weight: 600; border-radius: .75rem; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="/">
                <i class="bi bi-shield-lock-fill"></i> Vault
            </a>
            <div class="d-flex gap-2">
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">Your passwords,<br>secured in one place</h1>
            <p class="lead text-white-50 mb-4 mx-auto" style="max-width: 560px;">
                Vault helps you store, organize, and share credentials securely. Never forget a password again.
            </p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('register') }}" class="btn btn-primary btn-get-started">
                    Get Started <i class="bi bi-arrow-right ms-1"></i>
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-get-started">
                    Sign In
                </a>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card p-4 h-100">
                        <div class="feature-icon mb-3"><i class="bi bi-safe"></i></div>
                        <h3 class="h5 fw-semibold">Organized Vaults</h3>
                        <p class="text-white-50 small mb-0">Group your passwords into vaults by project, client, or however you like.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card p-4 h-100">
                        <div class="feature-icon mb-3"><i class="bi bi-tags"></i></div>
                        <h3 class="h5 fw-semibold">Categories</h3>
                        <p class="text-white-50 small mb-0">Tag entries with categories for quick filtering and easy navigation.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card p-4 h-100">
                        <div class="feature-icon mb-3"><i class="bi bi-share"></i></div>
                        <h3 class="h5 fw-semibold">Secure Sharing</h3>
                        <p class="text-white-50 small mb-0">Share individual credentials with teammates without exposing your full vault.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="text-center py-4 text-white-50 small">
        &copy; {{ date('Y') }} Vault. All rights reserved.
    </footer>
</body>
</html>
