<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'NeonEx Admin'))</title>

    <!-- Theme CSS Assets (CDN + Custom) -->
    {!! render_theme_assets('css') !!}

    <!-- Page-specific CSS -->
    @stack('styles')
</head>
<body class="bg-light">
    <div class="d-flex align-items-center justify-content-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-5 col-xl-4">
                    <!-- Auth Card -->
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <!-- Logo -->
                            <div class="text-center mb-4">
                                <h3 class="fw-bold text-primary">{{ config('app.name', 'NeonEx') }}</h3>
                                <p class="text-muted small mb-0">@yield('subtitle', 'Admin Platform')</p>
                            </div>

                            <!-- Flash Messages -->
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- Auth Content -->
                            @yield('content')
                        </div>
                    </div>

                    <!-- Footer Text -->
                    <div class="text-center mt-3">
                        <p class="text-muted small mb-0">
                            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Theme JS Assets (CDN + Custom) -->
    {!! render_theme_assets('js') !!}

    <!-- Page-specific JS -->
    @stack('scripts')
</body>
</html>
