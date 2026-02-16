{{-- Menu item table row (partial) --}}
<tr data-id="{{ $item->id }}">
    <td>{{ $item->sort_order }}</td>
    <td>
        @if($depth > 0)
            <span class="ms-{{ $depth * 3 }} text-muted">└─</span>
        @endif
        @if($item->icon)
            <i class="{{ $item->icon }} me-1"></i>
        @endif
        {{ $item->title }}
        @if($item->permission)
            <br><small class="text-muted"><i class="ph-shield-check"></i> {{ $item->permission }}</small>
        @endif
    </td>
    <td>
        <span class="badge bg-{{ $item->type === 'route' ? 'primary' : ($item->type === 'url' ? 'info' : 'secondary') }}">
            {{ $item->type }}
        </span>
        @if($item->type === 'route' && $item->route_name)
            <br><small class="text-muted">{{ $item->route_name }}</small>
        @elseif($item->type === 'url' && $item->url)
            <br><small class="text-muted">{{ Str::limit($item->url, 30) }}</small>
        @endif
    </td>
    <td>
        <span class="badge bg-{{ $item->is_active ? 'success' : 'secondary' }}">
            {{ $item->is_active ? 'Yes' : 'No' }}
        </span>
    </td>
    <td class="text-center">
        {{-- Move buttons --}}
        <a href="{{ route('admin.menu.items.moveUp', $item) }}" class="btn btn-sm btn-light" title="Move Up">
            <i class="ph-arrow-up"></i>
        </a>
        <a href="{{ route('admin.menu.items.moveDown', $item) }}" class="btn btn-sm btn-light" title="Move Down">
            <i class="ph-arrow-down"></i>
        </a>
        {{-- Edit modal trigger --}}
        <button type="button" class="btn btn-sm btn-primary"
                data-bs-toggle="modal" data-bs-target="#editItemModal{{ $item->id }}" title="Edit">
            <i class="ph-pencil"></i>
        </button>
        {{-- Delete --}}
        <button type="button" class="btn btn-sm btn-danger"
                data-action="delete-item"
                data-url="{{ route('admin.menu.items.destroy', $item) }}" title="Delete">
            <i class="ph-trash"></i>
        </button>

        {{-- Edit Item Modal --}}
        <x-limitless::modal id="editItemModal{{ $item->id }}" title="Edit: {{ $item->title }}" size="lg">
            <form method="POST" action="{{ route('admin.menu.items.update', $item) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <x-limitless::form-group label="Title" name="title" required>
                            <input type="text" class="form-control" name="title" value="{{ $item->title }}" required>
                        </x-limitless::form-group>
                    </div>
                    <div class="col-md-6">
                        <x-limitless::form-group label="Type" name="type" required>
                            <select class="form-select" name="type" required>
                                <option value="route" {{ $item->type === 'route' ? 'selected' : '' }}>Route</option>
                                <option value="url" {{ $item->type === 'url' ? 'selected' : '' }}>URL</option>
                                <option value="divider" {{ $item->type === 'divider' ? 'selected' : '' }}>Divider</option>
                            </select>
                        </x-limitless::form-group>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <x-limitless::form-group label="Route Name" name="route_name">
                            <input type="text" class="form-control" name="route_name" value="{{ $item->route_name }}">
                        </x-limitless::form-group>
                    </div>
                    <div class="col-md-6">
                        <x-limitless::form-group label="URL" name="url">
                            <input type="text" class="form-control" name="url" value="{{ $item->url }}">
                        </x-limitless::form-group>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <x-limitless::form-group label="Icon" name="icon">
                            <input type="text" class="form-control" name="icon" value="{{ $item->icon }}">
                        </x-limitless::form-group>
                    </div>
                    <div class="col-md-4">
                        <x-limitless::form-group label="Permission" name="permission">
                            <input type="text" class="form-control" name="permission" value="{{ $item->permission }}">
                        </x-limitless::form-group>
                    </div>
                    <div class="col-md-4">
                        <x-limitless::form-group label="Active" name="is_active">
                            <select class="form-select" name="is_active">
                                <option value="1" {{ $item->is_active ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ !$item->is_active ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </x-limitless::form-group>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="ph-floppy-disk me-1"></i> Update Item
                </button>
            </form>
        </x-limitless::modal>
    </td>
</tr>
