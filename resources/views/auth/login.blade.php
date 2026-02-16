@extends('theme::layouts.auth')

@section('title', 'Login')
@section('subtitle', 'Sign in to your account')

@section('content')
{{-- Phase 1: Login Form --}}
{{-- Layer A: Plain Bootstrap markup only (no component library) --}}

<form method="POST" action="{{ route('login.store') }}">
    @csrf

    {{-- Email Field --}}
    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input 
            type="email" 
            class="form-control @error('email') is-invalid @enderror" 
            id="email" 
            name="email" 
            value="{{ old('email') }}" 
            placeholder="Enter your email"
            required 
            autofocus
        >
        @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- Password Field --}}
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input 
            type="password" 
            class="form-control @error('password') is-invalid @enderror" 
            id="password" 
            name="password" 
            placeholder="Enter your password"
            required
        >
        @error('password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- Remember Me Checkbox --}}
    <div class="mb-3">
        <div class="form-check">
            <input 
                type="checkbox" 
                class="form-check-input" 
                id="remember" 
                name="remember" 
                value="1"
            >
            <label class="form-check-label" for="remember">
                Remember me
            </label>
        </div>
    </div>

    {{-- Submit Button --}}
    <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary">
            Sign In
        </button>
    </div>
</form>

{{-- Register Link --}}
<div class="text-center mt-3">
    <p class="text-muted small mb-0">
        Don't have an account? 
        <a href="{{ route('register') }}" class="text-decoration-none">Register here</a>
    </p>
</div>

{{-- Phase Badge --}}
<div class="text-center mt-2">
    <span class="badge bg-success">Phase 1: Auth</span>
</div>
@endsection
