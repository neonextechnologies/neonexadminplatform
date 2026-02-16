{{-- Sidebar Component (Placeholder) --}}
{{-- Phase 0B: Static sidebar, no DB-driven menu yet --}}
{{-- Layer A: Plain Bootstrap markup only --}}
{{-- Phase 8: Will be replaced with dynamic menu from DB --}}

<aside class="bg-light border-end" style="width: 250px; min-height: calc(100vh - 56px);">
    <div class="p-3">
        <h6 class="text-muted text-uppercase small mb-3">Navigation</h6>
        
        <!-- Placeholder Menu Items -->
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="{{ url('/dashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/example') }}">
                    <i class="bi bi-box me-2"></i>Example Module
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/_shell') }}">
                    <i class="bi bi-tools me-2"></i>UI Shell Test
                </a>
            </li>
        </ul>

        <hr class="my-3">

        <!-- Phase 1+ Menu Items (Placeholders) -->
        <h6 class="text-muted text-uppercase small mb-3">Admin</h6>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-muted" href="#">
                    <i class="bi bi-people me-2"></i>Users
                    <span class="badge bg-secondary ms-auto">Phase 3</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-muted" href="#">
                    <i class="bi bi-shield-check me-2"></i>Roles
                    <span class="badge bg-secondary ms-auto">Phase 2</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-muted" href="#">
                    <i class="bi bi-building me-2"></i>Tenants
                    <span class="badge bg-secondary ms-auto">Phase 5</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
