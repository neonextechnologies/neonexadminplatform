{{-- Header Component (Placeholder) --}}
{{-- Phase 0B: Static header, no DB-driven menu yet --}}
{{-- Layer A: Plain Bootstrap markup only --}}

<header class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">
        <!-- Logo / Brand -->
        <a class="navbar-brand fw-bold" href="{{ url('/dashboard') }}">
            {{ config('app.name', 'NeonEx') }}
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Items -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Left Side (Placeholder) -->
            <ul class="navbar-nav me-auto">
                <!-- Phase 8: Dynamic menu will go here -->
            </ul>

            <!-- Right Side -->
            <ul class="navbar-nav ms-auto">
                @auth
                    <!-- User Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ auth()->user()->name ?? 'User' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') ?? '#' }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') ?? '#' }}">Login</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</header>
