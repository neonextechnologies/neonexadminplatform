{{-- Limitless Sidebar (Phase 8.0 + 8.2) --}}
{{-- Phase 8.2: Dynamic menu rendering from MenuService --}}

<!-- Main sidebar -->
<div class="sidebar sidebar-main sidebar-expand-lg align-self-start">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Sidebar header -->
        <div class="sidebar-section">
            <div class="sidebar-section-body d-flex justify-content-center">
                <h5 class="sidebar-resize-hide flex-grow-1 my-auto">Navigation</h5>

                <div>
                    <button type="button"
                        class="btn btn-light btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                        <i class="ph-arrows-left-right"></i>
                    </button>

                    <button type="button"
                        class="btn btn-light btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                        <i class="ph-x"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- /sidebar header -->

        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
                @php
                    // Phase 8.2: Get menu from MenuService (DB-driven, tenant-aware)
                    $menuTree = [];
                    try {
                        $menuTree = app(\App\Contracts\Menu\MenuServiceContract::class)->getTree('sidebar');
                    } catch (\Throwable $e) {
                        // Fallback: service not yet available
                    }
                @endphp

                @if(!empty($menuTree))
                    {{-- Dynamic menu from DB --}}
                    @include('theme::layouts.components.sidebar-tree', ['items' => $menuTree])
                @else
                    {{-- Fallback static menu (until Phase 8.2 seeds) --}}
                    <li class="nav-item-header pt-0">
                        <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Main</div>
                        <i class="ph-dots-three sidebar-resize-show"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link">
                            <i class="ph-squares-four"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    @if(auth()->check() && auth()->user()->canDo('users.view'))
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link">
                            <i class="ph-users"></i>
                            <span>Users</span>
                        </a>
                    </li>
                    @endif
                @endif
            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
<!-- /main sidebar -->
