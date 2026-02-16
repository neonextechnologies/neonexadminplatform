{{-- Breadcrumb Component (Placeholder) --}}
{{-- Phase 0B: Static breadcrumb --}}
{{-- Layer A: Plain Bootstrap markup only --}}

@if(isset($breadcrumbs) && count($breadcrumbs) > 0)
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
            
            @foreach($breadcrumbs as $breadcrumb)
                @if(isset($breadcrumb['url']))
                    <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a></li>
                @else
                    <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['label'] }}</li>
                @endif
            @endforeach
        </ol>
    </nav>
@endif
