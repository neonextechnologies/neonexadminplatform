{{-- <x-limitless::form-group> Component (Phase 8.0) --}}
{{-- Limitless form group with label + error --}}
@props([
    'label' => null,
    'name' => null,
    'required' => false,
    'helpText' => null,
])

<div class="mb-3">
    @if($label)
        <label class="form-label" @if($name) for="{{ $name }}" @endif>
            {{ $label }}
            @if($required) <span class="text-danger">*</span> @endif
        </label>
    @endif

    {{ $slot }}

    @if($name)
        @error($name)
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    @endif

    @if($helpText)
        <div class="form-text">{{ $helpText }}</div>
    @endif
</div>
