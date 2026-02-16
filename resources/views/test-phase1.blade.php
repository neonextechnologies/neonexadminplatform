@extends('theme::layouts.app')

@section('title', 'Phase 1 Test Summary')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">✅ Phase 1: Authentication - Test Summary</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-success">
                    <h6 class="alert-heading">
                        <i class="bi bi-check-circle-fill me-2"></i>Phase 1 Completed Successfully!
                    </h6>
                    <p class="mb-0">All authentication features are ready for testing.</p>
                </div>

                <h6 class="fw-bold mt-4 mb-3">📋 Test Checklist:</h6>

                <div class="row g-3">
                    <!-- Database Check -->
                    <div class="col-md-6">
                        <div class="card border-success">
                            <div class="card-header bg-success text-white">
                                <strong>1. Database</strong>
                            </div>
                            <div class="card-body">
                                <ul class="mb-0">
                                    <li>✅ Database: <code>neonexadminplatform</code></li>
                                    <li>✅ Users table migrated</li>
                                    <li>✅ Test accounts seeded</li>
                                </ul>
                                <hr>
                                <strong>Test Accounts:</strong>
                                <div class="mt-2">
                                    <div class="badge bg-primary">Admin</div>
                                    <code class="ms-2">admin@example.com / password</code>
                                </div>
                                <div class="mt-2">
                                    <div class="badge bg-secondary">User</div>
                                    <code class="ms-2">user@example.com / password</code>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Routes Check -->
                    <div class="col-md-6">
                        <div class="card border-info">
                            <div class="card-header bg-info text-white">
                                <strong>2. Routes</strong>
                            </div>
                            <div class="card-body">
                                <ul class="mb-0">
                                    <li>✅ <a href="{{ route('login') }}" target="_blank">Login Page</a></li>
                                    <li>✅ <a href="{{ route('register') }}" target="_blank">Register Page</a></li>
                                    <li>✅ <a href="{{ route('dashboard') }}">Dashboard (Auth Required)</a></li>
                                    <li>✅ Logout (POST only)</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Features Check -->
                    <div class="col-md-6">
                        <div class="card border-warning">
                            <div class="card-header bg-warning">
                                <strong>3. Features</strong>
                            </div>
                            <div class="card-body">
                                <ul class="mb-0">
                                    <li>✅ Session-based authentication</li>
                                    <li>✅ Session regeneration on login</li>
                                    <li>✅ CSRF protection</li>
                                    <li>✅ Password hashing (bcrypt)</li>
                                    <li>✅ Input validation</li>
                                    <li>✅ Guest/Auth middleware</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Audit & Security -->
                    <div class="col-md-6">
                        <div class="card border-danger">
                            <div class="card-header bg-danger text-white">
                                <strong>4. Audit & Security</strong>
                            </div>
                            <div class="card-body">
                                <ul class="mb-0">
                                    <li>✅ <strong>Audit-first:</strong> User creation logged</li>
                                    <li>✅ Audit logs in: <code>storage/logs/laravel.log</code></li>
                                    <li>✅ No component library (plain Bootstrap)</li>
                                    <li>✅ Layer A compliance</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <h6 class="fw-bold mt-4 mb-3">🧪 Manual Test Steps:</h6>
                
                <div class="accordion" id="testAccordion">
                    <!-- Test 1: Register -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#test1">
                                Test 1: Register New User
                            </button>
                        </h2>
                        <div id="test1" class="accordion-collapse collapse show" data-bs-parent="#testAccordion">
                            <div class="accordion-body">
                                <ol>
                                    <li>Go to: <a href="{{ route('register') }}" target="_blank">{{ route('register') }}</a></li>
                                    <li>Fill in the form with new user details</li>
                                    <li>Click "Create Account"</li>
                                    <li>✅ Should redirect to dashboard</li>
                                    <li>✅ Check <code>storage/logs/laravel.log</code> for audit entry</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <!-- Test 2: Login -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#test2">
                                Test 2: Login with Admin
                            </button>
                        </h2>
                        <div id="test2" class="accordion-collapse collapse" data-bs-parent="#testAccordion">
                            <div class="accordion-body">
                                <ol>
                                    <li>Logout if logged in (click user dropdown → Logout)</li>
                                    <li>Go to: <a href="{{ route('login') }}" target="_blank">{{ route('login') }}</a></li>
                                    <li>Email: <code>admin@example.com</code></li>
                                    <li>Password: <code>password</code></li>
                                    <li>Check "Remember me" (optional)</li>
                                    <li>Click "Sign In"</li>
                                    <li>✅ Should redirect to dashboard</li>
                                    <li>✅ Header should show "Admin User"</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <!-- Test 3: Protected Routes -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#test3">
                                Test 3: Protected Routes
                            </button>
                        </h2>
                        <div id="test3" class="accordion-collapse collapse" data-bs-parent="#testAccordion">
                            <div class="accordion-body">
                                <ol>
                                    <li>Logout (click user dropdown → Logout)</li>
                                    <li>Try to access: <a href="{{ route('dashboard') }}">{{ route('dashboard') }}</a></li>
                                    <li>✅ Should redirect to login page</li>
                                    <li>✅ After login, should redirect back to dashboard</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <!-- Test 4: Validation -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#test4">
                                Test 4: Validation & Errors
                            </button>
                        </h2>
                        <div id="test4" class="accordion-collapse collapse" data-bs-parent="#testAccordion">
                            <div class="accordion-body">
                                <ol>
                                    <li>Go to register page</li>
                                    <li>Try submitting with:
                                        <ul>
                                            <li>Invalid email</li>
                                            <li>Short password (< 8 chars)</li>
                                            <li>Mismatched password confirmation</li>
                                            <li>Existing email</li>
                                        </ul>
                                    </li>
                                    <li>✅ Should show validation errors</li>
                                    <li>✅ Form should retain old input</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info mt-4">
                    <h6 class="alert-heading">
                        <i class="bi bi-info-circle-fill me-2"></i>Current User Info
                    </h6>
                    @auth
                        <p class="mb-1"><strong>Logged in as:</strong> {{ auth()->user()->name }}</p>
                        <p class="mb-1"><strong>Email:</strong> {{ auth()->user()->email }}</p>
                        <p class="mb-0"><strong>User ID:</strong> {{ auth()->user()->id }}</p>
                    @else
                        <p class="mb-0"><strong>Status:</strong> Not logged in</p>
                    @endauth
                </div>

                <div class="mt-4 d-flex gap-2">
                    <a href="{{ route('login') }}" class="btn btn-primary">Go to Login</a>
                    <a href="{{ route('register') }}" class="btn btn-success">Go to Register</a>
                    <a href="/_shell" class="btn btn-secondary">UI Shell Test</a>
                    @auth
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger">Logout</button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
