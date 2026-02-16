@extends(theme_view('layouts.app'))

@section('title', 'Menu Builder')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="breadcrumb-item">Home</a>
    <span class="breadcrumb-item active">Menu Builder</span>
@endsection

@section('content')
<div class="row">
    {{-- Left: Menu Groups --}}
    <div class="col-md-3">
        <x-limitless::card title="Menu Groups">
            <x-slot:header>
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="ph-list-numbers me-2"></i>Groups</h5>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#groupModal">
                        <i class="ph-plus"></i>
                    </button>
                </div>
            </x-slot:header>

            <div class="list-group list-group-flush">
                @forelse($groups as $group)
                    <a href="{{ route('admin.menu.index', ['group' => $group->id]) }}"
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $activeGroup && $activeGroup->id === $group->id ? 'active' : '' }}">
                        <div>
                            <strong>{{ $group->name }}</strong>
                            <br><small class="text-{{ $activeGroup && $activeGroup->id === $group->id ? 'light' : 'muted' }}">{{ $group->position }} &middot; {{ $group->slug }}</small>
                        </div>
                        <span class="badge bg-{{ $activeGroup && $activeGroup->id === $group->id ? 'light text-dark' : 'primary' }} rounded-pill">
                            {{ $group->items()->count() }}
                        </span>
                    </a>
                @empty
                    <div class="text-center text-muted py-3">
                        <i class="ph-folder-open fs-2 d-block mb-2"></i>
                        No groups yet
                    </div>
                @endforelse
            </div>

            <x-slot:footer>
                <a href="{{ route('admin.menu.clearCache') }}" class="btn btn-sm btn-outline-warning w-100">
                    <i class="ph-broom me-1"></i> Clear Cache
                </a>
            </x-slot:footer>
        </x-limitless::card>
    </div>

    {{-- Center: Menu Items --}}
    <div class="col-md-5">
        <x-limitless::card>
            <x-slot:header>
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="ph-tree-structure me-2"></i>
                        {{ $activeGroup ? $activeGroup->name . ' Items' : 'Select a Group' }}
                    </h5>
                    @if($activeGroup)
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#itemModal">
                            <i class="ph-plus me-1"></i> Add Item
                        </button>
                    @endif
                </div>
            </x-slot:header>

            @if($activeGroup && $items->count() > 0)
                @php
                    $rootItems = $items->whereNull('parent_id')->sortBy('sort_order');
                @endphp
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width:40px">#</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th style="width:80px">Active</th>
                                <th style="width:180px" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rootItems as $item)
                                @include('admin.menu._item-row', ['item' => $item, 'depth' => 0])
                                @php
                                    $childItems = $items->where('parent_id', $item->id)->sortBy('sort_order');
                                @endphp
                                @foreach($childItems as $child)
                                    @include('admin.menu._item-row', ['item' => $child, 'depth' => 1])
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @elseif($activeGroup)
                <div class="text-center text-muted py-4">
                    <i class="ph-folder-open fs-1 d-block mb-2"></i>
                    <p>No items in this group.</p>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#itemModal">
                        <i class="ph-plus me-1"></i> Add First Item
                    </button>
                </div>
            @else
                <div class="text-center text-muted py-4">
                    <i class="ph-arrow-left fs-1 d-block mb-2"></i>
                    <p>Select a group from the left panel.</p>
                </div>
            @endif
        </x-limitless::card>
    </div>

    {{-- Right: Edit Form (when editing item) --}}
    <div class="col-md-4">
        @if($activeGroup)
            {{-- Group edit form --}}
            <x-limitless::card title="Edit Group">
                <form method="POST" action="{{ route('admin.menu.groups.update', $activeGroup) }}">
                    @csrf
                    @method('PUT')

                    <x-limitless::form-group label="Name" name="name" required>
                        <input type="text" class="form-control" name="name" value="{{ $activeGroup->name }}" required>
                    </x-limitless::form-group>

                    <x-limitless::form-group label="Position" name="position" required>
                        <select class="form-select" name="position" required>
                            <option value="sidebar" {{ $activeGroup->position === 'sidebar' ? 'selected' : '' }}>Sidebar</option>
                            <option value="topbar" {{ $activeGroup->position === 'topbar' ? 'selected' : '' }}>Topbar</option>
                            <option value="footer" {{ $activeGroup->position === 'footer' ? 'selected' : '' }}>Footer</option>
                        </select>
                    </x-limitless::form-group>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="ph-floppy-disk me-1"></i> Update Group
                        </button>
                        <button type="button" class="btn btn-danger"
                                data-action="delete-group"
                                data-url="{{ route('admin.menu.groups.destroy', $activeGroup) }}">
                            <i class="ph-trash me-1"></i> Delete
                        </button>
                    </div>
                </form>
            </x-limitless::card>
        @endif
    </div>
</div>

{{-- Create Group Modal --}}
<x-limitless::modal id="groupModal" title="Create Menu Group">
    <form method="POST" action="{{ route('admin.menu.groups.store') }}">
        @csrf
        <x-limitless::form-group label="Name" name="name" required>
            <input type="text" class="form-control" name="name" required placeholder="e.g., Main Sidebar">
        </x-limitless::form-group>

        <x-limitless::form-group label="Slug" name="slug" required>
            <input type="text" class="form-control" name="slug" required placeholder="e.g., main-sidebar">
        </x-limitless::form-group>

        <x-limitless::form-group label="Position" name="position" required>
            <select class="form-select" name="position" required>
                <option value="sidebar">Sidebar</option>
                <option value="topbar">Topbar</option>
                <option value="footer">Footer</option>
            </select>
        </x-limitless::form-group>

        <button type="submit" class="btn btn-primary w-100">
            <i class="ph-plus-circle me-1"></i> Create Group
        </button>
    </form>
</x-limitless::modal>

{{-- Create Item Modal --}}
@if($activeGroup)
<x-limitless::modal id="itemModal" title="Add Menu Item" size="lg">
    <form method="POST" action="{{ route('admin.menu.items.store') }}">
        @csrf
        <input type="hidden" name="menu_group_id" value="{{ $activeGroup->id }}">

        <div class="row">
            <div class="col-md-6">
                <x-limitless::form-group label="Title" name="title" required>
                    <input type="text" class="form-control" name="title" required placeholder="e.g., Dashboard">
                </x-limitless::form-group>
            </div>
            <div class="col-md-6">
                <x-limitless::form-group label="Type" name="type" required>
                    <select class="form-select" name="type" required id="itemType">
                        <option value="route">Route (Laravel)</option>
                        <option value="url">URL (External)</option>
                        <option value="divider">Divider / Section Header</option>
                    </select>
                </x-limitless::form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <x-limitless::form-group label="Route Name" name="route_name" helpText="Laravel named route (e.g., dashboard)">
                    <input type="text" class="form-control" name="route_name" placeholder="e.g., dashboard">
                </x-limitless::form-group>
            </div>
            <div class="col-md-6">
                <x-limitless::form-group label="URL" name="url" helpText="Full URL for external links">
                    <input type="text" class="form-control" name="url" placeholder="e.g., https://example.com">
                </x-limitless::form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <x-limitless::form-group label="Icon" name="icon" helpText="CSS class (e.g., ph-house)">
                    <input type="text" class="form-control" name="icon" placeholder="e.g., ph-house">
                </x-limitless::form-group>
            </div>
            <div class="col-md-4">
                <x-limitless::form-group label="Permission" name="permission" helpText="Permission key for visibility">
                    <input type="text" class="form-control" name="permission" placeholder="e.g., users.view">
                </x-limitless::form-group>
            </div>
            <div class="col-md-4">
                <x-limitless::form-group label="Parent" name="parent_id">
                    <select class="form-select" name="parent_id">
                        <option value="">None (Top Level)</option>
                        @foreach($items->whereNull('parent_id') as $parentItem)
                            <option value="{{ $parentItem->id }}">{{ $parentItem->title }}</option>
                        @endforeach
                    </select>
                </x-limitless::form-group>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">
            <i class="ph-plus-circle me-1"></i> Add Item
        </button>
    </form>
</x-limitless::modal>
@endif

@endsection

@push('scripts')
<script>
$(function() {
    // Delete group (jQuery action router)
    $(document).on('click', '[data-action="delete-group"]', function(e) {
        e.preventDefault();
        if (!confirm('Delete this group and all its items?')) return;

        var url = $(this).data('url');
        $.ajax({
            url: url,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            success: function() { location.href = '{{ route("admin.menu.index") }}'; },
            error: function(xhr) { alert(xhr.responseJSON?.message || 'Error'); }
        });
    });

    // Delete item (jQuery action router)
    $(document).on('click', '[data-action="delete-item"]', function(e) {
        e.preventDefault();
        if (!confirm('Delete this menu item?')) return;

        var $btn = $(this);
        var url = $btn.data('url');
        var $row = $btn.closest('tr');

        $.ajax({
            url: url,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            success: function() {
                $row.fadeOut(300, function() { $(this).remove(); });
            },
            error: function(xhr) { alert(xhr.responseJSON?.message || 'Error'); }
        });
    });
});
</script>
@endpush
