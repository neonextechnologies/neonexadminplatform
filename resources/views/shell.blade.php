@extends('theme::layouts.app')

@section('title', 'UI Shell Test - Phase 0B')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">UI Shell Smoke Test</h5>
                <span class="badge bg-success">Phase 0B</span>
            </div>
            <div class="card-body">
                <div class="alert alert-success">
                    <strong>✅ Success!</strong> Theme adapter and UI shell are working correctly.
                </div>
                
                <h6 class="fw-bold mb-3">Phase 0B Exit Criteria:</h6>
                <ul class="mb-4">
                    <li>✅ Theme renders a sample admin page via Blade layout (no broken assets)</li>
                    <li>✅ Bootstrap/theme JS plugins load without npm build</li>
                    <li>✅ Placeholder sidebar renders and does not depend on DB/menu services</li>
                    <li>✅ Theme adapter API is stable (theme_view, theme_asset, render_theme_assets)</li>
                </ul>

                <h6 class="fw-bold mb-3">What's Working:</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card border-primary">
                            <div class="card-body">
                                <h6 class="card-title text-primary">
                                    <i class="bi bi-check-circle me-2"></i>Phase 0A Complete
                                </h6>
                                <ul class="small mb-0">
                                    <li>Kernel/Modules structure created</li>
                                    <li>ModuleServiceProvider loading modules</li>
                                    <li>Contracts defined (Tenant, RBAC, Audit)</li>
                                    <li>Action Router JS convention established</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-success">
                            <div class="card-body">
                                <h6 class="card-title text-success">
                                    <i class="bi bi-check-circle me-2"></i>Phase 0B Complete
                                </h6>
                                <ul class="small mb-0">
                                    <li>Theme config + ThemeServiceProvider</li>
                                    <li>Theme helpers (theme_asset, theme_view)</li>
                                    <li>Base layouts (app, auth)</li>
                                    <li>Layout partials (header, sidebar, footer)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Table Test (Plain Bootstrap) --}}
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Table Test (Plain Bootstrap)</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>John Doe</td>
                                <td>john@example.com</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-action="test.edit" data-id="1">Edit</button>
                                    <button class="btn btn-sm btn-danger" data-action="test.delete" data-id="1">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Jane Smith</td>
                                <td>jane@example.com</td>
                                <td><span class="badge bg-warning">Pending</span></td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-action="test.edit" data-id="2">Edit</button>
                                    <button class="btn btn-sm btn-danger" data-action="test.delete" data-id="2">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Form Test (Plain Bootstrap) --}}
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Form Test (Plain Bootstrap)</h6>
            </div>
            <div class="card-body">
                <form id="testForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" placeholder="Enter name" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" placeholder="Enter email" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Role</label>
                            <select class="form-select">
                                <option>Admin</option>
                                <option>User</option>
                                <option>Guest</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="statusActive" checked>
                                <label class="form-check-label" for="statusActive">Active</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-primary" data-action="test.submit">Submit (Test Action Router)</button>
                            <button type="button" class="btn btn-success" id="testToastBtn">Test Toast</button>
                            <button type="button" class="btn btn-info" id="testModalBtn" data-bs-toggle="modal" data-bs-target="#testModal">Test Modal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Test Modal --}}
<div class="modal fade" id="testModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Test Modal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">This is a test modal to verify Bootstrap JS is working correctly.</p>
                <p class="text-muted small mb-0">Modal uses Bootstrap 5 modal component (no npm build required).</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Register test actions
registerAction('test.edit', function(data, event, $element) {
    console.log('Edit action triggered:', data);
    showToast('Edit action for ID: ' + data.id, 'info');
});

registerAction('test.delete', function(data, event, $element) {
    console.log('Delete action triggered:', data);
    confirmAction('Are you sure you want to delete this item?', function() {
        showToast('Delete action for ID: ' + data.id, 'danger');
    });
});

registerAction('test.submit', function(data, event, $element) {
    console.log('Submit action triggered:', data);
    showToast('Form submitted successfully!', 'success');
});

// Test toast button
$('#testToastBtn').on('click', function() {
    showToast('This is a test toast message!', 'success');
});

console.log('✅ UI Shell Test page loaded (Phase 0B)');
</script>
@endpush
