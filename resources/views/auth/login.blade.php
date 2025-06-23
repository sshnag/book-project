@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%; border-radius: 12px;">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-dark">Welcome Back</h2>
            <p class="text-muted">Sign in to your Bookio account</p>
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email Address</label>
                <input id="email" type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                       placeholder="example@gmail.com">
                @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="form-label fw-semibold">Password</label>
                <input id="password" type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       name="password" required autocomplete="current-password"
                       placeholder="Enter your password">
                @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot Password?</a>
                @endif
            </div>

            <button type="submit" class="btn btn-primary w-100 fw-semibold" style="background-color: #000000; border:none; border-radius: 8px; font-size: 1.1rem;">
                Login
            </button>

            <div class="text-center mt-4">
                <p class="mb-0">Don't have an account?
                    <a href="{{ route('register') }}" class="text-primary fw-semibold">Sign Up</a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset(path: 'css/book.css') }}">
@endpush
