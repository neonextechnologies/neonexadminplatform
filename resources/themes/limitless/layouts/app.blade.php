<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', config('app.name', 'NeonEx Admin'))</title>

    <!-- Limitless Theme CSS (Phase 8.0) -->
    {!! render_theme_assets('css') !!}

    <!-- Page-specific CSS -->
    @stack('styles')

    <style>
        /* Phase 8.0: Minimal overrides for Laravel integration */
        .modal-header { border-bottom: 0 none; }
        .modal-footer { border-top: 0 none; }
    </style>
</head>
<body class="navbar-top">

    <!-- Header + Breadcrumb -->
    @include('theme::layouts.components.header')

    <!-- Page content -->
    <div class="page-content pt-0">

        <!-- Sidebar -->
        @include('theme::layouts.components.sidebar')

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Content area -->
            <div class="content">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="ph-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="ph-x-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="ph-warning me-2"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </div>

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

    @include('theme::layouts.components.footer')

    <!-- Limitless Theme JS (Phase 8.0) -->
    {!! render_theme_assets('js') !!}

    <!-- Limitless notification helper -->
    <script>
        function notyshow(type, message, timeout) {
            timeout = timeout || 3000;
            var types = { success: 'success', error: 'error', warning: 'warning', info: 'info', cancel: 'error' };
            if (typeof Noty !== 'undefined') {
                new Noty({
                    text: message,
                    theme: 'limitless',
                    layout: 'topRight',
                    type: types[type] || 'success',
                    timeout: timeout
                }).show();
            }
        }
    </script>

    <!-- Page-specific JS -->
    @stack('scripts')
</body>
</html>
