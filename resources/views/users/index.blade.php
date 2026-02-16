@extends(theme_view('layouts.app'))

@section('title', 'Users')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            {{-- Success message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Users list card --}}
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Users</h5>
                    @if(auth()->user()->canDo('users.create'))
                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle"></i> Add User
                        </a>
                    @endif
                </div>

                <div class="card-body">
                    {{-- Plain Bootstrap table (no DataTables) --}}
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 60px;">ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th style="width: 180px;">Created</th>
                                    <th style="width: 120px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr data-id="{{ $user->id }}">
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @foreach($user->roles as $role)
                                                <span class="badge bg-secondary">{{ $role->label }}</span>
                                            @endforeach
                                        </td>
                                        <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            @if(auth()->user()->canDo('users.update'))
                                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-primary">
                                                    Edit
                                                </a>
                                            @endif
                                            
                                            @if(auth()->user()->canDo('users.delete'))
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger"
                                                        data-action="delete-user"
                                                        data-id="{{ $user->id }}">
                                                    Delete
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No users found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3 text-muted">
                        <small>Total: {{ $users->count() }} user(s)</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Phase 0: Action Router - jQuery event delegation
registerAction('delete-user', function($element) {
    const userId = $element.data('id');
    
    if (!confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
        return;
    }

    $.ajax({
        url: '/users/' + userId,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            showToast('User deleted successfully.', 'success');
            // Remove row from table
            $('tr[data-id="' + userId + '"]').fadeOut(300, function() {
                $(this).remove();
            });
        },
        error: function(xhr) {
            const message = xhr.responseJSON?.message || 'Failed to delete user.';
            showToast(message, 'danger');
        }
    });
});
</script>
@endpush
