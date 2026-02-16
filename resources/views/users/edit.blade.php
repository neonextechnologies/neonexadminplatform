@extends(theme_view('layouts.app'))

@section('title', 'Edit User')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-lg-6">
            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit: {{ $user->name }}</li>
                </ol>
            </nav>

            {{-- Edit user form --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit User</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('users.update', $user) }}">
                        @csrf
                        @method('PUT')

                        {{-- Name field --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   required 
                                   autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email field --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password field (optional for edit) --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                New Password
                            </label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password">
                            <small class="form-text text-muted">Leave blank to keep current password. Minimum 8 characters if changing.</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password confirmation field --}}
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">
                                Confirm New Password
                            </label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation">
                        </div>

                        {{-- User metadata --}}
                        <div class="alert alert-light" role="alert">
                            <small class="text-muted">
                                <strong>Created:</strong> {{ $user->created_at->format('Y-m-d H:i:s') }}<br>
                                <strong>Last Updated:</strong> {{ $user->updated_at->format('Y-m-d H:i:s') }}<br>
                                <strong>Tenant ID:</strong> {{ $user->tenant_id ?? 'N/A' }}
                            </small>
                        </div>

                        {{-- Form actions --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
