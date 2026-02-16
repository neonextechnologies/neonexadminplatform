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
<body>
    <div class="d-flex flex-column min-vh-100">
        <!-- Header -->
        @include('theme::layouts.components.header')

        <div class="d-flex flex-grow-1">
            <!-- Sidebar -->
            @include('theme::layouts.components.sidebar')

            <!-- Main Content -->
            <main class="flex-grow-1 p-4">
                <!-- Breadcrumb -->
                @include('theme::layouts.components.breadcrumb')

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

                <!-- Page Content -->
                @yield('content')
            </main>
        </div>

        <!-- Footer -->
        @include('theme::layouts.components.footer')
    </div>

    <!-- Theme JS Assets (CDN + Custom) -->
    {!! render_theme_assets('js') !!}

    <!-- Page-specific JS -->
    @stack('scripts')
</body>
</html>
