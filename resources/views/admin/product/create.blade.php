@extends(theme_view('layouts.app'))

@section('title', 'Create Product')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Create Product</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.product.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="price">Price</label>
                            <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
                            @error('price')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="is_active">Is_Active</label>
                            <select class="form-select" id="is_active" name="is_active" >
                                <option value="1" >Yes</option>
                                <option value="0" selected>No</option>
                            </select>
                            @error('is_active')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>



                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Save
                            </button>
                            <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
