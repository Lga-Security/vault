@extends('layouts.guest')

@section('title', 'Register')

@section('content')
    <h2 class="h5 text-center mb-3">Create your account</h2>

    @if ($errors->any())
        <div class="alert alert-danger py-2">
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label small fw-semibold">Full name</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required autofocus placeholder="John Doe">
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label small fw-semibold">Email address</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required placeholder="you@example.com">
            </div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label small fw-semibold">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" id="password" class="form-control" required placeholder="Min 8 characters">
            </div>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label small fw-semibold">Confirm password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="••••••••">
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-3">
            <i class="bi bi-person-plus me-1"></i>Create Account
        </button>
    </form>

    <p class="text-center text-muted small mb-0">
        Already have an account? <a href="{{ route('login') }}">Sign in</a>
    </p>
@endsection
