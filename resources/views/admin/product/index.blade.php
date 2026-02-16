@extends(theme_view('layouts.app'))

@section('title', 'Products')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Products</h5>
                    <div>
                        @if(auth()->user()->canDo('product.create'))
                            <a href="{{ route('admin.product.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Add Product
                            </a>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    {{-- Search form (plain Bootstrap) --}}
                    <form method="GET" action="{{ route('admin.product.index') }}" class="mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" 
                                       name="search" 
                                       class="form-control" 
                                       placeholder="Search..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-secondary">
                                    <i class="bi bi-search"></i> Search
                                </button>
                                @if(request('search'))
                                    <a href="{{ route('admin.product.index') }}" class="btn btn-link">Clear</a>
                                @endif
                            </div>
                        </div>
                    </form>

                    {{-- Plain Bootstrap table (NO DataTables in Layer A) --}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 80px;">ID</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Is_Active</th>

                                    <th class="text-center" style="width: 160px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr data-id="{{ $product->id }}">
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>
                                            <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                                                {{ $product->is_active ? 'Yes' : 'No' }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            @if(auth()->user()->canDo('product.update'))
                                                <a href="{{ route('admin.product.edit', $product) }}" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                            @endif
                                            
                                            @if(auth()->user()->canDo('product.delete'))
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger" 
                                                        data-action="delete-product"
                                                        data-id="{{ $product->id }}"
                                                        data-url="{{ route('admin.product.destroy', $product) }}">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            No products found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination (Bootstrap default) --}}
                    <div class="mt-3">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Phase 7: jQuery Action Router for AJAX delete (no npm build)
$(function() {
    $(document).on('click', '[data-action="delete-product"]', function(e) {
        e.preventDefault();
        
        if (!confirm('Are you sure you want to delete this product?')) {
            return;
        }

        const $btn = $(this);
        const url = $btn.data('url');
        const $row = $btn.closest('tr');

        // Disable button
        $btn.prop('disabled', true);

        $.ajax({
            url: url,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            success: function(response) {
                // Remove row with animation
                $row.fadeOut(300, function() {
                    $(this).remove();
                    // Show toast if available
                    if (typeof showToast === 'function') {
                        showToast(response.message || 'Product deleted successfully.', 'success');
                    }
                });
            },
            error: function(xhr) {
                $btn.prop('disabled', false);
                const message = xhr.responseJSON?.message || 'Error deleting product.';
                alert(message);
            }
        });
    });
});
</script>
@endpush
