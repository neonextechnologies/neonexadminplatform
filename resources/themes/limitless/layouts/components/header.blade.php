{{-- Limitless Header (Phase 8.0) --}}
{{-- Adapted from CI4 Limitless template for Laravel --}}
<div class="fixed-top">
    <!-- Main navbar -->
    <div class="navbar navbar-dark navbar-expand-lg">
        <div class="container-fluid">
            <div class="d-flex d-lg-none me-2">
                <button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
                    <i class="ph-list"></i>
                </button>
            </div>

            <div class="navbar-brand flex-1 flex-lg-0">
                <a href="{{ route('dashboard') }}" class="d-inline-flex align-items-center">
                    <span style="color:#fff">&nbsp;&nbsp;{{ setting()->get('app', 'site_name', config('app.name', 'NeonEx Admin')) }}</span>
                </a>
            </div>

            <ul class="nav flex-row justify-content-end order-1 order-lg-2">
                @auth
                    {{-- Tenant indicator --}}
                    @if(tenant()->hasContext())
                        <li class="nav-item d-none d-lg-flex align-items-center me-2">
                            <span class="badge bg-success bg-opacity-20 text-success border border-success border-opacity-25 rounded-pill px-2 py-1">
                                <i class="ph-buildings me-1"></i>{{ tenant()->current()->name ?? 'No Tenant' }}
                            </span>
                        </li>
                    @endif

                    {{-- User dropdown --}}
                    <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
                        <a href="#" class="navbar-nav-link align-items-center rounded-pill p-1" data-bs-toggle="dropdown">
                            <div class="status-indicator-container">
                                <span class="w-32px h-32px rounded-pill bg-primary bg-opacity-20 d-flex align-items-center justify-content-center text-primary">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                                <span class="status-indicator bg-success"></span>
                            </div>
                            <span class="d-none d-lg-inline-block mx-lg-2">{{ auth()->user()->name }}</span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="{{ route('dashboard') }}" class="dropdown-item">
                                <i class="ph-squares-four me-2"></i>Dashboard
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="ph-sign-out me-2"></i>Logout
                                </a>
                            </form>
                        </div>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
    <!-- /main navbar -->
</div>

<!-- Breadcrumbs -->
<div class="page-header page-header-light shadow">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <div class="breadcrumb py-2">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="ph-house"></i></a>
                @yield('breadcrumb')
            </div>
        </div>

        <div class="collapse d-lg-block my-lg-auto ms-lg-auto" id="page_header">
            <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3">
                <div class="d-inline-flex mt-3 mt-sm-0">
                    @yield('pageheader')
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /breadcrumbs -->
