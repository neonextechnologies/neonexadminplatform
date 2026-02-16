{{-- Recursive Sidebar Tree (Phase 8.2) --}}
{{-- Renders menu items from MenuService --}}
@foreach($items as $item)
    @php
        $type = $item['type'] ?? 'link';
        $children = $item['children'] ?? [];
        $hasChildren = !empty($children);
        $permission = $item['permission'] ?? null;
        $title = $item['title'] ?? '';
        $icon = $item['icon'] ?? '';

        // Skip items the user doesn't have permission for
        if ($permission && auth()->check() && !auth()->user()->canDo($permission)) {
            continue;
        }

        // Resolve URL based on type
        $url = '#';
        if ($type === 'url' && !empty($item['url'])) {
            $url = $item['url'];
        } elseif ($type === 'route' && !empty($item['route_name'])) {
            try { $url = route($item['route_name']); } catch (\Throwable) { $url = '#'; }
        }
    @endphp

    @if($type === 'divider')
        {{-- Section header / divider --}}
        <li class="nav-item-header pt-0">
            <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">{{ $title }}</div>
            <i class="ph-dots-three sidebar-resize-show"></i>
        </li>
    @else
        {{-- Regular menu item --}}
        <li class="nav-item {{ $hasChildren ? 'nav-item-submenu' : '' }}">
            <a href="{{ $url }}" class="nav-link">
                @if($icon)
                    <i class="{{ $icon }}"></i>
                @endif
                <span>{{ $title }}</span>
            </a>

            @if($hasChildren)
                <ul class="nav-group-sub collapse" data-submenu-title="{{ $title }}">
                    @include('theme::layouts.components.sidebar-tree', ['items' => $children])
                </ul>
            @endif
        </li>
    @endif
@endforeach
