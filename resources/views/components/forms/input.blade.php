@props(['label', 'error'])
<x-input label="{{ $label }}"></x-input>
<div>
    @error($error)
        <span class="error">{{ $message }}</span>
    @enderror
</div>
