@props(['id', 'label', 'value' => ''])
<div>
    <label for="{{ $id }}" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-zinc-500">{{ $label }}</label>
    <div id="{{ $id }}"></div>
    <input type="hidden" name="{{ $id }}" value="{{ $value }}">
</div>
