{{-- <x-limitless::card> Component (Phase 8.0) --}}
{{-- Limitless card component with header/body/footer support --}}
@props([
    'title' => null,
    'headerClass' => '',
    'bodyClass' => '',
    'footerClass' => '',
    'noPadding' => false,
])

<div {{ $attributes->merge(['class' => 'card']) }}>
    @if($title || isset($header))
        <div class="card-header {{ $headerClass }}">
            @if(isset($header))
                {{ $header }}
            @else
                <h5 class="mb-0">{{ $title }}</h5>
            @endif
        </div>
    @endif

    <div class="card-body {{ $bodyClass }} {{ $noPadding ? 'p-0' : '' }}">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="card-footer {{ $footerClass }}">
            {{ $footer }}
        </div>
    @endif
</div>
