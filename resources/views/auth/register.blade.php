@extends('theme::layouts.auth')

@section('title', 'Register')
@section('subtitle', 'Create a new account')

@section('content')
{{-- Phase 1: Register Form --}}
{{-- Layer A: Plain Bootstrap markup only (no component library) --}}

<form method="POST" action="{{ route('register.store') }}">
    @csrf

    {{-- Name Field --}}
    <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input 
            type="text" 
            class="form-control @error('name') is-invalid @enderror" 
            id="name" 
            name="name" 
            value="{{ old('name') }}" 
            placeholder="Enter your full name"
            required 
            autofocus
        >
        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

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
            placeholder="Enter password (min 8 characters)"
            required
        >
        @error('password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <div class="form-text">Password must be at least 8 characters long.</div>
    </div>

    {{-- Password Confirmation Field --}}
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <input 
            type="password" 
            class="form-control" 
            id="password_confirmation" 
            name="password_confirmation" 
            placeholder="Confirm your password"
            required
        >
    </div>

    {{-- Submit Button --}}
    <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary">
            Create Account
        </button>
    </div>
</form>

{{-- Login Link --}}
<div class="text-center mt-3">
    <p class="text-muted small mb-0">
        Already have an account? 
        <a href="{{ route('login') }}" class="text-decoration-none">Sign in here</a>
    </p>
</div>

{{-- Phase Badge --}}
<div class="text-center mt-2">
    <span class="badge bg-success">Phase 1: Auth</span>
    <span class="badge bg-warning">Audit-first</span>
</div>
@endsection

@push('scripts')
<script>
// Simple client-side password match validation (optional UX enhancement)
$(function() {
    $('#password_confirmation').on('input', function() {
        const password = $('#password').val();
        const confirmation = $(this).val();
        
        if (confirmation && password !== confirmation) {
            $(this).addClass('is-invalid');
            if (!$(this).next('.invalid-feedback').length) {
                $(this).after('<div class="invalid-feedback">Passwords do not match.</div>');
            }
        } else {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        }
    });
});
</script>
@endpush
