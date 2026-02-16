<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Login') - {{ config('app.name', 'NeonEx Admin') }}</title>

    <!-- Limitless Theme CSS -->
    {!! render_theme_assets('css') !!}

    @stack('styles')
</head>
<body>

    <!-- Page content -->
    <div class="page-content">
        <div class="content-wrapper">
            <div class="content d-flex justify-content-center align-items-center">

                <!-- Flash Messages -->
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index:9999;" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Auth Content -->
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Limitless Theme JS -->
    {!! render_theme_assets('js') !!}
    @stack('scripts')
</body>
</html>
